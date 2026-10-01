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

        // Comparativa de MRR contra mes anterior
        $prevMonthMrr = (float) Subscription::query()
            ->where('subscriptions.status', 'active')
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('subscriptions.created_at', '<', now()->startOfMonth())
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');

        $mrrDiff = $mrrReal - $prevMonthMrr;
        $mrrDesc = $prevMonthMrr > 0
            ? (($mrrDiff >= 0 ? '+$' : '-$') . number_format(abs($mrrDiff), 0, ',', '.') . ' vs. mes anterior')
            : 'Ingresos recurrentes actuales';

        // Total Mascotas
        $petsCount = Pet::query()
            ->when($tenantId, fn ($q) => $q->whereHas('customer', fn ($c) => $c->where('tenant_id', $tenantId)))
            ->count();

        // Nuevas Afiliaciones este mes
        $newSubsThisMonth = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();

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
            ? '$' . number_format($mrrAtRisk, 0, ',', '.') . ' en riesgo' 
            : 'Próximos 15 días';

        return [
            // 1. MRR
            Stat::make('Ingresos recurrentes (MRR)', '$' . number_format($mrrReal, 0, ',', '.') . ' COP')
                ->description($mrrDesc)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            // 2. Mascotas Activas
            Stat::make('Mascotas Activas', (string) $petsCount)
                ->description($activeSubsCount . ($activeSubsCount === 1 ? ' plan activo' : ' planes activos'))
                ->descriptionIcon('heroicon-m-heart')
                ->color('info'),

            // 3. Nuevas Afiliaciones (Clave para saber si la veterinaria está creciendo)
            Stat::make('Nuevas Afiliaciones', '+' . $newSubsThisMonth)
                ->description('Este mes')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('primary'),

            // 4. Renovaciones
            Stat::make('Renovaciones', (string) $expiring15Days)
                ->description($renovDesc)
                ->descriptionIcon($expiring15Days > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-badge')
                ->color($expiring15Days > 0 ? 'warning' : 'gray'),
        ];
    }
}
