@php
    $tenant = \Filament\Facades\Filament::getTenant();
    $tenantSlug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
@endphp

<div class="px-3 py-2 mb-2">
    <a href="/admin/{{ $tenantSlug }}/counter-redeem" 
       style="background: linear-gradient(135deg, #0d9488 0%, #10b981 100%); box-shadow: 0 4px 15px -2px rgba(13, 148, 136, 0.45); color: #ffffff !important;"
       class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs tracking-tight text-white hover:opacity-95 transition-all transform hover:-translate-y-0.5 border border-teal-300/30">
        <span class="text-sm">🩺</span>
        <span class="font-extrabold uppercase tracking-wider text-[11px]">Canje Rápido en Mostrador</span>
    </a>
</div>
