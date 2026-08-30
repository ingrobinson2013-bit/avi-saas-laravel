@php
    $tenant = \Filament\Facades\Filament::getTenant();
    $tenantSlug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
@endphp

<div class="px-3 py-2">
    <a href="/admin/{{ $tenantSlug }}/counter-redeem" 
       class="w-full flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl font-bold text-xs text-white bg-teal-600 hover:bg-teal-700 shadow-sm transition-all transform hover:-translate-y-0.5">
        <span class="text-sm">🩺</span>
        <span class="tracking-tight uppercase font-extrabold text-[11px]">Canje en Mostrador</span>
    </a>
</div>
