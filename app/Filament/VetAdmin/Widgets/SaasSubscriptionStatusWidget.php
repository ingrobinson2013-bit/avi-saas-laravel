<?php

namespace App\Filament\VetAdmin\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class SaasSubscriptionStatusWidget extends Widget
{
    protected static ?int $sort = 0; // Se muestra primero en la parte superior del Dashboard
    protected int | string | array $columnSpan = 'full';
    protected static string $view = 'filament.vet-admin.widgets.saas-subscription-status';

    public function getViewData(): array
    {
        $tenant = Filament::getTenant();
        $slug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
        
        $branding = $tenant?->branding ?? [];
        $status = $tenant?->saas_status ?? 'trial_active';
        $daysRemaining = $tenant?->trial_days_remaining ?? 14;
        $trialEndsAt = $tenant?->trial_ends_at;
        $paidUntil = isset($branding['saas_paid_until']) ? \Carbon\Carbon::parse($branding['saas_paid_until']) : null;
        $planTier = $tenant?->saas_plan_tier ?? $branding['saas_plan'] ?? 'pro';
        $amountCop = $branding['saas_amount_cop'] ?? 229000;

        return [
            'tenant' => $tenant,
            'slug' => $slug,
            'status' => $status,
            'daysRemaining' => max(0, $daysRemaining),
            'trialEndsAt' => $trialEndsAt,
            'paidUntil' => $paidUntil,
            'planTier' => $planTier,
            'amountCop' => $amountCop,
            'checkoutUrl' => "/admin/{$slug}/renovar-saas",
            'isJustPaid' => request()->has('saas_paid') || request()->has('bold_success'),
        ];
    }
}
