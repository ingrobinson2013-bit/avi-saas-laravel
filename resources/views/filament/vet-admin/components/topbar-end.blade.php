@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $branding = $tenant?->branding ?? [];
    $status = $tenant?->saas_status ?? $branding['saas_status'] ?? 'trial_active';
    $tier = $tenant?->saas_plan_tier ?? $branding['saas_plan'] ?? 'pro';
@endphp

<div class="flex items-center gap-2 mr-2">
    @if($status === 'paid')
        <span class="hidden md:inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-extrabold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
            <span>🏆</span>
            <span>Plan {{ ucfirst($tier) }} Activo</span>
        </span>
    @elseif($status === 'trial_active')
        <span class="hidden md:inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-extrabold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
            <span>⏳</span>
            <span>Prueba 15 Días</span>
        </span>
    @endif

    <a href="https://wa.me/573235813942?text={{ urlencode('Hola equipo AVI-Plan, requiero soporte para mi clínica ' . ($tenant?->name ?? '')) }}" target="_blank" class="hidden sm:inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
        <span>💬</span>
        <span>Soporte</span>
    </a>
</div>
