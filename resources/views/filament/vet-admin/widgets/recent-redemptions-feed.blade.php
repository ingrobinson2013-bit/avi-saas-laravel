<x-filament-widgets::widget>
    <div class="w-full">
        {{-- Barra visual de uso de beneficios clínicos (Punto 3 de Robinson) --}}
        <div class="mb-3.5 p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-2xs">
            <div class="flex items-center justify-between text-xs font-bold mb-1.5">
                <div class="flex items-center gap-1.5 text-slate-700 dark:text-slate-300">
                    <span class="text-blue-500">📊</span>
                    <span class="font-extrabold text-slate-900 dark:text-white">Uso de Beneficios Clínicos</span>
                </div>
                <span class="font-black text-blue-600 dark:text-cyan-400">
                    {{ $totalUsed }} / {{ $totalGranted }} utilizados ({{ $percent }}%)
                </span>
            </div>
            <div class="w-full h-2 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden border border-slate-200/60 dark:border-slate-700/60">
                <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 transition-all duration-500" 
                     style="width: {{ $percent > 0 ? max(4, $percent) : 0 }}%"></div>
            </div>
            <div class="flex items-center justify-between text-[11px] font-semibold text-slate-400 mt-1.5">
                <span>Servicios canjeados este ciclo</span>
                <span>Meta clínica: > 70%</span>
            </div>
        </div>

        {{ $this->table }}
    </div>
</x-filament-widgets::widget>
