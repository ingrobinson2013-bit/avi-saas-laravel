<?php

namespace App\Filament\VetAdmin\Pages;

use App\Models\Tenant;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageOptimizerService;

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

    public static function getUploadDisk(): string
    {
        $r2Key = config('filesystems.disks.r2.key');
        $r2Secret = config('filesystems.disks.r2.secret');
        $r2Endpoint = config('filesystems.disks.r2.endpoint');

        if (!empty($r2Key) && $r2Key !== 'placeholder-key' && !empty($r2Secret) && !empty($r2Endpoint)) {
            return 'r2';
        }

        return 'public';
    }

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
                'banner_video_file' => $branding['banner_video_path'] ?? null,
            ]);
        }
    }

    public function form(Form $form): Form
    {
        $disk = static::getUploadDisk();

        return $form
            ->schema([
                Forms\Components\Section::make('Identidad Visual y Colores de la Veterinaria')
                    ->description('Sube tu logo oficial y personaliza la paleta corporativa.')
                    ->schema([
                        Forms\Components\FileUpload::make('logo_file')
                            ->label('Logo Oficial de la Veterinaria')
                            ->disk($disk)
                            ->directory('tenants/logos')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('150')
                            ->maxSize(5120)
                            ->helperText('Arrastra tu logo en formato PNG, JPG o SVG.')
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

                Forms\Components\Section::make('Fotografías y Video del Portal')
                    ->description('Sube las imágenes y video corto de tu consultorio y pacientes.')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_file')
                            ->label('Foto Principal (Banner Superior Mascotas)')
                            ->disk($disk)
                            ->directory('tenants/heroes')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('160')
                            ->maxSize(10240)
                            ->helperText('Foto que se muestra al lado del título.'),

                        Forms\Components\FileUpload::make('banner_file')
                            ->label('Foto de Portada / Instalaciones')
                            ->disk($disk)
                            ->directory('tenants/banners')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('160')
                            ->maxSize(10240)
                            ->helperText('Foto para la sección "Así de fácil".'),

                        Forms\Components\FileUpload::make('banner_video_file')
                            ->label('Video Corto Promocional o de la Clínica (Máx 20 MB)')
                            ->disk($disk)
                            ->directory('tenants/videos')
                            ->visibility('public')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                            ->maxSize(20480)
                            ->helperText('Video corto de tus instalaciones o bienvenida (MP4 / WebM).')
                            ->columnSpanFull(),
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

            $disk = static::getUploadDisk();
            $r2BaseUrl = rtrim(config('filesystems.disks.r2.url', 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev'), '/');

            // 1. Logo (Optimizado a máx 400px WebP)
            if (!empty($state['logo_file'])) {
                $optimizedPath = ImageOptimizerService::optimizeToWebp($disk, $state['logo_file'], maxWidth: 400, quality: 85);
                $branding['logo_path'] = $optimizedPath;
                if ($disk === 'r2') {
                    $branding['logo_url'] = $r2BaseUrl . '/' . ltrim($optimizedPath, '/');
                } else {
                    $branding['logo_url'] = Storage::disk('public')->url($optimizedPath);
                }
            }

            // 2. Foto Hero (Optimizado a máx 1200px WebP)
            if (!empty($state['hero_file'])) {
                $optimizedPath = ImageOptimizerService::optimizeToWebp($disk, $state['hero_file'], maxWidth: 1200, quality: 80);
                $branding['hero_path'] = $optimizedPath;
                if ($disk === 'r2') {
                    $branding['hero_image_url'] = $r2BaseUrl . '/' . ltrim($optimizedPath, '/');
                } else {
                    $branding['hero_image_url'] = Storage::disk('public')->url($optimizedPath);
                }
            }

            // 3. Banner Foto (Optimizado a máx 1200px WebP)
            if (!empty($state['banner_file'])) {
                $optimizedPath = ImageOptimizerService::optimizeToWebp($disk, $state['banner_file'], maxWidth: 1200, quality: 80);
                $branding['banner_path'] = $optimizedPath;
                if ($disk === 'r2') {
                    $branding['banner_image_url'] = $r2BaseUrl . '/' . ltrim($optimizedPath, '/');
                } else {
                    $branding['banner_image_url'] = Storage::disk('public')->url($optimizedPath);
                }
            }

            // 4. Video Corto
            if (!empty($state['banner_video_file'])) {
                $branding['banner_video_path'] = $state['banner_video_file'];
                if ($disk === 'r2') {
                    $branding['banner_video_url'] = $r2BaseUrl . '/' . ltrim($state['banner_video_file'], '/');
                } else {
                    $branding['banner_video_url'] = Storage::disk('public')->url($state['banner_video_file']);
                }
            }

            $tenant->update(['branding' => $branding]);

            Notification::make()
                ->title('¡Marca, Fotos y Logo guardados exitosamente!')
                ->body('Tus cambios ya se encuentran activos en /v/' . $tenant->slug)
                ->success()
                ->send();
        }
    }

    protected function getTenant(): ?Tenant
    {
        return Filament::getTenant() ?? auth()->user()?->tenant ?? Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
    }
}
