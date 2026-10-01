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
                    Suscripción Pro Activa
                </span>
            </div>
        @endif

        {{-- Tarjeta Principal de Estado de Cuenta --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm transition-all hover:shadow-md">
            {{-- Barra de gradiente superior --}}
            @if($status === 'paid')
                <div class="h-1.5 w-full bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500"></div>
            @elseif($status === 'trial_active')
                <div class="h-1.5 w-full bg-gradient-to-r from-blue-500 via-indigo-500 to-teal-500"></div>
            @else
                <div class="h-1.5 w-full bg-gradient-to-r from-amber-500 via-rose-500 to-red-600"></div>
            @endif

            <div class="p-5 sm:p-6 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                {{-- Lado Izquierdo: Información y Estado --}}
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-2xl flex items-center justify-center text-2xl shadow-inner
                        {{ $status === 'paid' ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 border border-emerald-200 dark:border-emerald-700' : ($status === 'trial_active' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-600 border border-blue-200 dark:border-blue-700' : 'bg-amber-100 dark:bg-amber-900/50 text-amber-600 border border-amber-200 dark:border-amber-700') }}">
                        @if($status === 'paid')
                            ⭐
                        @elseif($status === 'trial_active')
                            ⏳
                        @else
                            ⚠️
                        @endif
                    </div>

                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Licencia AVI-Plan SaaS
                            </span>
                            
                            @if($status === 'paid')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Plan Pro Activo (Al Día)
                                </span>
                            @elseif($status === 'trial_active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300 border border-blue-300 dark:border-blue-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Prueba Gratuita ({{ $daysRemaining }} días restantes)
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-300 border border-amber-300 dark:border-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Período de Prueba Vencido
                                </span>
                            @endif

                            <span class="text-xs text-slate-400 font-medium">
                                • {{ $tenant?->name ?? 'Clínica Veterinaria' }}
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white">
                            @if($status === 'paid')
                                Tu clínica tiene acceso total a AVI-Plan SaaS
                            @elseif($status === 'trial_active')
                                Estás en tu período de prueba gratuito de 15 días
                            @else
                                Activa tu suscripción para continuar operando sin interrupciones
                            @endif
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-2xl leading-relaxed">
                            @if($status === 'paid')
                                Próxima fecha de renovación: <strong class="text-slate-800 dark:text-slate-200">{{ $paidUntil ? $paidUntil->format('d/m/Y') : 'En 30 días' }}</strong>. Incluye pasarela Bold, portal de clientes, carnets QR ilimitados y módulo de teleconsultas.
                            @elseif($status === 'trial_active')
                                Tu prueba vence el <strong class="text-slate-800 dark:text-slate-200">{{ $trialEndsAt ? $trialEndsAt->format('d/m/Y') : 'próximamente' }}</strong>. Activa hoy tu plan oficial por solo <strong>${{ number_format($amountCop, 0, ',', '.') }} COP/mes</strong> y garantiza la continuidad para tus pacientes.
                            @else
                                Tu período de prueba ha concluido. Para seguir emitiendo planes de salud, registrando mascotas y recibiendo pagos en línea, activa tu plan oficial con Bold.
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Lado Derecho: Botones de Pago y Acción --}}
                <div class="w-full lg:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 flex-shrink-0">
                    <a href="{{ $checkoutUrl }}" 
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-blue-600 via-indigo-600 to-teal-600 hover:from-blue-700 hover:to-teal-700 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span>
                            @if($status === 'paid')
                                Gestionar / Adelantar Renovación (${{ number_format($amountCop, 0, ',', '.') }})
                            @else
                                💳 Activar Plan con Bold (${{ number_format($amountCop, 0, ',', '.') }})
                            @endif
                        </span>
                    </a>

                    <a href="https://wa.me/573508742543?text={{ urlencode('Hola Robinson, tengo una consulta sobre el pago y suscripción de AVI-Plan para mi clínica ' . ($tenant?->name ?? '')) }}" 
                       target="_blank"
                       class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl font-semibold text-xs text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition-colors text-center">
                        <span class="text-emerald-500">💬</span>
                        <span>Soporte WhatsApp</span>
                    </a>
                </div>
            </div>

            {{-- Fila inferior con micro-detalles y beneficios --}}
            <div class="px-6 py-2.5 bg-slate-50/80 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/80 flex flex-wrap items-center justify-between gap-3 text-[11px] text-slate-500 dark:text-slate-400">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-teal-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Pagos seguros con Bold (PSE, Nequi, Tarjetas)
                    </span>
                    <span class="hidden sm:inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-teal-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Activación y factura inmediata
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <span>Pasarela Oficial: <strong class="text-slate-700 dark:text-slate-300">Bold.co</strong></span>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
