@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $slug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
@endphp

<div class="hidden sm:flex items-center gap-2 ml-2">
    {{-- Indicador en Vivo --}}
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200/80 dark:border-slate-700">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span>En Vivo</span>
    </span>

    {{-- Accesos Rápidos Operativos en la Barra Superior --}}
    <a href="/admin/{{ $slug }}/counter-redeem" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-blue-600 hover:bg-blue-500 text-white shadow-2xs transition">
        <span>🩺</span>
        <span>Canje en Caja</span>
    </a>

    <a href="/v/{{ $slug }}/afiche" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 transition">
        <span>🖨️</span>
        <span>Afiche QR</span>
    </a>

    <a href="/v/{{ $slug }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 transition">
        <span>🌐</span>
        <span>Web Pacientes</span>
    </a>
</div>
