<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\SaasPaymentLogResource\Pages;
use App\Models\SaasPaymentLog;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SaasPaymentLogResource extends Resource
{
    protected static ?string $model = SaasPaymentLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Historial de Pagos SaaS';
    protected static ?string $modelLabel = 'Pago de Clínica';
    protected static ?string $pluralModelLabel = 'Historial de Pagos SaaS';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detalle del Pago')
                    ->schema([
                        Forms\Components\Select::make('tenant_id')
                            ->label('Clínica Veterinaria')
                            ->relationship('tenant', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('amount')
                            ->label('Monto Cobrado (COP)')
                            ->numeric()
                            ->prefix('$')
                            ->required(),

                        Forms\Components\Select::make('gateway')
                            ->label('Medio / Pasarela de Pago')
                            ->options([
                                'bold' => '💳 Pasarela Bold (PSE / Tarjeta / Nequi)',
                                'nequi' => '📱 Nequi / Daviplata Directo',
                                'bancolombia' => '🏦 Transferencia Bancolombia',
                                'cash' => '💵 Efectivo / Directo',
                                'manual' => '⚙️ Ajuste Administrativo',
                            ])
                            ->default('bold')
                            ->required(),

                        Forms\Components\Select::make('plan_tier')
                            ->label('Nivel de Plan')
                            ->options([
                                'pay_per_pet' => '🌱 Por Mascota Activa',
                                'starter' => '🚀 Starter',
                                'pro' => '⭐ Profesional',
                                'enterprise' => '👑 Enterprise',
                                'custom' => '🏷️ Personalizado',
                            ])
                            ->default('pro'),

                        Forms\Components\Select::make('status')
                            ->label('Estado de la Transacción')
                            ->options([
                                'approved' => '✅ Aprobado / Pagado',
                                'pending' => '⏳ Pendiente',
                                'failed' => '❌ Rechazado / Fallido',
                                'refunded' => '↩️ Reembolsado',
                            ])
                            ->default('approved')
                            ->required(),

                        Forms\Components\TextInput::make('order_id')
                            ->label('ID de Orden / Referencia')
                            ->placeholder('SAAS-...')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('transaction_id')
                            ->label('ID Transacción Bold / Banco')
                            ->placeholder('TRX-...'),

                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('Fecha y Hora del Pago')
                            ->default(now()),

                        Forms\Components\DatePicker::make('period_start')
                            ->label('Inicio de Cobertura')
                            ->default(now()),

                        Forms\Components\DatePicker::make('period_end')
                            ->label('Fin de Cobertura')
                            ->default(now()->addDays(30)),

                        Forms\Components\Textarea::make('notes')
                            ->label('Notas / Observaciones')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('paid_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Clínica Veterinaria')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (SaasPaymentLog $record) => "Slug: /admin/{$record->tenant?->slug}"),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Monto (COP)')
                    ->money('COP')
                    ->weight('black')
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('gateway')
                    ->label('Medio')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'bold' => '💳 BOLD',
                        'nequi' => '📱 NEQUI',
                        'bancolombia' => '🏦 BANCOLOMBIA',
                        'cash' => '💵 EFECTIVO',
                        default => strtoupper($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'bold' => 'info',
                        'nequi' => 'warning',
                        'bancolombia' => 'primary',
                        'cash' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('plan_tier')
                    ->label('Plan')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pay_per_pet' => '🌱 MASCOTA',
                        'starter' => '🚀 STARTER',
                        'pro' => '⭐ PRO',
                        'enterprise' => '👑 ENTERPRISE',
                        default => strtoupper($state),
                    })
                    ->color('gray'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'approved' => '✅ Aprobado',
                        'pending' => '⏳ Pendiente',
                        'failed' => '❌ Fallido',
                        'refunded' => '↩️ Reembolsado',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('period_end')
                    ->label('Vigencia Hasta')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Fecha Pago')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gateway')
                    ->label('Filtrar por Pasarela')
                    ->options([
                        'bold' => 'Bold',
                        'nequi' => 'Nequi',
                        'bancolombia' => 'Bancolombia',
                        'cash' => 'Efectivo',
                    ]),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'approved' => 'Aprobado',
                        'pending' => 'Pendiente',
                        'failed' => 'Fallido',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('registerManualPayment')
                    ->label('➕ Registrar Pago Manual')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->form([
                        Forms\Components\Select::make('tenant_id')
                            ->label('Clínica Veterinaria')
                            ->options(Tenant::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $tenant = Tenant::find($state);
                                if ($tenant) {
                                    $branding = $tenant->branding ?? [];
                                    $fee = $branding['saas_monthly_fee'] ?? 229000;
                                    $set('amount', $fee);
                                    $set('plan_tier', $tenant->saas_plan_tier ?? 'pro');
                                }
                            }),

                        Forms\Components\TextInput::make('amount')
                            ->label('Monto Pagado (COP)')
                            ->numeric()
                            ->prefix('$')
                            ->required(),

                        Forms\Components\Select::make('gateway')
                            ->label('Medio de Pago Utilizado')
                            ->options([
                                'nequi' => '📱 Transferencia Nequi / Daviplata',
                                'bancolombia' => '🏦 Transferencia Bancolombia',
                                'bold' => '💳 Pasarela Bold',
                                'cash' => '💵 Efectivo Directo',
                            ])
                            ->default('nequi')
                            ->required(),

                        Forms\Components\Select::make('plan_tier')
                            ->label('Nivel de Plan Renovado')
                            ->options([
                                'pay_per_pet' => '🌱 Por Mascota Activa',
                                'starter' => '🚀 Starter',
                                'pro' => '⭐ Profesional',
                                'enterprise' => '👑 Enterprise',
                            ])
                            ->default('pro')
                            ->required(),

                        Forms\Components\DatePicker::make('paid_date')
                            ->label('Fecha del Pago')
                            ->default(now()->toDateString())
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Notas / Comprobante')
                            ->placeholder('Ej. Comprobante Nequi M123456 enviado por WhatsApp')
                            ->rows(2),
                    ])
                    ->action(function (array $data) {
                        $tenant = Tenant::findOrFail($data['tenant_id']);
                        $paidDate = \Carbon\Carbon::parse($data['paid_date']);
                        $nextDue = $paidDate->copy()->addDays(30);

                        // 1. Actualizar Tenant
                        $branding = $tenant->branding ?? [];
                        $branding['saas_status'] = 'paid';
                        $branding['saas_last_payment_date'] = $paidDate->toDateString();
                        $branding['saas_next_payment_due'] = $nextDue->toDateString();
                        $branding['saas_paid_until'] = $nextDue->toDateString();
                        $branding['saas_payment_method'] = $data['gateway'];
                        $branding['saas_monthly_fee'] = $data['amount'];
                        $tenant->update([
                            'branding' => $branding,
                            'saas_plan_tier' => $data['plan_tier'],
                            'is_active' => true,
                        ]);

                        // 2. Registrar en Log
                        SaasPaymentLog::create([
                            'tenant_id' => $tenant->id,
                            'order_id' => "MANUAL-{$tenant->slug}-" . time(),
                            'gateway' => $data['gateway'],
                            'amount' => $data['amount'],
                            'currency' => 'COP',
                            'plan_tier' => $data['plan_tier'],
                            'status' => 'approved',
                            'payer_name' => $tenant->name,
                            'period_start' => $paidDate->toDateString(),
                            'period_end' => $nextDue->toDateString(),
                            'notes' => $data['notes'] ?? 'Pago manual registrado por el SuperAdministrador',
                            'paid_at' => $paidDate,
                        ]);

                        Notification::make()
                            ->title('¡Pago Registrado Exitosamente!')
                            ->body("La clínica {$tenant->name} quedó al día hasta el {$nextDue->format('d/m/Y')}.")
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('sendWhatsAppReceipt')
                    ->label('📲 Recibo WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->url(function (SaasPaymentLog $record): ?string {
                        $phone = preg_replace('/[^0-9]/', '', $record->tenant?->branding['phone'] ?? '');
                        if (empty($phone)) return null;
                        $prefix = str_starts_with($phone, '57') ? $phone : "57{$phone}";
                        $amount = '$' . number_format($record->amount, 0, ',', '.') . ' COP';
                        $date = $record->paid_at?->format('d/m/Y') ?? date('d/m/Y');
                        $until = $record->period_end?->format('d/m/Y') ?? date('d/m/Y', strtotime('+30 days'));
                        $clinic = $record->tenant?->name ?? 'Clínica';
                        
                        $text = "🧾 *COMPROBANTE OFICIAL AVI-PLAN SAAS*\n\n"
                              . "Hola Dr(a) de *{$clinic}*,\n"
                              . "Confirmamos el registro de tu pago de suscripción mensual a la plataforma AVI-Plan.\n\n"
                              . "💰 *Monto:* {$amount}\n"
                              . "📅 *Fecha de Pago:* {$date}\n"
                              . "🛡️ *Vigencia de Cobertura:* Hasta el {$until}\n"
                              . "💳 *Medio:* " . strtoupper($record->gateway) . "\n\n"
                              . "Tu plataforma y portal de clientes se encuentran 100% activos y al día. ¡Gracias por confiar en AVI-Plan!";
                              
                        return "https://wa.me/{$prefix}?text=" . urlencode($text);
                    }, true),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSaasPaymentLogs::route('/'),
        ];
    }
}
