<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class SuperAdminUserController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role', 'all');

        $query = User::with('tenant')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%")
                  ->orWhereHas('tenant', function ($tq) use ($search) {
                      $tq->where('name', 'ILIKE', "%{$search}%");
                  });
            });
        }

        if ($roleFilter && $roleFilter !== 'all') {
            $query->where('role', $roleFilter);
        }

        $users = $query->paginate(15)->through(function ($u) {
            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'role' => $u->role,
                'tenant_id' => $u->tenant_id,
                'tenant_name' => $u->tenant?->name ?? '👑 Central AVI Pet',
                'tenant_slug' => $u->tenant?->slug ?? '',
                'created_at' => $u->created_at ? $u->created_at->format('d/m/Y') : null,
            ];
        });

        // Compute real KPIs
        $totalUsers = User::count();
        $superAdminsCount = User::where('role', 'super_admin')->count();
        $clinicStaffCount = User::whereIn('role', ['clinic_admin', 'vet_doctor'])->count();
        $receptionCount = User::where('role', 'reception')->count();

        $tenantsList = Tenant::select('id', 'name', 'slug')->orderBy('name')->get();
        $authUser = auth()->user();

        return Inertia::render('SuperAdmin/Users', [
            'users' => $users,
            'filters' => [
                'search' => $search ?? '',
                'role' => $roleFilter,
            ],
            'stats' => [
                'total' => $totalUsers,
                'superAdmins' => $superAdminsCount,
                'clinicStaff' => $clinicStaffCount,
                'reception' => $receptionCount,
            ],
            'tenantsList' => $tenantsList,
            'currentUserId' => $authUser?->id,
            'userName' => $authUser?->name ?? 'Robinson Naranjo',
            'userEmail' => $authUser?->email ?? 'superadmin@avipetapp.com',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|string|in:super_admin,clinic_admin,vet_doctor,reception',
            'tenant_id' => 'nullable|exists:tenants,id',
            'password' => 'required|string|min:6',
        ]);

        if ($validated['role'] === 'super_admin') {
            $validated['tenant_id'] = null;
        }

        User::create([
            'id' => Str::uuid(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'tenant_id' => $validated['tenant_id'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Usuario creado exitosamente.');
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:super_admin,clinic_admin,vet_doctor,reception',
            'tenant_id' => 'nullable|exists:tenants,id',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validated['role'] === 'super_admin') {
            $validated['tenant_id'] = null;
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'tenant_id' => $validated['tenant_id'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Usuario actualizado con éxito.');
    }

    public function destroy(string $id)
    {
        if (auth()->id() === $id) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta en uso.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
    }
}
