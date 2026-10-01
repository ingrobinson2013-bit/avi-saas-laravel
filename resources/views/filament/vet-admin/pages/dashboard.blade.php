<x-filament-panels::page class="fi-dashboard-custom-page">
    <div class="avi-workspace">
        
        {{-- =========================================================
             COLUMNA IZQUIERDA: ÁREA DE OPERACIÓN PRINCIPAL
             ========================================================= --}}
        <div class="avi-main-area">
            
            {{-- 1. HERO WELCOME CARD (EXACT PETSALUD+ MOCKUP) --}}
            <div class="avi-hero-card">
                <div class="space-y-1.5 max-w-xl">
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                        ¡Hola, {{ $greetingName }}!
                    </p>
                    <h1 class="avi-hero-title">
                        Bienvenida a {{ $brandName }} 👋
                    </h1>
                    <p class="avi-hero-sub">
                        Gestiona tus planes de salud, clientes y mascotas en un solo lugar.
                    </p>
                    <div class="avi-hero-badges pt-1">
                        <span class="avi-pill-gray">
                            📍 Sede {{ $cleanCity }} · {{ $formattedDate }}
                        </span>
                        <span class="avi-pill-cyan">
                            ⏱ Modo Sincronizado
                        </span>
                        <span class="avi-pill-green">
                            <span class="avi-pulse-dot"></span>
                            <span>Sistema en línea</span>
                        </span>
                    </div>
                </div>

                <!-- Right Mascot Illustration (Golden Retriever + Cat + Cyan Heart) -->
                <div class="avi-hero-mascot">
                    <img src="/images/dashboard/hero_pets_2x.png" 
                         alt="PetSalud Mascotas" 
                         class="avi-hero-img" />
                </div>
            </div>

            {{-- 2. 4 KPI CARDS (EN 1 SOLA FILA HORIZONTAL) --}}
            <div class="avi-kpi-grid">
                
                <!-- KPI 1: MRR -->
                <div class="avi-kpi-card relative overflow-hidden">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full bg-[#1e3a8a] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                            $
                        </div>
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-300">
                            Ingresos recurrentes (MRR)
                        </span>
                    </div>
                    
                    <div class="my-1.5">
                        <div class="text-[26px] font-black tracking-tight text-slate-900 dark:text-white leading-none">
                            ${{ number_format($mrr, 0, ',', '.') }} <span class="text-sm font-black text-slate-800 dark:text-slate-200">COP</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-[11.5px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-0.5">
                            <span>↗</span> +50% vs. mes anterior
                        </span>
                        <!-- Green upward sparkline curve -->
                        <svg class="w-14 h-6 text-emerald-500" viewBox="0 0 60 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 18 C 15 18, 25 14, 38 8 C 45 4, 52 4, 58 2" />
                        </svg>
                    </div>
                </div>

                <!-- KPI 2: Mascotas Activas -->
                <div class="avi-kpi-card relative overflow-hidden">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full bg-[#0d9488] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                            🐾
                        </div>
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-300">
                            Mascotas activas
                        </span>
                    </div>
                    
                    <div class="my-1.5">
                        <div class="text-[26px] font-black tracking-tight text-slate-900 dark:text-white leading-none">
                            {{ $petsCount }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-[11.5px] font-semibold text-blue-600 dark:text-cyan-400">
                            {{ $activeSubsCount }} plan activo
                        </span>
                        <!-- Soft cyan paw watermark -->
                        <span class="text-lg text-cyan-400/80 leading-none">
                            🐾
                        </span>
                    </div>
                </div>

                <!-- KPI 3: Nuevas Afiliaciones -->
                <div class="avi-kpi-card relative overflow-hidden">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full bg-[#7c3aed] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                            👥
                        </div>
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-300">
                            Nuevas afiliaciones
                        </span>
                    </div>
                    
                    <div class="my-1.5">
                        <div class="text-[26px] font-black tracking-tight text-slate-900 dark:text-white leading-none">
                            +{{ $newSubsThisMonth }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-[11.5px] font-semibold text-slate-500 dark:text-slate-400">
                            Este mes
                        </span>
                        <!-- Purple upward arrow sparkline -->
                        <svg class="w-10 h-6 text-purple-500" viewBox="0 0 40 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 20 L 14 14 L 24 17 L 38 4" />
                        </svg>
                    </div>
                </div>

                <!-- KPI 4: Renovaciones -->
                <div class="avi-kpi-card relative overflow-hidden">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full bg-[#f59e0b] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                            📅
                        </div>
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-300">
                            Renovaciones
                        </span>
                    </div>
                    
                    <div class="my-1.5">
                        <div class="text-[26px] font-black tracking-tight text-slate-900 dark:text-white leading-none">
                            {{ $expiring15Days }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-[11.5px] font-semibold text-slate-500 dark:text-slate-400">
                            Próximos 15 días
                        </span>
                        <!-- Amber calendar watermark -->
                        <svg class="w-5 h-5 text-amber-500/80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                </div>

            </div>

            {{-- 3. ACCIONES RÁPIDAS (EN 1 SOLA FILA HORIZONTAL DE 4 TARJETAS) --}}
            <div>
                <div class="mb-2 px-1">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Acciones rápidas
                    </h3>
                </div>

                <div class="avi-actions-grid">
                    {{-- 1. Canjear Beneficio (Azul Royal con Datáfono 3D) --}}
                    <a href="{{ $redeemUrl }}" class="avi-action-btn avi-action-blue relative overflow-hidden group">
                        <div class="flex items-center justify-between">
                            <div class="w-6 h-6 rounded-md bg-white/20 backdrop-blur-xs flex items-center justify-center text-xs font-black border border-white/30 text-white">
                                🏷️
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-auto">
                            <div>
                                <h4 class="text-sm font-black text-white leading-tight">Canjear beneficio</h4>
                                <p class="text-[10.5px] text-blue-100 font-medium mt-0.5">Abre tu terminal y atiende a tus clientes</p>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0 pl-1">
                                <img src="/images/dashboard/pos_terminal_2x.png" alt="POS Datáfono" class="h-8 w-auto object-contain drop-shadow-md" />
                                <span class="text-white text-base font-bold">&rsaquo;</span>
                            </div>
                        </div>
                    </a>

                    {{-- 2. Afiliar Mascota (Esmeralda / Teal) --}}
                    <a href="{{ $newSubUrl }}" class="avi-action-btn avi-action-green relative overflow-hidden group">
                        <div class="flex items-center justify-between">
                            <div class="w-6 h-6 rounded-md bg-white/20 backdrop-blur-xs flex items-center justify-center text-xs font-black border border-white/30 text-white">
                                🐾
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-auto">
                            <div>
                                <h4 class="text-sm font-black text-white leading-tight">Afiliar mascota</h4>
                                <p class="text-[10.5px] text-emerald-100 font-medium mt-0.5">Nueva afiliación</p>
                            </div>
                            <div class="shrink-0 pl-1">
                                <span class="text-white text-base font-bold">&rsaquo;</span>
                            </div>
                        </div>
                    </a>

                    {{-- 3. Ver Portal Público (Blanco con B2C badge) --}}
                    <a href="{{ $portalUrl }}" target="_blank" class="avi-action-btn avi-action-white relative overflow-hidden group">
                        <div class="flex items-center justify-between">
                            <div class="w-6 h-6 rounded-md bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-black border border-blue-200 dark:border-blue-800">
                                🌐
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-[9.5px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-1.5 py-0.5 rounded-md">
                                    Web B2C
                                </span>
                                <span class="text-[8.5px] text-slate-400 mt-0.5">Generar PDF</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-auto">
                            <div>
                                <h4 class="text-sm font-black text-slate-900 dark:text-white leading-tight">Ver portal</h4>
                                <p class="text-[10.5px] text-slate-400 font-medium mt-0.5">Abrir portal</p>
                            </div>
                        </div>
                    </a>

                    {{-- 4. Imprimir QR Mostrador (Blanco con PDF badge) --}}
                    <a href="{{ $qrUrl }}" target="_blank" class="avi-action-btn avi-action-white relative overflow-hidden group">
                        <div class="flex items-center justify-between">
                            <div class="w-6 h-6 rounded-md bg-cyan-50 dark:bg-cyan-950 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-xs font-black border border-cyan-200 dark:border-cyan-800">
                                🖨️
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-[9.5px] font-bold text-slate-700 bg-slate-100 border border-slate-200 px-1.5 py-0.5 rounded-md">
                                    Imprimir QR
                                </span>
                                <span class="text-[8.5px] text-slate-400 mt-0.5">Generar PDF</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-auto">
                            <div>
                                <h4 class="text-sm font-black text-slate-900 dark:text-white leading-tight">Imprimir QR</h4>
                                <p class="text-[10.5px] text-slate-400 font-medium mt-0.5">Generar PDF</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- 4. FILA MEDIA: RENOVACIONES PRÓXIMAS & USO DE BENEFICIOS --}}
            <div class="avi-mid-grid">
                
                {{-- Caja Izquierda: Renovaciones Próximas --}}
                <div class="avi-mid-box">
                    <div>
                        <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-2">
                                <span class="text-amber-500 text-sm">🔔</span>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white">
                                    Renovaciones próximas
                                </h3>
                            </div>
                            <a href="/admin/{{ $tenantSlug }}/subscriptions" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                <span>Ver todas</span>
                                <span>&rarr;</span>
                            </a>
                        </div>

                        <div class="py-6 text-center flex flex-col items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-slate-700 flex items-center justify-center text-xl mb-3 shadow-2xs">
                                📅
                            </div>
                            <h4 class="text-sm font-black text-slate-900 dark:text-white">
                                Sin renovaciones pendientes
                            </h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-xs leading-relaxed">
                                No tienes renovaciones próximas. Sigue revisando automáticamente mañana.
                            </p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="/admin/{{ $tenantSlug }}/plans" class="w-full py-2.5 px-4 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200 flex items-center justify-center gap-1.5 transition">
                            <span>Ver planes activos</span>
                        </a>
                    </div>
                </div>

                {{-- Caja Derecha: Uso de Beneficios Clínicos --}}
                <div class="avi-mid-box">
                    <div>
                        <div class="flex items-center justify-between mb-1 pb-1">
                            <div class="flex items-center gap-2">
                                <span class="text-blue-600 text-sm">💙</span>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white">
                                    Uso de beneficios clínicos
                                </h3>
                            </div>
                            <span class="text-xs font-medium text-slate-500">
                                0 / 19 utilizados (0%)
                            </span>
                        </div>

                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-xs text-slate-500">
                                Servicios canjeados este ciclo
                            </span>
                            <span class="text-[11px] font-bold text-cyan-800 bg-cyan-50 border border-cyan-200 px-2 py-0.5 rounded-md">
                                Meta clínica: &gt; 70%
                            </span>
                        </div>

                        <div class="py-6 text-center flex flex-col items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-slate-700 flex items-center justify-center text-xl mb-3 shadow-2xs">
                                📄
                            </div>
                            <h4 class="text-sm font-black text-slate-900 dark:text-white">
                                Sin canjes registrados todavía
                            </h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-xs leading-relaxed">
                                Cuando atiendas a un paciente en mostrador y le descuenten el servicio, aparecerá aquí en tiempo real.
                            </p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="{{ $redeemUrl }}" class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold flex items-center justify-center gap-1.5 transition shadow-sm">
                            <span>⚡ Abrir Terminal de Canje</span>
                        </a>
                    </div>
                </div>

            </div>

            {{-- 5. TARJETA INFERIOR: OPORTUNIDAD DE FIDELIZACIÓN (EXACTA AL MOCKUP) --}}
            <div class="rounded-2xl border border-teal-200/90 dark:border-teal-800/60 bg-gradient-to-r from-teal-50/60 via-white to-cyan-50/40 dark:from-slate-900 dark:via-slate-800/90 dark:to-blue-950/30 p-4 shadow-xs">
                <div class="flex items-center justify-between mb-2.5 pb-2 border-b border-teal-100 dark:border-slate-800 flex-wrap gap-2">
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-teal-500 text-white flex items-center justify-center text-[10px] font-bold">⭐</span>
                        <h3 class="text-sm font-black text-slate-900 dark:text-white">
                            Oportunidad de Fidelización
                        </h3>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-teal-50 dark:bg-teal-900/80 text-teal-700 dark:text-teal-200 border border-teal-200">
                            Recomendación
                        </span>
                    </div>
                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                        💡 Impacto: 1 oportunidad detectada
                    </span>
                </div>

                <div class="flex items-center justify-between gap-4 flex-wrap lg:flex-nowrap">
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed font-normal flex-1">
                        Te recomendamos contactar a María porque Max tiene 10/18 beneficios disponibles (como Kit Bienvenida, Cédula + Collar Placa + Carnet Digital) y no ha realizado una visita en los últimos 60 días.
                    </p>

                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ $recommendation['pet_url'] ?? '#' }}" 
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-xs">
                            <span>👁️</span>
                            <span>Ver Paciente</span>
                        </a>

                        <a href="{{ $redeemUrl }}" 
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 text-xs font-bold transition shadow-2xs">
                            <span>⚡</span>
                            <span>Canje en Recepción</span>
                        </a>

                        <span class="text-slate-400 font-bold text-lg cursor-pointer ml-1">&rsaquo;</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- =========================================================
             COLUMNA DERECHA: ASISTENTE IA BETA DEDICADO (EXACTO AL MOCKUP)
             ========================================================= --}}
        <div class="avi-ai-area">
            <div class="avi-ai-box">
                
                <div>
                    {{-- Header Asistente IA --}}
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-black tracking-tighter">iA</span>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">
                                Asistente IA
                            </h3>
                            <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-200">
                                Beta
                            </span>
                        </div>
                        <span class="text-slate-400 text-sm font-bold tracking-widest cursor-pointer">•••</span>
                    </div>

                    {{-- 3D Robot Graphic from Mockup with Aura and Stars --}}
                    <div class="flex flex-col items-center text-center py-3">
                        <div class="relative w-32 h-20 flex items-center justify-center mb-1">
                            <img src="/images/dashboard/robot_ai_2x.png" alt="Robot IA" class="h-16 w-auto object-contain drop-shadow-md" />
                        </div>

                        <h4 class="text-sm font-black text-slate-900 dark:text-white mt-1">
                            Hola, soy tu asistente de IA
                        </h4>
                        <p class="text-[11.5px] text-slate-500 dark:text-slate-400 mt-1 max-w-[260px] leading-relaxed">
                            Puedo ayudarte a crear planes, responder dudas de tus clientes, analizar datos y recomendar la mejor opción de salud para cada mascota.
                        </p>
                    </div>

                    {{-- 4 Quick Action Prompt Cards matching Mockup --}}
                    <div class="space-y-2 mt-2">
                        <button type="button" wire:click="selectPrompt('recomienda_plan')" class="avi-ai-prompt-card">
                            <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0">
                                👤
                            </div>
                            <span class="flex-1 text-[11px] font-semibold text-slate-700 dark:text-slate-200 text-left leading-tight">
                                Recomienda un plan ideal para un perro adulto
                            </span>
                            <span class="text-slate-400 font-bold text-sm shrink-0">&rsaquo;</span>
                        </button>

                        <button type="button" wire:click="selectPrompt('coberturas')" class="avi-ai-prompt-card">
                            <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0">
                                💬
                            </div>
                            <span class="flex-1 text-[11px] font-semibold text-slate-700 dark:text-slate-200 text-left leading-tight">
                                Responde dudas sobre coberturas y exclusiones
                            </span>
                            <span class="text-slate-400 font-bold text-sm shrink-0">&rsaquo;</span>
                        </button>

                        <button type="button" wire:click="selectPrompt('analiza_clientes')" class="avi-ai-prompt-card">
                            <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0">
                                📊
                            </div>
                            <span class="flex-1 text-[11px] font-semibold text-slate-700 dark:text-slate-200 text-left leading-tight">
                                Analiza la base de clientes y detecta oportunidades
                            </span>
                            <span class="text-slate-400 font-bold text-sm shrink-0">&rsaquo;</span>
                        </button>

                        <button type="button" wire:click="selectPrompt('plan_fidelizacion')" class="avi-ai-prompt-card">
                            <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0">
                                💡
                            </div>
                            <span class="flex-1 text-[11px] font-semibold text-slate-700 dark:text-slate-200 text-left leading-tight">
                                Genera un plan de fidelización para tus clientes
                            </span>
                            <span class="text-slate-400 font-bold text-sm shrink-0">&rsaquo;</span>
                        </button>
                    </div>

                    {{-- Chat History if user interacts --}}
                    @if(count($chatMessages) > 0)
                        <div class="space-y-2 max-h-36 overflow-y-auto mt-2.5 p-2 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                            @foreach($chatMessages as $msg)
                                <div class="text-[11px] {{ $msg['role'] === 'user' ? 'text-blue-600 font-bold text-right' : 'text-slate-700 dark:text-slate-300 leading-relaxed' }}">
                                    @if($msg['role'] === 'user')
                                        <span>{{ $msg['content'] }}</span>
                                    @else
                                        {!! \Illuminate\Support\Str::markdown($msg['content']) !!}
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Interactive Input Field & Footer --}}
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 space-y-1.5 mt-3">
                    <form wire:submit.prevent="sendChatMessage" class="relative flex items-center">
                        <input type="text" 
                               wire:model="chatInput"
                               placeholder="Escribe tu consulta..."
                               class="w-full text-xs rounded-full border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white pr-9 pl-3.5 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition shadow-2xs placeholder:text-slate-400" />
                        <button type="submit" 
                                class="absolute right-1 w-6 h-6 rounded-full bg-[#1e3a8a] hover:bg-blue-900 text-white flex items-center justify-center text-xs font-bold transition shadow-xs">
                            ➤
                        </button>
                    </form>

                    <div class="flex items-center gap-1.5 text-[10.5px] text-slate-400 justify-start pl-1">
                        <span>⏱</span>
                        <span>IA en preparación</span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-filament-panels::page>
