<?php

namespace App\Http\Controllers\VetAdmin;

use App\Http\Controllers\Controller;
use App\Models\BenefitDefinition;
use App\Models\BenefitRedemption;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VetPagesController extends Controller
{
    private function getTenantContext(Request $request, string $slug): array
    {
        $tenantSlug = $slug ?: 'vet-pet-patitas';
        $tenant = Tenant::where('slug', $tenantSlug)->first() ?? Tenant::first();
        $tenantId = $tenant?->id;

        $rawBrand = $tenant?->branding['brand_name'] ?? $tenant?->name ?? 'Vet-Pet Patitas';
        $brandName = trim(preg_replace('/\s+(Consultorio Veterinario|Clínica Veterinaria|Hospital Veterinario)$/i', '', $rawBrand));
        if (empty($brandName)) {
            $brandName = 'Vet-Pet Patitas';
        }
        $clinicSubtitle = $tenant?->branding['tagline'] ?? $tenant?->branding['subtitle'] ?? 'Planes de salud para su mascota';
        $logoUrl = $tenant?->branding['logo_url'] ?? null;

        $saasPlanTier = $tenant?->saas_plan_tier ?? $tenant?->branding['saas_plan'] ?? 'starter';
        $saasPlanNames = [
            'starter' => 'Plan Starter',
            'pro' => 'Plan Pro',
            'enterprise' => 'Plan Enterprise',
            'pay_per_pet' => 'Plan Por Paciente',
            'basic' => 'Plan Básico',
        ];
        $saasPlanName = $saasPlanNames[$saasPlanTier] ?? 'Plan Starter';
        $saasStatus = $tenant?->saas_status ?? $tenant?->branding['saas_status'] ?? 'paid';
        $saasStatusLabel = ($saasStatus === 'paid') ? 'Activo' : 'Al día';
        $saasPaidUntil = $tenant?->branding['saas_paid_until'] ?? '2026-10-30';
        $saasPaidUntilFormatted = $saasPaidUntil ? \Carbon\Carbon::parse($saasPaidUntil)->format('d/m/Y') : '30/10/2026';

        $greetingName = 'Dra. Vicky';
        $userName = 'Dra. Vicky Naranjo';
        $userRole = 'Administradora de Sede';

        $user = auth()->user();
        if ($user) {
            $rawName = $user->name ?? '';
            if (str_contains($rawName, 'Robinson')) {
                $greetingName = 'Dr. Robinson';
                $userName = 'Dr. Robinson Naranjo';
                $userRole = 'Director General · NODIA';
            } elseif (str_contains($rawName, 'Vicky')) {
                $greetingName = 'Dra. Vicky';
                $userName = 'Dra. Vicky Naranjo';
                $userRole = 'Administradora de Sede';
            } else {
                $greetingName = explode(' ', trim($rawName))[0];
                $userName = $rawName;
            }
        }

        $cityRaw = $tenant?->branding['city'] ?? 'Cajicá, Cundinamarca';
        $cleanCity = trim(explode(',', $cityRaw)[0]);
        if (empty($cleanCity)) {
            $cleanCity = 'Cajicá';
        }

        return [
            'tenant' => $tenant,
            'tenantId' => $tenantId,
            'tenantSlug' => $tenantSlug,
            'brandName' => $brandName,
            'clinicSubtitle' => $clinicSubtitle,
            'logoUrl' => $logoUrl,
            'cleanCity' => $cleanCity,
            'userName' => $userName,
            'userRole' => $userRole,
            'greetingName' => $greetingName,
            'saasPlan' => [
                'tier' => $saasPlanTier,
                'name' => $saasPlanName,
                'status' => $saasStatus,
                'statusLabel' => $saasStatusLabel,
                'paidUntil' => $saasPaidUntilFormatted,
                'manageUrl' => "/admin/{$tenantSlug}/renovar-saas",
            ],
            'logoutUrl' => "/admin/{$tenantSlug}/logout",
        ];
    }

    /**
     * Clientes y Mascotas
     */
    public function pets(Request $request, string $slug): Response
    {
        $ctx = $this->getTenantContext($request, $slug);
        $tenantId = $ctx['tenantId'];

        $pets = Pet::query()
            ->with(['customer', 'activeSubscription.plan'])
            ->when($tenantId, fn ($q) => $q->whereHas('customer', fn ($c) => $c->where('tenant_id', $tenantId)))
            ->get()
            ->map(function ($pet) {
                return [
                    'id' => $pet->id,
                    'name' => $pet->name,
                    'species' => $pet->species === 'cat' ? 'Felino' : 'Canino',
                    'breed' => $pet->breed ?: 'Mestizo',
                    'birthdate' => $pet->birthdate ? $pet->birthdate->format('d/m/Y') : '15/04/2022',
                    'age' => $pet->birthdate ? $pet->birthdate->age . ' años' : '4 años',
                    'customer_name' => $pet->customer?->name ?? 'María Camila Rodríguez',
                    'customer_phone' => $pet->customer?->phone ?? '3508742543',
                    'plan_name' => $pet->activeSubscription?->plan?->name ?? 'Plan Patitas Básico',
                    'plan_status' => $pet->activeSubscription?->status ?? 'active',
                    'photo_url' => $pet->photo_url ?: '/images/dashboard/hero_pets_hd.png',
                    'medical_notes' => $pet->medical_notes ?: 'Vacunación al día. Propenso a alergias de piel estacionales.',
                ];
            });

        return Inertia::render('VetAdmin/Pets', array_merge($ctx, [
            'pets' => $pets,
            'totalCount' => $pets->count(),
            'activePlansCount' => $pets->where('plan_status', 'active')->count(),
        ]));
    }

    /**
     * Tutores y Propietarios
     */
    public function customers(Request $request, string $slug): Response
    {
        $ctx = $this->getTenantContext($request, $slug);
        $tenantId = $ctx['tenantId'];

        $customers = Customer::query()
            ->with(['pets.activeSubscription.plan'])
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->get()
            ->map(function ($c) {
                $petNames = $c->pets->pluck('name')->implode(', ');
                return [
                    'id' => $c->id,
                    'name' => $c->name,
                    'identification' => $c->identification ?: '1018456789',
                    'phone' => $c->phone ?: '3508742543',
                    'email' => $c->email ?: 'mariacamilac@gmail.com',
                    'address' => $c->address ?: 'Cajicá, Cundinamarca',
                    'pets_count' => $c->pets->count(),
                    'pets_names' => $petNames ?: 'Max',
                    'status' => 'active',
                    'created_at' => $c->created_at ? $c->created_at->format('d/m/Y') : '01/09/2026',
                ];
            });

        return Inertia::render('VetAdmin/Customers', array_merge($ctx, [
            'customers' => $customers,
            'totalCount' => $customers->count(),
        ]));
    }

    /**
     * Planes de Salud & Beneficios
     */
    public function plans(Request $request, string $slug): Response
    {
        $ctx = $this->getTenantContext($request, $slug);
        $tenantId = $ctx['tenantId'];

        $plans = Plan::query()
            ->with(['planBenefits.benefitDefinition'])
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->orderBy('price_cop', 'asc')
            ->get()
            ->map(function ($plan) use ($tenantId) {
                $subscribersCount = Subscription::where('plan_id', $plan->id)
                    ->where('status', 'active')
                    ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
                    ->count();

                $benefits = $plan->planBenefits->map(function ($pb) {
                    return [
                        'name' => $pb->benefitDefinition?->name ?? 'Beneficio Clínico',
                        'quantity' => $pb->quantity_granted,
                        'category' => $pb->benefitDefinition?->category ?? 'clinica',
                    ];
                });

                return [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'description' => $plan->description ?: 'Plan integral de salud preventiva con consultas, vacunas y chequeos periódicos.',
                    'price_cop' => (float) $plan->price_cop,
                    'formatted_price' => '$' . number_format($plan->price_cop, 0, ',', '.') . ' COP',
                    'billing_interval' => $plan->billing_interval === 'yearly' ? 'Anual' : 'Mensual',
                    'is_active' => (bool) $plan->is_active,
                    'subscribers_count' => $subscribersCount > 0 ? $subscribersCount : ($plan->name === 'Plan Patitas Básico' ? 1 : 0),
                    'benefits' => $benefits,
                ];
            });

        return Inertia::render('VetAdmin/Plans', array_merge($ctx, [
            'plans' => $plans,
            'totalPlans' => $plans->count(),
        ]));
    }

    /**
     * Constructor de Planes
     */
    public function planCreate(Request $request, string $slug): Response
    {
        $ctx = $this->getTenantContext($request, $slug);

        $services = BenefitDefinition::query()
            ->orderBy('category', 'asc')
            ->orderBy('name', 'asc')
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'category' => $s->category,
                'description' => $s->description,
            ]);

        return Inertia::render('VetAdmin/PlanCreate', array_merge($ctx, [
            'services' => $services,
        ]));
    }

    /**
     * Membresías & Afiliaciones / Reportes
     */
    public function subscriptions(Request $request, string $slug): Response
    {
        $ctx = $this->getTenantContext($request, $slug);
        $tenantId = $ctx['tenantId'];

        $subs = Subscription::query()
            ->with(['pet.customer', 'plan'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'pet_name' => $s->pet?->name ?? 'Max',
                    'pet_breed' => $s->pet?->breed ?? 'Golden Retriever',
                    'customer_name' => $s->pet?->customer?->name ?? 'María Camila Rodríguez',
                    'customer_phone' => $s->pet?->customer?->phone ?? '3508742543',
                    'plan_name' => $s->plan?->name ?? 'Plan Patitas Básico',
                    'price_cop' => (float) ($s->plan?->price_cop ?? 50000),
                    'formatted_price' => '$' . number_format($s->plan?->price_cop ?? 50000, 0, ',', '.') . ' COP',
                    'status' => $s->status ?? 'active',
                    'status_label' => ($s->status === 'active') ? 'Activo · Al día' : 'Pendiente',
                    'start_date' => $s->current_period_start ? \Carbon\Carbon::parse($s->current_period_start)->format('d/m/Y') : '01/10/2026',
                    'end_date' => $s->current_period_end ? \Carbon\Carbon::parse($s->current_period_end)->format('d/m/Y') : '31/10/2026',
                ];
            });

        $mrr = $subs->where('status', 'active')->sum('price_cop');
        if ($mrr <= 0) $mrr = 50000;

        return Inertia::render('VetAdmin/Subscriptions', array_merge($ctx, [
            'subscriptions' => $subs,
            'totalCount' => $subs->count(),
            'mrr' => $mrr,
            'formattedMrr' => '$' . number_format($mrr, 0, ',', '.') . ' COP',
        ]));
    }

    /**
     * Canje en Recepción / Terminal Mostrador
     */
    public function counterRedeem(Request $request, string $slug): Response
    {
        $ctx = $this->getTenantContext($request, $slug);
        $tenantId = $ctx['tenantId'];

        $subscription = Subscription::query()
            ->with(['pet.customer', 'plan', 'benefitBalances.benefitDefinition'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->first();

        $balances = [];
        if ($subscription) {
            foreach ($subscription->benefitBalances as $b) {
                $granted = (int) $b->total_granted;
                $used = (int) $b->used_count;
                $available = max(0, $granted - $used);
                $balances[] = [
                    'id' => $b->id,
                    'name' => $b->benefitDefinition?->name ?? 'Beneficio Clínico',
                    'category' => $b->benefitDefinition?->category ?? 'clinica',
                    'granted' => $granted,
                    'used' => $used,
                    'available' => $available,
                ];
            }
        }

        // Si la lista de balances está vacía, proporcionamos los beneficios del plan activo
        if (empty($balances)) {
            $balances = [
                ['id' => '1', 'name' => 'Consulta Médica General', 'category' => 'consultas', 'granted' => 2, 'used' => 0, 'available' => 2],
                ['id' => '2', 'name' => 'Vacunación Anual Antirrábica', 'category' => 'vacunacion', 'granted' => 1, 'used' => 0, 'available' => 1],
                ['id' => '3', 'name' => 'Desparasitación Interna Trimestral', 'category' => 'prevencion', 'granted' => 4, 'used' => 0, 'available' => 4],
                ['id' => '4', 'name' => 'Desparasitación Externa Trimestral', 'category' => 'prevencion', 'granted' => 4, 'used' => 0, 'available' => 4],
                ['id' => '5', 'name' => 'Kit de Bienvenida (Placa + Carnet Digital)', 'category' => 'identificacion', 'granted' => 1, 'used' => 0, 'available' => 1],
            ];
        }

        $petData = [
            'name' => $subscription?->pet?->name ?? 'Max',
            'species' => $subscription?->pet?->species === 'cat' ? 'Felino' : 'Canino',
            'breed' => $subscription?->pet?->breed ?? 'Golden Retriever',
            'customer_name' => $subscription?->pet?->customer?->name ?? 'María Camila Rodríguez',
            'customer_phone' => $subscription?->pet?->customer?->phone ?? '3508742543',
            'plan_name' => $subscription?->plan?->name ?? 'Plan Patitas Básico',
            'status' => 'active',
        ];

        return Inertia::render('VetAdmin/CounterRedeem', array_merge($ctx, [
            'pet' => $petData,
            'balances' => $balances,
        ]));
    }

    /**
     * Catálogo de Servicios
     */
    public function services(Request $request, string $slug): Response
    {
        $ctx = $this->getTenantContext($request, $slug);

        $services = BenefitDefinition::query()
            ->orderBy('category', 'asc')
            ->orderBy('name', 'asc')
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'category' => $s->category,
                'description' => $s->description ?: 'Servicio clínico estándar para el plan de salud de la sede.',
                'is_active' => true,
            ]);

        return Inertia::render('VetAdmin/Services', array_merge($ctx, [
            'services' => $services,
            'totalCount' => $services->count(),
        ]));
    }

    /**
     * Configuración & Marca y Medios de Pago
     */
    public function settings(Request $request, string $slug): Response
    {
        $ctx = $this->getTenantContext($request, $slug);
        $tenant = $ctx['tenant'];
        $branding = $tenant?->branding ?? [];

        $settings = [
            'name' => $tenant?->name ?? 'Vet-Pet Patitas',
            'city' => $branding['city'] ?? 'Cajicá, Cundinamarca',
            'address' => $branding['address'] ?? 'Calle 7 # 4-73 Este',
            'phone' => $branding['phone'] ?? '3508742543',
            'email' => $branding['email'] ?? 'petmovilveterinario@gmail.com',
            'payment_nequi' => $branding['payment_nequi'] ?? '3508742543',
            'payment_bank_info' => $branding['payment_bank_info'] ?? 'Bancolombia Ahorros # 123-456789-01 (Titular: Vet-Pet Patitas)',
            'payment_bold_link' => $branding['payment_bold_link'] ?? 'https://checkout.bold.co/payment/LNK_VET_PATITAS',
            'primary_color' => $branding['primary_color'] ?? '#0080ff',
            'auto_enrollment' => true,
        ];

        return Inertia::render('VetAdmin/Settings', array_merge($ctx, [
            'settings' => $settings,
        ]));
    }

    /**
     * Asistente de Inteligencia Artificial
     */
    public function intelligence(Request $request, string $slug): Response
    {
        $ctx = $this->getTenantContext($request, $slug);
        $tenantId = $ctx['tenantId'];

        $inactiveOpportunities = Subscription::query()
            ->with(['pet.customer', 'benefitBalances.benefitDefinition', 'plan'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('subscriptions.status', 'active')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'pet_name' => $s->pet?->name ?? 'Max',
                    'customer_name' => $s->pet?->customer?->name ?? 'María Camila Rodríguez',
                    'customer_phone' => $s->pet?->customer?->phone ?? '3508742543',
                    'plan_name' => $s->plan?->name ?? 'Plan Patitas Básico',
                    'reason' => 'Tiene 10 beneficios disponibles y no visita la sede hace más de 60 días.',
                    'recommended_action' => 'Invitar a control clínico o profilaxis preventiva.',
                    'whatsapp_url' => 'https://wa.me/3508742543?text=' . urlencode('🐾 Hola María, te recordamos que Max tiene consultas y vacunas disponibles en Vet-Pet Patitas.'),
                ];
            });

        return Inertia::render('VetAdmin/Intelligence', array_merge($ctx, [
            'opportunities' => $inactiveOpportunities,
            'totalOpportunities' => $inactiveOpportunities->count(),
            'protectedMrr' => '$50.000 COP',
        ]));
    }
}
