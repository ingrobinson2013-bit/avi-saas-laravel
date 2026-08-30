<?php

namespace App\Filament\VetAdmin\Resources;

use App\Filament\VetAdmin\Resources\SubscriptionResource\Pages;
use App\Models\BenefitDefinition;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\BenefitLedgerService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Membresías & Suscripciones';
    protected static ?string $modelLabel = 'Membresía';
    protected static ?string $pluralModelLabel = 'Membresías';
    protected static ?string $navigationGroup = 'Gestión de Pacientes';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detalles de la Membresía')
                    ->description('Configura la mascota, plan de salud y vigencia del contrato')
                    ->schema([
                        Forms\Components\Select::make('pet_id')
                            ->label('Mascota Afiliada')
                            ->options(function () {
                                return Pet::with('customer')->get()->mapWithKeys(function ($pet) {
                                    $species = $pet->species === 'cat' ? '🐱' : '🐶';
                                    $tutor = $pet->customer ? " (Tutor: {$pet->customer->name})" : '';
                                    return [$pet->id => "{$species} {$pet->name}{$tutor}"];
                                });
                            })
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('plan_id')
                            ->label('Plan de Salud Contratado')
                            ->relationship('plan', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Estado de la Membresía')
                            ->options([
                                'active' => '🟢 Activa',
                                'past_due' => '🔴 En Mora / Vencida',
                                'canceled' => '⚫ Cancelada',
                                'paused' => '⏸️ Pausada',
                            ])
                            ->default('active')
                            ->required(),

                        Forms\Components\DateTimePicker::make('current_period_start')
                            ->label('Fecha Inicio de Ciclo')
                            ->default(now())
                            ->required(),

                        Forms\Components\DateTimePicker::make('current_period_end')
                            ->label('Fecha Fin de Ciclo (Próx. Renovación)')
                            ->default(now()->addMonth())
                            ->required(),

                        Forms\Components\TextInput::make('gateway_subscription_id')
                            ->label('ID Pasarela de Pagos (Opcional)')
                            ->placeholder('sub_wompi_xxxx o epayco_xxxx')
                            ->maxLength(255),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pet.name')
                    ->label('Mascota')
                    ->description(function (Subscription $record): string {
                        $species = $record->pet?->species === 'cat' ? '🐱 ' : '🐶 ';
                        $breed = $record->pet?->breed ?? 'Mestizo';
                        $age = $record->pet?->birthdate ? ' • ' . \Carbon\Carbon::parse($record->pet->birthdate)->age . ' años' : '';
                        return "{$species}{$breed}{$age}";
                    })
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('pet.customer.name')
                    ->label('Tutor')
                    ->description(fn (Subscription $record): string => $record->pet?->customer?->phone ?? '')
                    ->searchable(),

                Tables\Columns\TextColumn::make('plan.name')
                    ->label('Plan')
                    ->badge()
                    ->color(fn ($state) => str_contains(strtolower($state ?? ''), 'premium') ? 'purple' : 'info')
                    ->searchable(),

                Tables\Columns\TextColumn::make('computed_status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (Subscription $record) => $record->status_label)
                    ->color(fn (Subscription $record) => $record->status_color),

                Tables\Columns\TextColumn::make('benefit_balances_summary')
                    ->label('Saldo de Beneficios')
                    ->getStateUsing(function (Subscription $record) {
                        $granted = $record->total_granted;
                        $used = $record->total_used;
                        $pct = $record->usage_percentage;
                        return "{$used}/{$granted} usados ({$pct}%)";
                    })
                    ->badge()
                    ->color(fn (Subscription $record) => $record->usage_percentage > 80 ? 'danger' : ($record->usage_percentage > 40 ? 'warning' : 'success')),

                Tables\Columns\TextColumn::make('current_period_end')
                    ->label('Próx. Renovación')
                    ->dateTime('d/m/Y')
                    ->description(function (Subscription $record) {
                        $days = now()->diffInDays($record->current_period_end, false);
                        if ($days < 0) return '🔴 Vencida';
                        if ($days === 0) return '🟡 Hoy';
                        return "en {$days} días";
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'active' => 'Activas',
                        'past_due' => 'En Mora / Vencidas',
                        'canceled' => 'Canceladas',
                        'paused' => 'Pausadas',
                    ]),

                Tables\Filters\SelectFilter::make('plan')
                    ->relationship('plan', 'name')
                    ->label('Filtrar por Plan'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                
                // Acción de Canje Rápido directo desde la fila
                Tables\Actions\Action::make('quickRedeem')
                    ->label('Canjear')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->modalHeading(fn (Subscription $record) => "Registrar Consumo — {$record->pet?->name} ({$record->plan?->name})")
                    ->form(function (Subscription $record) {
                        return [
                            Forms\Components\Select::make('benefit_definition_id')
                                ->label('Seleccionar Servicio a Canjear')
                                ->options(function () use ($record) {
                                    $balances = $record->benefitBalances()->with('benefitDefinition')->get();
                                    $options = [];
                                    foreach ($balances as $bal) {
                                        $benefitName = $bal->benefitDefinition?->name ?? 'Servicio';
                                        $options[$bal->benefit_definition_id] = "{$benefitName} — Restantes: {$bal->remaining_count} de {$bal->total_granted}";
                                    }
                                    return $options;
                                })
                                ->required(),

                            Forms\Components\TextInput::make('quantity')
                                ->label('Cantidad de cupos')
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->required(),

                            Forms\Components\Textarea::make('notes')
                                ->label('Observaciones Clínicas / Motivo de Consulta')
                                ->placeholder('Ej: Control preventivo de peso, corte de uñas, aplicación de biológico...')
                                ->rows(2),
                        ];
                    })
                    ->action(function (Subscription $record, array $data, BenefitLedgerService $ledgerService) {
                        try {
                            $benefit = BenefitDefinition::findOrFail($data['benefit_definition_id']);
                            $ledgerService->redeemBenefit(
                                subscription: $record,
                                benefit: $benefit,
                                quantity: (int) $data['quantity'],
                                vetUserId: auth()->id(),
                                notes: $data['notes'] ?? null
                            );

                            Notification::make()
                                ->title('¡Consumo registrado correctamente!')
                                ->body("Se descontó {$data['quantity']} cupo de {$benefit->name} para {$record->pet?->name}.")
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('No se pudo registrar el canje')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // Acción de Renovar Ciclo
                Tables\Actions\Action::make('renewCycle')
                    ->label('Renovar')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('¿Renovar ciclo de membresía?')
                    ->modalDescription('Esta acción extenderá la vigencia por 1 mes adicional y reseteará los cupos de beneficios según el plan contratado.')
                    ->action(function (Subscription $record, BenefitLedgerService $ledgerService) {
                        $record->update([
                            'status' => 'active',
                            'current_period_start' => now(),
                            'current_period_end' => now()->addMonth(),
                        ]);

                        $ledgerService->resetCycleBalances($record);

                        Notification::make()
                            ->title('Membresía renovada con éxito')
                            ->body("Saldos de beneficios reiniciados para {$record->pet?->name}.")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (Subscription $record) {
                        $phone = preg_replace('/[^0-9]/', '', $record->pet?->customer?->phone ?? '');
                        $name = $record->pet?->customer?->name ?? 'Tutor';
                        $pet = $record->pet?->name ?? 'tu mascota';
                        return "https://wa.me/{$phone}?text=" . urlencode("Hola {$name}, te saludamos de la clínica veterinaria sobre el plan de {$pet}.");
                    })
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'view' => Pages\ViewSubscription::route('/{record}'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
