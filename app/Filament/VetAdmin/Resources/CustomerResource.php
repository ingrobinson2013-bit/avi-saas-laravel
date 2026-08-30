<?php

namespace App\Filament\VetAdmin\Resources;

use App\Filament\VetAdmin\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Tutores & Clientes';
    protected static ?string $modelLabel = 'Tutor';
    protected static ?string $pluralModelLabel = 'Tutores & Clientes';
    protected static ?string $navigationGroup = 'Gestión de Pacientes';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Tutor / Propietario')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre Completo')
                            ->placeholder('Ej: Carlos Mendoza')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('identification')
                            ->label('Cédula / Documento de Identidad')
                            ->placeholder('Ej: 1020304050')
                            ->maxLength(50),

                        Forms\Components\TextInput::make('phone')
                            ->label('Teléfono / WhatsApp')
                            ->placeholder('+57 300 123 4567')
                            ->tel()
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tutor')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('identification')
                    ->label('Cédula')
                    ->searchable()
                    ->placeholder('Sin cédula'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono / WhatsApp')
                    ->searchable(),

                Tables\Columns\TextColumn::make('pets_count')
                    ->label('Mascotas')
                    ->counts('pets')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Registro')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn (Customer $record) => "https://wa.me/" . preg_replace('/[^0-9]/', '', $record->phone) . "?text=" . urlencode("Hola {$record->name}, te saludamos del consultorio veterinario sobre tus mascotas y planes de salud."))
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
