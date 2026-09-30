@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $logoUrl = $tenant?->branding['logo_url'] ?? null;
    $clinicName = $tenant?->name ?? 'Clínica Veterinaria';
    $primaryColor = $tenant?->branding['primary_color'] ?? '#0d9488';
    $city = $tenant?->branding['city'] ?? 'Portal Veterinario';
@endphp

<div class="flex items-center gap-2.5 overflow-hidden">
    @if(!empty($logoUrl))
        <img src="{{ $logoUrl }}" alt="{{ $clinicName }}" class="h-8 w-8 object-contain rounded-lg p-0.5 bg-white shadow-xs border border-slate-200 dark:border-slate-700 shrink-0" loading="lazy">
    @else
        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-black text-sm shadow-xs shrink-0" style="background-color: {{ $primaryColor }};">
            🐾
        </div>
    @endif
    <div class="flex flex-col min-w-0 leading-tight">
        <span class="text-sm font-black tracking-tight text-gray-900 dark:text-white truncate">
            {{ $clinicName }}
        </span>
        <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 truncate">
            {{ $city }}
        </span>
    </div>
</div>
