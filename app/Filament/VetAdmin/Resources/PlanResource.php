<?php

namespace App\Filament\VetAdmin\Resources;

use App\Filament\VetAdmin\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Planes de Salud';
    protected static ?string $modelLabel = 'Plan de Salud';
    protected static ?string $pluralModelLabel = 'Planes de Salud';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detalles del Plan de Salud')
                    ->description('Configura los precios y coberturas del plan de tu clínica')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre del Plan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('price_cop')
                            ->label('Precio Mensual (COP)')
                            ->numeric()
                            ->prefix('$')
                            ->required(),
                        Forms\Components\Select::make('billing_interval')
                            ->label('Frecuencia de Cobro')
                            ->options([
                                'monthly' => 'Mensual',
                                'yearly' => 'Anual',
                            ])
                            ->default('monthly')
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Plan Activo para Venta')
                            ->default(true),
                        Forms\Components\Textarea::make('description')
                            ->label('Descripción y Reglas de Carencia')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre del Plan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('price_cop')
                    ->label('Precio COP')
                    ->money('COP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('billing_interval')
                    ->label('Frecuencia')
                    ->badge()
                    ->color('info'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('subscriptions_count')
                    ->label('Mascotas Afiliadas')
                    ->counts('subscriptions')
                    ->badge()
                    ->color('success'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
