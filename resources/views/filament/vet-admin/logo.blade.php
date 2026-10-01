@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $logoUrl = $tenant?->branding['logo_url'] ?? null;
    $fullName = $tenant?->name ?? 'Clínica Veterinaria';
    $rawCity = $tenant?->branding['city'] ?? 'Sede Principal';
    $cleanCity = trim(explode(',', $rawCity)[0]);
@endphp

<div class="flex items-center gap-3 py-1.5 w-full">
    @if(!empty($logoUrl))
        <div class="w-10 h-10 rounded-xl p-1 bg-white shadow-xs border border-slate-200 dark:border-slate-700 shrink-0 flex items-center justify-center overflow-hidden">
            <img src="{{ $logoUrl }}" alt="{{ $fullName }}" class="w-full h-full object-contain" loading="lazy">
        </div>
    @else
        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-xs shrink-0 bg-gradient-to-br from-blue-600 to-cyan-600">
            🐾
        </div>
    @endif
    <div class="flex flex-col min-w-0">
        <span class="text-sm font-black text-slate-900 dark:text-white truncate leading-tight tracking-tight">
            {{ $fullName }}
        </span>
        <span class="text-[11px] font-bold text-blue-600 dark:text-cyan-400 truncate tracking-wide mt-0.5">
            {{ $cleanCity }} · Salud Veterinaria
        </span>
    </div>
</div>
