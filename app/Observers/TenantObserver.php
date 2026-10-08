<?php

namespace App\Observers;

use App\Models\Tenant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TenantObserver
{
    /**
     * Handle the Tenant "creating" event.
     */
    public function creating(Tenant $tenant): void
    {
        // 1. Sanitizar slug único
        if (empty($tenant->slug)) {
            $tenant->slug = Str::slug($tenant->name);
        }

        // 2. Garantizar paleta y branding base para despliegue instantáneo
        $branding = $tenant->branding ?? [];
        $branding['primary_color'] = $branding['primary_color'] ?? '#0080ff';
        $branding['secondary_color'] = $branding['secondary_color'] ?? '#d437b5';
        $branding['city'] = $branding['city'] ?? 'Cajicá, Cundinamarca';
        $branding['phone'] = $branding['phone'] ?? '3235813942';
        $branding['saas_status'] = $branding['saas_status'] ?? 'paid';
        $branding['saas_plan'] = $branding['saas_plan'] ?? 'starter';

        $tenant->branding = $branding;
    }

    /**
     * Handle the Tenant "created" event.
     */
    public function created(Tenant $tenant): void
    {
        Log::info("🏥 [OBSERVER] Nueva Clínica Veterinaria aprovisionada en AVI-Plan:", [
            'tenant_id' => $tenant->id,
            'name' => $tenant->name,
            'slug' => $tenant->slug,
            'storefront_url' => url("/v/{$tenant->slug}"),
        ]);
    }

    /**
     * Handle the Tenant "updated" event.
     */
    public function updated(Tenant $tenant): void
    {
        if ($tenant->isDirty('branding')) {
            Log::info("🎨 [OBSERVER] Marca o configuración actualizada para clínica {$tenant->slug}");
        }
    }
}
