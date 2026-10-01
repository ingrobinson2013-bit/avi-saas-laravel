@php
    $tenant = \Filament\Facades\Filament::getTenant();
    $slug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
    $status = $tenant?->saas_status ?? 'trial_active';
    $daysRemaining = max(0, $tenant?->trial_days_remaining ?? 14);
@endphp

<div class="px-3 py-2 border-t border-slate-200/60 dark:border-slate-800/80 mt-auto">
    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/70 dark:border-slate-700/60 space-y-2">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                Plan AVI-SaaS
            </span>
            @if($status === 'paid')
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300">
                    ⭐ Activo
                </span>
            @elseif($status === 'trial_active')
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300">
                    ⏳ {{ $daysRemaining }}d prueba
                </span>
            @else
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-300">
                    ⚠️ Vencido
                </span>
            @endif
        </div>

        <a href="/admin/{{ $slug }}/renovar-saas" 
           class="w-full flex items-center justify-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-bold text-white bg-gradient-to-r from-blue-600 to-teal-600 hover:from-blue-700 hover:to-teal-700 shadow-sm transition-all text-center">
            <span>💳</span>
            <span>{{ $status === 'paid' ? 'Gestionar Plan' : 'Pagar con Bold' }}</span>
        </a>
    </div>
</div>
