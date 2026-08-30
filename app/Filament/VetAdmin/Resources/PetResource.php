<?php

namespace App\Filament\VetAdmin\Resources;

use App\Filament\VetAdmin\Resources\PetResource\Pages;

use App\Models\Pet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;
    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationLabel = 'Mascotas';
    protected static ?string $modelLabel = 'Mascota';
    protected static ?string $pluralModelLabel = 'Mascotas';

    public static function form(Form $form): Form
    {
        return $form
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
                    ->label('Notas Médicas / Alergias')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Mascota')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('species')
                    ->label('Especie')
                    ->badge(),
                Tables\Columns\TextColumn::make('breed')
                    ->label('Raza')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Tutor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Ingreso')
                    ->dateTime('d/m/Y'),
            ])
            ->actions([
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
