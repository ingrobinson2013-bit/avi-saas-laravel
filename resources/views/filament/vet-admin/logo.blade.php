@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $logoUrl = $tenant?->branding['logo_url'] ?? null;
    $clinicName = $tenant?->name ?? 'Clínica Veterinaria';
    $rawCity = $tenant?->branding['city'] ?? 'Sede Principal';
    $cleanCity = trim(explode(',', $rawCity)[0]);
@endphp

<div class="flex items-center gap-2.5 overflow-hidden py-1 max-w-full">
    @if(!empty($logoUrl))
        <div class="w-10 h-10 rounded-xl p-0.5 bg-white shadow-xs border border-slate-200 dark:border-slate-700 shrink-0 flex items-center justify-center overflow-hidden">
            <img src="{{ $logoUrl }}" alt="{{ $clinicName }}" class="w-full h-full object-contain" loading="lazy">
        </div>
    @else
        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-black text-base shadow-xs shrink-0 bg-gradient-to-br from-blue-600 to-cyan-600">
            🐾
        </div>
    @endif
    <div class="flex flex-col min-w-0 leading-tight">
        <span class="text-xs sm:text-[13px] font-extrabold text-slate-900 dark:text-white line-clamp-2 leading-tight">
            {{ $clinicName }}
        </span>
        <span class="text-[10px] font-bold text-blue-600 dark:text-cyan-400 uppercase tracking-wider mt-0.5">
            {{ $cleanCity }} · AVI-Plan
        </span>
    </div>
</div>
