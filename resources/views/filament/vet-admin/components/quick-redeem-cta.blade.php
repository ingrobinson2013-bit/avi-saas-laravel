@php
    $tenant = \Filament\Facades\Filament::getTenant();
    $tenantSlug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
@endphp

<div class="px-4 py-2 mb-2">
    <a href="/admin/{{ $tenantSlug }}/counter-redeem" 
       class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-teal-600 via-teal-500 to-emerald-500 hover:from-teal-500 hover:to-emerald-400 shadow-md shadow-teal-500/25 transition-all transform hover:-translate-y-0.5 border border-teal-400/30">
        <span class="text-base animate-pulse">🩺</span>
        <span class="tracking-tight">Canje Rápido en Mostrador</span>
    </a>
</div>
