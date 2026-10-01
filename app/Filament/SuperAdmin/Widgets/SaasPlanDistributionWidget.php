<?php

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\Tenant;
use Filament\Widgets\ChartWidget;

class SaasPlanDistributionWidget extends ChartWidget
{
    protected static ?string $heading = '📊 Distribución de Clínicas por Plan';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = ['md' => 2, 'xl' => 1];

    protected function getData(): array
    {
        $starterCount = Tenant::where('saas_plan_tier', 'starter')->count();
        $proCount = Tenant::where('saas_plan_tier', 'pro')->orWhereNull('saas_plan_tier')->count();
        $enterpriseCount = Tenant::where('saas_plan_tier', 'enterprise')->count();
        $perPetCount = Tenant::where('saas_plan_tier', 'pay_per_pet')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Clínicas',
                    'data' => [$starterCount, $proCount, $enterpriseCount, $perPetCount],
                    'backgroundColor' => [
                        '#64748B', // Slate para Starter
                        '#0D9488', // Teal para Pro
                        '#F59E0B', // Amber para Enterprise
                        '#3B82F6', // Blue para Por Mascota
                    ],
                ],
            ],
            'labels' => ['Starter ($99k)', 'Pro ($229k)', 'Enterprise ($489k)', 'Por Mascota ($5k)'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
