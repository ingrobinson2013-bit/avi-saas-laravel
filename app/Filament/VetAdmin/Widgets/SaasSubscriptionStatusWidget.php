<?php

namespace App\Filament\VetAdmin\Widgets;

use App\Models\Pet;
use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class SaasSubscriptionStatusWidget extends Widget
{
    protected static ?int $sort = -1;
    protected int | string | array $columnSpan = 'full';
    protected static string $view = 'filament.vet-admin.widgets.saas-subscription-status';

    public static function canView(): bool
    {
        $tenant = \Filament\Facades\Filament::getTenant();
        return in_array($tenant?->saas_status, ['expired', 'past_due']);
    }

    public ?string $slug = 'vet-pet-patitas';
    public ?string $tenantName = '';
    public string $status = 'trial_active';
    public int $daysRemaining = 14;
    public ?string $trialEndsAtFormatted = '';
    public ?string $paidUntilFormatted = '';
    public string $planTier = 'pro';
    public string $planName = 'Plan Pro';
    public int $petsCount = 0;
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
        
        $tenantId = $tenant?->id;
        $this->petsCount = Pet::query()
            ->when($tenantId, fn ($q) => $q->whereHas('customer', fn ($c) => $c->where('tenant_id', $tenantId)))
            ->count();

        $pricing = [
            'pay_per_pet' => 5000,
            'starter' => 99000,
            'pro' => 229000,
            'enterprise' => 489000,
        ];

        if ($this->planTier === 'pay_per_pet') {
            $unitFee = (int) ($branding['saas_per_pet_fee'] ?? 5000);
            $this->amountCop = $this->petsCount > 0 ? ($this->petsCount * $unitFee) : (int) ($branding['saas_monthly_fee'] ?? 50000);
            $this->planName = "Plan Por Mascota Activa ($" . number_format($unitFee, 0, ',', '.') . " COP/mascota)";
        } else {
            $this->amountCop = (int) ($branding['saas_monthly_fee'] ?? $pricing[$this->planTier] ?? 229000);
            $this->planName = match ($this->planTier) {
                'starter' => 'Plan Starter (Hasta 60 mascotas)',
                'pro' => 'Plan Profesional (Hasta 250 mascotas)',
                'enterprise' => 'Plan Enterprise (Ilimitado)',
                default => 'Plan Pro Oficial',
            };
        }

        $this->checkoutUrl = "/admin/{$this->slug}/renovar-saas";
        $this->isJustPaid = request()->has('saas_paid') || request()->has('bold_success');
    }
}
