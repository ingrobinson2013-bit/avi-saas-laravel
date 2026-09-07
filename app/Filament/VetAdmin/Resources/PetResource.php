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

                        Forms\Components\FileUpload::make('photo_url')
                            ->label('Foto Oficial de la Mascota')
                            ->disk('r2')
                            ->directory('tenants/pets')
                            ->visibility('public')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->circleCropper()
                            ->columnSpanFull(),

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
                Tables\Columns\ImageColumn::make('photo_url')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=100'),

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
                Tables\Actions\Action::make('view_carnet')
                    ->label('Ver Carnet')
                    ->icon('heroicon-o-identification')
                    ->color('success')
                    ->url(fn (Pet $record) => $record->activeSubscription ? "/v/{$record->customer->tenant->slug}/carnet/{$record->activeSubscription->gateway_subscription_id}" : null)
                    ->openUrlInNewTab()
                    ->visible(fn (Pet $record) => (bool) $record->activeSubscription),

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
