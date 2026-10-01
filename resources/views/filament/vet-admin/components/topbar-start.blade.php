@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $rawCity = $tenant?->branding['city'] ?? 'Sede Principal';
    $city = trim(explode(',', $rawCity)[0]);
@endphp

<div class="hidden md:flex items-center gap-2">
    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span>Sede Activa</span>
    </span>
    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">
        {{ $city }}
    </span>
</div>
