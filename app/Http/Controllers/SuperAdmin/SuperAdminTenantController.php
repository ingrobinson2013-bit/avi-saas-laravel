<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BenefitDefinition;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\PlanBenefit;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class SuperAdminTenantController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('tableSearch') ?? $request->input('search');
        $statusFilter = $request->input('status');

        $allTenants = Tenant::query()
            ->with(['users' => fn ($q) => $q->orderBy('created_at')])
            ->withCount(['pets', 'plans', 'subscriptions', 'customers'])
            ->latest()
            ->get();

        $mappedAll = $allTenants->map(function (Tenant $t) {
            $branding = $t->branding ?? [];
            $rawStatus = $branding['saas_status'] ?? ($t->trial_ends_at && $t->trial_ends_at->isPast() ? 'suspended' : 'paid');
            if (!$t->is_active) {
                $rawStatus = 'suspended';
            }

            $primaryUser = $t->users->first();

            return [
                'id' => $t->id,
                'name' => $t->name,
                'slug' => $t->slug,
                'domain' => $t->domain,
                'base_url' => $t->base_url,
                'is_active' => (bool) $t->is_active,
                'city' => $branding['city'] ?? 'Colombia',
                'address' => $branding['address'] ?? '',
                'phone' => $branding['phone'] ?? null,
                'email' => $branding['email'] ?? ($primaryUser?->email ?? null),
                'logo_url' => $branding['logo_url'] ?? null,
                'primary_color' => $branding['primary_color'] ?? '#0D9488',
                'doctor_name' => $branding['doctor_name'] ?? ($primaryUser?->name ?? 'Dirección Médica'),
                'saas_status' => $rawStatus,
                'saas_plan' => $t->saas_plan_tier ?: ($branding['saas_plan'] ?? 'pro'),
                'saas_monthly_fee' => (float) ($branding['saas_monthly_fee'] ?? 99000),
                'trial_ends_at' => $t->trial_ends_at ? $t->trial_ends_at->format('Y-m-d') : null,
                'trial_ends_at_formatted' => $t->trial_ends_at ? $t->trial_ends_at->format('d/m/Y') : null,
                'saas_next_payment_due' => $branding['saas_next_payment_due'] ?? null,
                'pets_count' => $t->pets_count ?? 0,
                'customers_count' => $t->customers_count ?? 0,
                'subscriptions_count' => $t->subscriptions_count ?? 0,
                'plans_count' => $t->plans_count ?? 0,
                'admin_user_id' => $primaryUser?->id,
                'admin_user_name' => $primaryUser?->name,
                'admin_user_email' => $primaryUser?->email,
                'created_at' => $t->created_at ? $t->created_at->format('d/m/Y') : null,
            ];
        });

        $stats = [
            'total' => $mappedAll->count(),
            'paid' => $mappedAll->where('saas_status', 'paid')->count(),
            'trial' => $mappedAll->where('saas_status', 'trial')->count(),
            'suspended' => $mappedAll->where('saas_status', 'suspended')->count(),
        ];

        $filtered = $mappedAll->filter(function (array $item) use ($search, $statusFilter) {
            if ($statusFilter && $statusFilter !== 'all' && $item['saas_status'] !== $statusFilter) {
                return false;
            }
            if ($search) {
                $needle = mb_strtolower(trim($search));
                $haystack = mb_strtolower(implode(' ', array_filter([
                    $item['name'],
                    $item['slug'],
                    $item['domain'],
                    $item['city'],
                    $item['phone'],
                    $item['email'],
                    $item['doctor_name'],
                ])));
                if (!str_contains($haystack, $needle)) {
                    return false;
                }
            }
            return true;
        })->values();

        $authUser = auth()->user();

        return Inertia::render('SuperAdmin/Tenants', [
            'tenants' => $filtered,
            'filters' => [
                'search' => $search ?? '',
                'status' => $statusFilter ?? 'all',
            ],
            'stats' => $stats,
            'userName' => $authUser?->name ?? 'Robinson Naranjo',
            'userEmail' => $authUser?->email ?? 'superadmin@avipetapp.com',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'doctor_name' => 'nullable|string|max:150',
            'password' => 'nullable|string|min:6|max:100',
            'saas_plan' => 'nullable|string|max:50',
            'saas_status' => 'nullable|string|max:50',
            'saas_monthly_fee' => 'nullable|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated) {
            $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
            if (empty($slug)) {
                $slug = 'veterinaria-' . Str::lower(Str::random(4));
            }
            if (Tenant::where('slug', $slug)->exists()) {
                $slug .= '-' . Str::lower(Str::random(3));
            }

            $status = $validated['saas_status'] ?? 'paid';
            $plan = $validated['saas_plan'] ?? 'pro';
            $fee = isset($validated['saas_monthly_fee']) ? (float) $validated['saas_monthly_fee'] : 99000;
            $doctorName = !empty($validated['doctor_name']) ? trim($validated['doctor_name']) : ('Dr(a). ' . $validated['name']);

            $tenant = Tenant::create([
                'name' => $validated['name'],
                'slug' => $slug,
                'saas_plan_tier' => $plan,
                'is_active' => $status !== 'suspended',
                'branding' => [
                    'brand_name' => $validated['name'],
                    'city' => $validated['city'] ?: 'Colombia',
                    'address' => $validated['address'] ?: 'Sede Principal',
                    'phone' => $validated['phone'] ?? '',
                    'email' => $validated['email'] ?? '',
                    'doctor_name' => $doctorName,
                    'doctor_title' => 'Dirección Médica Veterinaria',
                    'saas_plan' => $plan,
                    'saas_status' => $status,
                    'saas_monthly_fee' => $fee,
                    'primary_color' => '#0D9488',
                    'secondary_color' => '#0F172A',
                    'trial_active' => $status === 'trial',
                    'trial_ends_at' => now()->addDays(15)->toIso8601String(),
                    'section_how_it_works' => true,
                    'section_plans' => true,
                    'section_calculator' => true,
                    'section_carnet_feature' => true,
                    'section_comparison' => true,
                    'section_carencias' => true,
                    'section_facilities' => true,
                ],
            ]);

            if (!empty($validated['email']) && !User::where('email', $validated['email'])->exists()) {
                User::create([
                    'tenant_id' => $tenant->id,
                    'name' => $doctorName,
                    'email' => $validated['email'],
                    'password' => Hash::make(!empty($validated['password']) ? $validated['password'] : 'AviPet2026*'),
                    'role' => 'clinic_admin',
                ]);
            }

            return redirect()->back()->with('success', "Clínica {$tenant->name} creada con sus planes preventivos y acceso de administrador.");
        });
    }

    public function update(Request $request, string $id)
    {
        $tenant = Tenant::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:100|unique:tenants,slug,' . $tenant->id,
            'domain' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'doctor_name' => 'nullable|string|max:150',
            'logo_url' => 'nullable|string|max:500',
            'primary_color' => 'nullable|string|max:30',
            'saas_plan' => 'required|string|max:50',
            'saas_status' => 'required|in:paid,trial,suspended',
            'saas_monthly_fee' => 'required|numeric|min:0',
            'trial_ends_at' => 'nullable|date',
            'saas_next_payment_due' => 'nullable|string|max:40',
            'new_password' => 'nullable|string|min:6|max:100',
        ]);

        return DB::transaction(function () use ($tenant, $validated) {
            $branding = $tenant->branding ?? [];
            $branding['brand_name'] = $validated['name'];
            $branding['city'] = $validated['city'] ?: 'Colombia';
            $branding['address'] = $validated['address'] ?? ($branding['address'] ?? '');
            $branding['phone'] = $validated['phone'] ?? '';
            $branding['email'] = $validated['email'] ?? '';
            $branding['doctor_name'] = $validated['doctor_name'] ?? ($branding['doctor_name'] ?? '');
            if (array_key_exists('logo_url', $validated)) {
                $branding['logo_url'] = $validated['logo_url'] ?: null;
            }
            if (!empty($validated['primary_color'])) {
                $branding['primary_color'] = $validated['primary_color'];
            }
            $branding['saas_plan'] = $validated['saas_plan'];
            $branding['saas_status'] = $validated['saas_status'];
            $branding['saas_monthly_fee'] = (float) $validated['saas_monthly_fee'];
            $branding['trial_active'] = $validated['saas_status'] === 'trial';

            if (!empty($validated['trial_ends_at'])) {
                $branding['trial_ends_at'] = \Carbon\Carbon::parse($validated['trial_ends_at'])->endOfDay()->toIso8601String();
            }
            if (array_key_exists('saas_next_payment_due', $validated)) {
                $branding['saas_next_payment_due'] = $validated['saas_next_payment_due'] ?: null;
            }

            $tenant->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['slug']),
                'domain' => !empty($validated['domain']) ? trim($validated['domain']) : null,
                'saas_plan_tier' => $validated['saas_plan'],
                'is_active' => $validated['saas_status'] !== 'suspended',
                'branding' => $branding,
            ]);

            // Actualizar o crear el usuario administrador de la clínica si se envió correo o nueva contraseña
            $adminUser = User::where('tenant_id', $tenant->id)->orderBy('created_at')->first();
            if ($adminUser) {
                $userUpdates = [];
                if (!empty($validated['doctor_name'])) {
                    $userUpdates['name'] = $validated['doctor_name'];
                }
                if (!empty($validated['email']) && !User::where('email', $validated['email'])->where('id', '!=', $adminUser->id)->exists()) {
                    $userUpdates['email'] = $validated['email'];
                }
                if (!empty($validated['new_password'])) {
                    $userUpdates['password'] = Hash::make($validated['new_password']);
                }
                if (!empty($userUpdates)) {
                    $adminUser->update($userUpdates);
                }
            } elseif (!empty($validated['email']) && !User::where('email', $validated['email'])->exists()) {
                User::create([
                    'tenant_id' => $tenant->id,
                    'name' => $validated['doctor_name'] ?: ('Dr(a). ' . $validated['name']),
                    'email' => $validated['email'],
                    'password' => Hash::make(!empty($validated['new_password']) ? $validated['new_password'] : 'AviPet2026*'),
                    'role' => 'clinic_admin',
                ]);
            }

            return redirect()->back()->with('success', "Clínica {$tenant->name} actualizada correctamente.");
        });
    }

    public function destroy(string $id)
    {
        $tenant = Tenant::findOrFail($id);
        if ($tenant->slug === 'vet-pet-patitas') {
            return redirect()->back()->with('error', 'La clínica piloto oficial Vet-Pet Patitas está protegida contra eliminación.');
        }
        $name = $tenant->name;

        DB::transaction(function () use ($tenant) {
            $planIds = Plan::where('tenant_id', $tenant->id)->pluck('id');
            if ($planIds->isNotEmpty()) {
                PlanBenefit::whereIn('plan_id', $planIds)->delete();
            }

            Subscription::where('tenant_id', $tenant->id)->delete();
            Plan::where('tenant_id', $tenant->id)->delete();
            BenefitDefinition::where('tenant_id', $tenant->id)->delete();

            $customerIds = Customer::where('tenant_id', $tenant->id)->pluck('id');
            if ($customerIds->isNotEmpty()) {
                Pet::whereIn('customer_id', $customerIds)->delete();
            }
            Customer::where('tenant_id', $tenant->id)->delete();
            User::where('tenant_id', $tenant->id)->delete();

            if (method_exists($tenant, 'saasPaymentLogs')) {
                $tenant->saasPaymentLogs()->delete();
            }

            $tenant->delete();
        });

        return redirect()->back()->with('success', "La clínica «{$name}» fue eliminada permanentemente.");
    }
}
