@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $rawCity = $tenant?->branding['city'] ?? 'Sede Principal';
    $city = trim(explode(',', $rawCity)[0]);
    $slug = $tenant?->slug ?? 'vet-pet-patitas';
@endphp

<div class="flex items-center gap-3">
    <div class="hidden md:flex items-center gap-2">
        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Sede Activa</span>
        </span>
        <span class="text-xs font-bold text-slate-500 dark:text-slate-400">
            {{ $city }}
        </span>
    </div>

    {{-- Search pill matching mockup center topbar --}}
    <div class="hidden lg:flex items-center relative w-64 xl:w-80 ml-2">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs">
            🔍
        </div>
        <form action="/admin/{{ $slug }}/pets" method="GET" class="w-full">
            <input type="text" 
                   name="tableSearch" 
                   placeholder="Buscar cliente, mascota o plan..." 
                   class="w-full pl-8 pr-3 py-1.5 text-xs rounded-full border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 focus:outline-hidden focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition shadow-2xs placeholder:text-slate-400" />
        </form>
    </div>
</div>
