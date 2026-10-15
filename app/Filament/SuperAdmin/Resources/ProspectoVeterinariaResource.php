<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource\Pages;
use App\Mail\ProspectoOutreachMail;
use App\Models\ProspectoVeterinaria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class ProspectoVeterinariaResource extends Resource
{
    protected static ?string $model = ProspectoVeterinaria::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?string $navigationLabel = 'Prospección B2B';
    protected static ?string $modelLabel = 'Prospecto';
    protected static ?string $pluralModelLabel = 'Prospección B2B & Campañas';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $pendientes = ProspectoVeterinaria::pendientes()->count();
        return $pendientes > 0 ? (string) $pendientes : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos de la Veterinaria')
                    ->schema([
                        Forms\Components\TextInput::make('razon_social')
                            ->label('Razón Social / Nombre Comercial')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('correo_comercial')
                            ->label('Correo Electrónico')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('telefono')
                            ->label('Teléfono / WhatsApp')
                            ->tel()
                            ->placeholder('Ej. 3201234567')
                            ->maxLength(50),

                        Forms\Components\Select::make('tipo')
                            ->label('Tipo de Establecimiento')
                            ->options([
                                'Clínica Veterinaria' => '🏥 Clínica Veterinaria',
                                'Hospital Veterinario' => '🏨 Hospital Veterinario',
                                'Consultorio Veterinario' => '🩺 Consultorio Veterinario',
                                'Pet Shop & Consultorio' => '🐾 Pet Shop con Consultorio',
                                'Servicios Veterinarios' => '💉 Servicios Veterinarios',
                                'Clínica Especializada' => '⭐ Clínica Especializada',
                            ])
                            ->default('Clínica Veterinaria'),

                        Forms\Components\TextInput::make('municipio')
                            ->label('Municipio / Ciudad')
                            ->default('Bogotá D.C.')
                            ->required(),

                        Forms\Components\TextInput::make('departamento')
                            ->label('Departamento')
                            ->default('Cundinamarca')
                            ->required(),

                        Forms\Components\TextInput::make('direccion')
                            ->label('Dirección Comercial')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('fuente')
                            ->label('Fuente de Extracción')
                            ->default('Google Maps')
                            ->maxLength(100),
                    ])->columns(2),

                Forms\Components\Section::make('Estado de la Campaña y Auditoría')
                    ->schema([
                        Forms\Components\Select::make('estado')
                            ->label('Estado Actual')
                            ->options([
                                'pendiente' => '⏳ Pendiente de Envío',
                                'enviado' => '✅ Correo Enviado',
                                'error' => '❌ Error en Envío',
                                'respondido' => '💬 Prospecto Respondió / En Conversación',
                                'desuscrito' => '🚫 Desuscrito',
                            ])
                            ->default('pendiente')
                            ->required(),

                        Forms\Components\TextInput::make('intentos_envio')
                            ->label('Número de Envíos Realizados')
                            ->numeric()
                            ->default(0),

                        Forms\Components\DateTimePicker::make('ultimo_envio_at')
                            ->label('Fecha del Último Envío')
                            ->nullable(),

                        Forms\Components\DateTimePicker::make('abierto_at')
                            ->label('Primera Vez Abierto / Leído')
                            ->nullable(),

                        Forms\Components\TextInput::make('aperturas_count')
                            ->label('Cantidad de Veces Abierto')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Textarea::make('error_mensaje')
                            ->label('Último Mensaje de Error')
                            ->columnSpanFull()
                            ->nullable(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('razon_social')
                    ->label('Veterinaria / Clínica')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (ProspectoVeterinaria $record) => $record->tipo ?? 'Clínica Veterinaria'),

                Tables\Columns\TextColumn::make('correo_comercial')
                    ->label('Correo Electrónico')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Correo copiado')
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('telefono')
                    ->label('WhatsApp / Celular')
                    ->searchable()
                    ->copyable()
                    ->placeholder('Sin registrar')
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('municipio')
                    ->label('Ubicación')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->description(fn (ProspectoVeterinaria $record) => $record->departamento),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado de Prospección')
                    ->badge()
                    ->colors([
                        'warning' => 'pendiente',
                        'success' => 'enviado',
                        'danger' => 'error',
                        'info' => 'respondido',
                        'gray' => 'desuscrito',
                    ])
                    ->icons([
                        'heroicon-m-clock' => 'pendiente',
                        'heroicon-m-check-circle' => 'enviado',
                        'heroicon-m-x-circle' => 'error',
                        'heroicon-m-chat-bubble-left-ellipsis' => 'respondido',
                        'heroicon-m-no-symbol' => 'desuscrito',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pendiente' => '⏳ Pendiente',
                        'enviado' => '✅ Enviado',
                        'error' => '❌ Error',
                        'respondido' => '💬 Respondido',
                        'desuscrito' => '🚫 Desuscrito',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('aperturas_count')
                    ->label('Lectura / Apertura')
                    ->badge()
                    ->color(fn (ProspectoVeterinaria $record) => $record->aperturas_count > 0 ? 'success' : 'gray')
                    ->icon(fn (ProspectoVeterinaria $record) => $record->aperturas_count > 0 ? 'heroicon-m-eye' : 'heroicon-m-eye-slash')
                    ->formatStateUsing(fn (ProspectoVeterinaria $record) => $record->aperturas_count > 0 
                        ? "👀 Leído ({$record->aperturas_count})" 
                        : "Sin abrir")
                    ->description(fn (ProspectoVeterinaria $record) => $record->abierto_at ? $record->abierto_at->diffForHumans() : null)
                    ->sortable(),

                Tables\Columns\TextColumn::make('ultimo_envio_at')
                    ->label('Enviado el')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Nunca'),

                Tables\Columns\TextColumn::make('fuente')
                    ->label('Origen')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\Filter::make('solo_abiertos')
                    ->label('👀 Solo que Abrieron el Correo')
                    ->query(fn ($query) => $query->where('aperturas_count', '>', 0)),

                Tables\Filters\SelectFilter::make('estado')
                    ->label('Filtrar por Estado')
                    ->options([
                        'pendiente' => '⏳ Pendiente',
                        'enviado' => '✅ Enviado',
                        'error' => '❌ Error',
                        'respondido' => '💬 Respondido',
                        'desuscrito' => '🚫 Desuscrito',
                    ]),

                Tables\Filters\SelectFilter::make('municipio')
                    ->label('Filtrar por Ciudad')
                    ->options(fn () => ProspectoVeterinaria::query()->distinct()->pluck('municipio', 'municipio')->toArray()),
            ])
            ->actions([
                Tables\Actions\Action::make('enviar_correo')
                    ->label('Enviar Correo')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Enviar Correo Oficial de AVI-Plan')
                    ->modalDescription(fn (ProspectoVeterinaria $record) => "¿Deseas despachar inmediatamente la propuesta de ingresos recurrentes a {$record->razon_social} ({$record->correo_comercial})?")
                    ->modalSubmitActionLabel('Sí, Enviar Correo Ahora')
                    ->action(function (ProspectoVeterinaria $record) {
                        try {
                            Mail::to($record->correo_comercial)->send(new ProspectoOutreachMail($record));

                            $record->update([
                                'estado' => 'enviado',
                                'ultimo_envio_at' => now(),
                                'intentos_envio' => $record->intentos_envio + 1,
                                'error_mensaje' => null,
                            ]);

                            Notification::make()
                                ->title('Correo Entregado con Éxito')
                                ->body("Propuesta despachada a {$record->razon_social} ({$record->correo_comercial}) vía Hostinger SMTP.")
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            $record->update([
                                'estado' => 'error',
                                'intentos_envio' => $record->intentos_envio + 1,
                                'error_mensaje' => $e->getMessage(),
                            ]);

                            Notification::make()
                                ->title('Error al Enviar')
                                ->body("No se pudo entregar el correo: {$e->getMessage()}")
                                ->danger()
                                ->send();
                        }
                    }),

                Tables\Actions\Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->visible(fn (ProspectoVeterinaria $record) => filled($record->clean_whatsapp_number))
                    ->url(function (ProspectoVeterinaria $record) {
                        $texto = "¡Hola, muy buenas tardes equipo de {$record->razon_social}! 👋🐾\n\n"
                            . "Les saluda Robinson de AVI-Plan (https://avipetapp.com).\n\n"
                            . "Les escribo porque estamos trabajando con clínicas veterinarias ayudándoles a implementar Planes de Salud Preventiva en suscripción mensual (con carnet digital y canje en mostrador), para asegurar ingresos fijos recurrentes de $3M a $6M mensuales para la clínica.\n\n"
                            . "¿Ustedes actualmente manejan algún plan de salud o membresías para sus pacientes, o les gustaría conocer cómo funciona?";
                        $mensaje = rawurlencode($texto);
                        return "https://wa.me/{$record->clean_whatsapp_number}?text={$mensaje}";
                    }, shouldOpenInNewTab: true),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('enviar_masivo')
                        ->label('Despachar Correos a Seleccionados')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Despacho Masivo de Correos')
                        ->modalDescription('Se enviará la propuesta oficial de AVI-Plan a cada una de las veterinarias seleccionadas a través de Hostinger SMTP.')
                        ->action(function ($records) {
                            $enviados = 0;
                            $fallidos = 0;

                            foreach ($records as $record) {
                                try {
                                    Mail::to($record->correo_comercial)->send(new ProspectoOutreachMail($record));
                                    $record->update([
                                        'estado' => 'enviado',
                                        'ultimo_envio_at' => now(),
                                        'intentos_envio' => $record->intentos_envio + 1,
                                        'error_mensaje' => null,
                                    ]);
                                    $enviados++;
                                    sleep(10); // Pausa segura de 10 segundos entre envíos para proteger Hostinger SMTP
                                } catch (\Throwable $e) {
                                    $record->update([
                                        'estado' => 'error',
                                        'intentos_envio' => $record->intentos_envio + 1,
                                        'error_mensaje' => $e->getMessage(),
                                    ]);
                                    $fallidos++;
                                }
                            }

                            Notification::make()
                                ->title('Despacho Masivo Finalizado')
                                ->body("Exitosos: {$enviados} | Fallidos: {$fallidos}")
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProspectosVeterinarias::route('/'),
            'create' => Pages\CreateProspectoVeterinaria::route('/create'),
            'edit' => Pages\EditProspectoVeterinaria::route('/{record}/edit'),
        ];
    }
}
