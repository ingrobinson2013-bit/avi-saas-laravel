<?php

namespace App\Filament\VetAdmin\Widgets;

use App\Models\BenefitRedemption;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VetStatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $tenant = Filament::getTenant();
        $tenantId = $tenant?->id ?? session('current_tenant_id') ?? auth()->user()?->tenant_id;

        // Subscripciones activas
        $activeSubsCount = Subscription::query()
            ->where('subscriptions.status', 'active')
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->count();

        // Ingresos Recurrentes Estimados (MRR)
        $mrrReal = (float) Subscription::query()
            ->where('subscriptions.status', 'active')
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');

        // Total Mascotas
        $petsCount = Pet::query()
            ->when($tenantId, fn ($q) => $q->whereHas('customer', fn ($c) => $c->where('tenant_id', $tenantId)))
            ->count();

        // Ratio de Uso de Beneficios Clínicos (excluyendo cupos ilimitados)
        $totalGranted = (int) SubscriptionBenefitBalance::query()
            ->where('total_granted', '<', 500)
            ->when($tenantId, fn ($q) => $q->whereHas('subscription', fn ($s) => $s->where('tenant_id', $tenantId)))
            ->sum('total_granted');

        $totalUsed = (int) SubscriptionBenefitBalance::query()
            ->where('total_granted', '<', 500)
            ->when($tenantId, fn ($q) => $q->whereHas('subscription', fn ($s) => $s->where('tenant_id', $tenantId)))
            ->sum('used_count');

        // Membresías en Riesgo (Próximas a vencer en 15 días o en mora)
        $expiring15Days = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where(function ($q) {
                $q->whereBetween('current_period_end', [now(), now()->addDays(15)])
                  ->orWhere('status', 'past_due');
            })
            ->count();

        $mrrAtRisk = (float) Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where(function ($q) {
                $q->whereBetween('current_period_end', [now(), now()->addDays(15)])
                  ->orWhere('status', 'past_due');
            })
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');

        $renovDesc = $expiring15Days > 0 
            ? '$' . number_format($mrrAtRisk, 0, ',', '.') . ' COP en riesgo' 
            : 'Próximos 15 días (Al día)';

        return [
            Stat::make('Ingresos recurrentes (MRR)', '$' . number_format($mrrReal, 0, ',', '.') . ' COP')
                ->description('↑ Este mes')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Mascotas Activas', (string) $petsCount)
                ->description('Con plan preventivo al día')
                ->descriptionIcon('heroicon-m-heart')
                ->color('info'),

            Stat::make('Renovaciones Próximas', (string) $expiring15Days)
                ->description($renovDesc)
                ->descriptionIcon($expiring15Days > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-badge')
                ->color($expiring15Days > 0 ? 'warning' : 'success'),

            Stat::make('Uso de Beneficios', "{$totalUsed} / {$totalGranted} utilizados")
                ->description('Servicios canjeados este ciclo')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('primary'),
        ];
    }
}
