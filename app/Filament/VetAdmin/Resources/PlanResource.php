<?php

namespace App\Filament\VetAdmin\Resources;

use App\Filament\VetAdmin\Resources\PlanResource\Pages;
use App\Models\BenefitDefinition;
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
    protected static ?string $navigationLabel = 'Constructor de Planes';
    protected static ?string $modelLabel = 'Plan de Salud y Bienestar';
    protected static ?string $pluralModelLabel = 'Planes de Bienestar';
    protected static ?string $navigationGroup = 'Planes & Catálogo';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Configuración General del Plan')
                            ->description('Define los valores comerciales y periodicidad del plan')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre del Plan')
                                    ->placeholder('Ej: Plan Patitas Básico, Plan Vital Cachorros, Plan Gold')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('price_cop')
                                    ->label('Precio por Período (COP)')
                                    ->numeric()
                                    ->prefix('$')
                                    ->placeholder('50000')
                                    ->required(),

                                Forms\Components\Select::make('billing_interval')
                                    ->label('Frecuencia de Cobro / Facturación')
                                    ->options([
                                        'monthly' => '📅 Mensual',
                                        'yearly' => '📆 Anual',
                                    ])
                                    ->default('monthly')
                                    ->required(),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Plan Activo para Venta')
                                    ->helperText('Si está activo, se mostrará en la página web pública de la clínica')
                                    ->default(true),

                                Forms\Components\Textarea::make('description')
                                    ->label('Descripción Comercial y Condiciones')
                                    ->placeholder('Describe los diferenciales del plan, tiempos de activación, carencias y propuesta de valor para el tutor...')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make('Constructor de Beneficios y Límites de Consumo')
                            ->description('Asigna los servicios incluidos en este plan y cuántos cupos tendrá cada mascota por período.')
                            ->schema([
                                Forms\Components\Repeater::make('planBenefits')
                                    ->relationship('planBenefits')
                                    ->label('Servicios Incluidos en la Membresía')
                                    ->schema([
                                        Forms\Components\Select::make('benefit_definition_id')
                                            ->label('Servicio / Beneficio')
                                            ->options(function () {
                                                return BenefitDefinition::all()->mapWithKeys(function ($benefit) {
                                                    return [$benefit->id => "{$benefit->name} ({$benefit->category_label})"];
                                                });
                                            })
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->columnSpan(2),

                                        Forms\Components\TextInput::make('quantity')
                                            ->label('Cupos / Veces por Período')
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->required()
                                            ->helperText('Ej: 2 para 2 consultas/año, o 999 para ilimitadas'),

                                        Forms\Components\Toggle::make('expires_each_cycle')
                                            ->label('Reiniciar al renovar')
                                            ->default(true)
                                            ->inline(false),
                                    ])
                                    ->columns(4)
                                    ->defaultItems(1)
                                    ->addActionLabel('➕ Agregar Beneficio al Plan')
                                    ->reorderableWithButtons()
                                    ->collapsible()
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpanFull(),
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
                    ->formatStateUsing(fn ($state) => $state === 'monthly' ? 'Mensual' : 'Anual')
                    ->color(fn ($state) => $state === 'monthly' ? 'info' : 'primary'),

                Tables\Columns\TextColumn::make('plan_benefits_count')
                    ->label('Beneficios')
                    ->counts('planBenefits')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('subscriptions_count')
                    ->label('Mascotas Activas')
                    ->counts('subscriptions')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('En Venta')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Estado de Venta')
                    ->trueLabel('Solo Planes Activos')
                    ->falseLabel('Solo Inactivos'),
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
