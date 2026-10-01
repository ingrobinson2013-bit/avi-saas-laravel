<x-filament-widgets::widget>
    <div class="w-full">
        {{-- Alerta de confirmación si acaba de pagar --}}
        @if($isJustPaid)
            <div class="mb-4 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-900 dark:text-emerald-100 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🎉</span>
                    <div>
                        <h4 class="font-bold text-sm">¡Pago Exitoso con Bold!</h4>
                        <p class="text-xs text-emerald-700 dark:text-emerald-300">Tu suscripción ha sido activada y tu clínica está al día en AVI-Plan.</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">
                    {{ $planName }} Activo
                </span>
            </div>
        @endif

        {{-- Tarjeta Principal de Suscripción --}}
        <div class="w-full rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm overflow-hidden">
            {{-- Línea de color superior según estado --}}
            @if($status === 'paid')
                <div class="h-1.5 w-full bg-emerald-500"></div>
            @elseif($status === 'trial_active')
                <div class="h-1.5 w-full bg-blue-600"></div>
            @else
                <div class="h-1.5 w-full bg-amber-500"></div>
            @endif

            <div class="p-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    {{-- Bloque Izquierdo: Icono + Información --}}
                    <div class="flex items-start sm:items-center gap-4 min-w-0 flex-1">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-3xl flex-shrink-0 shadow-inner
                            {{ $status === 'paid' ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 border border-emerald-200 dark:border-emerald-800' : ($status === 'trial_active' ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-600 border border-blue-200 dark:border-blue-800' : 'bg-amber-50 dark:bg-amber-950/60 text-amber-600 border border-amber-200 dark:border-amber-800') }}">
                            @if($status === 'paid')
                                🏆
                            @elseif($status === 'trial_active')
                                ⏳
                            @else
                                ⚠️
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Licencia AVI-Plan SaaS
                                </span>

                                @if($status === 'paid')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        {{ $planName }} (Activo)
                                    </span>
                                @elseif($status === 'trial_active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-black bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300">
                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                        Prueba Gratuita ({{ $daysRemaining }} días restantes)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-black bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-300">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        Prueba Expirada
                                    </span>
                                @endif

                                <span class="text-xs font-medium text-slate-400">
                                    • {{ $tenantName }}
                                </span>
                            </div>

                            <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 dark:text-white leading-tight mb-1">
                                @if($status === 'paid')
                                    Tu clínica tiene acceso total a AVI-Plan SaaS
                                @elseif($status === 'trial_active')
                                    Estás en tu período de prueba de 15 días
                                @else
                                    Activa tu suscripción para seguir operando
                                @endif
                            </h3>

                            <p class="text-sm text-slate-600 dark:text-slate-300 leading-normal">
                                @if($status === 'paid')
                                    Próxima fecha de renovación: <strong class="text-slate-900 dark:text-white">{{ $paidUntilFormatted ?: 'En 30 días' }}</strong>. 
                                    @if($planTier === 'pay_per_pet')
                                        Liquidación actual: <strong class="text-emerald-600 dark:text-emerald-400 font-bold">${{ number_format($amountCop, 0, ',', '.') }} COP</strong> ({{ $petsCount }} pacientes inscritos x $5.000 COP).
                                    @else
                                        Canon mensual: <strong class="text-emerald-600 dark:text-emerald-400 font-bold">${{ number_format($amountCop, 0, ',', '.') }} COP</strong>.
                                    @endif
                                @elseif($status === 'trial_active')
                                    Tu prueba finaliza el <strong class="text-slate-900 dark:text-white">{{ $trialEndsAtFormatted ?: 'próximamente' }}</strong>. 
                                    @if($planTier === 'pay_per_pet')
                                        Activa tu plan de <strong class="text-blue-600 dark:text-blue-400 font-bold">${{ number_format($amountCop, 0, ',', '.') }} COP</strong> (calculado sobre {{ $petsCount }} pacientes registrados a $5.000 COP c/u).
                                    @else
                                        Activa hoy tu plan oficial por <strong class="text-blue-600 dark:text-blue-400 font-bold">${{ number_format($amountCop, 0, ',', '.') }} COP/mes</strong>.
                                    @endif
                                @else
                                    Tu período de prueba ha concluido. Para seguir registrando pacientes y emitiendo carnets digitales, activa tu plan oficial con Bold.
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Bloque Derecho: Botones de Acción Nativos Filament --}}
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-shrink-0">
                        <x-filament::button
                            tag="a"
                            href="{{ $checkoutUrl }}"
                            color="primary"
                            icon="heroicon-o-credit-card"
                            size="lg"
                            class="shadow-md font-bold"
                        >
                            {{ $status === 'paid' ? 'Renovar Plan' : 'Pagar con Bold' }} (${{ number_format($amountCop, 0, ',', '.') }} COP)
                        </x-filament::button>

                        <x-filament::button
                            tag="a"
                            href="https://wa.me/573508742543?text={{ urlencode('Hola Robinson, tengo una consulta sobre el pago y suscripción de AVI-Plan para mi clínica ' . $tenantName) }}"
                            target="_blank"
                            color="gray"
                            icon="heroicon-m-chat-bubble-left-ellipsis"
                            size="lg"
                        >
                            Soporte WhatsApp
                        </x-filament::button>
                    </div>
                </div>
            </div>

            {{-- Pie de la tarjeta con garantías --}}
            <div class="px-6 py-3 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500 dark:text-slate-400">
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Pagos seguros con PSE, Nequi, Bancolombia y Tarjetas
                    </span>
                    <span class="hidden md:inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Activación instantánea
                    </span>
                </div>
                <div>
                    Pasarela Oficial: <strong class="text-slate-700 dark:text-slate-300">Bold.co</strong>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
