<?php

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\SaasPaymentLog;
use Filament\Widgets\ChartWidget;

class SaasRevenueChartWidget extends ChartWidget
{
    protected static ?string $heading = '📈 Facturación Recurrente SaaS (Últimos Meses)';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = ['md' => 2, 'xl' => 1];

    protected function getData(): array
    {
        $months = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabel = $date->translatedFormat('M Y');
            $months[] = ucfirst($monthLabel);

            $sum = (float) SaasPaymentLog::whereYear('paid_at', $date->year)
                ->whereMonth('paid_at', $date->month)
                ->where('status', 'approved')
                ->sum('amount');

            // Si es el mes actual y apenas arrancamos, proyectamos con los planes activos
            if ($i === 0 && $sum === 0.0) {
                $sum = (float) \App\Models\Tenant::where('is_active', true)
                    ->where('branding->saas_status', 'paid')
                    ->get()
                    ->sum(fn ($t) => (float) ($t->branding['saas_monthly_fee'] ?? 229000));
            }

            $data[] = $sum;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Facturación SaaS ($ COP)',
                    'data' => $data,
                    'borderColor' => '#0D9488',
                    'backgroundColor' => 'rgba(13, 148, 136, 0.15)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
