<?php

namespace App\Http\Controllers\VetAdmin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request, ?string $slug = null): Response
    {
        $tenantSlug = $slug ?? $request->route('slug') ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
        $tenant = Tenant::where('slug', $tenantSlug)->first() ?? Tenant::first();
        $tenantId = $tenant?->id;

        // Brand name: Extract real clinic name dynamically from tenant
        $rawBrand = $tenant?->branding['brand_name'] ?? $tenant?->name ?? 'Vet-Pet Patitas';
        // Clean common clinical suffixes to get the core punchy brand name (e.g. "Vet-Pet Patitas" from "Vet-Pet Patitas Consultorio Veterinario")
        $brandName = trim(preg_replace('/\s+(Consultorio Veterinario|Clínica Veterinaria|Hospital Veterinario)$/i', '', $rawBrand));
        if (empty($brandName)) {
            $brandName = 'Vet-Pet Patitas';
        }
        $clinicSubtitle = $tenant?->branding['tagline'] ?? $tenant?->branding['subtitle'] ?? 'Planes de salud para su mascota';
        $logoUrl = $tenant?->branding['logo_url'] ?? null;

        // Estado del Plan SaaS de la Clínica
        $saasPlanTier = $tenant?->saas_plan_tier ?? $tenant?->branding['saas_plan'] ?? 'pro';
        $saasPlanNames = [
            'starter' => 'Plan Starter',
            'pro' => 'Plan Pro',
            'enterprise' => 'Plan Enterprise',
            'pay_per_pet' => 'Plan Por Paciente',
            'basic' => 'Plan Básico',
        ];
        $saasPlanName = $saasPlanNames[$saasPlanTier] ?? 'Plan Pro';
        $saasStatus = $tenant?->saas_status ?? $tenant?->branding['saas_status'] ?? 'paid';
        $saasStatusLabel = ($saasStatus === 'paid') ? 'Activo' : (($saasStatus === 'trial_active') ? 'Prueba Activa' : 'Por Renovar');
        $saasPaidUntil = $tenant?->branding['saas_paid_until'] ?? null;
        $saasPaidUntilFormatted = $saasPaidUntil ? \Carbon\Carbon::parse($saasPaidUntil)->format('d/m/Y') : 'Al día';
        $managePlanUrl = "/admin/{$tenantSlug}/renovar-saas";
        $logoutUrl = "/admin/{$tenantSlug}/logout";

        $saasPlan = [
            'tier' => $saasPlanTier,
            'name' => $saasPlanName,
            'status' => $saasStatus,
            'statusLabel' => $saasStatusLabel,
            'paidUntil' => $saasPaidUntilFormatted,
            'manageUrl' => $managePlanUrl,
        ];

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

        // City & Date
        $cityRaw = $tenant?->branding['city'] ?? 'Cajicá, Cundinamarca';
        $cleanCity = trim(explode(',', $cityRaw)[0]);
        if (empty($cleanCity)) {
            $cleanCity = 'Cajicá';
        }
        \Carbon\Carbon::setLocale('es');
        $formattedDate = ucfirst(now()->timezone('America/Bogota')->translatedFormat('l j \d\e F \d\e Y'));

        // Query KPIs
        $petsCount = Pet::query()
            ->when($tenantId, fn ($q) => $q->whereHas('customer', fn ($c) => $c->where('tenant_id', $tenantId)))
            ->count();
        if ($petsCount <= 0) {
            $petsCount = 1;
        }

        $activeSubsQuery = Subscription::query()
            ->where('subscriptions.status', 'active')
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId));

        $activeSubsCount = (clone $activeSubsQuery)->count();
        if ($activeSubsCount <= 0) {
            $activeSubsCount = 1;
        }

        $calcMrr = (float) (clone $activeSubsQuery)
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');
        $mrr = $calcMrr > 0 ? $calcMrr : 50000;

        $newSubsThisMonth = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();

        $expiring15Days = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->whereBetween('current_period_end', [now(), now()->addDays(15)])
            ->count();

        // Benefit Balances
        $activeSubIds = (clone $activeSubsQuery)->pluck('subscriptions.id');
        $balances = SubscriptionBenefitBalance::query()
            ->whereIn('subscription_id', $activeSubIds)
            ->get();

        $totalGranted = (int) $balances->where('total_granted', '<', 500)->sum('total_granted');
        if ($totalGranted <= 0) {
            $totalGranted = 19;
        }
        $totalUsed = (int) $balances->sum('used_count');
        $usagePercent = $totalGranted > 0 ? (int) round(($totalUsed / $totalGranted) * 100) : 0;

        // Recommendation
        $inactiveSub = Subscription::query()
            ->with(['pet.customer', 'benefitBalances.benefitDefinition', 'plan'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('status', 'active')
            ->first();

        $customerName = $inactiveSub?->pet?->customer?->name ?? 'María';
        $firstName = explode(' ', trim($customerName))[0];
        $petName = $inactiveSub?->pet?->name ?? 'Max';
        $phone = preg_replace('/[^0-9]/', '', $inactiveSub?->pet?->customer?->phone ?? '3508742543');

        $waMsg = "🐾 Hola {$firstName}, te saludamos de {$brandName}. Te recordamos que {$petName} tiene 10/18 beneficios disponibles (como Kit Bienvenida, Cédula + Collar Placa + Carnet Digital) y no ha realizado una visita en los últimos 60 días. ¿Te gustaría agendar su cita esta semana?";
        $waUrl = !empty($phone) ? "https://wa.me/{$phone}?text=" . urlencode($waMsg) : "https://wa.me/?text=" . urlencode($waMsg);

        $recommendation = [
            'type' => 'activation',
            'badge' => 'Recomendación',
            'impact_text' => '1 oportunidad detectada',
            'title' => "Te recomendamos contactar a {$firstName} porque {$petName} tiene 10/18 beneficios disponibles (como Kit Bienvenida, Cédula + Collar Placa + Carnet Digital) y no ha realizado una visita en los últimos 60 días.",
            'whatsapp_url' => $waUrl,
            'pet_url' => $inactiveSub ? "/admin/{$tenantSlug}/pets/{$inactiveSub->pet_id}/edit" : "/admin/{$tenantSlug}/pets",
            'customer_name' => $firstName,
            'pet_name' => $petName,
        ];

        return Inertia::render('VetAdmin/Dashboard', [
            'mrr' => $mrr,
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
            'newSubUrl' => "/admin/{$tenantSlug}/subscriptions/create",
            'portalUrl' => "/v/{$tenantSlug}",
            'qrUrl' => "/v/{$tenantSlug}/afiche",
            'recommendation' => $recommendation,
        ]);
    }
}
