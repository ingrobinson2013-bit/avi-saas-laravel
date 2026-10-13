<?php

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\Subscription;
use App\Models\Tenant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SuperAdminStatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columns = [
        'default' => 1,
        'sm' => 2,
        'lg' => 4,
    ];

    protected function getStats(): array
    {
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('is_active', true)->count();
        
        $trialTenants = Tenant::all()->filter(fn ($t) => $t->saas_status === 'trial_active')->count();
        $paidTenants = Tenant::all()->filter(fn ($t) => $t->saas_status === 'paid')->count();
        $expiredTrials = Tenant::all()->filter(fn ($t) => $t->saas_status === 'trial_expired')->count();

        $totalPets = Pet::count();
        $totalCustomers = Customer::count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();

        // Ingresos SaaS Mensuales Proyectados
        $monthlySaasRevenue = Tenant::all()->sum(function ($t) {
            if ($t->saas_status === 'paid') {
                return (float) ($t->branding['saas_monthly_fee'] ?? 99000);
            }
            return 0;
        });

        // Ingresos generados por las clínicas veterinarias a través de sus planes
        $totalGMV = Subscription::query()
            ->where('subscriptions.status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');

        return [
            Stat::make('Red de Clínicas', "{$totalTenants} Clínicas")
                ->description("{$paidTenants} oficiales pagas • {$trialTenants} en prueba")
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary')
                ->chart([1, 2, $totalTenants]),

            Stat::make('Pacientes & Membresías', "{$totalPets} Mascotas")
                ->description("{$activeSubscriptions} planes activos • {$totalCustomers} tutores")
                ->descriptionIcon('heroicon-m-heart')
                ->color('success')
                ->chart([2, 5, $totalPets]),

            Stat::make('Facturación SaaS (MRR)', '$' . number_format($monthlySaasRevenue, 0, ',', '.') . ' COP/m')
                ->description('Canon mensual SuperAdmin')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning')
                ->chart([150000, 250000, (int) $monthlySaasRevenue]),

            Stat::make('Volumen Manejado (GMV)', '$' . number_format($totalGMV, 0, ',', '.') . ' COP/m')
                ->description('Recaudo de las veterinarias')
                ->descriptionIcon('heroicon-m-chart-bar-square')
                ->color('info')
                ->chart([200000, 380000, (int) $totalGMV]),
        ];
    }
}
