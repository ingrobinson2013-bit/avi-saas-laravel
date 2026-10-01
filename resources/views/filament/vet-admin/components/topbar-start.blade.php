@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $clinicName = $tenant?->name ?? 'Clínica Veterinaria';
    $rawCity = $tenant?->branding['city'] ?? 'Sede Principal';
    $city = trim(explode(',', $rawCity)[0]);
@endphp

<div class="hidden md:flex items-center gap-2.5 ml-1">
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 shadow-2xs">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span>Sede Activa</span>
    </span>
    <span class="text-xs font-black text-slate-800 dark:text-slate-200">
        {{ $clinicName }}
    </span>
    <span class="text-slate-300 dark:text-slate-600 text-xs">•</span>
    <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">
        {{ $city }}
    </span>
</div>
