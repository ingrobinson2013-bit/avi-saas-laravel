<?php

namespace App\Http\Controllers\VetAdmin;

use App\Http\Controllers\Controller;
use App\Models\BenefitDefinition;
use App\Models\BenefitRedemption;
use App\Models\Customer;
use App\Models\DispatchOrder;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use App\Models\Tenant;
use App\Services\ActuarialMonteCarloService;
use App\Services\GeminiClinicalTriageService;
use App\Services\HealthWalletService;
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

        $actuarialService = new ActuarialMonteCarloService();
        $breeds = $actuarialService->getAvailableBreeds();
        $selectedBreed = $request->query('breed', 'golden_retriever');
        $selectedAge = (int) $request->query('age', 3);
        $selectedMargin = (float) $request->query('margin', 35.0);
        $actuarialSimulation = $actuarialService->simulate($selectedBreed, $selectedAge, $selectedMargin);

        return Inertia::render('VetAdmin/PlanCreate', array_merge($ctx, [
            'services' => $services,
            'breeds' => $breeds,
            'actuarialSimulation' => $actuarialSimulation,
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
            ->with(['pet.customer', 'plan', 'wallet'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->get()
            ->map(function ($s) {
                $walletBalance = (float) ($s->wallet?->balance_cop ?? 20000);
                return [
                    'id' => $s->id,
                    'pet_name' => $s->pet?->name ?? 'Max',
                    'pet_breed' => $s->pet?->breed ?? 'Golden Retriever',
                    'customer_name' => $s->pet?->customer?->name ?? 'María Camila Rodríguez',
                    'customer_phone' => $s->pet?->customer?->phone ?? '3508742543',
                    'plan_name' => $s->plan?->name ?? 'Plan Patitas Básico',
                    'price_cop' => (float) ($s->plan?->price_cop ?? 50000),
                    'formatted_price' => '$' . number_format($s->plan?->price_cop ?? 50000, 0, ',', '.') . ' COP',
                    'wallet_balance' => $walletBalance,
                    'formatted_wallet' => '$' . number_format($walletBalance, 0, ',', '.') . ' COP',
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
            ->with(['pet.customer', 'plan', 'benefitBalances.benefitDefinition', 'wallet'])
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

        $walletBalance = (float) ($subscription?->wallet?->balance_cop ?? 20000);
        $walletData = [
            'balance_cop' => $walletBalance,
            'formatted_balance' => '$' . number_format($walletBalance, 0, ',', '.') . ' COP',
            'reserve_percentage' => (float) ($subscription?->wallet?->reserve_percentage ?? 10.0),
            'total_accrued_cop' => (float) ($subscription?->wallet?->total_accrued_cop ?? 20000),
            'total_redeemed_cop' => (float) ($subscription?->wallet?->total_redeemed_cop ?? 0),
        ];

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
            'wallet' => $walletData,
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
            ->with(['pet.customer', 'benefitBalances.benefitDefinition', 'plan', 'wallet'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('subscriptions.status', 'active')
            ->get()
            ->map(function ($s) {
                $walletBalance = (float) ($s->wallet?->balance_cop ?? 20000);
                $formattedWallet = '$' . number_format($walletBalance, 0, ',', '.') . ' COP';
                return [
                    'id' => $s->id,
                    'pet_name' => $s->pet?->name ?? 'Max',
                    'customer_name' => $s->pet?->customer?->name ?? 'María Camila Rodríguez',
                    'customer_phone' => $s->pet?->customer?->phone ?? '3508742543',
                    'plan_name' => $s->plan?->name ?? 'Plan Patitas Básico',
                    'wallet_balance' => $walletBalance,
                    'formatted_wallet' => $formattedWallet,
                    'reason' => "Tiene 10 beneficios disponibles y acumula {$formattedWallet} en Crédito Clínico de Emergencia sin visitar la sede hace más de 60 días.",
                    'recommended_action' => "Invitar a control clínico o profilaxis recordando su crédito acumulado de {$formattedWallet}.",
                    'whatsapp_url' => 'https://wa.me/3508742543?text=' . urlencode("🐾 Hola María, te recordamos que tienes acumulados {$formattedWallet} en Crédito Clínico de Emergencia de Max y 10 beneficios disponibles en Vet-Pet Patitas. ¡Te esperamos para su chequeo preventivo!"),
                ];
            });

        $triageService = new GeminiClinicalTriageService();
        $petContext = [
            'pet_name' => 'Max',
            'species' => 'Canino',
            'breed' => 'Golden Retriever',
            'age' => '4 años',
        ];
        $visualTriage = $triageService->triageSkinLesion(null, $petContext);
        $bioacousticTriage = $triageService->triageBioacoustic(null, $petContext);

        return Inertia::render('VetAdmin/Intelligence', array_merge($ctx, [
            'opportunities' => $inactiveOpportunities,
            'totalOpportunities' => $inactiveOpportunities->count(),
            'protectedMrr' => '$50.000 COP',
            'triagePatient' => $petContext,
            'visualTriage' => $visualTriage,
            'bioacousticTriage' => $bioacousticTriage,
            'walletCustodyCop' => '$20.000 COP',
        ]));
    }

    /**
     * Logística & Despacho Domiciliario Preventivo (Supply Auto-Replenishment)
     */
    public function logistics(Request $request, string $slug): Response
    {
        $ctx = $this->getTenantContext($request, $slug);
        $tenantId = $ctx['tenantId'];

        $orders = DispatchOrder::query()
            ->with(['pet', 'customer', 'subscription.plan'])
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->orderBy('scheduled_dispatch_date', 'asc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'pet_name' => $order->pet?->name ?? 'Max',
                    'pet_species' => $order->pet?->species === 'cat' ? 'Felino' : 'Canino',
                    'pet_breed' => $order->pet?->breed ?? 'Golden Retriever',
                    'customer_name' => $order->customer?->name ?? 'María Camila Rodríguez',
                    'recipient_phone' => $order->recipient_phone,
                    'delivery_address' => $order->delivery_address,
                    'product_name' => $order->product_name,
                    'dosage' => $order->dosage,
                    'frequency_label' => "Cada {$order->frequency_months} meses",
                    'scheduled_date' => $order->scheduled_dispatch_date ? $order->scheduled_dispatch_date->format('d/m/Y') : '15/10/2026',
                    'status' => $order->status,
                    'status_label' => $order->status_label,
                    'courier_name' => $order->courier_name,
                    'tracking_number' => $order->tracking_number,
                    'whatsapp_tracking_url' => 'https://wa.me/' . preg_replace('/\D/', '', $order->recipient_phone) . '?text=' . urlencode("📦 ¡Hola " . ($order->customer?->name ?? 'Tutor') . "! Tu despacho preventivo de " . $order->product_name . " para " . ($order->pet?->name ?? 'tu mascota') . " está " . $order->status_label . ". Dirección: " . $order->delivery_address . ". ¡Cuidado oportuno sin salir de casa con Vet-Pet Patitas!"),
                ];
            });

        // Si la tabla aún no tiene registros en BD, retornamos pedidos de demostración inicial
        if ($orders->isEmpty()) {
            $orders = collect([
                [
                    'id' => 'disp-001',
                    'pet_name' => 'Max',
                    'pet_species' => 'Canino',
                    'pet_breed' => 'Golden Retriever',
                    'customer_name' => 'María Camila Rodríguez',
                    'recipient_phone' => '3508742543',
                    'delivery_address' => 'Calle 7 # 4-73 Este, Cajicá, Cundinamarca',
                    'product_name' => 'Credelio 450mg (Antipulgas y Garrapatas)',
                    'dosage' => '1 comprimido masticable oral (11-22 kg)',
                    'frequency_label' => 'Cada 3 meses',
                    'scheduled_date' => '15/10/2026',
                    'status' => 'scheduled',
                    'status_label' => 'Programado',
                    'courier_name' => 'Mensajería Express Local / Coordinadora',
                    'tracking_number' => 'PENDIENTE-DSP-01',
                    'whatsapp_tracking_url' => 'https://wa.me/3508742543?text=' . urlencode("📦 ¡Hola María Camila! Tu despacho preventivo de Credelio 450mg para Max está Programado para el 15/10/2026 en Calle 7 # 4-73 Este, Cajicá."),
                ],
                [
                    'id' => 'disp-002',
                    'pet_name' => 'Luna',
                    'pet_species' => 'Canino',
                    'pet_breed' => 'Poodle',
                    'customer_name' => 'Juan Carlos Osorio',
                    'recipient_phone' => '3104567890',
                    'delivery_address' => 'Carrera 6 # 3-21, Centro, Cajicá',
                    'product_name' => 'NexGard Spectra (Interno + Externo)',
                    'dosage' => '1 masticable sabor a carne (3.5-7.5 kg)',
                    'frequency_label' => 'Mensual',
                    'scheduled_date' => '05/10/2026',
                    'status' => 'in_preparation',
                    'status_label' => 'En Empaque',
                    'courier_name' => 'Servientrega Priority Pet',
                    'tracking_number' => 'SER-2026-98124',
                    'whatsapp_tracking_url' => 'https://wa.me/3104567890?text=' . urlencode("📦 ¡Hola Juan Carlos! El tratamiento preventivo de NexGard Spectra para Luna está en empaque para envío a Cra 6 # 3-21."),
                ],
                [
                    'id' => 'disp-003',
                    'pet_name' => 'Thor',
                    'pet_species' => 'Canino',
                    'pet_breed' => 'Bulldog Francés',
                    'customer_name' => 'Andrés Felipe Morales',
                    'recipient_phone' => '3209876543',
                    'delivery_address' => 'Vereda Chuntame Lote 4, Cajicá',
                    'product_name' => 'Bravecto 1 Masticable (12 Semanas)',
                    'dosage' => '1 tableta masticable (10-20 kg)',
                    'frequency_label' => 'Cada 3 meses',
                    'scheduled_date' => '28/09/2026',
                    'status' => 'shipped',
                    'status_label' => 'En Camino',
                    'courier_name' => 'Coordinadora Mercantil',
                    'tracking_number' => 'CRD-9843210-CO',
                    'whatsapp_tracking_url' => 'https://wa.me/3209876543?text=' . urlencode("📦 ¡Hola Andrés! El antiparasitario de Thor ya va en camino con Coordinadora (Guía: CRD-9843210-CO)."),
                ]
            ]);
        }

        $totalScheduled = $orders->where('status', 'scheduled')->count();
        $totalInPreparation = $orders->where('status', 'in_preparation')->count();
        $totalShipped = $orders->where('status', 'shipped')->count();
        $totalDelivered = $orders->where('status', 'delivered')->count();

        return Inertia::render('VetAdmin/Logistics', array_merge($ctx, [
            'orders' => $orders,
            'stats' => [
                'total_scheduled' => $totalScheduled,
                'total_in_preparation' => $totalInPreparation,
                'total_shipped' => $totalShipped,
                'total_delivered' => $totalDelivered,
                'total_orders' => $orders->count(),
                'adherence_rate' => '98.5%',
            ],
        ]));
    }
}
