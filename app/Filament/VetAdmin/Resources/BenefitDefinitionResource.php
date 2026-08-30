<?php

namespace App\Filament\VetAdmin\Resources;

use App\Filament\VetAdmin\Resources\BenefitDefinitionResource\Pages;
use App\Models\BenefitDefinition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BenefitDefinitionResource extends Resource
{
    protected static ?string $model = BenefitDefinition::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationLabel = 'Catálogo de Servicios';
    protected static ?string $modelLabel = 'Servicio / Beneficio';
    protected static ?string $pluralModelLabel = 'Catálogo de Servicios';
    protected static ?string $navigationGroup = 'Planes & Catálogo';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Definición del Servicio Canjeable')
                    ->description('Crea o edita los servicios que podrán ser incluidos dentro de los planes de salud')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre del Servicio / Beneficio')
                            ->placeholder('Ej: Consulta Preventiva General, Baño Medicado, Vacuna Rabia')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                        Forms\Components\Select::make('category')
                            ->label('Categoría')
                            ->options([
                                'consulta' => '🩺 Consulta Médica',
                                'vacuna' => '💉 Vacunación',
                                'desparasitacion' => '💊 Desparasitación',
                                'bano' => '🛁 Baño & Estética',
                                'laboratorio' => '🔬 Exámenes & Laboratorio',
                                'urgencia' => '🚨 Urgencias / Prioritaria',
                                'guarderia' => '🏠 Guardería / Hotel',
                                'bienvenida' => '🎁 Kit Bienvenida',
                                'descuento' => '🏷️ Descuento Especial',
                                'funerario' => '🕊️ Previsión Exequial',
                            ])
                            ->default('consulta')
                            ->required(),

                        Forms\Components\TextInput::make('default_validity_days')
                            ->label('Días de Vigencia por Defecto')
                            ->numeric()
                            ->default(365)
                            ->required()
                            ->suffix('días'),

                        Forms\Components\Textarea::make('description')
                            ->label('Descripción y Alcance del Beneficio')
                            ->placeholder('Detalles de lo que incluye este servicio al canjearse en la clínica...')
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
                    ->label('Nombre del Servicio')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Categoría')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->category_label)
                    ->color(fn (string $state): string => match ($state) {
                        'consulta' => 'info',
                        'vacuna' => 'success',
                        'desparasitacion' => 'warning',
                        'bano' => 'primary',
                        'laboratorio' => 'danger',
                        'urgencia' => 'danger',
                        'guarderia' => 'gray',
                        default => 'secondary',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('plan_benefits_count')
                    ->label('En Planes')
                    ->counts('planBenefits')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Filtrar por Categoría')
                    ->options([
                        'consulta' => 'Consulta Médica',
                        'vacuna' => 'Vacunación',
                        'desparasitacion' => 'Desparasitación',
                        'bano' => 'Baño & Estética',
                        'laboratorio' => 'Exámenes & Laboratorio',
                        'urgencia' => 'Urgencias',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBenefitDefinitions::route('/'),
            'create' => Pages\CreateBenefitDefinition::route('/create'),
            'edit' => Pages\EditBenefitDefinition::route('/{record}/edit'),
        ];
    }
}
