@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $logoUrl = $tenant?->branding['logo_url'] ?? null;
    $clinicName = $tenant?->name ?? 'Clínica Veterinaria';
    $city = $tenant?->branding['city'] ?? 'Sede Principal';
@endphp

<div class="flex items-center gap-3 overflow-hidden py-1">
    @if(!empty($logoUrl))
        <img src="{{ $logoUrl }}" alt="{{ $clinicName }}" class="h-9 w-9 object-contain rounded-xl p-1 bg-white shadow-xs border border-slate-200 dark:border-slate-700 shrink-0" loading="lazy">
    @else
        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-black text-base shadow-xs shrink-0 bg-gradient-to-br from-blue-600 to-cyan-600">
            🐾
        </div>
    @endif
    <div class="flex flex-col min-w-0 leading-snug">
        <span class="text-sm font-extrabold tracking-tight text-slate-900 dark:text-white truncate">
            {{ $clinicName }}
        </span>
        <span class="text-[10px] font-semibold text-blue-600 dark:text-cyan-400 truncate uppercase tracking-wider">
            {{ $city }} · AVI-Plan
        </span>
    </div>
</div>
