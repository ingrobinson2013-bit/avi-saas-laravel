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
                      $tq->where('name', 'ILIKE', "%{$search}%")
                         ->orWhere('slug', 'ILIKE', "%{$search}%");
                  });
            });
        }

        if ($roleFilter && $roleFilter !== 'all') {
            $query->where('role', $roleFilter);
        }

        $users = $query->paginate(25)->through(function (User $u) {
            $tenant = $u->tenant;
            $branding = $tenant?->branding ?? [];

            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'role' => $u->role,
                'tenant_id' => $u->tenant_id,
                'tenant_name' => $tenant?->name ?? 'Central AviPetApp',
                'tenant_slug' => $tenant?->slug ?? '',
                'tenant_phone' => $branding['phone'] ?? null,
                'login_url' => $tenant ? ($tenant->base_url . '/admin/login') : 'https://avipetapp.com/super-admin/login',
                'is_protected' => $u->role === 'super_admin' || in_array(strtolower($u->email), ['contacto@avipetapp.com', 'petmovilveterinario@gmail.com']),
                'created_at' => $u->created_at ? $u->created_at->format('d/m/Y') : null,
            ];
        });

        // KPIs reales
        $totalUsers = User::count();
        $superAdminsCount = User::where('role', 'super_admin')->count();
        $clinicStaffCount = User::whereIn('role', ['clinic_admin', 'vet_doctor'])->count();
        $receptionCount = User::where('role', 'reception')->count();

        $tenantsList = Tenant::select('id', 'name', 'slug')->orderBy('name')->get();
        $authUser = (auth()->user() && auth()->user()->role === 'super_admin')
            ? auth()->user()
            : User::where('role', 'super_admin')->orWhere('email', 'contacto@avipetapp.com')->first();

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
            'userEmail' => $authUser?->email ?? 'contacto@avipetapp.com',
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

        $user = User::create([
            'id' => Str::uuid(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'tenant_id' => $validated['tenant_id'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        // Sincronizar nombre y correo del director médico en la ficha de la clínica
        if ($user->role === 'clinic_admin' && $user->tenant_id) {
            $tenant = Tenant::find($user->tenant_id);
            if ($tenant) {
                $branding = $tenant->branding ?? [];
                $branding['doctor_name'] = $user->name;
                $branding['email'] = $user->email;
                $tenant->update(['branding' => $branding]);
            }
        }

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

        // Sincronizar con la ficha de la clínica si es Director de Clínica
        if ($user->role === 'clinic_admin' && $user->tenant_id) {
            $tenant = Tenant::find($user->tenant_id);
            if ($tenant) {
                $branding = $tenant->branding ?? [];
                $branding['doctor_name'] = $user->name;
                $branding['email'] = $user->email;
                $tenant->update(['branding' => $branding]);
            }
        }

        return redirect()->back()->with('success', 'Usuario actualizado con éxito.');
    }

    public function destroy(string $id)
    {
        if (auth()->id() === $id) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta en uso.');
        }

        $user = User::findOrFail($id);
        if (
            $user->role === 'super_admin' ||
            in_array(strtolower($user->email), ['contacto@avipetapp.com', 'petmovilveterinario@gmail.com'])
        ) {
            return redirect()->back()->with('error', 'Esta cuenta principal está protegida contra eliminación.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
    }
}
