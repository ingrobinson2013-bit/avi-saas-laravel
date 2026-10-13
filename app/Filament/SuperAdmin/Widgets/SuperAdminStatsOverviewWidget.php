<?php

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\Subscription;
use App\Models\Tenant;
use Filament\Widgets\Widget;

class SuperAdminStatsOverviewWidget extends Widget
{
    protected static string $view = 'filament.super-admin.widgets.kpi-stats';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $totalTenants = Tenant::count();
        $trialTenants = Tenant::all()->filter(fn ($t) => $t->saas_status === 'trial_active')->count();
        $paidTenants = Tenant::all()->filter(fn ($t) => $t->saas_status === 'paid')->count();

        $totalPets = Pet::count();
        $totalCustomers = Customer::count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();

        $monthlySaasRevenue = Tenant::all()->sum(function ($t) {
            if ($t->saas_status === 'paid') {
                return (float) ($t->branding['saas_monthly_fee'] ?? 99000);
            }
            return 0;
        });

        $totalGMV = Subscription::query()
            ->where('subscriptions.status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');

        return [
            'totalTenants' => $totalTenants,
            'paidTenants' => $paidTenants,
            'trialTenants' => $trialTenants,
            'totalPets' => $totalPets,
            'totalCustomers' => $totalCustomers,
            'activeSubscriptions' => $activeSubscriptions,
            'monthlySaasRevenue' => '$' . number_format($monthlySaasRevenue, 0, ',', '.') . ' COP/m',
            'totalGMV' => '$' . number_format($totalGMV, 0, ',', '.') . ' COP/m',
        ];
    }
}
