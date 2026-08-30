@php
    $tenant = \Filament\Facades\Filament::getTenant();
    $tenantSlug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
@endphp

<div class="px-4 py-2 mb-2">
    <a href="/admin/{{ $tenantSlug }}/counter-redeem" 
       class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-black text-sm text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-300 hover:from-emerald-300 hover:to-teal-200 shadow-lg shadow-emerald-500/30 transition-all transform hover:-translate-y-0.5 border border-emerald-300/40">
        <span class="text-base animate-pulse">⚡</span>
        <span class="tracking-tight">Canje Rápido en Mostrador</span>
    </a>
</div>
