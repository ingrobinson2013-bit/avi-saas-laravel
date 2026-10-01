<?php

namespace App\Filament\VetAdmin\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class SaasSubscriptionStatusWidget extends Widget
{
    protected static ?int $sort = -1; // Primero en la parte superior
    protected int | string | array $columnSpan = 'full';
    protected static string $view = 'filament.vet-admin.widgets.saas-subscription-status';

    public ?string $slug = 'vet-pet-patitas';
    public ?string $tenantName = '';
    public string $status = 'trial_active';
    public int $daysRemaining = 14;
    public ?string $trialEndsAtFormatted = '';
    public ?string $paidUntilFormatted = '';
    public string $planTier = 'pro';
    public int $amountCop = 229000;
    public string $checkoutUrl = '';
    public bool $isJustPaid = false;

    public function mount(): void
    {
        $tenant = Filament::getTenant();
        $this->tenantName = $tenant?->name ?? 'Clínica Veterinaria';
        $this->slug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
        
        $branding = $tenant?->branding ?? [];
        $this->status = $tenant?->saas_status ?? 'trial_active';
        $this->daysRemaining = max(0, $tenant?->trial_days_remaining ?? 14);
        
        $trialEndsAt = $tenant?->trial_ends_at;
        $this->trialEndsAtFormatted = $trialEndsAt ? $trialEndsAt->format('d/m/Y') : null;
        
        $paidUntil = isset($branding['saas_paid_until']) ? \Carbon\Carbon::parse($branding['saas_paid_until']) : null;
        $this->paidUntilFormatted = $paidUntil ? $paidUntil->format('d/m/Y') : null;
        
        $this->planTier = $tenant?->saas_plan_tier ?? $branding['saas_plan'] ?? 'pro';
        $this->amountCop = (int) ($branding['saas_amount_cop'] ?? 229000);
        $this->checkoutUrl = "/admin/{$this->slug}/renovar-saas";
        $this->isJustPaid = request()->has('saas_paid') || request()->has('bold_success');
    }
}
