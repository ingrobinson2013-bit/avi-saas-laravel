@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $slug = $tenant?->slug ?? 'vet-pet-patitas';
@endphp

<div class="flex items-center gap-2.5">
    <a href="/admin/{{ $slug }}/counter-redeem" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-xs transition transform hover:-translate-y-0.5 shrink-0 whitespace-nowrap">
        <span>🩺</span>
        <span>Canjear en Caja</span>
    </a>

    <a href="/v/{{ $slug }}/afiche" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs border border-slate-200 dark:border-slate-700 shadow-2xs transition shrink-0 whitespace-nowrap">
        <span>🖨️</span>
        <span>Afiche QR</span>
    </a>
</div>
