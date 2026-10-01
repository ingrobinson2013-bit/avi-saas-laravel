<x-filament-widgets::widget>
    <div class="w-full space-y-3">
        {{-- ONBOARDING BANNER DE BIENVENIDA (Si la clínica está arrancando o tiene pocas mascotas) --}}
        @if($activeSubsCount < 3)
            <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-blue-900 to-indigo-950 text-white shadow-md border border-blue-800/80 relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 opacity-10 text-9xl pointer-events-none">🐾</div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1.5 max-w-2xl">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-blue-500/30 text-cyan-300 border border-blue-400/30">
                            🚀 Puesta en Marcha Rápida · Tu Clínica en Vivo
                        </div>
                        <h3 class="text-base sm:text-lg font-black tracking-tight text-white">
                            ¡Bienvenido(a) a tu Plataforma de Salud, {{ $clinicName }}!
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                            Ya dejamos tus primeros <strong>2 planes de salud creados</strong> y tu <strong>afiche con código QR generado</strong>. Sigue estos 3 pasos para recibir a tus primeros miembros:
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 shrink-0">
                        <a href="{{ $flyerUrl }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-black text-xs shadow-md transition transform hover:-translate-y-0.5">
                            <span>🖨️</span>
                            <span>Imprimir Afiche QR</span>
                        </a>
                        <a href="{{ $publicUrl }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 transition">
                            <span>🌐 Ver Mi Web</span>
                        </a>
                    </div>
                </div>

                {{-- Pasos Rápidos Visuales --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 mt-4 pt-3.5 border-t border-blue-800/60 text-xs">
                    <div class="flex items-center gap-2 bg-blue-950/60 p-2.5 rounded-xl border border-blue-800/50 text-slate-200">
                        <span class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 font-bold flex items-center justify-center text-xs shrink-0">✓</span>
                        <div class="leading-tight">
                            <strong class="block text-white">1. Planes creados</strong>
                            <span class="text-[11px] text-slate-400">Básico y Premium listos</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 bg-blue-950/60 p-2.5 rounded-xl border border-blue-800/50 text-slate-200">
                        <span class="w-6 h-6 rounded-lg bg-cyan-500/20 text-cyan-400 font-bold flex items-center justify-center text-xs shrink-0">2</span>
                        <div class="leading-tight">
                            <strong class="block text-white">2. Pega el Afiche</strong>
                            <span class="text-[11px] text-slate-400">En recepción o sala de espera</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 bg-blue-950/60 p-2.5 rounded-xl border border-blue-800/50 text-slate-200">
                        <span class="w-6 h-6 rounded-lg bg-blue-500/20 text-blue-400 font-bold flex items-center justify-center text-xs shrink-0">3</span>
                        <div class="leading-tight">
                            <strong class="block text-white">3. Primer Canje</strong>
                            <span class="text-[11px] text-slate-400">Valida en caja en 3 seg.</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- 4 TARJETAS OPERATIVAS DE ALTA DENSIDAD (Centro de Mando) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            {{-- 1. Mostrador de Canje --}}
            <a href="{{ $redeemUrl }}" class="group p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 hover:border-blue-500 dark:hover:border-blue-500 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform">
                        🩺
                    </div>
                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                        Recepción
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition-colors">
                        Canje en Caja
                    </h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2">
                        Valida el carnet digital o cédula y descuenta cupos en 3 segundos.
                    </p>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-blue-600 dark:text-cyan-400">
                    <span>Abrir Mostrador</span>
                    <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                </div>
            </a>

            {{-- 2. Afiche de Mostrador con QR --}}
            <a href="{{ $flyerUrl }}" target="_blank" class="group p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 hover:border-cyan-500 dark:hover:border-cyan-500 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform">
                        🖨️
                    </div>
                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-cyan-50 dark:bg-cyan-950 text-cyan-700 dark:text-cyan-300 border border-cyan-200 dark:border-cyan-800">
                        Imprimible
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                        Afiche Oficial QR
                    </h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2">
                        PDF de alta resolución con tu marca listo para tu mostrador.
                    </p>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-cyan-600 dark:text-cyan-400">
                    <span>Ver Afiche PDF</span>
                    <span class="transform group-hover:translate-x-1 transition-transform">↗</span>
                </div>
            </a>

            {{-- 3. Portal Web de Pacientes --}}
            <a href="{{ $publicUrl }}" target="_blank" class="group p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 hover:border-emerald-500 dark:hover:border-emerald-500 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform">
                        🌐
                    </div>
                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                        B2C Clientes
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                        Web de Pacientes
                    </h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-mono truncate">
                        {{ parse_url($publicUrl, PHP_URL_HOST) }}/v/{{ $slug }}
                    </p>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-emerald-600 dark:text-emerald-400">
                    <span>Visitar Web</span>
                    <span class="transform group-hover:translate-x-1 transition-transform">↗</span>
                </div>
            </a>

            {{-- 4. Planes de Salud --}}
            <a href="{{ $plansUrl }}" class="group p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 hover:border-indigo-500 dark:hover:border-indigo-500 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform">
                        📋
                    </div>
                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                        Catálogo
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        Planes & Beneficios
                    </h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2">
                        Configura cupos, servicios incluidos y tarifas mensuales.
                    </p>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-indigo-600 dark:text-indigo-400">
                    <span>Gestionar Planes</span>
                    <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                </div>
            </a>
        </div>
    </div>
</x-filament-widgets::widget>
