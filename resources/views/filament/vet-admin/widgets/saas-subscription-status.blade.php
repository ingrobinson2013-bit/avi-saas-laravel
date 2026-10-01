<x-filament-widgets::widget>
    <div class="space-y-4">
        {{-- Mensaje de éxito si acaba de pagar --}}
        @if($isJustPaid)
            <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-900 dark:text-emerald-100 flex items-center justify-between shadow-sm animate-pulse">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xl shadow-md">
                        🎉
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">¡Pago Exitoso con Bold!</h4>
                        <p class="text-xs text-emerald-700 dark:text-emerald-300">Tu suscripción a AVI-Plan SaaS ha sido activada y tu período de servicio está 100% al día.</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">
                    {{ $planName }} Activo
                </span>
            </div>
        @endif

        {{-- Tarjeta Principal de Estado de Cuenta --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm transition-all hover:shadow-md">
            {{-- Barra de gradiente superior --}}
            @if($status === 'paid')
                <div class="h-1.5 w-full bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500"></div>
            @elseif($status === 'trial_active')
                <div class="h-1.5 w-full bg-gradient-to-r from-blue-500 via-indigo-500 to-teal-500"></div>
            @else
                <div class="h-1.5 w-full bg-gradient-to-r from-amber-500 via-rose-500 to-red-600"></div>
            @endif

            <div class="p-5 sm:p-6 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6">
                {{-- Lado Izquierdo: Información y Estado --}}
                <div class="flex items-start gap-4 flex-1">
                    <div class="flex-shrink-0 w-12 h-12 rounded-2xl flex items-center justify-center text-2xl shadow-sm
                        {{ $status === 'paid' ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 border border-emerald-200' : ($status === 'trial_active' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-600 border border-blue-200' : 'bg-amber-100 dark:bg-amber-900/50 text-amber-600 border border-amber-200') }}">
                        @if($status === 'paid')
                            ⭐
                        @elseif($status === 'trial_active')
                            ⏳
                        @else
                            ⚠️
                        @endif
                    </div>

                    <div class="space-y-1.5 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Licencia AVI-Plan SaaS
                            </span>
                            
                            @if($status === 'paid')
                                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300 border border-emerald-300">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    {{ $planName }} (Al Día)
                                </span>
                            @elseif($status === 'trial_active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-black bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300 border border-blue-300">
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                    Prueba Gratuita ({{ $daysRemaining }} días restantes)
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-black bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-300 border border-amber-300">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    Período de Prueba Vencido
                                </span>
                            @endif

                            <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">
                                • {{ $tenantName }}
                            </span>
                        </div>

                        <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">
                            @if($status === 'paid')
                                Tu clínica tiene acceso total al {{ $planName }}
                            @elseif($status === 'trial_active')
                                Estás disfrutando del período de prueba gratuito de 15 días
                            @else
                                Activa tu suscripción para continuar operando sin interrupciones
                            @endif
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-3xl leading-relaxed">
                            @if($status === 'paid')
                                Próxima fecha de renovación: <strong class="text-slate-900 dark:text-slate-100">{{ $paidUntilFormatted ?: 'En 30 días' }}</strong>. Canon acordado: <strong class="text-teal-700 dark:text-teal-400 font-bold">${{ number_format($amountCop, 0, ',', '.') }} COP/mes</strong>. Incluye pasarela Bold, portal de clientes y carnets digitales ilimitados.
                            @elseif($status === 'trial_active')
                                Tu prueba vence el <strong class="text-slate-900 dark:text-slate-100">{{ $trialEndsAtFormatted ?: 'próximamente' }}</strong>. Activa hoy tu plan oficial por <strong class="text-blue-700 dark:text-blue-400 font-bold">${{ number_format($amountCop, 0, ',', '.') }} COP/mes</strong> y garantiza la continuidad para tus pacientes.
                            @else
                                Tu período de prueba ha concluido. Para seguir emitiendo planes de salud, registrando pacientes y cobrando por pasarela, activa tu suscripción oficial con Bold.
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Lado Derecho: Botones de Pago y Acción --}}
                <div class="w-full xl:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-shrink-0 pt-2 xl:pt-0">
                    <a href="{{ $checkoutUrl }}" 
                       style="background: linear-gradient(135deg, #2563eb 0%, #0d9488 100%); color: #ffffff !important;"
                       class="inline-flex items-center justify-center gap-2.5 px-6 py-3 rounded-xl font-extrabold text-sm text-white shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-center whitespace-nowrap">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span>
                            @if($status === 'paid')
                                Renovar Plan (${{ number_format($amountCop, 0, ',', '.') }})
                            @else
                                💳 Activar Plan con Bold (${{ number_format($amountCop, 0, ',', '.') }})
                            @endif
                        </span>
                    </a>

                    <a href="https://wa.me/573508742543?text={{ urlencode('Hola Robinson, tengo una consulta sobre el plan y pago de AVI-Plan para mi clínica ' . $tenantName) }}" 
                       target="_blank"
                       class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-bold text-xs text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border border-slate-300 dark:border-slate-700 transition-colors text-center whitespace-nowrap">
                        <span class="text-base text-emerald-500">💬</span>
                        <span>Soporte WhatsApp</span>
                    </a>
                </div>
            </div>

            {{-- Fila inferior con micro-detalles y beneficios --}}
            <div class="px-6 py-3 bg-slate-50 dark:bg-slate-800/60 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500 dark:text-slate-400">
                <div class="flex items-center gap-5">
                    <span class="flex items-center gap-1.5 font-medium">
                        <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Pagos seguros con Bold (PSE, Nequi, Bancolombia, Tarjetas)
                    </span>
                    <span class="hidden sm:flex items-center gap-1.5 font-medium">
                        <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Activación instantánea y comprobante
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-semibold">Pasarela Oficial: <strong class="text-slate-800 dark:text-slate-200">Bold.co</strong></span>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
