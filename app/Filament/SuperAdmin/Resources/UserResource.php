<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\UserResource\Pages;
use App\Models\Tenant;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Usuarios & Doctores';
    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $pluralModelLabel = 'Usuarios y Doctores';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos de Acceso y Clínica')
                    ->schema([
                        Forms\Components\Select::make('tenant_id')
                            ->label('Clínica Veterinaria Asociada')
                            ->relationship('tenant', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Dejar vacío únicamente si es un usuario SuperAdministrador global de AVI-Plan.'),

                        Forms\Components\TextInput::make('name')
                            ->label('Nombre Completo / Título')
                            ->required()
                            ->placeholder('Ej. Dr. Robinson Naranjo')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Correo Electrónico (Login)')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Select::make('role')
                            ->label('Rol en el Sistema')
                            ->options([
                                'super_admin' => '👑 SuperAdministrador (NODIA / AVI-Plan Central)',
                                'clinic_admin' => '🏥 Director / Administrador de Clínica',
                                'vet_doctor' => '🩺 Médico Veterinario de Turno',
                                'reception' => '💼 Recepcionista / Mostrador',
                            ])
                            ->default('clinic_admin')
                            ->required(),

                        Forms\Components\TextInput::make('password')
                            ->label('Contraseña')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->helperText('Dejar en blanco para conservar la contraseña actual.'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Correo / Usuario')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Clínica')
                    ->default('👑 AVI-Plan Central (SuperAdmin)')
                    ->badge()
                    ->color(fn ($state) => str_contains($state, 'Central') ? 'primary' : 'gray')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Rol')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'super_admin' => 'SuperAdmin',
                        'clinic_admin' => 'Admin Clínica',
                        'vet_doctor' => 'Médico Vet',
                        'reception' => 'Recepción',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'clinic_admin' => 'success',
                        'vet_doctor' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Alta')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Filtrar por Rol')
                    ->options([
                        'super_admin' => 'SuperAdmin',
                        'clinic_admin' => 'Director de Clínica',
                        'vet_doctor' => 'Médico Veterinario',
                        'reception' => 'Recepcionista',
                    ]),
                Tables\Filters\SelectFilter::make('tenant_id')
                    ->label('Filtrar por Clínica')
                    ->relationship('tenant', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar Cuenta')
                    ->modalHeading(fn ($record) => "⚠️ ¿Eliminar la cuenta de {$record->name} ({$record->email})?")
                    ->modalDescription('Esta acción eliminará de forma permanente al usuario y revocará de inmediato todos sus accesos.')
                    ->hidden(fn ($record) => $record->id === auth()->id() || $record->email === 'contacto@avipetapp.com'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->reject(fn ($u) => $u->id === auth()->id() || $u->email === 'contacto@avipetapp.com')->each->delete()),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
