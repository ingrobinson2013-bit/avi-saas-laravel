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

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Marca y Medios de Pago';
    protected static ?string $title = 'Personalización de Marca y Medios de Pago';
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
                'banner_video_file' => $branding['banner_video_path'] ?? null,
                'payment_nequi' => $branding['payment_nequi'] ?? '3508742543',
                'payment_bank_info' => $branding['payment_bank_info'] ?? 'Bancolombia Ahorros # 123-456789-01 (Titular: Clínica Veterinaria)',
                'payment_bold_link' => $branding['payment_bold_link'] ?? '',
                'payment_instructions' => $branding['payment_instructions'] ?? 'Una vez realizada la transferencia o pago, envía el comprobante por WhatsApp indicando el código de tu carnet.',
            ]);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identidad Visual y Colores de la Veterinaria')
                    ->description('Sube tu logo oficial y personaliza la paleta corporativa (Almacenamiento Cloudflare R2).')
                    ->schema([
                        Forms\Components\FileUpload::make('logo_file')
                            ->label('Logo Oficial de la Veterinaria')
                            ->disk('r2')
                            ->directory('tenants/logos')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('150')
                            ->maxSize(51200)
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

                Forms\Components\Section::make('💳 Configuración de Medios de Pago de la Veterinaria')
                    ->description('Configura tus cuentas bancarias y link de Bold/Wompi para que los tutores te paguen directamente a tu clínica.')
                    ->schema([
                        Forms\Components\TextInput::make('payment_nequi')
                            ->label('Número Nequi / Daviplata')
                            ->placeholder('Ej. 3508742543')
                            ->helperText('Número para recibir transferencias directas por Nequi o Daviplata.')
                            ->default('3508742543'),

                        Forms\Components\TextInput::make('payment_bold_link')
                            ->label('Link de Pago Bold / Wompi / Pasarela')
                            ->placeholder('Ej. https://bold.co/p/tu-clinica o https://checkout.wompi.co/l/...')
                            ->helperText('Si tienes datáfono Bold o cuenta comercial, pega aquí tu link de pago virtual para cobro con tarjeta/PSE.'),

                        Forms\Components\TextInput::make('payment_bank_info')
                            ->label('Datos de Cuenta Bancaria (Bancolombia, etc.)')
                            ->placeholder('Ej. Bancolombia Ahorros # 123-456789-01 - Nit: 900.123.456')
                            ->helperText('Información de transferencia interbancaria tradicional.')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('payment_instructions')
                            ->label('Instrucciones Adicionales de Pago para el Tutor')
                            ->placeholder('Instrucciones para validar el pago...')
                            ->rows(2)
                            ->helperText('Este texto aparecerá en el modal de afiliación y confirmación.')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Fotografías y Video del Portal')
                    ->description('Sube las imágenes y video corto de tu consultorio y pacientes a la nube.')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_file')
                            ->label('Foto Principal (Banner Superior Mascotas)')
                            ->disk('r2')
                            ->directory('tenants/heroes')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('160')
                            ->maxSize(51200)
                            ->helperText('Foto que se muestra al lado del título.'),

                        Forms\Components\FileUpload::make('banner_file')
                            ->label('Foto de Portada / Instalaciones')
                            ->disk('r2')
                            ->directory('tenants/banners')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('160')
                            ->maxSize(51200)
                            ->helperText('Foto para la sección "Conoce Nuestras Instalaciones".'),

                        Forms\Components\FileUpload::make('banner_video_file')
                            ->label('Video Corto Promocional o de la Clínica (Máx 50 MB)')
                            ->disk('r2')
                            ->directory('tenants/videos')
                            ->visibility('public')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                            ->maxSize(51200)
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
            $branding['payment_nequi'] = $state['payment_nequi'] ?? '3508742543';
            $branding['payment_bank_info'] = $state['payment_bank_info'] ?? '';
            $branding['payment_bold_link'] = $state['payment_bold_link'] ?? '';
            $branding['payment_instructions'] = $state['payment_instructions'] ?? '';

            $r2BaseUrl = rtrim(config('filesystems.disks.r2.url', 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev'), '/');

            // 1. Logo (Optimizado a máx 400px WebP en Cloudflare R2)
            if (!empty($state['logo_file'])) {
                $optimizedPath = ImageOptimizerService::optimizeToWebp('r2', $state['logo_file'], maxWidth: 400, quality: 85);
                $branding['logo_path'] = $optimizedPath;
                $branding['logo_url'] = $r2BaseUrl . '/' . ltrim($optimizedPath, '/');
            }

            // 2. Foto Hero (Optimizado a máx 1200px WebP en Cloudflare R2)
            if (!empty($state['hero_file'])) {
                $optimizedPath = ImageOptimizerService::optimizeToWebp('r2', $state['hero_file'], maxWidth: 1200, quality: 80);
                $branding['hero_path'] = $optimizedPath;
                $branding['hero_image_url'] = $r2BaseUrl . '/' . ltrim($optimizedPath, '/');
            }

            // 3. Banner Foto (Optimizado a máx 1200px WebP en Cloudflare R2)
            if (!empty($state['banner_file'])) {
                $optimizedPath = ImageOptimizerService::optimizeToWebp('r2', $state['banner_file'], maxWidth: 1200, quality: 80);
                $branding['banner_path'] = $optimizedPath;
                $branding['banner_image_url'] = $r2BaseUrl . '/' . ltrim($optimizedPath, '/');
            }

            // 4. Video Corto en Cloudflare R2
            if (!empty($state['banner_video_file'])) {
                $branding['banner_video_path'] = $state['banner_video_file'];
                $branding['banner_video_url'] = $r2BaseUrl . '/' . ltrim($state['banner_video_file'], '/');
            }

            $tenant->update(['branding' => $branding]);

            // Re-llenar el formulario para que los campos permanezcan actualizados
            $this->form->fill([
                'name' => $tenant->name,
                'city' => $branding['city'],
                'address' => $branding['address'],
                'phone' => $branding['phone'],
                'email' => $branding['email'],
                'primary_color' => $branding['primary_color'],
                'secondary_color' => $branding['secondary_color'],
                'logo_file' => $branding['logo_path'] ?? null,
                'hero_file' => $branding['hero_path'] ?? null,
                'banner_file' => $branding['banner_path'] ?? null,
                'banner_video_file' => $branding['banner_video_path'] ?? null,
                'payment_nequi' => $branding['payment_nequi'] ?? '',
                'payment_bank_info' => $branding['payment_bank_info'] ?? '',
                'payment_bold_link' => $branding['payment_bold_link'] ?? '',
                'payment_instructions' => $branding['payment_instructions'] ?? '',
            ]);

            Notification::make()
                ->title('¡Configuración de Marca y Pagos Guardada!')
                ->body('Tus cuentas y opciones de cobro ya se encuentran activas en el portal.')
                ->success()
                ->send();
        }
    }

    public function getTenant(): ?Tenant
    {
        return Filament::getTenant() ?? auth()->user()?->tenant ?? Tenant::where('slug', 'vet-pet-patitas')->first() ?? Tenant::first();
    }
}
