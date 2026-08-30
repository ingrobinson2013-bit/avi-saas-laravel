<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\TenantResource\Pages;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Form;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la Clínica')
                    ->description('Datos generales y configuración SaaS')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre de la Veterinaria')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug / Identificador Único')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('domain')
                            ->label('Dominio / Subdominio Personalizado')
                            ->placeholder('ej. patitas.aviplan.co')
                            ->maxLength(255),
                        Forms\Components\Select::make('saas_plan_tier')
                            ->label('Nivel de Plan SaaS')
                            ->options([
                                'starter' => 'Starter (Hasta 100 mascotas)',
                                'pro' => 'Profesional (Hasta 500 mascotas)',
                                'enterprise' => 'Enterprise (Ilimitado + Multi-sucursal)',
                            ])
                            ->default('pro')
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Estado de Activación')
                            ->helperText('Si se desactiva, el acceso para esta clínica y sus usuarios quedará suspendido.')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Identidad Visual y Marca Blanca')
                    ->schema([
                        Forms\Components\TextInput::make('branding.logo_url')
                            ->label('URL del Logo')
                            ->placeholder('https://...'),
                        Forms\Components\ColorPicker::make('branding.primary_color')
                            ->label('Color Primario')
                            ->default('#10B981'),
                        Forms\Components\ColorPicker::make('branding.secondary_color')
                            ->label('Color Secundario')
                            ->default('#065F46'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Veterinaria')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('domain')
                    ->label('Dominio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('saas_plan_tier')
                    ->label('Plan SaaS')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'starter' => 'info',
                        'pro' => 'success',
                        'enterprise' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Alta')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Filtrar por Estado'),
            ])
            ->actions([
                Tables\Actions\Action::make('toggleActive')
                    ->label(fn (Tenant $record) => $record->is_active ? 'Suspender' : 'Activar')
                    ->icon(fn (Tenant $record) => $record->is_active ? 'heroicon-o-no-symbol' : 'heroicon-o-check-circle')
                    ->color(fn (Tenant $record) => $record->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->action(fn (Tenant $record) => $record->update(['is_active' => !$record->is_active])),
                Tables\Actions\EditAction::make(),
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
