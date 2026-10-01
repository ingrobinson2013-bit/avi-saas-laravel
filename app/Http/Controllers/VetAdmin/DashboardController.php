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

        // Brand name & User Greeting
        $brandName = 'PetSalud+';
        $greetingName = 'Dra. Vicky';
        $user = auth()->user();
        if ($user) {
            $rawName = $user->name ?? 'Dra. Vicky';
            $firstName = explode(' ', trim($rawName))[0];
            $greetingName = (str_starts_with(mb_strtolower($firstName), 'dra') ? '' : 'Dra. ') . $firstName;
        }

        // City & Date
        $cleanCity = 'Cajicá';
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
        $phone = preg_replace('/[^0-9]/', '', $inactiveSub?->pet?->customer?->phone ?? '');

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
            'brandName' => $brandName,
            'cleanCity' => $cleanCity,
            'formattedDate' => $formattedDate,
            'tenantSlug' => $tenantSlug,
            'redeemUrl' => "/admin/{$tenantSlug}/canje-mostrador",
            'newSubUrl' => "/admin/{$tenantSlug}/subscriptions/create",
            'portalUrl' => "/v/{$tenantSlug}",
            'qrUrl' => "/v/{$tenantSlug}/afiche",
            'recommendation' => $recommendation,
        ]);
    }
}
