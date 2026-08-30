<?php

namespace App\Filament\VetAdmin\Pages;

use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ClinicSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $navigationLabel = 'Marca y Colores';
    protected static ?string $title = 'Personalización de Marca Blanca';
    protected static ?string $slug = 'clinic-settings';
    protected static ?int $navigationSort = 10;
    protected static string $view = 'filament.vet-admin.pages.clinic-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $tenant = $this->getTenant();
        if ($tenant) {
            $this->form->fill([
                'name' => $tenant->name,
                'city' => $tenant->branding['city'] ?? '',
                'address' => $tenant->branding['address'] ?? '',
                'phone' => $tenant->branding['phone'] ?? '',
                'email' => $tenant->branding['email'] ?? '',
                'logo_url' => $tenant->branding['logo_url'] ?? '',
                'primary_color' => $tenant->branding['primary_color'] ?? '#059669',
                'secondary_color' => $tenant->branding['secondary_color'] ?? '#034433',
                'hero_image_url' => $tenant->branding['hero_image_url'] ?? 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?w=700&auto=format&fit=crop&q=80',
                'banner_image_url' => $tenant->branding['banner_image_url'] ?? 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=1000',
            ]);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identidad Visual y Colores de la Página')
                    ->description('Personaliza el logo, fotos y colores con los que tus clientes ven el portal de tu veterinaria.')
                    ->schema([
                        Forms\Components\TextInput::make('logo_url')
                            ->label('URL del Logo de la Clínica')
                            ->placeholder('https://tusitio.com/logo.png')
                            ->helperText('Pega el enlace de tu logo transparente (PNG/SVG).')
                            ->columnSpanFull(),
                        Forms\Components\ColorPicker::make('primary_color')
                            ->label('Color Principal de Botones y Acentos')
                            ->default('#059669')
                            ->required(),
                        Forms\Components\ColorPicker::make('secondary_color')
                            ->label('Color de la Barra Superior')
                            ->default('#034433')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Fotos de la Página Pública')
                    ->description('Imágenes principales que verán tus tutores de mascotas.')
                    ->schema([
                        Forms\Components\TextInput::make('hero_image_url')
                            ->label('Foto Principal (Hero - Perro y Gato)')
                            ->placeholder('https://images.unsplash.com/...')
                            ->helperText('Foto que aparece al lado del título principal.'),
                        Forms\Components\TextInput::make('banner_image_url')
                            ->label('Foto de la Sección "Así de Fácil"')
                            ->placeholder('https://images.unsplash.com/...')
                            ->helperText('Foto o imagen del consultorio / clínica veterinaria.'),
                    ])->columns(2),

                Forms\Components\Section::make('Datos de Contacto y Ubicación')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('WhatsApp / Teléfono')
                            ->placeholder('3508742543')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('Correo Electrónico Oficial')
                            ->placeholder('contacto@veterinaria.com')
                            ->email(),
                        Forms\Components\TextInput::make('city')
                            ->label('Ciudad / Municipio')
                            ->placeholder('Cajicá, Cundinamarca')
                            ->required(),
                        Forms\Components\TextInput::make('address')
                            ->label('Dirección del Consultorio')
                            ->placeholder('Calle 7 # 4-73 Este')
                            ->required(),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $tenant = $this->getTenant();

        if ($tenant) {
            $branding = $tenant->branding ?? [];
            $branding['city'] = $state['city'];
            $branding['address'] = $state['address'];
            $branding['phone'] = $state['phone'];
            $branding['email'] = $state['email'];
            $branding['logo_url'] = $state['logo_url'];
            $branding['primary_color'] = $state['primary_color'];
            $branding['secondary_color'] = $state['secondary_color'];
            $branding['hero_image_url'] = $state['hero_image_url'];
            $branding['banner_image_url'] = $state['banner_image_url'];

            $tenant->update(['branding' => $branding]);

            Notification::make()
                ->title('¡Marca y Colores actualizados con éxito!')
                ->body('Los cambios ya se reflejan en tu portal público /v/' . $tenant->slug)
                ->success()
                ->send();
        }
    }

    protected function getTenant(): ?Tenant
    {
        $user = auth()->user();
        if ($user?->tenant_id) {
            return Tenant::find($user->tenant_id);
        }
        return Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
    }
}
