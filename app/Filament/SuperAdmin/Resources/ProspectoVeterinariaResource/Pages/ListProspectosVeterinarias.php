<?php

namespace App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource\Pages;

use App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource;
use App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource\Widgets\ProspectosStatsWidget;
use App\Models\ProspectoVeterinaria;
use Filament\Actions;
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
                ->form([
                    Forms\Components\Select::make('region')
                        ->label('Seleccionar Región a Explorar')
                        ->options([
                            'sabana' => '🐾 Zipaquirá y Sabana Centro (Chía, Cajicá, Cota, Tenjo, Tabio, Sopó, Tocancipá, Funza, Mosquera)',
                            'bogota' => '🏙️ Bogotá D.C. (Suba, Cedritos, Modelia, Salitre, Chapinero, Usaquén, Castilla, Teusaquillo)',
                            'antioquia' => '🏔️ Antioquia (Medellín, Envigado, Sabaneta, Poblado, Laureles, Itagüí, Rionegro)',
                            'valle' => '☀️ Valle del Cauca (Cali, Palmira, Jamundí)',
                            'santander' => '🦅 Santanderes (Bucaramanga, Floridablanca, Cúcuta)',
                            'ejecafetero' => '☕ Eje Cafetero (Pereira, Manizales, Armenia)',
                            'caribe' => '🏖️ Costa Caribe (Barranquilla, Cartagena, Santa Marta)',
                            'cundinamarca_tolima' => '🌄 Cundinamarca Sur & Tolima (Soacha, Fusagasugá, Girardot)',
                            'todo_el_pais' => '🇨🇴 Barrido Nacional Completo (Todas las regiones)',
                        ])
                        ->default('todo_el_pais')
                        ->required()
                        ->helperText('El motor consulta la API de OpenStreetMap en vivo y rastrea sitios web para extraer correos reales.'),

                    Forms\Components\TextInput::make('url_especifica')
                        ->label('🌐 Opcional: Rastrear una Web de Veterinaria Específica')
                        ->placeholder('https://www.clinicaveterinaria.com')
                        ->url()
                        ->helperText('Si tienes una web de clínica, el crawler la navegará en vivo y extraerá sus correos de contacto de forma inmediata.'),

                    Forms\Components\Select::make('limite_extraccion')
                        ->label('⚡ Cantidad de Clínicas a Rastrear en Paralelo')
                        ->options([
                            '5' => '⚡ Rápido: 5 webs simultáneas (~3 segundos)',
                            '10' => '🚀 Recomendado: 10 webs simultáneas (~5 segundos)',
                            '15' => '🔥 Intensivo: 15 webs simultáneas (~8 segundos)',
                            '25' => '💥 Máximo: 25 webs simultáneas (~12 segundos)',
                        ])
                        ->default('10')
                        ->required()
                        ->helperText('Rastreo concurrente asíncrono en paralelo (sin esperas ni tiempos muertos).'),

                    Forms\Components\Section::make('⚡ Motor Oficial Google Search API (Buscador en Vivo)')
                        ->description('Conecta Google en tiempo real para encontrar clínicas en vivo (100 consultas gratis al día).')
                        ->schema([
                            Forms\Components\TextInput::make('google_api_key')
                                ->label('Google Search API Key')
                                ->placeholder('AIzaSy...')
                                ->password()
                                ->revealable()
                                ->default(env('GOOGLE_SEARCH_API_KEY', 'AIzaSyCt2hw0ILDJh73qMGrYoZiR0eTPPtTXH8w'))
                                ->helperText('Clave oficial de Google Cloud vinculada con éxito.'),

                            Forms\Components\TextInput::make('google_cx_id')
                                ->label('Search Engine ID (CX)')
                                ->placeholder('d423366d7396c45e5')
                                ->default(env('GOOGLE_SEARCH_ENGINE_ID', 'd423366d7396c45e5'))
                                ->helperText('Motor de búsqueda de Google vinculado.'),
                        ])
                        ->collapsible()
                        ->collapsed(true),
                ])
                ->action(function (array $data) {
                    $scraper = app(\App\Services\VeterinariaScraperService::class);
                    $res = $scraper->scanRegion(
                        $data['region'],
                        $data['url_especifica'] ?? null,
                        $data['google_api_key'] ?? null,
                        $data['google_cx_id'] ?? null,
                        (int) ($data['limite_extraccion'] ?? 10)
                    );

                    Notification::make()
                        ->title('Escaneo y Sincronización Exitosa')
                        ->body("Se procesaron {$res['total_encontrados']} clínicas en {$res['region']}. Total pendientes en cola: {$res['pendientes_en_cola']}.")
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
