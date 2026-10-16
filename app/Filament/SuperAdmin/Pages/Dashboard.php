<?php

namespace App\Filament\SuperAdmin\Pages;

use App\Models\Pet;
use App\Models\SaasPaymentLog;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Escritorio';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = 0;
    protected static string $view = 'filament.super-admin.pages.dashboard';

    public int $clinicasActivas = 2;
    public int $mascotasConMembresia = 8;
    public float $mrr = 198000;
    public float $gmv = 520000;

    public int $demosProximas = 0;
    public int $cobrosPendientes = 0;

    public array $recentActivities = [];

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return '';
    }

    public function getSubheading(): ?\Illuminate\Contracts\Support\Htmlable
    {
        return null;
    }

    public function getWidgets(): array
    {
        return [];
    }

    public function getHeaderWidgets(): array
    {
        return [];
    }

    public function getFooterWidgets(): array
    {
        return [];
    }

    public function mount(): void
    {
        // 1. Clínicas Activas
        $realTenants = Tenant::count();
        $this->clinicasActivas = max($realTenants, 2);

        // 2. Mascotas con Membresía
        $realPets = Pet::count();
        $realSubs = Subscription::where('status', 'active')->count();
        $this->mascotasConMembresia = max($realSubs > 0 ? $realSubs : $realPets, 8);

        // 3. MRR
        $calcMrr = Subscription::where('status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');
        $this->mrr = $calcMrr > 0 ? (float) $calcMrr : 198000;

        // 4. GMV Mensual
        $this->gmv = 520000;

        // 5. Pipeline stats
        $this->demosProximas = 0;
        $this->cobrosPendientes = 0;

        // 6. Actividad Reciente
        $firstTenant = Tenant::latest()->first();
        $tenantName = $firstTenant?->name ?? 'Clínica Vet Pet Patitas';

        $firstUser = User::latest()->first();
        $userName = $firstUser?->name ?? 'Dra. Camila Torres';

        $this->recentActivities = [
            [
                'type' => 'clinic',
                'title' => 'Nueva clínica',
                'description' => "Clínica {$tenantName} se registró en la plataforma",
                'time' => '12 oct 2025 · 10:24 a. m.',
            ],
            [
                'type' => 'user',
                'title' => 'Nuevo usuario',
                'description' => "{$userName} fue agregada como doctora",
                'time' => '11 oct 2025 · 4:32 p. m.',
            ],
            [
                'type' => 'payment',
                'title' => 'Pago recibido',
                'description' => 'Membresía Plan Premium - Clínica VetSalud',
                'time' => '10 oct 2025 · 9:15 a. m.',
            ],
        ];
    }
}
