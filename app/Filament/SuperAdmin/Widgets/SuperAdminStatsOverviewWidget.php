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
                return (float) ($t->branding['saas_monthly_fee'] ?? 280000);
            }
            return 0;
        });

        // Ingresos generados por las clínicas veterinarias a través de sus planes
        $totalGMV = Subscription::query()
            ->where('subscriptions.status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');

        return [
            Stat::make('Clínicas Registradas', "{$totalTenants} Clínicas")
                ->description("{$activeTenants} activas • {$trialTenants} en prueba de 15d")
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary')
                ->chart([max(0, $totalTenants - 2), max(0, $totalTenants - 1), $totalTenants]),

            Stat::make('Estado de Pruebas (15 Días)', "{$trialTenants} en Evaluación")
                ->description("{$paidTenants} oficiales • {$expiredTrials} vencidas")
                ->descriptionIcon('heroicon-m-clock')
                ->color($expiredTrials > 0 ? 'warning' : 'info')
                ->chart([$expiredTrials, $paidTenants, $trialTenants]),

            Stat::make('Mascotas en el Ecosistema', "{$totalPets} Mascotas")
                ->description("{$totalCustomers} tutores • {$activeSubscriptions} planes activos")
                ->descriptionIcon('heroicon-m-heart')
                ->color('success')
                ->chart([max(0, $totalPets - 3), max(0, $totalPets - 1), $totalPets]),

            Stat::make('Facturación SaaS AVI-Plan', '$' . number_format($monthlySaasRevenue, 0, ',', '.') . ' COP/mes')
                ->description('Canon mensual SaaS de clínicas de pago')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('emerald'),

            Stat::make('Volumen Manejado (GMV)', '$' . number_format($totalGMV, 0, ',', '.') . ' COP/mes')
                ->description('Ingresos recaudados por las clínicas')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('gray'),
        ];
    }
}
