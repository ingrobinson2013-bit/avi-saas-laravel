<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\TenantResource\Pages;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Clínicas Veterinarias';
    protected static ?string $modelLabel = 'Clínica Veterinaria';
    protected static ?string $pluralModelLabel = 'Clínicas Veterinarias';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Detalles de la Clínica')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('SaaS & Facturación')
                            ->icon('heroicon-o-credit-card')
                            ->schema([
                                Forms\Components\Grid::make(3)->schema([
                                    Forms\Components\Select::make('branding.saas_status')
                                        ->label('Estado de Cuenta SaaS')
                                        ->options([
                                            'trial' => '⏳ En Período de Prueba (15 Días)',
                                            'paid' => '⭐ Suscripción Oficial / Pago Activo',
                                            'suspended' => '⛔ Suspendido por Falta de Pago',
                                        ])
                                        ->default('trial')
                                        ->required(),

                                    Forms\Components\DatePicker::make('branding.trial_ends_at')
                                        ->label('Fecha Fin de Prueba')
                                        ->helperText('Fecha en que expiran los 15 días gratis'),

                                    Forms\Components\Select::make('saas_plan_tier')
                                        ->label('Nivel de Plan AVI-Plan')
                                        ->options([
                                            'starter' => 'Starter ($150.000/mes - Hasta 100 mascotas)',
                                            'pro' => 'Profesional ($280.000/mes - Hasta 500 mascotas)',
                                            'enterprise' => 'Enterprise ($450.000/mes - Ilimitado)',
                                        ])
                                        ->default('pro')
                                        ->required(),
                                ]),

                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('branding.saas_monthly_fee')
                                        ->label('Canon Mensual SaaS Acordado (COP)')
                                        ->numeric()
                                        ->prefix('$')
                                        ->placeholder('280000'),

                                    Forms\Components\Toggle::make('is_active')
                                        ->label('Acceso al Software Activo')
                                        ->helperText('Si se apaga, ni el administrador ni los clientes podrán acceder.')
                                        ->default(true),
                                ]),

                                Forms\Components\Textarea::make('branding.admin_notes')
                                    ->label('Notas de Seguimiento Comercial / Robinson')
                                    ->placeholder('Ej. Contactado por WhatsApp el 30/09, interesado en plan Pro con 2 sedes...')
                                    ->rows(3),
                            ]),

                        Forms\Components\Tabs\Tab::make('Información y Contacto')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Nombre de la Veterinaria')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('slug')
                                        ->label('Slug / Identificador Web (/v/slug)')
                                        ->required()
                                        ->unique(ignoreRecord: true)
                                        ->maxLength(255),
                                ]),

                                Forms\Components\Grid::make(3)->schema([
                                    Forms\Components\TextInput::make('branding.city')
                                        ->label('Ciudad / Municipio')
                                        ->placeholder('Ej. Cajicá, Cundinamarca'),

                                    Forms\Components\TextInput::make('branding.phone')
                                        ->label('WhatsApp Oficial de Contacto')
                                        ->tel()
                                        ->placeholder('3508742543'),

                                    Forms\Components\TextInput::make('branding.email')
                                        ->label('Email de Contacto')
                                        ->email()
                                        ->placeholder('contacto@veterinaria.com'),
                                ]),

                                Forms\Components\TextInput::make('branding.address')
                                    ->label('Dirección de la Sede')
                                    ->placeholder('Calle 7 # 4-73'),

                                Forms\Components\TextInput::make('domain')
                                    ->label('Dominio Personalizado (Opcional)')
                                    ->placeholder('ej. mi-veterinaria.com')
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Tabs\Tab::make('Marca Blanca & Colores')
                            ->icon('heroicon-o-swatch')
                            ->schema([
                                Forms\Components\TextInput::make('branding.logo_url')
                                    ->label('URL del Logo')
                                    ->placeholder('https://...'),

                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\ColorPicker::make('branding.primary_color')
                                        ->label('Color Primario de Marca')
                                        ->default('#0D9488'),

                                    Forms\Components\ColorPicker::make('branding.secondary_color')
                                        ->label('Color Secundario')
                                        ->default('#0F172A'),
                                ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('30s')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Clínica Veterinaria')
                    ->searchable(['name', 'slug', 'domain'])
                    ->sortable()
                    ->weight('bold')
                    ->description(function (Tenant $record): string {
                        $city = $record->branding['city'] ?? 'Sin ciudad';
                        $address = $record->branding['address'] ?? '';
                        return "📍 {$city}" . ($address ? " • {$address}" : '') . " • /v/{$record->slug}";
                    }),

                Tables\Columns\TextColumn::make('saas_status_badge')
                    ->label('Estado SaaS / 15 Días')
                    ->badge()
                    ->state(function (Tenant $record): string {
                        $status = $record->saas_status;
                        if ($status === 'paid') {
                            return '⭐ Plan Pago Activo';
                        }
                        if ($status === 'suspended') {
                            return '⛔ Suspendido';
                        }
                        $days = $record->trial_days_remaining;
                        if ($days < 0) {
                            return '🔴 Vencida (' . abs($days) . 'd atrás)';
                        }
                        return '⏳ Prueba: ' . $days . 'd restantes';
                    })
                    ->color(function (Tenant $record): string {
                        $status = $record->saas_status;
                        if ($status === 'paid') return 'success';
                        if ($status === 'suspended') return 'danger';
                        $days = $record->trial_days_remaining;
                        return $days > 3 ? 'warning' : 'danger';
                    }),

                Tables\Columns\TextColumn::make('saas_plan_tier')
                    ->label('Plan SaaS')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => strtoupper($state))
                    ->color(fn (string $state): string => match ($state) {
                        'starter' => 'info',
                        'pro' => 'success',
                        'enterprise' => 'warning',
                        default => 'gray',
                    })
                    ->description(function (Tenant $record): ?string {
                        $fee = $record->branding['saas_monthly_fee'] ?? null;
                        return $fee ? '$' . number_format((float) $fee, 0, ',', '.') . '/mes' : null;
                    }),

                Tables\Columns\TextColumn::make('contact_phone')
                    ->label('WhatsApp Contacto')
                    ->state(fn (Tenant $record): string => $record->branding['phone'] ?? 'N/A')
                    ->icon('heroicon-m-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->url(function (Tenant $record): ?string {
                        $phone = preg_replace('/[^0-9]/', '', $record->branding['phone'] ?? '');
                        if (empty($phone)) return null;
                        $prefix = str_starts_with($phone, '57') ? $phone : "57{$phone}";
                        return "https://wa.me/{$prefix}?text=" . urlencode("Hola Dr(a) de {$record->name}, te escribo de AVI-Plan para hacer seguimiento a tus 15 días de prueba.");
                    }, true),

                Tables\Columns\TextColumn::make('customers_count')
                    ->label('Tutores')
                    ->counts('customers')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subscriptions_count')
                    ->label('Membresías')
                    ->counts('subscriptions')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Alta')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('saas_plan_tier')
                    ->label('Filtrar por Plan')
                    ->options([
                        'starter' => 'Starter',
                        'pro' => 'Profesional',
                        'enterprise' => 'Enterprise',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Activas / Suspendidas'),
            ])
            ->actions([
                Tables\Actions\Action::make('extendTrial')
                    ->label('+15 Días')
                    ->icon('heroicon-o-clock')
                    ->color('warning')
                    ->button()
                    ->size('xs')
                    ->requiresConfirmation()
                    ->modalHeading('¿Extender período de prueba?')
                    ->modalDescription('Se sumarán 15 días adicionales a partir de hoy a la clínica para que continúe evaluando AVI-Plan.')
                    ->action(function (Tenant $record) {
                        $branding = $record->branding ?? [];
                        $branding['trial_ends_at'] = now()->addDays(15)->toIso8601String();
                        $branding['saas_status'] = 'trial';
                        $record->update(['branding' => $branding, 'is_active' => true]);

                        Notification::make()
                            ->title('¡Prueba extendida con éxito!')
                            ->body("La clínica {$record->name} tiene 15 días más de prueba activa.")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('activatePaid')
                    ->label('Plan Pago')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->button()
                    ->size('xs')
                    ->requiresConfirmation()
                    ->modalHeading('¿Activar Suscripción Oficial de Pago?')
                    ->modalDescription('Esta clínica pasará a estado oficial activo pagado en AVI-Plan.')
                    ->action(function (Tenant $record) {
                        $branding = $record->branding ?? [];
                        $branding['saas_status'] = 'paid';
                        $record->update(['branding' => $branding, 'is_active' => true]);

                        Notification::make()
                            ->title('¡Plan de Pago Activado!')
                            ->body("La clínica {$record->name} ahora es un cliente SaaS de pago oficial.")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('openAdmin')
                        ->label('Ir al Panel Admin de la Clínica')
                        ->icon('heroicon-o-arrow-top-right-on-square')
                        ->color('info')
                        ->url(fn (Tenant $record): string => url("/admin/{$record->slug}"), true),

                    Tables\Actions\Action::make('openStorefront')
                        ->label('Ver Web Pacientes (/v/' . 'slug)')
                        ->icon('heroicon-o-globe-alt')
                        ->color('gray')
                        ->url(fn (Tenant $record): string => url("/v/{$record->slug}"), true),

                    Tables\Actions\Action::make('toggleActive')
                        ->label(fn (Tenant $record) => $record->is_active ? 'Suspender Acceso' : 'Reactivar Acceso')
                        ->icon(fn (Tenant $record) => $record->is_active ? 'heroicon-o-no-symbol' : 'heroicon-o-check-circle')
                        ->color(fn (Tenant $record) => $record->is_active ? 'danger' : 'success')
                        ->requiresConfirmation()
                        ->action(fn (Tenant $record) => $record->update(['is_active' => !$record->is_active])),

                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}
