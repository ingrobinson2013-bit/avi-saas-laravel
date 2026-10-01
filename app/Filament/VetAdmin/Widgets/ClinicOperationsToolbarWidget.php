<?php

namespace App\Filament\VetAdmin\Widgets;

use App\Models\Subscription;
use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class ClinicOperationsToolbarWidget extends Widget
{
    protected static ?int $sort = 0; // Justo después del estado de la suscripción
    protected int | string | array $columnSpan = 'full';
    protected static string $view = 'filament.vet-admin.widgets.clinic-operations-toolbar';

    public ?string $slug = 'vet-pet-patitas';
    public ?string $clinicName = 'Clínica Veterinaria';
    public int $activeSubsCount = 0;
    public string $publicUrl = '';
    public string $flyerUrl = '';
    public string $redeemUrl = '';
    public string $plansUrl = '';
    public string $newSubUrl = '';

    public function mount(): void
    {
        $tenant = Filament::getTenant();
        $this->clinicName = $tenant?->name ?? 'Clínica Veterinaria';
        $this->slug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
        
        $tenantId = $tenant?->id;
        $this->activeSubsCount = Subscription::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->where('status', 'active')
            ->count();

        $this->publicUrl = url("/v/{$this->slug}");
        $this->flyerUrl = url("/v/{$this->slug}/afiche");
        $this->redeemUrl = url("/admin/{$this->slug}/counter-redeem");
        $this->plansUrl = url("/admin/{$this->slug}/plans");
        $this->newSubUrl = url("/admin/{$this->slug}/subscriptions/create");
    }
}
