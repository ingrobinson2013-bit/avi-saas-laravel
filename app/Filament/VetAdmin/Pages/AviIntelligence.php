<?php

namespace App\Filament\VetAdmin\Pages;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class AviIntelligence extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationLabel = 'AVI Recomienda';
    protected static ?string $navigationGroup = '🤖 Inteligencia';
    protected static ?int $navigationSort = 1;
    protected static ?string $title = 'AVI Intelligence · Copiloto de Retención & Crecimiento';
    protected static ?string $slug = 'inteligencia';
    protected static string $view = 'filament.vet-admin.pages.avi-intelligence';

    public Collection $inactiveOpportunities;
    public Collection $expiringSubscriptions;
    public int $totalOpportunitiesCount = 0;
    public float $estimatedRecoverableMrr = 0;

    public function mount(): void
    {
        $tenant = Filament::getTenant();
        $tenantId = $tenant?->id ?? session('current_tenant_id') ?? auth()->user()?->tenant_id;

        // 1. Pacientes con beneficios disponibles sin usar en los últimos 60 días
        $this->inactiveOpportunities = Subscription::query()
            ->with(['pet.customer', 'benefitBalances.benefitDefinition', 'plan'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('subscriptions.status', 'active')
            ->whereDoesntHave('benefitBalances.redemptions', fn ($q) => $q->where('redeemed_at', '>=', now()->subDays(60)))
            ->get();

        $this->totalOpportunitiesCount = $this->inactiveOpportunities->count();

        // 2. Membresías que vencen en los próximos 15 días
        $this->expiringSubscriptions = Subscription::query()
            ->with(['pet.customer', 'plan'])
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('subscriptions.status', 'active')
            ->whereBetween('current_period_end', [now(), now()->addDays(15)])
            ->orderBy('current_period_end', 'asc')
            ->get();

        $this->estimatedRecoverableMrr = (float) $this->expiringSubscriptions->sum(fn ($s) => $s->plan?->price_cop ?? 0);
    }
}
