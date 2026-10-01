<x-filament-widgets::widget>
    <div class="w-full">
        <div class="relative overflow-hidden rounded-2xl p-5 bg-white dark:bg-slate-900 border border-indigo-200/80 dark:border-indigo-900/60 shadow-xs">
            {{-- Fondo con brillo sutil tecnológico --}}
            <div class="absolute -right-12 -top-12 w-48 h-48 bg-gradient-to-br from-indigo-500/10 via-purple-500/10 to-transparent rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                {{-- Bloque Izquierdo: Icono + Título + Recomendación --}}
                <div class="flex items-start gap-3.5 min-w-0 flex-1">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 text-white flex items-center justify-center text-xl shrink-0 shadow-sm shadow-indigo-500/20">
                        🤖
                    </div>

                    <div class="min-w-0 flex-1 space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-black uppercase tracking-wider text-indigo-700 dark:text-indigo-400">
                                AVI Recomienda
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider
                                {{ ($recommendation['badge_color'] ?? 'indigo') === 'amber' ? 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300' : '' }}
                                {{ ($recommendation['badge_color'] ?? 'indigo') === 'blue' ? 'bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300' : '' }}
                                {{ ($recommendation['badge_color'] ?? 'indigo') === 'emerald' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : '' }}
                                {{ ($recommendation['badge_color'] ?? 'indigo') === 'indigo' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-950 dark:text-indigo-300' : '' }}
                            ">
                                {{ $recommendation['badge'] ?? 'Copiloto IA' }}
                            </span>
                        </div>

                        <h4 class="text-sm sm:text-base font-black text-slate-900 dark:text-white leading-snug">
                            “{{ $recommendation['title'] ?? 'Optimiza tu programa de salud continua' }}”
                        </h4>

                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed max-w-3xl">
                            {{ $recommendation['description'] ?? 'Monitoreamos tus pacientes en tiempo real para sugerirte acciones de retención e ingresos.' }}
                        </p>
                    </div>
                </div>

                {{-- Bloque Derecho: Botón de Acción Nítido --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ $recommendation['action_url'] ?? '#' }}" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-sm transition transform hover:-translate-y-0.5 whitespace-nowrap">
                        <span>{{ $recommendation['action_label'] ?? 'Ver Oportunidades' }}</span>
                        <span>→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
