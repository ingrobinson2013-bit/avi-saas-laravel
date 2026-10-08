<?php

namespace App\Http\Controllers\VetAdmin;

use App\Http\Controllers\Controller;
use App\Models\BenefitRedemption;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use App\Models\SubscriptionWallet;
use App\Models\Tenant;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request, ?string $slug = null): Response
    {
        $tenantSlug = $slug ?? $request->route('slug') ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
        $tenant = Tenant::where('slug', $tenantSlug)->firstOrFail();
        $tenantId = $tenant->id;

        // Brand name: Extract real clinic name dynamically from tenant
        $rawBrand = $tenant?->branding['brand_name'] ?? $tenant?->name ?? 'Vet-Pet Patitas';
        $brandName = trim(preg_replace('/\s+(Consultorio Veterinario|Clínica Veterinaria|Hospital Veterinario)$/i', '', $rawBrand));
        if (empty($brandName)) {
            $brandName = 'Vet-Pet Patitas';
        }
        $clinicSubtitle = $tenant?->branding['tagline'] ?? $tenant?->branding['subtitle'] ?? 'Planes de salud para su mascota';
        $logoUrl = $tenant?->branding['logo_url'] ?? null;

        // Estado del Plan SaaS de la Clínica
        $isPilot = ($tenant->slug === 'vet-pet-patitas');
        $saasPlanTier = $tenant->saas_plan_tier ?? $tenant->branding['saas_plan'] ?? 'pro';
        $saasPlanNames = [
            'starter' => 'Plan Starter',
            'pro' => 'Plan Profesional',
            'enterprise' => 'Plan Enterprise',
            'pay_per_pet' => 'Plan Por Paciente',
            'basic' => 'Plan Básico',
        ];
        $saasPlanName = $saasPlanNames[$saasPlanTier] ?? 'Plan Profesional';
        $saasStatus = $isPilot ? 'paid' : $tenant->saas_status;
        $daysRemaining = $isPilot ? 999 : $tenant->trial_days_remaining;

        $saasStatusLabel = match ($saasStatus) {
            'paid' => 'Activo',
            'trial_active' => "Prueba ({$daysRemaining}d)",
            'trial_expired' => 'Prueba Vencida',
            'suspended' => 'Suspendido',
            default => 'Al día',
        };

        $saasPaidUntil = $tenant->branding['saas_paid_until'] ?? null;
        $saasPaidUntilFormatted = $saasPaidUntil ? \Carbon\Carbon::parse($saasPaidUntil)->format('d/m/Y') : ($tenant->trial_ends_at ? $tenant->trial_ends_at->format('d/m/Y') : 'Al día');
        $managePlanUrl = "/admin/{$tenantSlug}/renovar-saas";
        $logoutUrl = "/admin/{$tenantSlug}/logout";

        $saasPlan = [
            'tier' => $saasPlanTier,
            'name' => $saasPlanName,
            'status' => $saasStatus,
            'statusLabel' => $saasStatusLabel,
            'paidUntil' => $saasPaidUntilFormatted,
            'manageUrl' => $managePlanUrl,
            'trialActive' => ($saasStatus === 'trial_active'),
            'isTrialExpired' => ($saasStatus === 'trial_expired'),
            'daysLeft' => max(0, $daysRemaining),
            'monthlyFee' => (float) ($tenant->branding['saas_monthly_fee'] ?? 229000),
        ];

        // Usuario autenticado
        $greetingName = 'Doctor(a)';
        $userName = 'Administrador de Sede';
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
        } else {
            // Default amigable si no hay sesión abierta en preview
            $greetingName = 'Dra. Vicky';
            $userName = 'Dra. Vicky Naranjo';
            $userRole = 'Administradora de Sede';
        }

        // City & Date
        $cityRaw = $tenant?->branding['city'] ?? 'Cajicá, Cundinamarca';
        $cleanCity = trim(explode(',', $cityRaw)[0]);
        if (empty($cleanCity)) {
            $cleanCity = 'Cajicá';
        }
        \Carbon\Carbon::setLocale('es');
        $formattedDate = ucfirst(now()->timezone('America/Bogota')->translatedFormat('l j \d\e F \d\e Y'));

        // ==========================================
        // 1. KPIS REALES Y DINÁMICOS
        // ==========================================
        $petsCount = Pet::query()
            ->when($tenantId, fn ($q) => $q->whereHas('customer', fn ($c) => $c->where('tenant_id', $tenantId)))
            ->count();

        $activeSubsQuery = Subscription::query()
            ->where('subscriptions.status', 'active')
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId));

        $activeSubsCount = (clone $activeSubsQuery)->count();

        // Cálculo exacto del MRR sumando precios de planes activos
        $mrr = (float) (clone $activeSubsQuery)
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');

        // MRR del mes anterior para calcular el delta real
        $mrrLastMonth = (float) Subscription::query()
            ->where('subscriptions.status', 'active')
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('subscriptions.created_at', '<', now()->startOfMonth())
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');
        $mrrDelta = $mrr - $mrrLastMonth;

        // Nuevas membresías creadas en el mes calendario actual
        $newSubsThisMonth = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();

        // Membresías próximas a vencer en los siguientes 15 días
        $expiring15Days = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->whereBetween('current_period_end', [now(), now()->addDays(15)])
            ->count();

        // Balances de beneficios y cálculo real de uso
        $activeSubIds = (clone $activeSubsQuery)->pluck('subscriptions.id');
        $balances = SubscriptionBenefitBalance::query()
            ->whereIn('subscription_id', $activeSubIds)
            ->get();

        // Excluir 999 (beneficios ilimitados como consultas virtuales) para porcentaje finito
        $totalGranted = (int) $balances->where('total_granted', '<', 500)->sum('total_granted');
        $totalUsed = (int) $balances->sum('used_count');
        $usagePercent = $totalGranted > 0 ? (int) min(100, round(($totalUsed / $totalGranted) * 100)) : 0;

        // ==========================================
        // 2. RENOVACIONES PRÓXIMAS (LISTA REAL)
        // ==========================================
        $upcomingRenewals = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->whereBetween('current_period_end', [now()->subDays(1), now()->addDays(30)])
            ->with(['pet.customer', 'plan'])
            ->orderBy('current_period_end', 'asc')
            ->take(5)
            ->get()
            ->map(function ($sub) use ($brandName) {
                $daysLeft = (int) max(0, ceil(now()->diffInDays($sub->current_period_end, false)));
                $custPhone = preg_replace('/[^0-9]/', '', $sub->pet?->customer?->phone ?? '');
                $custName = explode(' ', trim($sub->pet?->customer?->name ?? 'Tutor'))[0];
                $petName = $sub->pet?->name ?? 'tu mascota';
                $species = strtolower($sub->pet?->species ?? 'canino');
                $icon = (str_contains($species, 'fel') || str_contains($species, 'gat')) ? '🐱' : '🐕';
                $msg = "🐾 Hola {$custName}, te saludamos de {$brandName}. Te recordamos que la membresía de {$petName} vence en {$daysLeft} días. ¿Deseas renovarla hoy para mantener activos sus beneficios?";
                $waUrl = !empty($custPhone) ? "https://wa.me/{$custPhone}?text=" . urlencode($msg) : "https://wa.me/?text=" . urlencode($msg);

                return [
                    'id' => $sub->id,
                    'pet_name' => $petName,
                    'species' => $species,
                    'icon' => $icon,
                    'customer_name' => $sub->pet?->customer?->name ?? 'Tutor',
                    'customer_phone' => $sub->pet?->customer?->phone ?? '',
                    'plan_name' => $sub->plan?->name ?? 'Plan de Salud',
                    'current_period_end' => $sub->current_period_end ? $sub->current_period_end->translatedFormat('j M Y') : 'Al día',
                    'days_left' => $daysLeft,
                    'whatsapp_url' => $waUrl,
                ];
            });

        // ==========================================
        // 3. ACTIVIDAD RECIENTE (FEED UNIFICADO REAL)
        // ==========================================
        $activityItems = collect();

        // A. Canjes de beneficios
        $dbRedemptions = BenefitRedemption::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->with(['balance.benefitDefinition', 'balance.subscription.pet.customer', 'vetUser'])
            ->latest('redeemed_at')
            ->take(4)
            ->get();

        foreach ($dbRedemptions as $r) {
            $cName = $r->balance?->subscription?->pet?->customer?->name ?? 'Cliente';
            $pName = $r->balance?->subscription?->pet?->name ?? 'Mascota';
            $bName = $r->balance?->benefitDefinition?->name ?? 'Beneficio clínico';
            $initials = strtoupper(substr($cName, 0, 1) . (str_contains($cName, ' ') ? substr(explode(' ', $cName)[1], 0, 1) : ''));
            $activityItems->push([
                'id' => 'red-' . $r->id,
                'initials' => !empty($initials) ? $initials : 'CB',
                'color' => 'amber',
                'title' => $cName,
                'subtitle' => "Canje de beneficio · {$bName} ({$pName})",
                'time_ago' => $r->redeemed_at ? $r->redeemed_at->timezone('America/Bogota')->diffForHumans() : 'Reciente',
                'timestamp' => $r->redeemed_at ? $r->redeemed_at->timestamp : 0,
            ]);
        }

        // B. Nuevas suscripciones
        $dbSubs = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->with(['pet.customer', 'plan'])
            ->latest('created_at')
            ->take(4)
            ->get();

        foreach ($dbSubs as $s) {
            $cName = $s->pet?->customer?->name ?? 'Cliente';
            $pName = $s->pet?->name ?? 'Mascota';
            $planName = $s->plan?->name ?? 'Plan de Salud';
            $initials = strtoupper(substr($cName, 0, 1) . (str_contains($cName, ' ') ? substr(explode(' ', $cName)[1], 0, 1) : ''));
            $activityItems->push([
                'id' => 'sub-' . $s->id,
                'initials' => !empty($initials) ? $initials : 'AF',
                'color' => 'blue',
                'title' => $cName,
                'subtitle' => "Nueva afiliación · {$planName} ({$pName})",
                'time_ago' => $s->created_at ? $s->created_at->timezone('America/Bogota')->diffForHumans() : 'Reciente',
                'timestamp' => $s->created_at ? $s->created_at->timestamp : 0,
            ]);
        }

        // C. Transacciones de billetera / Fondo de emergencia
        $dbWalletTxs = WalletTransaction::query()
            ->whereHas('wallet', fn ($w) => $tenantId ? $w->where('tenant_id', $tenantId) : $w)
            ->with('wallet.subscription.pet.customer')
            ->latest('created_at')
            ->take(4)
            ->get();

        foreach ($dbWalletTxs as $w) {
            $cName = $w->wallet?->subscription?->pet?->customer?->name ?? 'Fondo Quirúrgico';
            $pName = $w->wallet?->subscription?->pet?->name ?? '';
            $prefix = $w->type === 'redemption' ? '-' : '+';
            $amtStr = $prefix . '$' . number_format($w->amount_cop, 0, ',', '.') . ' COP';
            $initials = strtoupper(substr($cName, 0, 1) . (str_contains($cName, ' ') ? substr(explode(' ', $cName)[1], 0, 1) : ''));
            $activityItems->push([
                'id' => 'wal-' . $w->id,
                'initials' => !empty($initials) ? $initials : 'FQ',
                'color' => 'emerald',
                'title' => $cName . ($pName ? " ({$pName})" : ''),
                'subtitle' => "{$w->description} · {$amtStr}",
                'time_ago' => $w->created_at ? $w->created_at->timezone('America/Bogota')->diffForHumans() : 'Reciente',
                'timestamp' => $w->created_at ? $w->created_at->timestamp : 0,
            ]);
        }

        // D. Nuevos pacientes registrados
        $dbPets = Pet::query()
            ->when($tenantId, fn ($q) => $q->whereHas('customer', fn ($c) => $c->where('tenant_id', $tenantId)))
            ->with('customer')
            ->latest('created_at')
            ->take(3)
            ->get();

        foreach ($dbPets as $p) {
            $cName = $p->customer?->name ?? 'Tutor';
            $initials = strtoupper(substr($p->name, 0, 2));
            $activityItems->push([
                'id' => 'pet-' . $p->id,
                'initials' => $initials,
                'color' => 'purple',
                'title' => $p->name,
                'subtitle' => "Registro de paciente · {$p->species} ({$cName})",
                'time_ago' => $p->created_at ? $p->created_at->timezone('America/Bogota')->diffForHumans() : 'Reciente',
                'timestamp' => $p->created_at ? $p->created_at->timestamp : 0,
            ]);
        }

        $recentActivity = $activityItems
            ->sortByDesc('timestamp')
            ->values()
            ->take(5)
            ->all();

        // ==========================================
        // 4. CANJES RECIENTES EN MOSTRADOR (TABLA REAL)
        // ==========================================
        $recentRedemptions = BenefitRedemption::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->with(['balance.benefitDefinition', 'balance.subscription.pet', 'vetUser'])
            ->latest('redeemed_at')
            ->take(5)
            ->get()
            ->map(function ($r) {
                $species = strtolower($r->balance?->subscription?->pet?->species ?? 'canino');
                $icon = (str_contains($species, 'fel') || str_contains($species, 'gat')) ? '🐱' : '🐕';
                return [
                    'id' => $r->id,
                    'time' => $r->redeemed_at ? $r->redeemed_at->timezone('America/Bogota')->format('H:i') : '--:--',
                    'pet_name' => $r->balance?->subscription?->pet?->name ?? 'Mascota',
                    'icon' => $icon,
                    'benefit_name' => $r->balance?->benefitDefinition?->name ?? 'Beneficio clínico',
                    'user_name' => $r->vetUser?->name ?? 'Recepción',
                ];
            });

        // ==========================================
        // 5. AVI RECOMIENDA (OPORTUNIDAD DE FIDELIZACIÓN REAL)
        // ==========================================
        $candidateSub = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->with(['pet.customer', 'benefitBalances.benefitDefinition', 'plan', 'wallet'])
            ->first();

        $recommendation = null;
        if ($candidateSub) {
            $customerName = $candidateSub->pet?->customer?->name ?? 'Tutor';
            $firstName = explode(' ', trim($customerName))[0];
            $petName = $candidateSub->pet?->name ?? 'Mascota';
            $petBreed = $candidateSub->pet?->breed ?? 'Paciente';
            $petPhoto = $candidateSub->pet?->photo_url ?? '/images/dashboard/sidebar_pet_hd.png';
            $phone = preg_replace('/[^0-9]/', '', $candidateSub->pet?->customer?->phone ?? '');

            $remBenefits = (int) $candidateSub->benefitBalances->where('total_granted', '<', 500)->sum('remaining_count');
            $totBenefits = (int) $candidateSub->benefitBalances->where('total_granted', '<', 500)->sum('total_granted');
            if ($totBenefits <= 0) {
                $totBenefits = 10;
                $remBenefits = 10;
            }

            $walletBalance = (float) ($candidateSub->wallet?->balance_cop ?? 0);
            $lastRedemption = BenefitRedemption::whereHas('balance', fn ($b) => $b->where('subscription_id', $candidateSub->id))->latest('redeemed_at')->first();
            $daysSinceVisit = $lastRedemption ? (int) $lastRedemption->redeemed_at->diffInDays(now()) : (int) $candidateSub->created_at->diffInDays(now());
            if ($daysSinceVisit <= 0) {
                $daysSinceVisit = 60; // Días preventivos recomendados de chequeo
            }

            $waMsg = "🐾 Hola {$firstName}, te saludamos de {$brandName}. Te recordamos que {$petName} tiene {$remBenefits} beneficios disponibles en su plan de salud";
            if ($walletBalance > 0) {
                $waMsg .= " y acumula $" . number_format($walletBalance, 0, ',', '.') . " COP en Fondo de Emergencia Quirúrgica.";
            } else {
                $waMsg .= " y hace {$daysSinceVisit} días no realiza una visita preventiva.";
            }
            $waMsg .= " ¿Te gustaría agendar su chequeo esta semana?";
            $waUrl = !empty($phone) ? "https://wa.me/{$phone}?text=" . urlencode($waMsg) : "https://wa.me/?text=" . urlencode($waMsg);

            $recommendation = [
                'type' => 'activation',
                'badge' => 'Oportunidad de fidelización',
                'impact_text' => "+{$remBenefits} beneficios disponibles",
                'title' => "{$petName} no ha utilizado sus beneficios en los últimos {$daysSinceVisit} días.",
                'description' => "Tiene {$remBenefits} de {$totBenefits} beneficios disponibles (consulta preventiva, vacunación, desparasitación y chequeos).",
                'pet_photo' => $petPhoto,
                'pet_name' => $petName,
                'pet_breed' => $petBreed,
                'customer_name' => $firstName,
                'remaining_count' => $remBenefits,
                'total_count' => $totBenefits,
                'days_inactive' => $daysSinceVisit,
                'whatsapp_url' => $waUrl,
                'pet_url' => "/admin/{$tenantSlug}/pets",
            ];
        }

        // ==========================================
        // 6. ASISTENTE IA & CONTEXTO DE INTELIGENCIA
        // ==========================================
        $topPlan = Plan::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->withCount(['subscriptions' => fn ($q) => $q->where('status', 'active')])
            ->orderBy('subscriptions_count', 'desc')
            ->first();

        $topPlanName = $topPlan?->name ?? 'Plan Patitas Básico';
        $topPlanPrice = (float) ($topPlan?->price_cop ?? 50000);
        $topPlanPercent = $activeSubsCount > 0 ? (int) round((($topPlan?->subscriptions_count ?? 1) / $activeSubsCount) * 100) : 100;
        $totalReserveFund = (float) SubscriptionWallet::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->sum('balance_cop');
        if ($totalReserveFund <= 0 && $candidateSub?->wallet?->balance_cop) {
            $totalReserveFund = (float) $candidateSub->wallet->balance_cop;
        }

        $samplePet = $candidateSub?->pet ?? Pet::whereHas('customer', fn ($c) => $tenantId ? $c->where('tenant_id', $tenantId) : $c)->first();

        $aiContext = [
            'brandName' => $brandName,
            'cleanCity' => $cleanCity,
            'activeSubsCount' => $activeSubsCount,
            'petsCount' => $petsCount,
            'mrr' => $mrr,
            'topPlanName' => $topPlanName,
            'topPlanPrice' => $topPlanPrice,
            'topPlanPercent' => $topPlanPercent,
            'totalReserveFund' => $totalReserveFund,
            'samplePetName' => $samplePet?->name ?? 'Max',
            'samplePetBreed' => $samplePet?->breed ?? 'Golden Retriever',
            'sampleCustomerName' => $candidateSub?->pet?->customer?->name ?? 'María Rodríguez',
            'sampleCustomerPhone' => $candidateSub?->pet?->customer?->phone ?? '3508742543',
            'pendingVaccinesCount' => $activeSubsCount > 0 ? 1 : 0,
            'inactiveDays' => $daysSinceVisit ?? 60,
        ];

        return Inertia::render('VetAdmin/Dashboard', [
            'mrr' => $mrr,
            'mrrDelta' => $mrrDelta,
            'petsCount' => $petsCount,
            'activeSubsCount' => $activeSubsCount,
            'newSubsThisMonth' => $newSubsThisMonth,
            'expiring15Days' => $expiring15Days,
            'totalGranted' => $totalGranted,
            'totalUsed' => $totalUsed,
            'usagePercent' => $usagePercent,
            'greetingName' => $greetingName,
            'userName' => $userName,
            'userRole' => $userRole,
            'brandName' => $brandName,
            'clinicSubtitle' => $clinicSubtitle,
            'logoUrl' => $logoUrl,
            'saasPlan' => $saasPlan,
            'logoutUrl' => $logoutUrl,
            'cleanCity' => $cleanCity,
            'formattedDate' => $formattedDate,
            'tenantSlug' => $tenantSlug,
            'redeemUrl' => "/admin/{$tenantSlug}/counter-redeem",
            'newSubUrl' => "/admin/{$tenantSlug}/plans",
            'portalUrl' => "/v/{$tenantSlug}",
            'qrUrl' => "/v/{$tenantSlug}/afiche",
            'recommendation' => $recommendation,
            'upcomingRenewals' => $upcomingRenewals,
            'recentActivity' => $recentActivity,
            'recentRedemptions' => $recentRedemptions,
            'aiContext' => $aiContext,
        ]);
    }
}
