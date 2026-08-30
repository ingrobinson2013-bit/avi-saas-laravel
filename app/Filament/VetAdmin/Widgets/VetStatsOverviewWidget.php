<?php

namespace App\Filament\VetAdmin\Widgets;

use App\Models\BenefitRedemption;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Subscription;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VetStatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

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
        $mrr = (float) Subscription::query()
            ->where('subscriptions.status', 'active')
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');

        // Total Mascotas Afiliadas
        $petsCount = Pet::query()
            ->when($tenantId, fn ($q) => $q->whereHas('customer', fn ($c) => $c->where('tenant_id', $tenantId)))
            ->count();

        // Total Tutores
        $customersCount = Customer::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->count();

        // Canjes del mes
        $redemptionsThisMonth = BenefitRedemption::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->whereMonth('redeemed_at', now()->month)
            ->whereYear('redeemed_at', now()->year)
            ->sum('quantity');

        // Subscripciones por vencer (próximos 7 días)
        $expiringSoon = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('subscriptions.tenant_id', $tenantId))
            ->where('subscriptions.status', 'active')
            ->whereBetween('current_period_end', [now(), now()->addDays(7)])
            ->count();

        return [
            Stat::make('Membresías Activas', $activeSubsCount)
                ->description("{$expiringSoon} por renovar esta semana")
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('success')
                ->chart([max(0, $activeSubsCount - 2), max(0, $activeSubsCount - 1), $activeSubsCount]),

            Stat::make('Ingresos Recurrentes (MRR)', '$' . number_format($mrr, 0, ',', '.') . ' COP')
                ->description('Membresías activas mensuales')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info')
                ->chart([$mrr * 0.8, $mrr * 0.9, $mrr]),

            Stat::make('Pacientes y Tutores', "{$petsCount} mascotas / {$customersCount} tutores")
                ->description('Base de datos fidelizada')
                ->descriptionIcon('heroicon-m-heart')
                ->color('primary'),

            Stat::make('Servicios Canjeados este Mes', "{$redemptionsThisMonth} atenciones")
                ->description('Valor y ahorro generado en clínica')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('warning'),
        ];
    }
}
