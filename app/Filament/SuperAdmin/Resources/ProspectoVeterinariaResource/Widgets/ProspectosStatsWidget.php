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
        $abiertos = ProspectoVeterinaria::abiertos()->count();
        $pendientes = ProspectoVeterinaria::pendientes()->count();
        $errores = ProspectoVeterinaria::conError()->count();

        $tasaEnvio = $total > 0 ? round(($enviados / $total) * 100, 1) : 0;
        $tasaApertura = $enviados > 0 ? round(($abiertos / $enviados) * 100, 1) : 0;

        return [
            Stat::make('Base Total de Prospectos', number_format($total))
                ->description('Veterinarias en base nacional')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('primary'),

            Stat::make('Correos Entregados (Hostinger)', number_format($enviados))
                ->description("{$tasaEnvio}% de cobertura")
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Leídos / Abiertos', number_format($abiertos))
                ->description("{$tasaApertura}% tasa de apertura 👀")
                ->descriptionIcon('heroicon-m-eye')
                ->color($abiertos > 0 ? 'info' : 'gray'),

            Stat::make('Pendientes por Despachar', number_format($pendientes))
                ->description('Listas para el cron diario')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
