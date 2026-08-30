@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? \App\Models\Tenant::where('slug', 'vet-pet-patitas')->first() ?? \App\Models\Tenant::first();
    $logoUrl = $tenant?->branding['logo_url'] ?? null;
    $clinicName = $tenant?->name ?? 'Vet-Pet Patitas';
@endphp

<div class="flex items-center gap-2.5 overflow-hidden">
    @if(!empty($logoUrl))
        <img src="{{ $logoUrl }}" alt="{{ $clinicName }}" class="h-8 w-8 object-cover rounded-lg shadow-sm border border-teal-500/20 shrink-0" loading="lazy">
    @else
        <div class="w-8 h-8 rounded-lg bg-teal-600 flex items-center justify-center text-white font-bold text-sm shadow-sm shrink-0">
            🐾
        </div>
    @endif
    <div class="flex flex-col min-w-0 leading-tight">
        <span class="text-sm font-black tracking-tight text-gray-900 dark:text-white truncate">
            Vet-Pet <span class="text-teal-600 dark:text-teal-400">Patitas</span>
        </span>
        <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 truncate">
            Consultorio Veterinario
        </span>
    </div>
</div>
