<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        
        {{-- Panel Izquierdo: Buscador Reactivo --}}
        <div class="md:col-span-5 bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span>🔍</span> Buscar Tutor o Mascota
            </h3>

            <div class="mb-4">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="searchQuery" 
                    placeholder="Buscar por cédula, teléfono, nombre..."
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    autofocus
                />
            </div>

            <div class="space-y-3 max-h-[500px] overflow-y-auto">
                @php $results = $this->search(); @endphp

                @forelse($results as $sub)
                    <div 
                        wire:click="selectSubscription('{{ $sub->id }}')"
                        class="p-4 rounded-lg cursor-pointer transition border {{ $selectedSubscriptionId === $sub->id ? 'bg-emerald-50 dark:bg-emerald-950/40 border-emerald-500' : 'bg-gray-50 dark:bg-gray-700/50 border-gray-200 dark:border-gray-600 hover:border-emerald-400' }}"
                    >
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="font-bold text-gray-900 dark:text-white text-base">🐾 {{ $sub->pet->name }}</span>
                                <span class="text-xs bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300 px-2 py-0.5 rounded-full ml-2">
                                    {{ $sub->plan->name }}
                                </span>
                            </div>
                            <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase">Activo</span>
                        </div>
                        <div class="text-xs text-gray-600 dark:text-gray-300 mt-2 space-y-0.5">
                            <p><strong>Tutor:</strong> {{ $sub->pet->customer->name }} (CC: {{ $sub->pet->customer->identification ?? 'N/A' }})</p>
                            <p><strong>Teléfono:</strong> {{ $sub->pet->customer->phone }}</p>
                            <p><strong>Especie/Raza:</strong> {{ ucfirst($sub->pet->species) }} - {{ $sub->pet->breed ?? 'Mestizo' }}</p>
                        </div>
                    </div>
                @empty
                    @if(strlen($searchQuery) >= 2)
                        <p class="text-center text-sm text-gray-500 dark:text-gray-400 py-6">No se encontraron contratos activos con ese criterio.</p>
                    @else
                        <p class="text-center text-xs text-gray-400 dark:text-gray-500 py-6">Ingresa al menos 2 caracteres para buscar en tiempo real.</p>
                    @endif
                @endforelse
            </div>
        </div>

        {{-- Panel Derecho: Tarjeta de Mascota y Canje de Saldos --}}
        <div class="md:col-span-7 bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            @if($this->selectedSubscription)
                @php $sub = $this->selectedSubscription; @endphp

                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white flex items-center gap-2">
                                🐶 {{ $sub->pet->name }}
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Tutor: <strong class="text-gray-800 dark:text-gray-200">{{ $sub->pet->customer->name }}</strong> | Plan: <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ $sub->plan->name }}</span>
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300 px-3 py-1 rounded-full font-bold">
                                Vence: {{ $sub->current_period_end->format('d/M/Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Ledger de Saldos Disponibles --}}
                <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-4">
                    Saldos y Cupos Disponibles
                </h4>

                <div class="space-y-4">
                    @foreach($sub->benefitBalances as $balance)
                        @php 
                            $percent = $balance->total_granted > 0 ? ($balance->used_count / $balance->total_granted) * 100 : 0;
                        @endphp
                        <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex-1">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-gray-900 dark:text-white text-base">
                                        {{ $balance->benefitDefinition->name }}
                                    </span>
                                    <span class="text-sm font-extrabold {{ $balance->remaining_count > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-500' }}">
                                        {{ $balance->remaining_count }} de {{ $balance->total_granted }} disponibles
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-600 h-2 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full transition-all" style="width: {{ 100 - $percent }}%"></div>
                                </div>
                            </div>

                            <div>
                                @if($balance->remaining_count > 0)
                                    <button 
                                        wire:click="redeemBenefit('{{ $balance->benefitDefinition->id }}')"
                                        wire:loading.attr="disabled"
                                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-sm transition flex items-center gap-1.5"
                                    >
                                        <span>⚡</span> Canjear (1)
                                    </button>
                                @else
                                    <span class="px-3 py-1.5 bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400 text-xs font-bold rounded-lg">
                                        Agotado
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="text-center py-20">
                    <div class="text-5xl mb-3">🩺</div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">Selecciona un tutor o mascota</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto mt-1">
                        Utiliza el buscador de la izquierda para consultar el contrato, verificar saldos vigentes y aplicar canjes de recepción con 1 clic.
                    </p>
                </div>
            @endif
        </div>

    </div>
</x-filament-panels::page>
