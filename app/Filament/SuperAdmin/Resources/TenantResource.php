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
    protected static ?int $navigationSort = 1;

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
                                        ->label('Fecha Fin de Prueba (15 Días)')
                                        ->helperText('Fecha en que expiran los 15 días gratis'),

                                    Forms\Components\Select::make('saas_plan_tier')
                                        ->label('Nivel de Plan AVI-Plan')
                                        ->options([
                                            'pay_per_pet' => '🌱 Por Mascota Activa ($5.000 COP / mascota)',
                                            'starter' => '🚀 Starter ($99.000 COP/mes — Hasta 60 mascotas)',
                                            'pro' => '⭐ Profesional ($229.000 COP/mes — Hasta 250 mascotas)',
                                            'enterprise' => '👑 Enterprise ($489.000 COP/mes — Ilimitado)',
                                        ])
                                        ->default('pro')
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                                            $defaultFees = [
                                                'pay_per_pet' => 50000,
                                                'starter' => 99000,
                                                'pro' => 229000,
                                                'enterprise' => 489000,
                                            ];
                                            if (isset($defaultFees[$state])) {
                                                $set('branding.saas_monthly_fee', $defaultFees[$state]);
                                            }
                                        }),
                                ]),

                                Forms\Components\Grid::make(3)->schema([
                                    Forms\Components\TextInput::make('branding.saas_monthly_fee')
                                        ->label('Canon Mensual SaaS Acordado (COP)')
                                        ->numeric()
                                        ->prefix('$')
                                        ->placeholder('229000')
                                        ->helperText('Monto mensual cobrado a la clínica'),

                                    Forms\Components\Select::make('branding.saas_payment_method')
                                        ->label('Medio de Pago del Canon')
                                        ->options([
                                            'nequi' => '📱 Nequi / Daviplata',
                                            'bancolombia' => '🏦 Transferencia Bancaria',
                                            'bold_wompi' => '💳 Débito / Tarjeta / PSE (Bold o Wompi)',
                                            'cash' => '💵 Efectivo / Directo',
                                        ])
                                        ->default('nequi'),

                                    Forms\Components\Toggle::make('is_active')
                                        ->label('Acceso al Software Activo')
                                        ->helperText('Si se apaga, el acceso para esta clínica quedará bloqueado.')
                                        ->default(true),
                                ]),

                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\DatePicker::make('branding.saas_last_payment_date')
                                        ->label('Fecha del Último Pago Recibido'),

                                    Forms\Components\DatePicker::make('branding.saas_next_payment_due')
                                        ->label('Próxima Fecha Límite de Pago'),
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

                        Forms\Components\Tabs\Tab::make('Métricas & Rendimiento')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Forms\Components\Placeholder::make('clinic_summary')
                                    ->label('Rendimiento en Vivo de esta Clínica')
                                    ->content(function (?Tenant $record): string {
                                        if (!$record) return 'Guarda la clínica primero para ver sus métricas.';

                                        $tutores = $record->customers()->count();
                                        $subs = $record->subscriptions()->where('status', 'active')->count();
                                        
                                        $gmv = $record->subscriptions()
                                            ->where('subscriptions.status', 'active')
                                            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                                            ->sum('plans.price_cop');

                                        $mrr = '$' . number_format($gmv, 0, ',', '.') . ' COP/mes';
                                        $canon = '$' . number_format((float) ($record->branding['saas_monthly_fee'] ?? 229000), 0, ',', '.') . ' COP/mes';

                                        return "📊 {$tutores} Tutores Registrados | 🐕 {$subs} Membresías Activas | 💰 Facturación Clínica: {$mrr} | 🏷️ Canon AVI-Plan: {$canon}";
                                    }),
                            ]),

                        Forms\Components\Tabs\Tab::make('Pasarela de Pagos (Bold & Cuentas)')
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                Forms\Components\TextInput::make('branding.payment_bold_link')
                                    ->label('Link de Pago de Bold de la Clínica (Smart Link)')
                                    ->placeholder('https://checkout.bold.co/payment/LNK_...')
                                    ->helperText('Enlace oficial para que los tutores paguen sus planes con PSE, Tarjeta y Botón Bancolombia.'),

                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('branding.bold_api_key')
                                        ->label('Bold API Key (Para checkout automatizado)')
                                        ->placeholder('B_pk_live_... / sandbox key')
                                        ->password()
                                        ->helperText('Para generar links dinámicos y validar pagos por Webhook.'),

                                    Forms\Components\TextInput::make('branding.bold_secret_key')
                                        ->label('Bold Secret Key (Firma SHA256)')
                                        ->placeholder('Llave secreta de integridad')
                                        ->password(),
                                ]),

                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('branding.payment_nequi')
                                        ->label('Número Nequi / Daviplata Oficial')
                                        ->placeholder('3508742543'),

                                    Forms\Components\TextInput::make('branding.payment_bank_info')
                                        ->label('Cuenta Bancaria Oficial')
                                        ->placeholder('Bancolombia Ahorros # 123-456789-01'),
                                ]),
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
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pay_per_pet' => '🌱 POR MASCOTA',
                        'starter' => '🚀 STARTER ($99k)',
                        'pro' => '⭐ PRO ($229k)',
                        'enterprise' => '👑 ENTERPRISE ($489k)',
                        default => strtoupper($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pay_per_pet' => 'info',
                        'starter' => 'gray',
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
                        $fee = $record->branding['saas_monthly_fee'] ?? '229.000';
                        return "https://wa.me/{$prefix}?text=" . urlencode("Hola Dr(a) de {$record->name}, te escribo de AVI-Plan para hacer seguimiento a tus 15 días de prueba de tu plataforma de membresías de bienestar.");
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
                        'pay_per_pet' => 'Por Mascota Activa ($5.000)',
                        'starter' => 'Starter ($99.000)',
                        'pro' => 'Profesional ($229.000)',
                        'enterprise' => 'Enterprise ($489.000)',
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
                    Tables\Actions\Action::make('openSaasCheckout')
                        ->label('💳 Abrir Pasarela de Pago Bold SaaS')
                        ->icon('heroicon-o-credit-card')
                        ->color('success')
                        ->url(fn (Tenant $record): string => url("/admin/{$record->slug}/renovar-saas"), true),

                    Tables\Actions\Action::make('sendBoldLinkWhatsApp')
                        ->label('📲 Enviar Link de Cobro Bold por WhatsApp')
                        ->icon('heroicon-m-chat-bubble-left-ellipsis')
                        ->color('success')
                        ->url(function (Tenant $record): ?string {
                            $phone = preg_replace('/[^0-9]/', '', $record->branding['phone'] ?? '');
                            if (empty($phone)) return null;
                            $prefix = str_starts_with($phone, '57') ? $phone : "57{$phone}";
                            $fee = '$' . number_format((float) ($record->branding['saas_monthly_fee'] ?? 229000), 0, ',', '.') . ' COP';
                            $link = url("/admin/{$record->slug}/renovar-saas");
                            $msg = "Hola Dr(a) de {$record->name}, te escribo de AVI-Plan. Tu período de prueba de 15 días vence pronto. Para continuar activo con tu suscripción mensual ({$fee}), puedes realizar tu pago seguro con PSE, Tarjeta o Botón Bancolombia en el siguiente link oficial de Bold: {$link} . ¡Muchas gracias!";
                            return "https://wa.me/{$prefix}?text=" . urlencode($msg);
                        }, true),

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
