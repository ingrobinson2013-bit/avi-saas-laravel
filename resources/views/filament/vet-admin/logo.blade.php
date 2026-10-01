@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $logoUrl = $tenant?->branding['logo_url'] ?? null;
    $fullName = $tenant?->name ?? 'PetSalud+';
    
    // Check if PetSalud+ or custom
    $isPetSalud = str_contains(mb_strtolower($fullName), 'petsalud') || str_contains(mb_strtolower($fullName), 'patitas') || empty($logoUrl);
    $brandTitle = $isPetSalud ? 'PetSalud+' : $fullName;
    $brandSubtitle = $isPetSalud ? 'Planes de salud para su mascota' : 'Planes de salud para su mascota';
@endphp

<div class="flex items-center gap-2.5 py-1 w-full min-w-0">
    <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-black text-lg shadow-sm shrink-0 bg-gradient-to-tr from-blue-600 via-sky-500 to-cyan-400">
        🐾
    </div>
    <div class="flex flex-col min-w-0 flex-1 justify-center">
        <span class="text-sm font-black text-slate-900 dark:text-white leading-tight tracking-tight truncate block">
            {{ $brandTitle }}
        </span>
        <span class="text-[10px] font-medium text-slate-500 dark:text-slate-400 truncate block">
            {{ $brandSubtitle }}
        </span>
    </div>
</div>
