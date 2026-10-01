<x-filament-panels::page>
    @php
        $tenant = \Filament\Facades\Filament::getTenant();
        $slug = $tenant?->slug ?? 'vet-pet-patitas';
    @endphp

    <div class="space-y-6">
        {{-- Banner Superior: Filosofía de IA Accionable --}}
        <div class="p-6 rounded-2xl bg-gradient-to-r from-indigo-900 via-blue-900 to-slate-900 text-white shadow-md border border-indigo-700/40 relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-48 h-48 bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-black uppercase tracking-wider text-indigo-200 mb-2">
                        <span>🤖</span>
                        <span>Motor de Fidelización Predictivo</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-white">
                        AVI Intelligence · Crece y Retén Clientes
                    </h2>
                    <p class="text-sm text-indigo-100 max-w-2xl mt-1">
                        Detectamos patrones de abandono temprano y te entregamos la acción exacta para contactar al tutor con un mensaje personalizado de WhatsApp listo para enviar.
                    </p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <div class="p-3 rounded-xl bg-white/10 border border-white/20 text-center">
                        <span class="block text-2xl font-black text-white">{{ $totalOpportunitiesCount }}</span>
                        <span class="text-[11px] font-bold text-indigo-200 uppercase">Oportunidades</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECCIÓN 1: PACIENTES INACTIVOS CON BENEFICIOS DISPONIBLES --}}
        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 sm:p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <span class="text-xl">🐾</span>
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">
                            Tutores con Beneficios Sin Utilizar (> 60 días)
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Invita a estos tutores a su clínica. El 84% responde positivamente cuando se les recuerda que tienen consultas o baños prepagados disponibles.
                        </p>
                    </div>
                </div>
                <span class="text-xs font-black px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                    {{ $totalOpportunitiesCount }} detectados
                </span>
            </div>

            @if($inactiveOpportunities->isEmpty())
                <div class="py-12 text-center">
                    <div class="w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl mx-auto mb-2">
                        ✓
                    </div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">¡Excelente retención clínica!</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                        Todos tus pacientes afiliados han utilizado sus beneficios en los últimos 60 días.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($inactiveOpportunities as $opp)
                        @php
                            $pet = $opp->pet;
                            $customer = $pet?->customer;
                            $firstName = explode(' ', trim($customer?->name ?? 'Tutor'))[0];
                            $petName = $pet?->name ?? 'la mascota';
                            $phone = preg_replace('/[^0-9]/', '', $customer?->phone ?? '');
                            $availCount = (int) $opp->benefitBalances->where('remaining', '>', 0)->sum('remaining');
                            $firstBenefit = $opp->benefitBalances->where('remaining', '>', 0)->first()?->benefitDefinition?->name ?? 'Consulta preventiva';
                            
                            $msg = "🐾 Hola {$firstName}, te saludamos de la clínica veterinaria. Queríamos recordarte que {$petName} tiene {$availCount} beneficios disponibles en su {$opp->plan?->name} (como {$firstBenefit}) y hace más de 60 días no nos visita. ¿Te gustaría agendar su chequeo esta semana?";
                            $waUrl = !empty($phone) ? "https://wa.me/{$phone}?text=" . urlencode($msg) : null;
                        @endphp

                        <div class="p-4 rounded-xl border border-slate-200/90 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-850 flex flex-col justify-between hover:border-blue-500/50 transition">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="inline-flex items-center gap-1.5 font-black text-sm text-slate-900 dark:text-white">
                                        <span>{{ $pet?->species === 'cat' ? '🐱' : '🐶' }}</span>
                                        <span>{{ $petName }}</span>
                                    </span>
                                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300">
                                        {{ $opp->plan?->name ?? 'Plan Activo' }}
                                    </span>
                                </div>

                                <p class="text-xs text-slate-600 dark:text-slate-300 font-medium">
                                    Tutor: <strong class="text-slate-900 dark:text-white">{{ $customer?->name ?? 'Sin tutor' }}</strong>
                                    @if($customer?->phone)
                                        · <span class="text-slate-500 font-mono">{{ $customer->phone }}</span>
                                    @endif
                                </p>

                                <div class="mt-2.5 p-2 rounded-lg bg-blue-50/70 dark:bg-blue-950/40 border border-blue-200/60 dark:border-blue-900/60 text-xs">
                                    <span class="font-bold text-blue-900 dark:text-blue-200">
                                        🎁 {{ $availCount }} beneficios disponibles
                                    </span>
                                    <span class="text-blue-700 dark:text-blue-300 block text-[11px] mt-0.5">
                                        Ej: {{ $firstBenefit }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-200/60 dark:border-slate-750 flex items-center justify-between gap-2">
                                <a href="/admin/{{ $slug }}/pets/{{ $pet?->id }}/edit" 
                                   class="text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400">
                                    Ver Ficha Mascota →
                                </a>

                                @if($waUrl)
                                    <a href="{{ $waUrl }}" 
                                       target="_blank" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-2xs transition">
                                        <span>💬</span>
                                        <span>Enviar WhatsApp</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- SECCIÓN 2: RENOVACIONES PRÓXIMAS EN RIESGO --}}
        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 sm:p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <span class="text-xl">🔔</span>
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">
                            Membresías por Renovar (< 15 días)
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Asegura la renovación antes del vencimiento para proteger tu ingreso recurrente mensual.
                        </p>
                    </div>
                </div>
                <span class="text-xs font-black px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                    ${{ number_format($estimatedRecoverableMrr, 0, ',', '.') }} COP en riesgo
                </span>
            </div>

            @if($expiringSubscriptions->isEmpty())
                <div class="py-8 text-center">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        No hay membresías por vencer en los próximos 15 días. Siguiente revisión automática: mañana 08:00.
                    </p>
                </div>
            @else
                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($expiringSubscriptions as $sub)
                        @php
                            $pet = $sub->pet;
                            $customer = $pet?->customer;
                            $firstName = explode(' ', trim($customer?->name ?? 'Tutor'))[0];
                            $petName = $pet?->name ?? 'tu mascota';
                            $phone = preg_replace('/[^0-9]/', '', $customer?->phone ?? '');
                            $date = $sub->current_period_end?->format('d/m/Y');
                            $msg = "🐾 Hola {$firstName}, te saludamos de la clínica veterinaria. El plan de bienestar {$sub->plan?->name} de {$petName} finaliza su ciclo el {$date}. ¿Deseas renovar su cobertura para mantener sus beneficios?";
                            $waUrl = !empty($phone) ? "https://wa.me/{$phone}?text=" . urlencode($msg) : null;
                        @endphp
                        <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <span class="font-bold text-sm text-slate-900 dark:text-white">
                                    {{ $pet?->species === 'cat' ? '🐱' : '🐶' }} {{ $petName }} · {{ $customer?->name }}
                                </span>
                                <span class="block text-xs text-slate-500">
                                    Plan: {{ $sub->plan?->name }} (${{ number_format($sub->plan?->price_cop ?? 0, 0, ',', '.') }} COP) · Vence: <strong>{{ $date }}</strong>
                                </span>
                            </div>
                            @if($waUrl)
                                <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-2xs transition self-start sm:self-auto">
                                    <span>💬</span>
                                    <span>Contactar Renovación</span>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-filament-panels::page>
