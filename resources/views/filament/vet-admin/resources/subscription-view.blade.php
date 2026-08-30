<x-filament-panels::page>
    @php
        $sub = $this->record;
        $pet = $sub->pet;
        $customer = $pet?->customer;
        $plan = $sub->plan;
        $balances = $sub->benefitBalances()->with(['benefitDefinition', 'redemptions.vetUser'])->get();
    @endphp

    <!-- 1. Tarjeta Principal de la Membresía / Paciente -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-6 shadow-sm">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-emerald-100 dark:bg-emerald-950/50 flex items-center justify-center text-3xl border border-emerald-200 dark:border-emerald-800 shadow-inner">
                    {{ $pet?->species === 'cat' ? '🐱' : '🐶' }}
                </div>
                <div>
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">
                            {{ $pet?->name ?? 'Mascota' }}
                        </h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $sub->status_color === 'success' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : ($sub->status_color === 'warning' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                            {{ $sub->status_label }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300">
                            {{ $plan?->name }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ $pet?->breed ?? 'Mestizo' }} 
                        @if($pet?->birthdate)
                            • {{ \Carbon\Carbon::parse($pet->birthdate)->age }} años
                        @endif
                        • Tutor: <strong class="text-gray-700 dark:text-gray-200">{{ $customer?->name ?? 'Sin tutor' }}</strong>
                        @if($customer?->identification) (CC: {{ $customer->identification }}) @endif
                    </p>
                </div>
            </div>

            <!-- Acciones rápidas del Tutor -->
            <div class="flex items-center gap-2 flex-wrap">
                @if($customer?->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone) }}?text={{ urlencode('Hola ' . ($customer->name ?? '') . ', te saludamos de la clínica veterinaria sobre el plan de ' . ($pet->name ?? 'tu mascota')) }}" 
                       target="_blank" 
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition">
                        <span>💬 WhatsApp Tutor</span>
                    </a>
                @endif

                <button wire:click="resetBalances" 
                        wire:confirm="¿Estás seguro de restablecer todos los saldos al cupo inicial del plan?"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-medium bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 transition">
                    🔄 Resetear Saldos
                </button>
            </div>
        </div>

        <!-- Barra de Ciclo y Resumen de Consumo -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-100 dark:border-gray-800 text-sm">
            <div class="bg-gray-50 dark:bg-gray-800/50 p-3.5 rounded-xl">
                <span class="text-xs text-gray-500 block">Vigencia del Período Actual</span>
                <span class="font-bold text-gray-800 dark:text-gray-200">
                    {{ $sub->current_period_start?->format('d/m/Y') }} — {{ $sub->current_period_end?->format('d/m/Y') }}
                </span>
                @if($sub->isExpiringSoon())
                    <span class="text-[11px] text-amber-600 font-bold block mt-0.5">⚠️ Vence en menos de 7 días</span>
                @endif
            </div>

            <div class="bg-gray-50 dark:bg-gray-800/50 p-3.5 rounded-xl">
                <span class="text-xs text-gray-500 block">Valor Mensual del Plan</span>
                <span class="font-bold text-emerald-600 dark:text-emerald-400 text-base">
                    ${{ number_format($plan?->price_cop ?? 0, 0, ',', '.') }} COP / {{ $plan?->billing_interval === 'monthly' ? 'mes' : 'año' }}
                </span>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800/50 p-3.5 rounded-xl">
                <span class="text-xs text-gray-500 block">Consumo Global del Ciclo</span>
                <div class="flex items-center justify-between font-bold text-gray-800 dark:text-gray-200">
                    <span>{{ $sub->total_used }} de {{ $sub->total_granted }} cupos</span>
                    <span>{{ $sub->usage_percentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full mt-1.5 overflow-hidden">
                    <div class="bg-emerald-500 h-full rounded-full transition-all duration-300" style="width: {{ $sub->usage_percentage }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Estado de Beneficios (Saldos en Vivo) -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                    <span>📊</span> Estado de Beneficios & Cupos Disponibles
                </h3>
                <p class="text-xs text-gray-500">Límites y consumo en tiempo real para este ciclo</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($balances as $bal)
                @php
                    $bDef = $bal->benefitDefinition;
                    $used = $bal->used_count;
                    $total = $bal->total_granted;
                    $remaining = $bal->remaining_count;
                    $percent = $bal->usage_percentage;
                    $isUnlimited = $total >= 900;
                @endphp
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5 shadow-sm hover:border-emerald-300 dark:hover:border-emerald-700 transition">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 block mb-0.5">
                                {{ $bDef?->category_label ?? 'Servicio' }}
                            </span>
                            <h4 class="text-base font-bold text-gray-900 dark:text-white truncate">
                                {{ $bDef?->name }}
                            </h4>
                            @if($bDef?->description)
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-1">{{ $bDef->description }}</p>
                            @endif
                        </div>

                        <div class="text-right shrink-0">
                            @if($isUnlimited)
                                <span class="px-2.5 py-1 rounded-lg text-xs font-black bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300">
                                    ♾️ Ilimitado
                                </span>
                            @elseif($remaining > 0)
                                <span class="px-2.5 py-1 rounded-lg text-xs font-black bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                    {{ $remaining }} Disp.
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg text-xs font-black bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">
                                    0 Cupos
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Barra de Progreso Visual tipo Mockup -->
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-xs mb-1">
                            <span class="text-gray-500">
                                @if($isUnlimited)
                                    Utilizadas: {{ $used }} veces
                                @else
                                    Utilizadas: <strong>{{ $used }} de {{ $total }}</strong>
                                @endif
                            </span>
                            <span class="font-bold {{ $remaining === 0 && !$isUnlimited ? 'text-rose-500' : 'text-emerald-600' }}">
                                @if($isUnlimited) Activo @else {{ $remaining }} disponibles @endif
                            </span>
                        </div>

                        @if(!$isUnlimited)
                            <div class="w-full bg-gray-100 dark:bg-gray-800 h-2.5 rounded-full overflow-hidden flex">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-300" style="width: {{ $percent }}%"></div>
                            </div>
                        @else
                            <div class="w-full bg-sky-100 dark:bg-sky-950/40 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-sky-500 h-full w-full rounded-full"></div>
                            </div>
                        @endif
                    </div>

                    <!-- Botón de Canje Rápido para este Beneficio -->
                    <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                        <span class="text-[11px] text-gray-400">
                            {{ $bal->redemptions->count() }} canjes registrados
                        </span>

                        <button wire:click="redeemSingleBenefit('{{ $bDef?->id }}')" 
                                @if($remaining <= 0 && !$isUnlimited) disabled @endif
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition {{ $remaining > 0 || $isUnlimited ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white dark:bg-emerald-950/60 dark:text-emerald-300 dark:hover:bg-emerald-600' : 'bg-gray-100 text-gray-400 cursor-not-allowed dark:bg-gray-800 dark:text-gray-600' }}">
                            <span>✨ Canjear 1 servicio</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-10 bg-white dark:bg-gray-900 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700">
                    <p class="text-sm text-gray-500">No hay beneficios configurados en este plan.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- 3. Historial Cronológico de Canjes / Atenciones -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                    <span>📋</span> Historial Inmutable de Atenciones & Servicios Canjeados
                </h3>
                <p class="text-xs text-gray-500">Registro de auditoría con fecha, profesional veterinario y notas</p>
            </div>
        </div>

        @php
            $allRedemptions = collect();
            foreach($balances as $bal) {
                foreach($bal->redemptions as $r) {
                    $r->benefit_name = $bal->benefitDefinition?->name;
                    $r->benefit_category = $bal->benefitDefinition?->category_label;
                    $allRedemptions->push($r);
                }
            }
            $allRedemptions = $allRedemptions->sortByDesc('redeemed_at');
        @endphp

        @if($allRedemptions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-800 text-xs uppercase font-bold text-gray-500">
                            <th class="py-3 px-4">Fecha / Hora</th>
                            <th class="py-3 px-4">Servicio Tomado</th>
                            <th class="py-3 px-4">Cantidad</th>
                            <th class="py-3 px-4">Atendido Por</th>
                            <th class="py-3 px-4">Observaciones Médicas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach($allRedemptions as $red)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                <td class="py-3.5 px-4 font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($red->redeemed_at)->format('d/m/Y h:i A') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-gray-800 dark:text-gray-200 block">{{ $red->benefit_name }}</span>
                                    <span class="text-[11px] text-emerald-600 dark:text-emerald-400">{{ $red->benefit_category }}</span>
                                </td>
                                <td class="py-3.5 px-4 font-bold text-emerald-600">
                                    -{{ $red->quantity }} cupo
                                </td>
                                <td class="py-3.5 px-4 text-xs text-gray-600 dark:text-gray-300">
                                    {{ $red->vetUser?->name ?? 'Equipo Veterinario' }}
                                </td>
                                <td class="py-3.5 px-4 text-xs text-gray-500 max-w-xs truncate">
                                    {{ $red->notes ?: 'Sin notas registradas' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 bg-gray-50 dark:bg-gray-800/30 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                <span class="text-3xl block mb-2">🐾</span>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Aún no se han registrado consumos en este ciclo.</p>
                <p class="text-xs text-gray-400 mt-1">Los servicios utilizados aparecerán aquí automáticamente al canjearse.</p>
            </div>
        @endif
    </div>
</x-filament-panels::page>
