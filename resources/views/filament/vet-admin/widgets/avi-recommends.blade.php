<x-filament-widgets::widget>
    <div class="w-full">
        <div class="relative overflow-hidden rounded-2xl p-5 sm:p-6 bg-white dark:bg-slate-900 border-2 border-indigo-500/20 dark:border-indigo-500/30 shadow-sm">
            {{-- Fondo de brillo tecnológico sutil --}}
            <div class="absolute -right-16 -top-16 w-56 h-56 bg-gradient-to-br from-indigo-500/10 via-blue-500/10 to-transparent rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                {{-- Encabezado de la tarjeta: Título + Badge + Indicador de Impacto --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mb-3.5 pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-600 to-blue-600 text-white flex items-center justify-center text-base shadow-xs shrink-0">
                            🤖
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-xs font-black uppercase tracking-wider text-indigo-700 dark:text-indigo-400">
                                AVI Recomienda
                            </h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10.5px] font-black uppercase tracking-wider
                                {{ ($recommendation['badge_color'] ?? 'blue') === 'blue' ? 'bg-blue-50 text-blue-700 dark:bg-blue-950/80 dark:text-blue-300 border border-blue-200 dark:border-blue-800' : '' }}
                                {{ ($recommendation['badge_color'] ?? 'blue') === 'amber' ? 'bg-amber-50 text-amber-700 dark:bg-amber-950/80 dark:text-amber-300 border border-amber-200 dark:border-amber-800' : '' }}
                                {{ ($recommendation['badge_color'] ?? 'blue') === 'emerald' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : '' }}
                                {{ ($recommendation['badge_color'] ?? 'blue') === 'indigo' ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/80 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800' : '' }}
                            ">
                                {{ $recommendation['badge'] ?? 'Oportunidad de Fidelización' }}
                            </span>
                        </div>
                    </div>

                    {{-- Indicador de Impacto --}}
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800 text-[11px] font-bold text-indigo-700 dark:text-indigo-300">
                        <span>💡</span>
                        <span>Impacto:</span>
                        <strong class="font-black text-indigo-900 dark:text-white">{{ $recommendation['impact_text'] ?? '1 oportunidad' }}</strong>
                    </div>
                </div>

                {{-- Recomendación Inteligente Directa y Personalizada --}}
                <div class="mb-4">
                    <p class="text-base sm:text-lg font-black text-slate-900 dark:text-white leading-snug">
                        “{{ $recommendation['title'] ?? 'Monitoreamos a tus pacientes para impulsar la retención de tus planes.' }}”
                    </p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                        El uso continuo de beneficios clínicos reduce la tasa de cancelación en un 68% y mantiene al tutor comprometido con la salud de su mascota.
                    </p>
                </div>

                {{-- Acciones Sugeridas Inmediatas --}}
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3">
                    <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                        Acción sugerida:
                    </span>

                    <div class="flex items-center gap-2.5 flex-wrap">
                        @if(!empty($recommendation['whatsapp_url']))
                            <a href="{{ $recommendation['whatsapp_url'] }}" 
                               target="_blank"
                               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-xs transition transform hover:-translate-y-0.5">
                                <span class="text-sm">💬</span>
                                <span>Enviar WhatsApp</span>
                            </a>
                        @endif

                        @if(!empty($recommendation['pet_url']))
                            <a href="{{ $recommendation['pet_url'] }}" 
                               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs border border-slate-200 dark:border-slate-700 transition">
                                <span>🐾</span>
                                <span>{{ $recommendation['pet_label'] ?? 'Ver Paciente' }}</span>
                            </a>
                        @endif

                        <a href="/admin/{{ $slug }}/counter-redeem"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-100 dark:hover:bg-blue-900 text-blue-700 dark:text-blue-300 font-bold text-xs border border-blue-200 dark:border-blue-800 transition">
                            <span>⚡</span>
                            <span>Canje en Recepción</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
