@php
    $tenant = \Filament\Facades\Filament::getTenant();
    $slug = $tenant?->slug ?? session('current_tenant_slug') ?? 'vet-pet-patitas';
    $status = $tenant?->saas_status ?? 'trial_active';
    $daysRemaining = max(0, $tenant?->trial_days_remaining ?? 14);
@endphp

<div class="px-3 py-3 border-t border-gray-200 dark:border-gray-800 mt-auto">
    <div class="p-3 rounded-xl bg-gray-50 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 flex flex-col gap-2.5 shadow-sm">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                Plan AVI-Plan
            </span>
            @if($status === 'paid')
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/80 dark:text-emerald-200">
                    ⭐ Activo
                </span>
            @elseif($status === 'trial_active')
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/80 dark:text-blue-200">
                    ⏳ {{ $daysRemaining }}d prueba
                </span>
            @else
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/80 dark:text-amber-200">
                    ⚠️ Vencido
                </span>
            @endif
        </div>

        <x-filament::button
            tag="a"
            href="/admin/{{ $slug }}/renovar-saas"
            color="primary"
            size="sm"
            icon="heroicon-o-credit-card"
            class="w-full font-bold shadow-sm"
        >
            {{ $status === 'paid' ? 'Gestionar Plan' : 'Pagar con Bold' }}
        </x-filament::button>
    </div>
</div>
