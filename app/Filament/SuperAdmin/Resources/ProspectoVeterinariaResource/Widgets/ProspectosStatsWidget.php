<?php

namespace App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource\Widgets;

use App\Models\ProspectoVeterinaria;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProspectosStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $total = ProspectoVeterinaria::count();
        $enviados = ProspectoVeterinaria::enviados()->count();
        $pendientes = ProspectoVeterinaria::pendientes()->count();
        $errores = ProspectoVeterinaria::conError()->count();

        $tasaEnvio = $total > 0 ? round(($enviados / $total) * 100, 1) : 0;

        return [
            Stat::make('Base Total de Prospectos', number_format($total))
                ->description('Veterinarias en base nacional')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('primary'),

            Stat::make('Correos Entregados (Hostinger)', number_format($enviados))
                ->description("{$tasaEnvio}% de cobertura")
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Pendientes por Despachar', number_format($pendientes))
                ->description('Listas para el cron diario')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Rebotes / Errores', number_format($errores))
                ->description('Fallos de entrega o DNS')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($errores > 0 ? 'danger' : 'gray'),
        ];
    }
}
