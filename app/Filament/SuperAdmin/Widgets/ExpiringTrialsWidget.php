<?php

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\Tenant;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ExpiringTrialsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = '🎯 Pipeline Comercial: Demos Próximas a Vencer & Cobros Pendientes';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Tenant::query()
                    ->where(function ($q) {
                        $q->where('branding->saas_status', 'trial')
                          ->orWhereNull('branding->saas_status')
                          ->orWhere('branding->saas_status', 'suspended');
                    })
                    ->where('is_active', true)
                    ->withCount(['customers', 'subscriptions'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Clínica Veterinaria')
                    ->weight('bold')
                    ->description(function (Tenant $record): string {
                        $city = $record->branding['city'] ?? 'Sin ciudad';
                        $phone = $record->branding['phone'] ?? 'Sin teléfono';
                        return "📍 {$city} • 📞 {$phone}";
                    }),

                Tables\Columns\TextColumn::make('trial_status')
                    ->label('Días Restantes Demo')
                    ->badge()
                    ->state(function (Tenant $record): string {
                        $days = $record->trial_days_remaining;
                        if ($days < 0) {
                            return '🔴 Vencida (' . abs($days) . 'd atrás)';
                        }
                        if ($days === 0) {
                            return '🟡 Vence Hoy';
                        }
                        return "⏳ {$days} días restantes";
                    })
                    ->color(function (Tenant $record): string {
                        $days = $record->trial_days_remaining;
                        if ($days < 0) return 'danger';
                        if ($days <= 3) return 'warning';
                        return 'info';
                    })
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderByRaw("branding->>'trial_ends_at' {$direction}");
                    }),

                Tables\Columns\TextColumn::make('saas_plan_tier')
                    ->label('Plan Asignado')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pay_per_pet' => '🌱 POR MASCOTA',
                        'starter' => '🚀 STARTER ($99k)',
                        'pro' => '⭐ PRO ($229k)',
                        'enterprise' => '👑 ENTERPRISE ($489k)',
                        default => strtoupper($state),
                    })
                    ->color('success'),

                Tables\Columns\TextColumn::make('branding.saas_monthly_fee')
                    ->label('Canon Mensual')
                    ->money('COP')
                    ->default(229000)
                    ->weight('black'),

                Tables\Columns\TextColumn::make('customers_count')
                    ->label('Tutores / Mascotas')
                    ->formatStateUsing(fn (Tenant $record) => "👥 {$record->customers_count} Tutores • 🐕 {$record->subscriptions_count} Planes"),
            ])
            ->actions([
                Tables\Actions\Action::make('sendWhatsAppCobro')
                    ->label('📲 Cobrar por WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->button()
                    ->size('xs')
                    ->url(function (Tenant $record): ?string {
                        $phone = preg_replace('/[^0-9]/', '', $record->branding['phone'] ?? '');
                        if (empty($phone)) return null;
                        $prefix = str_starts_with($phone, '57') ? $phone : "57{$phone}";
                        $fee = '$' . number_format((float) ($record->branding['saas_monthly_fee'] ?? 229000), 0, ',', '.') . ' COP';
                        $link = url("/admin/{$record->slug}/renovar-saas");
                        $days = $record->trial_days_remaining;
                        
                        $urgency = $days <= 0 ? 'ha finalizado' : "vence en {$days} días";
                        $msg = "Hola Dr(a) de *{$record->name}*, te saludamos de AVI-Plan.\n\n"
                             . "Tu período de prueba gratuito de 15 días {$urgency}.\n\n"
                             . "Para mantener activos los carnets digitales de tus pacientes y el portal de membresías de tu clínica, puedes realizar tu pago seguro ({$fee}) con PSE, Nequi o Tarjetas a través de nuestra pasarela oficial Bold:\n"
                             . "👉 {$link}\n\n"
                             . "¡Cualquier duda estamos a tu disposición!";
                             
                        return "https://wa.me/{$prefix}?text=" . urlencode($msg);
                    }, true),

                Tables\Actions\Action::make('openCheckout')
                    ->label('💳 Bold')
                    ->icon('heroicon-o-credit-card')
                    ->color('info')
                    ->button()
                    ->size('xs')
                    ->url(fn (Tenant $record): string => url("/admin/{$record->slug}/renovar-saas"), true),

                Tables\Actions\Action::make('registerPaymentModal')
                    ->label('➕ Pagó')
                    ->icon('heroicon-o-check-circle')
                    ->color('primary')
                    ->button()
                    ->size('xs')
                    ->form([
                        Forms\Components\TextInput::make('amount')
                            ->label('Monto Pagado (COP)')
                            ->numeric()
                            ->prefix('$')
                            ->default(fn (Tenant $record) => $record->branding['saas_monthly_fee'] ?? 229000)
                            ->required(),

                        Forms\Components\Select::make('gateway')
                            ->label('Medio de Pago')
                            ->options([
                                'nequi' => '📱 Transferencia Nequi / Daviplata',
                                'bancolombia' => '🏦 Transferencia Bancolombia',
                                'bold' => '💳 Pasarela Bold',
                                'cash' => '💵 Efectivo Directo',
                            ])
                            ->default('nequi')
                            ->required(),

                        Forms\Components\DatePicker::make('paid_date')
                            ->label('Fecha del Pago')
                            ->default(now()->toDateString())
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Notas')
                            ->placeholder('Ej. Pago recibido vía Nequi')
                            ->rows(2),
                    ])
                    ->action(function (Tenant $record, array $data) {
                        $paidDate = \Carbon\Carbon::parse($data['paid_date']);
                        $nextDue = $paidDate->copy()->addDays(30);

                        $branding = $record->branding ?? [];
                        $branding['saas_status'] = 'paid';
                        $branding['saas_last_payment_date'] = $paidDate->toDateString();
                        $branding['saas_next_payment_due'] = $nextDue->toDateString();
                        $branding['saas_paid_until'] = $nextDue->toDateString();
                        $branding['saas_payment_method'] = $data['gateway'];
                        $branding['saas_monthly_fee'] = $data['amount'];
                        $record->update(['branding' => $branding, 'is_active' => true]);

                        \App\Models\SaasPaymentLog::create([
                            'tenant_id' => $record->id,
                            'order_id' => "MANUAL-{$record->slug}-" . time(),
                            'gateway' => $data['gateway'],
                            'amount' => $data['amount'],
                            'currency' => 'COP',
                            'plan_tier' => $record->saas_plan_tier ?? 'pro',
                            'status' => 'approved',
                            'payer_name' => $record->name,
                            'period_start' => $paidDate->toDateString(),
                            'period_end' => $nextDue->toDateString(),
                            'notes' => $data['notes'] ?? 'Pago manual registrado desde Pipeline SuperAdmin',
                            'paid_at' => $paidDate,
                        ]);

                        Notification::make()
                            ->title('¡Pago Registrado!')
                            ->body("La clínica {$record->name} quedó activa y al día.")
                            ->success()
                            ->send();
                    }),
            ])
            ->paginated([5, 10, 25]);
    }
}
