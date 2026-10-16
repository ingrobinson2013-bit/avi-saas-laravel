<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class SuperAdminTenantController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('tableSearch') ?? $request->input('search');
        $statusFilter = $request->input('status');

        $query = Tenant::query()
            ->withCount(['pets', 'plans', 'subscriptions'])
            ->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('slug', 'ILIKE', "%{$search}%")
                  ->orWhere('domain', 'ILIKE', "%{$search}%")
                  ->orWhere('branding->city', 'ILIKE', "%{$search}%")
                  ->orWhere('branding->phone', 'ILIKE', "%{$search}%")
                  ->orWhere('branding->email', 'ILIKE', "%{$search}%");
            });
        }

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('branding->saas_status', $statusFilter);
        }

        $tenants = $query->get()->map(function ($t) {
            $branding = $t->branding ?? [];
            return [
                'id' => $t->id,
                'name' => $t->name,
                'slug' => $t->slug,
                'domain' => $t->domain,
                'city' => $branding['city'] ?? 'Colombia',
                'phone' => $branding['phone'] ?? null,
                'email' => $branding['email'] ?? null,
                'logo_url' => $branding['logo_url'] ?? null,
                'doctor_name' => $branding['doctor_name'] ?? 'Dirección Médica',
                'saas_status' => $branding['saas_status'] ?? ($t->trial_ends_at && $t->trial_ends_at->isPast() ? 'suspended' : 'paid'),
                'saas_plan' => $branding['saas_plan'] ?? 'starter',
                'saas_monthly_fee' => (float) ($branding['saas_monthly_fee'] ?? 99000),
                'trial_ends_at' => $t->trial_ends_at ? $t->trial_ends_at->format('d/m/Y') : null,
                'saas_next_payment_due' => $branding['saas_next_payment_due'] ?? null,
                'pets_count' => $t->pets_count ?? 0,
                'subscriptions_count' => $t->subscriptions_count ?? 0,
                'plans_count' => $t->plans_count ?? 0,
                'created_at' => $t->created_at ? $t->created_at->format('d/m/Y') : null,
            ];
        });

        $totalCount = Tenant::count();
        $paidCount = Tenant::where('branding->saas_status', 'paid')->count();
        $trialCount = Tenant::where('branding->saas_status', 'trial')->orWhereNull('branding->saas_status')->count();
        $suspendedCount = Tenant::where('branding->saas_status', 'suspended')->count();

        $authUser = auth()->user();

        return Inertia::render('SuperAdmin/Tenants', [
            'tenants' => $tenants,
            'filters' => [
                'search' => $search ?? '',
                'status' => $statusFilter ?? 'all',
            ],
            'stats' => [
                'total' => $totalCount,
                'paid' => $paidCount,
                'trial' => $trialCount,
                'suspended' => $suspendedCount,
            ],
            'userName' => $authUser?->name ?? 'Robinson Naranjo',
            'userEmail' => $authUser?->email ?? 'superadmin@avipetapp.com',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:100|unique:tenants,slug',
            'city' => 'nullable|string|max:150',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'saas_plan' => 'nullable|string',
            'saas_status' => 'nullable|string',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        if (Tenant::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        $tenant = Tenant::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'branding' => [
                'brand_name' => $validated['name'],
                'city' => $validated['city'] ?? 'Colombia',
                'phone' => $validated['phone'] ?? '',
                'email' => $validated['email'] ?? '',
                'saas_plan' => $validated['saas_plan'] ?? 'starter',
                'saas_status' => $validated['saas_status'] ?? 'paid',
                'saas_monthly_fee' => 99000,
                'primary_color' => '#0D9488',
                'secondary_color' => '#0F172A',
            ],
        ]);

        return redirect()->back()->with('success', "Clínica {$tenant->name} creada exitosamente.");
    }
}
