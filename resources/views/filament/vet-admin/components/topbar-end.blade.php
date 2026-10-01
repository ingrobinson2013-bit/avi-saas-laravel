@php
    $tenant = \Filament\Facades\Filament::getTenant() ?? auth()->user()?->tenant ?? \App\Models\Tenant::first();
    $slug = $tenant?->slug ?? 'vet-pet-patitas';
    $branding = $tenant?->branding ?? [];
    $status = $tenant?->saas_status ?? $branding['saas_status'] ?? 'trial_active';
    $tier = $tenant?->saas_plan_tier ?? $branding['saas_plan'] ?? 'pro';
@endphp

<div class="flex items-center gap-2 mr-2">
    @if($status === 'paid')
        <span class="hidden lg:inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
            <span>🏆</span>
            <span>{{ ucfirst($tier) }}</span>
        </span>
    @elseif($status === 'trial_active')
        <span class="hidden lg:inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
            <span>⏳</span>
            <span>Prueba 15D</span>
        </span>
    @endif

    <a href="/admin/{{ $slug }}/counter-redeem" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-xs transition transform hover:-translate-y-0.5">
        <span>🩺</span>
        <span>Canje en Caja</span>
    </a>

    <a href="/v/{{ $slug }}/afiche" target="_blank" class="hidden sm:inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs border border-slate-200 dark:border-slate-700 transition">
        <span>🖨️</span>
        <span>Afiche</span>
    </a>
</div>
