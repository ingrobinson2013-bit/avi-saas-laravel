<?php

namespace App\Filament\VetAdmin\Pages;

use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;

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
            $branding = $tenant->branding ?? [];

            $this->form->fill([
                'name' => $tenant->name,
                'city' => $branding['city'] ?? 'Cajicá, Cundinamarca',
                'address' => $branding['address'] ?? 'Calle 7 # 4-73 Este',
                'phone' => $branding['phone'] ?? '3508742543',
                'email' => $branding['email'] ?? 'petmovilveterinario@gmail.com',
                'primary_color' => $branding['primary_color'] ?? '#0284c7',
                'secondary_color' => $branding['secondary_color'] ?? '#0f172a',
                'logo_file' => $branding['logo_path'] ?? null,
                'hero_file' => $branding['hero_path'] ?? null,
                'banner_file' => $branding['banner_path'] ?? null,
            ]);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identidad Visual y Colores de la Veterinaria')
                    ->description('Sube tu logo oficial y personaliza la paleta corporativa.')
                    ->schema([
                        Forms\Components\FileUpload::make('logo_file')
                            ->label('Logo Oficial de la Veterinaria')
                            ->disk('r2')
                            ->directory('tenants/logos')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('150')
                            ->maxSize(5120)
                            ->helperText('Arrastra tu logo en formato PNG o SVG (fondo transparente o blanco).')
                            ->columnSpanFull(),

                        Forms\Components\ColorPicker::make('primary_color')
                            ->label('Color Principal de Botones y Acentos')
                            ->default('#0284c7')
                            ->required(),

                        Forms\Components\ColorPicker::make('secondary_color')
                            ->label('Color de la Barra Superior')
                            ->default('#0f172a')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Fotografías del Portal Web')
                    ->description('Sube las imágenes de tu consultorio y mascotas.')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_file')
                            ->label('Foto Principal (Banner Superior Mascotas)')
                            ->disk('r2')
                            ->directory('tenants/heroes')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('160')
                            ->maxSize(10240),

                        Forms\Components\FileUpload::make('banner_file')
                            ->label('Foto de Instalaciones / Consultorio')
                            ->disk('r2')
                            ->directory('tenants/banners')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('160')
                            ->maxSize(10240),
                    ])->columns(2),

                Forms\Components\Section::make('Datos de Contacto')
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('WhatsApp Oficial')
                            ->default('3508742543'),
                        Forms\Components\TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->default('petmovilveterinario@gmail.com'),
                        Forms\Components\TextInput::make('city')
                            ->label('Ciudad')
                            ->default('Cajicá, Cundinamarca'),
                        Forms\Components\TextInput::make('address')
                            ->label('Dirección')
                            ->default('Calle 7 # 4-73 Este'),
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
            $branding['city'] = $state['city'] ?? 'Cajicá, Cundinamarca';
            $branding['address'] = $state['address'] ?? 'Calle 7 # 4-73 Este';
            $branding['phone'] = $state['phone'] ?? '3508742543';
            $branding['email'] = $state['email'] ?? 'petmovilveterinario@gmail.com';
            $branding['primary_color'] = $state['primary_color'] ?? '#0284c7';
            $branding['secondary_color'] = $state['secondary_color'] ?? '#0f172a';

            $r2BaseUrl = rtrim(config('filesystems.disks.r2.url', 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev'), '/');

            // 1. Procesar Logo
            if (!empty($state['logo_file'])) {
                $branding['logo_path'] = $state['logo_file'];
                $branding['logo_url'] = $r2BaseUrl . '/' . ltrim($state['logo_file'], '/');
            }

            // 2. Procesar Foto Hero
            if (!empty($state['hero_file'])) {
                $branding['hero_path'] = $state['hero_file'];
                $branding['hero_image_url'] = $r2BaseUrl . '/' . ltrim($state['hero_file'], '/');
            }

            // 3. Procesar Banner Instalaciones
            if (!empty($state['banner_file'])) {
                $branding['banner_path'] = $state['banner_file'];
                $branding['banner_image_url'] = $r2BaseUrl . '/' . ltrim($state['banner_file'], '/');
            }

            $tenant->update(['branding' => $branding]);

            Notification::make()
                ->title('¡Marca y Colores guardados con éxito!')
                ->body('Tu logo y fotos ya se encuentran disponibles en alta resolución en /v/' . $tenant->slug)
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
