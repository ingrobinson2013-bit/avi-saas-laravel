@php
    $tenant = \Filament\Facades\Filament::getTenant();
    $tenantSlug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
@endphp

<div class="px-3 py-2">
    <a href="/admin/{{ $tenantSlug }}/counter-redeem" 
       style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 14px; border-radius: 12px; font-weight: 800; font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; text-decoration: none; box-shadow: 0 2px 4px rgba(13, 148, 136, 0.25);"
       class="transition-all transform hover:-translate-y-0.5">
        <span style="font-size: 14px;">🩺</span>
        <span style="color: #ffffff !important;">Canje en Mostrador</span>
    </a>
</div>
