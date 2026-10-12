<?php

namespace App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource\Pages;

use App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource;
use App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource\Widgets\ProspectosStatsWidget;
use App\Models\ProspectoVeterinaria;
use Filament\Forms;
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

            Actions\Action::make('importar_csv')
                ->label('📥 Importar / Pegar CSV (Upsert)')
                ->color('gray')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    Forms\Components\Textarea::make('csv_data')
                        ->label('Pegar Filas de Excel / CSV (delimitado por ; o ,)')
                        ->placeholder("razon_social;correo_comercial;municipio;telefono\nClínica Animal;contacto@animal.com;Bogotá;3201234567")
                        ->rows(8)
                        ->required()
                        ->helperText('Aplica Upsert automático: los correos repetidos se actualizarán sin duplicarse y conservarán su estado de envío.'),
                ])
                ->action(function (array $data) {
                    $lines = explode("\n", trim($data['csv_data']));
                    if (empty($lines)) return;

                    $items = [];
                    $header = null;
                    $delimiter = str_contains($lines[0], ';') ? ';' : ',';

                    foreach ($lines as $line) {
                        $line = trim($line);
                        if (!$line) continue;
                        $cols = str_getcsv($line, $delimiter);
                        if (!$header) {
                            $header = array_map(fn($h) => strtolower(trim($h)), $cols);
                            continue;
                        }

                        $row = [];
                        foreach ($header as $i => $key) {
                            $row[$key] = $cols[$i] ?? null;
                        }

                        $email = $row['correo_comercial'] ?? $row['email'] ?? $row['correo'] ?? null;
                        if ($email) {
                            $items[] = [
                                'razon_social' => $row['razon_social'] ?? $row['nombre'] ?? 'Clínica Veterinaria',
                                'correo_comercial' => $email,
                                'telefono' => $row['telefono'] ?? null,
                                'municipio' => $row['municipio'] ?? $row['ciudad'] ?? 'Bogotá D.C.',
                                'departamento' => $row['departamento'] ?? 'Cundinamarca',
                                'tipo' => $row['tipo'] ?? 'Clínica Veterinaria',
                                'fuente' => 'Importación CSV Manual',
                            ];
                        }
                    }

                    $total = ProspectoVeterinaria::upsertProspectos($items);

                    Notification::make()
                        ->title('Importación Completada')
                        ->body("Se procesaron y sincronizaron {$total} registros con Upsert blindado (cero duplicados).")
                        ->success()
                        ->send();
                }),

            Actions\CreateAction::make()
                ->label('+ Agregar Clínica Manualmente'),
        ];
    }
}
