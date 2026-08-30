@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? \App\Models\Tenant::where('slug', 'vet-pet-patitas')->first() ?? \App\Models\Tenant::first();
    $logoUrl = $tenant?->branding['logo_url'] ?? null;
    $clinicName = $tenant?->name ?? 'Vet-Pet Patitas';
    $city = $tenant?->branding['city'] ?? 'Cajicá, Cundinamarca';
@endphp

<div class="flex items-center space-x-3 py-1">
    @if(!empty($logoUrl))
        <img src="{{ $logoUrl }}" alt="{{ $clinicName }}" class="h-9 w-auto max-w-[130px] object-contain rounded-lg shadow-sm border border-slate-700/50 bg-slate-800/40 p-0.5" loading="lazy">
    @else
        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-teal-600 via-teal-500 to-emerald-500 flex items-center justify-center text-white font-black text-lg shadow-md border border-teal-400/30 shrink-0">
            🐾
        </div>
    @endif
    <div class="flex flex-col min-w-0">
        <span class="text-sm font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight truncate">
            {{ $clinicName }}
        </span>
        <span class="text-[10px] font-semibold text-teal-600 dark:text-teal-400 truncate">
            Consultorio Veterinario • {{ $city }}
        </span>
    </div>
</div>
