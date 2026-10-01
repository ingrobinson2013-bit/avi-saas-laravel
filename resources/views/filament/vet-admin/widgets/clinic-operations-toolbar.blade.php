<x-filament-widgets::widget>
    <div class="w-full">
        <div class="flex items-center justify-between mb-2.5 px-1">
            <div class="flex items-center gap-2">
                <span class="text-amber-500 text-sm">⚡</span>
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 dark:text-slate-200">
                    Acciones de Hoy
                </h3>
            </div>
            <span class="text-[11px] font-bold text-slate-400">
                Flujo Operativo en Mostrador
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
            {{-- 1. CTA HERO: Canjear Beneficio --}}
            <a href="{{ $redeemUrl }}" 
               class="group relative overflow-hidden rounded-2xl p-4 flex flex-col justify-between shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 border border-blue-500/40 text-white"
               style="background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #0284c7 100%) !important;">
                <div class="absolute -right-6 -bottom-6 opacity-15 text-8xl pointer-events-none select-none">🧾</div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-xs text-white flex items-center justify-center text-xl shrink-0 border border-white/30 group-hover:scale-110 transition-transform">
                            🧾
                        </div>
                        <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full bg-white/20 text-white border border-white/30 backdrop-blur-xs">
                            Recepción · 3 seg
                        </span>
                    </div>
                    <h4 class="text-base font-black text-white leading-tight">
                        Canjear Beneficio
                    </h4>
                    <p class="text-xs text-blue-100 mt-1 font-medium leading-relaxed">
                        Escanea código QR o busca paciente por cédula o nombre.
                    </p>
                </div>
                <div class="relative z-10 mt-4 pt-2.5 border-t border-white/20 flex items-center justify-between text-xs font-black text-white">
                    <span>Abrir Terminal</span>
                    <span class="transform group-hover:translate-x-1.5 transition-transform">→</span>
                </div>
            </a>

            {{-- 2. ACCIÓN: Afiliar Mascota --}}
            <a href="{{ $newSubUrl }}" 
               class="group rounded-2xl p-4 flex flex-col justify-between bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-emerald-500/60 hover:shadow-md transition-all transform hover:-translate-y-0.5">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl shrink-0 border border-emerald-200 dark:border-emerald-800 group-hover:scale-110 transition-transform">
                            👤
                        </div>
                        <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            + Membresía
                        </span>
                    </div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors leading-tight">
                        Afiliar Mascota
                    </h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                        Crea una nueva membresía y asigna tutor en 1 minuto.
                    </p>
                </div>
                <div class="mt-4 pt-2.5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-emerald-600 dark:text-emerald-400">
                    <span>Nueva Afiliación</span>
                    <span class="transform group-hover:translate-x-1.5 transition-transform">→</span>
                </div>
            </a>

            {{-- 3. ACCIÓN: Ver Portal Pacientes --}}
            <a href="{{ $publicUrl }}" target="_blank"
               class="group rounded-2xl p-4 flex flex-col justify-between bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-cyan-500/60 hover:shadow-md transition-all transform hover:-translate-y-0.5">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-xl shrink-0 border border-cyan-200 dark:border-cyan-800 group-hover:scale-110 transition-transform">
                            📱
                        </div>
                        <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full bg-cyan-50 dark:bg-cyan-950 text-cyan-700 dark:text-cyan-300 border border-cyan-200 dark:border-cyan-800">
                            Público B2C
                        </span>
                    </div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors leading-tight">
                        Ver Portal
                    </h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                        Abre tu página pública para que clientes se afilien en línea.
                    </p>
                </div>
                <div class="mt-4 pt-2.5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-cyan-600 dark:text-cyan-400">
                    <span>Abrir Portal Web</span>
                    <span class="transform group-hover:translate-x-1.5 transition-transform">↗</span>
                </div>
            </a>

            {{-- 4. ACCIÓN: Imprimir QR Afiche --}}
            <a href="{{ $flyerUrl }}" target="_blank"
               class="group rounded-2xl p-4 flex flex-col justify-between bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-indigo-500/60 hover:shadow-md transition-all transform hover:-translate-y-0.5">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl shrink-0 border border-indigo-200 dark:border-indigo-800 group-hover:scale-110 transition-transform">
                            🖨️
                        </div>
                        <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                            Imprimible
                        </span>
                    </div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-tight">
                        Imprimir QR
                    </h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                        Afiche PDF listo en alta resolución para colocar en mostrador.
                    </p>
                </div>
                <div class="mt-4 pt-2.5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-indigo-600 dark:text-indigo-400">
                    <span>Generar Afiche PDF</span>
                    <span class="transform group-hover:translate-x-1.5 transition-transform">↗</span>
                </div>
            </a>
        </div>
    </div>
</x-filament-widgets::widget>
