<x-filament-panels::page>
    <div class="space-y-6">
        
        {{-- Custom CSS for Animations & Glassmorphism --}}
        <style>
            @keyframes pulse-glow {
                0%, 100% { opacity: 0.6; transform: scale(1); }
                50% { opacity: 1; transform: scale(1.04); }
            }
            @keyframes float-slow {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-6px); }
            }
            .animate-float {
                animation: float-slow 4s ease-in-out infinite;
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
            .dark .glass-card {
                background: rgba(17, 24, 39, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
            .card-hover {
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .card-hover:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 24px -8px rgba(16, 185, 129, 0.15);
            }
            .modal-backdrop-blur {
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
            }
        </style>

        {{-- Grid Principal: 2 Columnas --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            {{-- ======================================================== --}}
            {{-- COLUMNA IZQUIERDA: BUSCADOR & LISTA REACTIVA (5 COLS) --}}
            {{-- ======================================================== --}}
            <div class="lg:col-span-5 space-y-4">
                
                {{-- Caja de Búsqueda con Luces y Estados --}}
                <div class="glass-card rounded-2xl p-5 shadow-sm border border-slate-200/80 dark:border-slate-700/80 relative overflow-hidden">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </span>
                            <h3 class="text-sm font-black uppercase tracking-wider text-slate-800 dark:text-slate-100">
                                Terminal de Recepción
                            </h3>
                        </div>
                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            Validación en Vivo
                        </span>
                    </div>

                    {{-- Input de Búsqueda Multifiltro --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <span wire:loading.remove wire:target="searchQuery" class="text-base">🔍</span>
                            <span wire:loading wire:target="searchQuery" class="animate-spin text-base text-emerald-500">⏳</span>
                        </div>
                        <input 
                            type="text" 
                            wire:model.live.debounce.250ms="searchQuery" 
                            placeholder="Buscar por Contrato (VPP-2026-...), Cédula, Mascota o WhatsApp..."
                            class="w-full pl-10 pr-10 py-3 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-800 transition-all shadow-inner"
                            autofocus
                        />
                        @if(!empty($searchQuery))
                            <button 
                                type="button" 
                                wire:click="$set('searchQuery', '')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-bold"
                            >
                                ✕
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Lista Reactiva de Pacientes --}}
                <div class="space-y-3 max-h-[620px] overflow-y-auto pr-1">
                    @php $results = $this->search(); @endphp

                    @forelse($results as $sub)
                        @php 
                            $isSelected = $selectedSubscriptionId === $sub->id;
                            $pet = $sub->pet;
                            $customer = $pet?->customer;
                            $isCat = strtolower($pet?->species ?? '') === 'cat' || strtolower($pet?->species ?? '') === 'felino';
                            $photo = $pet?->photo_url;
                            $granted = $sub->total_granted;
                            $used = $sub->total_used;
                            $percent = $sub->usage_percentage;
                        @endphp

                        <div 
                            wire:click="selectSubscription('{{ $sub->id }}')"
                            class="p-4 rounded-2xl cursor-pointer card-hover border transition-all relative overflow-hidden {{ $isSelected ? 'bg-gradient-to-r from-emerald-500/10 via-teal-500/10 to-transparent border-emerald-500 dark:border-emerald-400 shadow-md ring-2 ring-emerald-500/30' : 'glass-card border-slate-200/80 dark:border-slate-700/80 hover:border-emerald-300 dark:hover:border-emerald-600 shadow-xs' }}"
                        >
                            {{-- Indicador lateral activo --}}
                            @if($isSelected)
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-emerald-500 to-teal-400"></div>
                            @endif

                            <div class="flex items-center space-x-3.5">
                                {{-- Avatar con Foto o Emoji --}}
                                <div class="relative shrink-0">
                                    @if(!empty($photo))
                                        <div class="w-13 h-13 rounded-2xl overflow-hidden shadow-md border-2 {{ $isSelected ? 'border-emerald-500 ring-2 ring-emerald-400/40' : 'border-slate-200 dark:border-slate-700' }} bg-slate-100 dark:bg-slate-800">
                                            <img src="{{ $photo }}" alt="{{ $pet->name }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-13 h-13 rounded-2xl flex items-center justify-center text-2xl shadow-md border-2 {{ $isSelected ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-950/60' : 'border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800' }}">
                                            {{ $isCat ? '🐱' : '🐶' }}
                                        </div>
                                    @endif
                                    <span class="absolute -bottom-1 -right-1 text-[10px] bg-slate-900/90 text-white px-1 rounded-md border border-white/20">
                                        {{ $isCat ? 'Gato' : 'Perro' }}
                                    </span>
                                </div>

                                {{-- Información Central --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1">
                                        <h4 class="font-black text-sm sm:text-base text-slate-900 dark:text-white truncate">
                                            {{ $pet->name }}
                                        </h4>
                                        <span class="font-mono text-[10px] font-black px-2 py-0.5 rounded-lg bg-slate-900 text-white dark:bg-slate-700 shadow-xs shrink-0">
                                            {{ $sub->gateway_subscription_id }}
                                        </span>
                                    </div>

                                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium truncate mt-0.5">
                                        {{ $pet->breed ?: 'Mestizo' }} • Tutor: <strong class="text-slate-700 dark:text-slate-300">{{ $customer->name ?? 'N/A' }}</strong>
                                    </p>

                                    {{-- Mini Barra de Saldo --}}
                                    <div class="mt-2 flex items-center justify-between gap-2 text-[11px]">
                                        <span class="font-bold text-teal-700 dark:text-teal-300">
                                            {{ $sub->plan->name }}
                                        </span>
                                        <span class="font-black {{ $sub->total_remaining > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-500' }}">
                                            {{ $sub->total_remaining }} cupos disp.
                                        </span>
                                    </div>

                                    <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden mt-1">
                                        <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full transition-all duration-500" style="width: {{ 100 - $percent }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="glass-card rounded-2xl p-8 text-center border border-slate-200 dark:border-slate-700 space-y-3">
                            <span class="text-4xl inline-block animate-bounce">🐾</span>
                            <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200">
                                @if(strlen($searchQuery) >= 2)
                                    No se encontraron resultados
                                @else
                                    No hay membresías activas registradas aún
                                @endif
                            </h4>
                            <p class="text-xs text-slate-400 max-w-xs mx-auto">
                                @if(strlen($searchQuery) >= 2)
                                    Prueba buscando con otro nombre, número de contrato o documento.
                                @else
                                    Las nuevas afiliaciones desde la página web o el panel aparecerán aquí automáticamente.
                                @endif
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ======================================================== --}}
            {{-- COLUMNA DERECHA: CENTRO DE CANJE Y LEDGER (7 COLS)       --}}
            {{-- ======================================================== --}}
            <div class="lg:col-span-7">
                @if($this->selectedSubscription)
                    @php 
                        $sub = $this->selectedSubscription; 
                        $pet = $sub->pet;
                        $customer = $pet?->customer;
                        $tenant = $sub->tenant;
                        $isCat = strtolower($pet?->species ?? '') === 'cat' || strtolower($pet?->species ?? '') === 'felino';
                        $photo = $pet?->photo_url;
                        $cleanPhone = preg_replace('/[^0-9]/', '', $customer?->phone ?? '');
                        $carnetUrl = "/v/{$tenant->slug}/carnet/{$sub->gateway_subscription_id}";
                    @endphp

                    <div class="space-y-6">
                        
                        {{-- 1. Tarjeta Hero del Paciente Seleccionado --}}
                        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-lg border border-emerald-500/30 dark:border-emerald-500/20 relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white">
                            
                            {{-- Decoración de Fondo --}}
                            <div class="absolute -right-16 -top-16 w-56 h-56 rounded-full bg-emerald-500/10 blur-2xl pointer-events-none"></div>
                            <div class="absolute -left-16 -bottom-16 w-48 h-48 rounded-full bg-teal-500/10 blur-xl pointer-events-none"></div>

                            <div class="relative z-10 space-y-5">
                                
                                {{-- Fila Superior: Contrato & Botones de Acción Rápida --}}
                                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-white/10 pb-4">
                                    <div class="flex items-center space-x-2">
                                        <span class="px-3 py-1 rounded-xl bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-xs font-black tracking-wider flex items-center space-x-1.5">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                            <span>MEMBRESÍA ACTIVA</span>
                                        </span>
                                        <span class="font-mono text-xs font-bold text-slate-300 bg-white/10 px-2.5 py-1 rounded-xl">
                                            {{ $sub->gateway_subscription_id }}
                                        </span>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        @if(!empty($cleanPhone))
                                            <a 
                                                href="https://wa.me/57{{ $cleanPhone }}?text={{ urlencode('¡Hola ' . $customer->name . '! Te saludamos desde ' . $tenant->name . ' sobre la membresía de ' . $pet->name . '.') }}" 
                                                target="_blank" 
                                                class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition flex items-center space-x-1.5 shadow-sm"
                                            >
                                                <span>💬</span>
                                                <span>WhatsApp</span>
                                            </a>
                                        @endif
                                        <a 
                                            href="{{ $carnetUrl }}" 
                                            target="_blank" 
                                            class="px-3 py-1.5 bg-white/15 hover:bg-white/25 text-white text-xs font-bold rounded-xl border border-white/20 transition flex items-center space-x-1.5"
                                        >
                                            <span>💳</span>
                                            <span>Ver Carnet</span>
                                        </a>
                                    </div>
                                </div>

                                {{-- Fila Central: Datos Mascota y Tutor --}}
                                <div class="flex items-center space-x-4 sm:space-x-5">
                                    @if(!empty($photo))
                                        <div class="w-20 h-20 sm:w-22 sm:h-22 rounded-3xl overflow-hidden shadow-2xl border-2 border-white/80 p-0.5 bg-white/20 shrink-0">
                                            <img src="{{ $photo }}" alt="{{ $pet->name }}" class="w-full h-full object-cover rounded-2xl">
                                        </div>
                                    @else
                                        <div class="w-20 h-20 sm:w-22 sm:h-22 rounded-3xl bg-white/15 backdrop-blur-md flex items-center justify-center text-4xl shadow-2xl border-2 border-white/30 shrink-0">
                                            {{ $isCat ? '🐱' : '🐶' }}
                                        </div>
                                    @endif

                                    <div class="min-w-0 flex-1 space-y-1">
                                        <h2 class="text-2xl sm:text-3xl font-black text-white uppercase tracking-tight truncate">
                                            {{ $pet->name }}
                                        </h2>
                                        <p class="text-xs sm:text-sm text-teal-200 font-medium truncate">
                                            {{ $pet->breed ?: 'Mestizo' }} • {{ $isCat ? 'Felino' : 'Canino' }}
                                        </p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-0.5 pt-1 text-xs text-slate-300">
                                            <p><span class="text-slate-400">Tutor:</span> <strong>{{ $customer->name ?? 'N/A' }}</strong></p>
                                            <p><span class="text-slate-400">Tel:</span> <strong>{{ $customer->phone ?? 'N/A' }}</strong></p>
                                            <p><span class="text-slate-400">Doc:</span> <strong>{{ $customer->identification ?? 'Sin doc' }}</strong></p>
                                            <p><span class="text-slate-400">Plan:</span> <strong class="text-amber-300">{{ $sub->plan->name }}</strong></p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Fila Inferior: Medidor Global de Saldos --}}
                                <div class="bg-black/30 backdrop-blur-md p-3.5 rounded-2xl border border-white/10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 text-xs">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-base">📊</span>
                                        <span>Consumo del Plan: <strong>{{ $sub->total_used }} de {{ $sub->total_granted }} servicios canjeados</strong></span>
                                    </div>
                                    <span class="text-teal-300 font-bold">
                                        Vence: {{ $sub->current_period_end ? $sub->current_period_end->format('d/M/Y') : 'Activo' }}
                                    </span>
                                </div>

                            </div>
                        </div>

                        {{-- 2. Filtros por Categoría de Servicio --}}
                        <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-bold">
                            @php
                                $categories = [
                                    'all' => '🐾 Todos los Servicios',
                                    'consulta' => '🩺 Consultas',
                                    'vacuna' => '💉 Vacunas',
                                    'desparasitacion' => '💊 Desparasitación',
                                    'bano' => '🛁 Baño & Estética',
                                    'laboratorio' => '🔬 Laboratorio',
                                ];
                            @endphp
                            @foreach($categories as $key => $label)
                                <button 
                                    type="button" 
                                    wire:click="filterCategory('{{ $key }}')"
                                    class="px-3.5 py-2 rounded-xl transition-all shrink-0 {{ $selectedCategory === $key ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300' }}"
                                >
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>

                        {{-- 3. Grid de Beneficios & Cupos --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($sub->benefitBalances as $balance)
                                @php 
                                    $benefit = $balance->benefitDefinition;
                                    if ($selectedCategory !== 'all' && $benefit->category !== $selectedCategory) {
                                        continue;
                                    }
                                    $percent = $balance->total_granted > 0 ? ($balance->used_count / $balance->total_granted) * 100 : 0;
                                    $hasRemaining = $balance->remaining_count > 0;
                                @endphp

                                <div class="glass-card rounded-2xl p-4.5 border transition-all duration-300 relative flex flex-col justify-between space-y-4 {{ $hasRemaining ? 'border-slate-200 dark:border-slate-700 shadow-xs hover:border-emerald-400 dark:hover:border-emerald-500' : 'border-slate-200/60 dark:border-slate-800 opacity-60' }}">
                                    
                                    <div>
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="flex items-center space-x-2 min-w-0">
                                                <span class="text-xl shrink-0">
                                                    @switch($benefit->category)
                                                        @case('consulta') 🩺 @break
                                                        @case('vacuna') 💉 @break
                                                        @case('desparasitacion') 💊 @break
                                                        @case('bano') 🛁 @break
                                                        @case('laboratorio') 🔬 @break
                                                        @case('urgencia') 🚨 @break
                                                        @default 🐾
                                                    @endswitch
                                                </span>
                                                <h4 class="font-bold text-sm text-slate-900 dark:text-white leading-tight truncate">
                                                    {{ $benefit->name }}
                                                </h4>
                                            </div>

                                            <span class="text-xs font-black px-2.5 py-0.5 rounded-full shrink-0 {{ $hasRemaining ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-slate-100 text-slate-500 dark:bg-slate-800' }}">
                                                {{ $balance->remaining_count }} de {{ $balance->total_granted }}
                                            </span>
                                        </div>

                                        {{-- Barra de Progreso --}}
                                        <div class="mt-3 space-y-1">
                                            <div class="w-full bg-slate-100 dark:bg-slate-700 h-2 rounded-full overflow-hidden">
                                                <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full transition-all duration-500" style="width: {{ 100 - $percent }}%"></div>
                                            </div>
                                            <div class="flex justify-between text-[10px] text-slate-400">
                                                <span>Usados: {{ $balance->used_count }}</span>
                                                <span>Disponibles: {{ $balance->remaining_count }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Botón de Acción --}}
                                    <div>
                                        @if($hasRemaining)
                                            <button 
                                                type="button" 
                                                wire:click="openRedeemModal('{{ $balance->id }}')"
                                                class="w-full py-2.5 px-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black text-xs rounded-xl shadow-md transition-all transform active:scale-95 flex items-center justify-center space-x-1.5"
                                            >
                                                <span>⚡</span>
                                                <span>Canjear Beneficio</span>
                                            </button>
                                        @else
                                            <div class="w-full py-2 px-3 bg-slate-100 dark:bg-slate-800/80 text-slate-400 text-center font-bold text-xs rounded-xl border border-slate-200 dark:border-slate-700">
                                                Cupos Agotados
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        {{-- 4. Historial Reciente de Canjes del Paciente --}}
                        @php $recentRedemptions = $this->recentRedemptions; @endphp
                        @if($recentRedemptions->isNotEmpty())
                            <div class="glass-card rounded-2xl p-5 shadow-sm border border-slate-200/80 dark:border-slate-700/80 space-y-3">
                                <h4 class="text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 flex items-center space-x-2">
                                    <span>📋</span>
                                    <span>Historial de Canjes Realizados en Esta Membresía</span>
                                </h4>

                                <div class="space-y-2">
                                    @foreach($recentRedemptions as $redemption)
                                        <div class="p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200/60 dark:border-slate-700/60 flex items-center justify-between gap-3 text-xs">
                                            <div class="flex items-center space-x-2.5 min-w-0">
                                                <span class="text-base">✅</span>
                                                <div class="min-w-0">
                                                    <p class="font-bold text-slate-900 dark:text-white truncate">
                                                        {{ $redemption->balance->benefitDefinition->name }} (x{{ $redemption->quantity }})
                                                    </p>
                                                    @if(!empty($redemption->notes))
                                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">
                                                            📝 {{ $redemption->notes }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="text-right shrink-0 text-[11px] text-slate-400">
                                                <span>{{ $redemption->redeemed_at ? $redemption->redeemed_at->diffForHumans() : 'Reciente' }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>

                @else
                    {{-- Pantalla de Bienvenida cuando no hay paciente seleccionado --}}
                    <div class="glass-card rounded-3xl p-12 text-center border border-slate-200 dark:border-slate-700 space-y-5">
                        <div class="w-24 h-24 mx-auto rounded-3xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center text-5xl shadow-lg animate-float">
                            🩺
                        </div>
                        <div class="space-y-1 max-w-md mx-auto">
                            <h3 class="text-xl font-black text-slate-900 dark:text-white">
                                Selecciona una Mascota o Contrato
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Utiliza el panel izquierdo para buscar por número de contrato, nombre de la mascota, cédula o WhatsApp del tutor para canjear servicios al instante.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        {{-- ======================================================== --}}
        {{-- MODAL INTERACTIVO DE CONFIRMACIÓN DE CANJE              --}}
        {{-- ======================================================== --}}
        @if($showRedeemModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 modal-backdrop-blur transition-opacity animate-in fade-in duration-200">
                <div class="glass-card w-full max-w-lg rounded-3xl p-6 sm:p-7 shadow-2xl border border-emerald-500/40 dark:border-emerald-500/30 space-y-6 relative bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                    
                    {{-- Botón Cerrar --}}
                    <button 
                        type="button" 
                        wire:click="closeRedeemModal" 
                        class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 dark:hover:text-white text-lg font-bold w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center transition"
                    >
                        ✕
                    </button>

                    {{-- Encabezado Modal --}}
                    <div class="text-center space-y-2">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-3xl border border-emerald-500/20 shadow-inner">
                            ⚡
                        </div>
                        <h3 class="text-xl font-black text-slate-900 dark:text-white">
                            Confirmar Canje en Recepción
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Estás a punto de aplicar el beneficio <strong class="text-emerald-600 dark:text-emerald-400">"{{ $activeBenefitName }}"</strong>
                        </p>
                    </div>

                    {{-- Selector de Cantidad Interactiva Stepper --}}
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 space-y-2 text-center">
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                            Cantidad a Descontar (Cupos Disponibles: {{ $activeAvailableCount }})
                        </label>
                        <div class="flex items-center justify-center space-x-4">
                            <button 
                                type="button" 
                                wire:click="decrementQuantity" 
                                class="w-10 h-10 rounded-xl bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-800 dark:text-white font-black text-lg hover:bg-slate-100 dark:hover:bg-slate-600 active:scale-95 transition shadow-xs"
                            >
                                −
                            </button>
                            <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400 w-12 text-center">
                                {{ $redeemQuantity }}
                            </span>
                            <button 
                                type="button" 
                                wire:click="incrementQuantity" 
                                class="w-10 h-10 rounded-xl bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-800 dark:text-white font-black text-lg hover:bg-slate-100 dark:hover:bg-slate-600 active:scale-95 transition shadow-xs"
                            >
                                +
                            </button>
                        </div>
                    </div>

                    {{-- Notas Rápidas / Tags --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                            Plantillas Rápidas de Motivo (Opcional):
                        </label>
                        <div class="flex flex-wrap gap-1.5 text-[11px]">
                            @php
                                $quickTags = ['Consulta de rutina', 'Vacuna anual', 'Chequeo preventivo', 'Peluquería & Baño', 'Urgencia atendida'];
                            @endphp
                            @foreach($quickTags as $tag)
                                <button 
                                    type="button" 
                                    wire:click="setQuickNote('{{ $tag }}')"
                                    class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 transition"
                                >
                                    + {{ $tag }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Campo de Observaciones Clínicas --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            Notas Clínicas / Profesional Responsable:
                        </label>
                        <textarea 
                            wire:model="redeemNotes" 
                            rows="2" 
                            placeholder="Ej. Realizada por Dr. Pérez. Mascota en buen estado general..."
                            class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        ></textarea>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <button 
                            type="button" 
                            wire:click="closeRedeemModal" 
                            class="py-3 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs transition"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="button" 
                            wire:click="confirmRedeem" 
                            wire:loading.attr="disabled"
                            class="py-3 px-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black text-xs shadow-lg shadow-emerald-600/30 transition transform active:scale-95 flex items-center justify-center space-x-1.5"
                        >
                            <span wire:loading.remove wire:target="confirmRedeem">⚡ Confirmar y Canjear</span>
                            <span wire:loading wire:target="confirmRedeem" class="animate-spin">⏳ Procesando...</span>
                        </button>
                    </div>

                </div>
            </div>
        @endif

    </div>

    {{-- Confetti Script Effect on Redemption --}}
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('benefit-redeemed', (event) => {
                if (typeof confetti === 'function') {
                    confetti({
                        particleCount: 80,
                        spread: 70,
                        origin: { y: 0.6 }
                    });
                }
            });
        });
    </script>
</x-filament-panels::page>
