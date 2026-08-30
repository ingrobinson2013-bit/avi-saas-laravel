<?php

namespace App\Filament\VetAdmin\Resources;

use App\Filament\VetAdmin\Resources\PetResource\Pages;
use App\Models\BenefitDefinition;
use App\Models\Pet;
use App\Services\BenefitLedgerService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;
    protected static ?string $tenantOwnershipRelationshipName = 'customer';
    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationLabel = 'Mascotas & Pacientes';
    protected static ?string $modelLabel = 'Mascota';
    protected static ?string $pluralModelLabel = 'Mascotas';
    protected static ?string $navigationGroup = 'Gestión de Pacientes';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Ficha de Identificación de la Mascota')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->label('Tutor / Propietario')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('name')
                            ->label('Nombre de la Mascota')
                            ->required(),

                        Forms\Components\Select::make('species')
                            ->label('Especie')
                            ->options([
                                'dog' => 'Perro 🐶',
                                'cat' => 'Gato 🐱',
                                'other' => 'Otro 🐾',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('breed')
                            ->label('Raza'),

                        Forms\Components\DatePicker::make('birthdate')
                            ->label('Fecha de Nacimiento'),

                        Forms\Components\Textarea::make('medical_notes')
                            ->label('Historial Clínico / Alergias / Observaciones')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Mascota')
                    ->description(fn (Pet $record): string => ($record->species === 'cat' ? '🐱 ' : '🐶 ') . ($record->breed ?? 'Mestizo'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Tutor')
                    ->description(fn (Pet $record): string => $record->customer?->phone ?? '')
                    ->searchable(),

                Tables\Columns\TextColumn::make('activeSubscription.plan.name')
                    ->label('Plan Activo')
                    ->badge()
                    ->color('info')
                    ->placeholder('Sin plan activo')
                    ->formatStateUsing(fn ($state) => $state ? "🐾 {$state}" : 'Sin plan'),

                Tables\Columns\TextColumn::make('activeSubscription.computed_status')
                    ->label('Membresía')
                    ->badge()
                    ->getStateUsing(fn (Pet $record) => $record->activeSubscription?->status_label ?? 'Inactiva')
                    ->color(fn (Pet $record) => $record->activeSubscription?->status_color ?? 'gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Ingreso')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('viewSubscription')
                    ->label('Ver Plan')
                    ->icon('heroicon-o-shield-check')
                    ->color('info')
                    ->visible(fn (Pet $record) => $record->activeSubscription !== null)
                    ->url(fn (Pet $record) => SubscriptionResource::getUrl('view', ['record' => $record->activeSubscription->id])),

                Tables\Actions\Action::make('quickRedeem')
                    ->label('Canjear')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Pet $record) => $record->activeSubscription !== null)
                    ->modalHeading(fn (Pet $record) => "Canjear Servicio — {$record->name}")
                    ->form(function (Pet $record) {
                        $sub = $record->activeSubscription;
                        if (!$sub) return [];

                        return [
                            Forms\Components\Select::make('benefit_definition_id')
                                ->label('Servicio a Canjear')
                                ->options(function () use ($sub) {
                                    $balances = $sub->benefitBalances()->with('benefitDefinition')->get();
                                    $options = [];
                                    foreach ($balances as $bal) {
                                        $options[$bal->benefit_definition_id] = "{$bal->benefitDefinition?->name} (Disponibles: {$bal->remaining_count} de {$bal->total_granted})";
                                    }
                                    return $options;
                                })
                                ->required(),

                            Forms\Components\TextInput::make('quantity')
                                ->label('Cantidad')
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->required(),

                            Forms\Components\Textarea::make('notes')
                                ->label('Notas / Observaciones Médicas')
                                ->rows(2),
                        ];
                    })
                    ->action(function (Pet $record, array $data, BenefitLedgerService $ledgerService) {
                        $sub = $record->activeSubscription;
                        if (!$sub) return;

                        try {
                            $benefit = BenefitDefinition::findOrFail($data['benefit_definition_id']);
                            $ledgerService->redeemBenefit(
                                subscription: $sub,
                                benefit: $benefit,
                                quantity: (int) $data['quantity'],
                                vetUserId: auth()->id(),
                                notes: $data['notes'] ?? null
                            );

                            Notification::make()
                                ->title('¡Servicio Canjeado!')
                                ->body("Se descontó {$data['quantity']} cupo de {$benefit->name} para {$record->name}.")
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('Error al canjear')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPets::route('/'),
            'create' => Pages\CreatePet::route('/create'),
            'edit' => Pages\EditPet::route('/{record}/edit'),
        ];
    }
}
