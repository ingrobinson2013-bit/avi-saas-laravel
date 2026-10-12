<?php

namespace App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource\Pages;

use App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource;
use App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource\Widgets\ProspectosStatsWidget;
use App\Models\ProspectoVeterinaria;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Artisan;

class ListProspectosVeterinarias extends ListRecords
{
    protected static string $resource = ProspectoVeterinariaResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            ProspectosStatsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('disparar_lote_diario')
                ->label('🚀 Despachar Lote Hoy (25 Clínicas)')
                ->color('success')
                ->icon('heroicon-o-paper-airplane')
                ->requiresConfirmation()
                ->modalHeading('Despachar Lote Inmediato de Correos')
                ->modalDescription('El sistema tomará las primeras 25 veterinarias pendientes y les enviará la propuesta oficial vía Hostinger SMTP con pausas de seguridad.')
                ->action(function () {
                    $exitCode = Artisan::call('avi:prospectos-scan-and-send', [
                        '--limit' => 25,
                    ]);

                    if ($exitCode === 0) {
                        Notification::make()
                            ->title('Lote Despachado')
                            ->body('El lote de prospectos se procesó y actualizó en tiempo real.')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Aviso en Despacho')
                            ->body('El comando se ejecutó con advertencias. Revisa los estados en la tabla.')
                            ->warning()
                            ->send();
                    }
                }),

            Actions\Action::make('escanear_nuevas')
                ->label('🔍 Escanear Nuevas Veterinarias')
                ->color('primary')
                ->icon('heroicon-o-magnifying-glass')
                ->action(function () {
                    Artisan::call('avi:prospectos-scan-and-send', [
                        '--scan' => true,
                        '--limit' => 0,
                    ]);

                    Notification::make()
                        ->title('Escaneo Completado')
                        ->body('Se han verificado e integrado nuevas veterinarias al inventario de prospección.')
                        ->success()
                        ->send();
                }),

            Actions\CreateAction::make()
                ->label('+ Agregar Clínica Manualmente'),
        ];
    }
}
