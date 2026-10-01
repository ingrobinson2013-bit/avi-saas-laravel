<x-filament-widgets::widget>
    <div class="w-full">
        <div class="flex items-center justify-between mb-2 px-1">
            <div class="flex items-center gap-2">
                <span class="text-amber-500 text-xs">⚡</span>
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Acciones Rápidas
                </h3>
            </div>
            <span class="text-[11px] font-semibold text-slate-400">
                Operación Diaria
            </span>
        </div>

        {{-- Grid forzado a 1 sola fila de 4 tarjetas en desktop --}}
        <div class="avi-operations-grid" style="display: grid !important; grid-template-columns: repeat(4, minmax(0, 1fr)) !important; gap: 0.75rem !important; width: 100% !important;">
            {{-- 1. HERO CTA: Canjear Beneficio (Destacado) --}}
            <a href="{{ $redeemUrl }}" 
               class="group relative overflow-hidden rounded-xl p-3 sm:p-3.5 flex flex-col justify-between h-[96px] min-w-0 shadow-xs hover:shadow-md transition-all transform hover:-translate-y-0.5 border border-blue-600/50 text-white"
               style="background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 55%, #0284c7 100%) !important;">
                <div class="flex items-center justify-between">
                    <div class="w-7 h-7 rounded-lg bg-white/20 backdrop-blur-xs flex items-center justify-center text-sm font-black border border-white/30 shrink-0">
                        ⚡
                    </div>
                    <span class="text-[9.5px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded-md bg-white/20 border border-white/30 backdrop-blur-xs">
                        Mostrador
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-black text-white leading-tight truncate">
                        Canjear Beneficio
                    </h4>
                    <p class="text-[11px] font-bold text-blue-100 flex items-center justify-between mt-0.5">
                        <span>Abrir terminal</span>
                        <span class="transform group-hover:translate-x-1 transition-transform font-black">→</span>
                    </p>
                </div>
            </a>

            {{-- 2. Afiliar Mascota --}}
            <a href="{{ $newSubUrl }}" 
               class="group rounded-xl p-3 sm:p-3.5 flex flex-col justify-between h-[96px] min-w-0 bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-2xs hover:border-emerald-500/60 hover:shadow-xs transition-all transform hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-sm font-black border border-emerald-200 dark:border-emerald-800 shrink-0">
                        🐾
                    </div>
                    <span class="text-[9.5px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/50 px-1.5 py-0.5 rounded-md border border-emerald-200 dark:border-emerald-900">
                        Membresía
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors leading-tight truncate">
                        Afiliar Mascota
                    </h4>
                    <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 flex items-center justify-between mt-0.5">
                        <span>Nueva afiliac.</span>
                        <span class="transform group-hover:translate-x-1 transition-transform font-black">→</span>
                    </p>
                </div>
            </a>

            {{-- 3. Ver Portal Público --}}
            <a href="{{ $publicUrl }}" target="_blank"
               class="group rounded-xl p-3 sm:p-3.5 flex flex-col justify-between h-[96px] min-w-0 bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-2xs hover:border-cyan-500/60 hover:shadow-xs transition-all transform hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div class="w-7 h-7 rounded-lg bg-cyan-50 dark:bg-cyan-950/60 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-sm font-black border border-cyan-200 dark:border-cyan-800 shrink-0">
                        🌐
                    </div>
                    <span class="text-[9.5px] font-bold text-cyan-600 dark:text-cyan-400 bg-cyan-50 dark:bg-cyan-950/50 px-1.5 py-0.5 rounded-md border border-cyan-200 dark:border-cyan-900">
                        Web B2C
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors leading-tight truncate">
                        Ver Portal
                    </h4>
                    <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 flex items-center justify-between mt-0.5">
                        <span>Abrir portal</span>
                        <span class="transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform font-black">↗</span>
                    </p>
                </div>
            </a>

            {{-- 4. Imprimir QR --}}
            <a href="{{ $flyerUrl }}" target="_blank"
               class="group rounded-xl p-3 sm:p-3.5 flex flex-col justify-between h-[96px] min-w-0 bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-2xs hover:border-indigo-500/60 hover:shadow-xs transition-all transform hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div class="w-7 h-7 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-sm font-black border border-indigo-200 dark:border-indigo-800 shrink-0">
                        🖨️
                    </div>
                    <span class="text-[9.5px] font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 px-1.5 py-0.5 rounded-md border border-indigo-200 dark:border-indigo-900">
                        Mostrador
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-tight truncate">
                        Imprimir QR
                    </h4>
                    <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 flex items-center justify-between mt-0.5">
                        <span>Generar PDF</span>
                        <span class="transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform font-black">↗</span>
                    </p>
                </div>
            </a>
        </div>
    </div>
</x-filament-widgets::widget>
