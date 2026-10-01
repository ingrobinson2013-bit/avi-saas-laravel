<x-filament-panels::page class="fi-dashboard-custom-page">
    <div class="avi-workspace">
        
        {{-- =========================================================
             COLUMNA IZQUIERDA: ÁREA DE OPERACIÓN PRINCIPAL
             ========================================================= --}}
        <div class="avi-main-area">
            
            {{-- 1. HERO WELCOME CARD --}}
            <div class="avi-hero-card">
                <div class="space-y-2">
                    <h1 class="avi-hero-title">
                        ¡Hola, {{ $greetingName }}! Bienvenida a {{ $brandName }} 👋
                    </h1>
                    <p class="avi-hero-sub">
                        Gestiona tus planes de salud, clientes y mascotas en un solo lugar.
                    </p>
                    <div class="avi-hero-badges">
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

                <!-- Right Mascot Photo with floating cyan heart -->
                <div class="avi-hero-mascot">
                    <div class="avi-floating-heart">💙</div>
                    <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?w=600&auto=format&fit=crop&q=80" 
                         alt="Cachorro Feliz" 
                         class="avi-hero-img" />
                </div>
            </div>

            {{-- 2. 4 KPI CARDS (EN 1 SOLA FILA HORIZONTAL) --}}
            <div class="avi-kpi-grid">
                <!-- KPI 1: MRR -->
                <div class="avi-kpi-card">
                    <div class="flex items-center justify-between">
                        <div class="avi-kpi-icon-badge bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                            $
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800">
                            <span>↗</span> +50K vs mes ant.
                        </span>
                    </div>
                    <div>
                        <div class="avi-kpi-val">${{ number_format($mrr, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400">COP</span></div>
                        <p class="avi-kpi-lbl">Ingresos recurrentes (MRR)</p>
                        <p class="avi-kpi-sub">Facturación proyectada mensual</p>
                    </div>
                </div>

                <!-- KPI 2: Mascotas Activas -->
                <div class="avi-kpi-card">
                    <div class="flex items-center justify-between">
                        <div class="avi-kpi-icon-badge bg-cyan-50 text-cyan-600 dark:bg-cyan-950/60 dark:text-cyan-400 border border-cyan-200 dark:border-cyan-800">
                            🐾
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-cyan-700 dark:text-cyan-400 bg-cyan-50 dark:bg-cyan-950/60 px-2 py-0.5 rounded-full border border-cyan-200 dark:border-cyan-800">
                            Activos
                        </span>
                    </div>
                    <div>
                        <div class="avi-kpi-val">{{ $petsCount }}</div>
                        <p class="avi-kpi-lbl">Mascotas activas</p>
                        <p class="avi-kpi-sub">{{ $activeSubsCount }} plan activo en cobertura</p>
                    </div>
                </div>

                <!-- KPI 3: Nuevas Afiliaciones -->
                <div class="avi-kpi-card">
                    <div class="flex items-center justify-between">
                        <div class="avi-kpi-icon-badge bg-purple-50 text-purple-600 dark:bg-purple-950/60 dark:text-purple-400 border border-purple-200 dark:border-purple-800">
                            📈
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-purple-700 dark:text-purple-400 bg-purple-50 dark:bg-purple-950/60 px-2 py-0.5 rounded-full border border-purple-200 dark:border-purple-800">
                            Este mes
                        </span>
                    </div>
                    <div>
                        <div class="avi-kpi-val">+{{ $newSubsThisMonth }}</div>
                        <p class="avi-kpi-lbl">Nuevas afiliaciones</p>
                        <p class="avi-kpi-sub">Adquisición últimos 30 días</p>
                    </div>
                </div>

                <!-- KPI 4: Renovaciones Próximas -->
                <div class="avi-kpi-card">
                    <div class="flex items-center justify-between">
                        <div class="avi-kpi-icon-badge bg-amber-50 text-amber-600 dark:bg-amber-950/60 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                            📅
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800">
                            ✓ Al día
                        </span>
                    </div>
                    <div>
                        <div class="avi-kpi-val">{{ $expiring15Days }}</div>
                        <p class="avi-kpi-lbl">Renovaciones próximas</p>
                        <p class="avi-kpi-sub">Próximos 15 días calendario</p>
                    </div>
                </div>
            </div>

            {{-- 3. ACCIONES RÁPIDAS (EN 1 SOLA FILA HORIZONTAL DE 4 TARJETAS) --}}
            <div>
                <div class="flex items-center justify-between mb-2 px-1">
                    <div class="flex items-center gap-2">
                        <span class="text-amber-500 text-xs">⚡</span>
                        <h3 class="text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Acciones Rápidas
                        </h3>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-400">
                        Operación Diaria
                    </span>
                </div>

                <div class="avi-actions-grid">
                    {{-- 1. Canjear Beneficio (Destacado Azul Royal) --}}
                    <a href="{{ $redeemUrl }}" class="avi-action-btn avi-action-blue">
                        <div class="flex items-center justify-between">
                            <div class="w-6 h-6 rounded-lg bg-white/20 backdrop-blur-xs flex items-center justify-center text-xs font-black border border-white/30">
                                💳
                            </div>
                            <span class="text-[9.5px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded-md bg-white/20 border border-white/30">
                                Mostrador
                            </span>
                        </div>
                        <div>
                            <h4 class="avi-action-title">Canjear Beneficio</h4>
                            <p class="avi-action-sub text-blue-100">
                                <span>Abrir terminal</span>
                                <span>→</span>
                            </p>
                        </div>
                    </a>

                    {{-- 2. Afiliar Mascota (Destacado Esmeralda / Teal) --}}
                    <a href="{{ $newSubUrl }}" class="avi-action-btn avi-action-green">
                        <div class="flex items-center justify-between">
                            <div class="w-6 h-6 rounded-lg bg-white/20 backdrop-blur-xs flex items-center justify-center text-xs font-black border border-white/30">
                                🐾
                            </div>
                            <span class="text-[9.5px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded-md bg-white/20 border border-white/30">
                                Membresía
                            </span>
                        </div>
                        <div>
                            <h4 class="avi-action-title">Afiliar Mascota</h4>
                            <p class="avi-action-sub text-emerald-100">
                                <span>Nueva afiliac.</span>
                                <span>→</span>
                            </p>
                        </div>
                    </a>

                    {{-- 3. Ver Portal Público (Tarjeta Blanca / B2C) --}}
                    <a href="{{ $portalUrl }}" target="_blank" class="avi-action-btn avi-action-white">
                        <div class="flex items-center justify-between">
                            <div class="w-6 h-6 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-black border border-blue-200 dark:border-blue-800">
                                🌐
                            </div>
                            <span class="text-[9.5px] font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/50 px-1.5 py-0.5 rounded-md border border-blue-200 dark:border-blue-900">
                                Web B2C
                            </span>
                        </div>
                        <div>
                            <h4 class="avi-action-title text-slate-900 dark:text-white">Ver Portal</h4>
                            <p class="avi-action-sub text-slate-500 dark:text-slate-400">
                                <span>Abrir portal</span>
                                <span>→</span>
                            </p>
                        </div>
                    </a>

                    {{-- 4. Imprimir QR Mostrador (Tarjeta Blanca / PDF) --}}
                    <a href="{{ $qrUrl }}" target="_blank" class="avi-action-btn avi-action-white">
                        <div class="flex items-center justify-between">
                            <div class="w-6 h-6 rounded-lg bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xs font-black border border-purple-200 dark:border-purple-800">
                                🖨️
                            </div>
                            <span class="text-[9.5px] font-bold text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-950/50 px-1.5 py-0.5 rounded-md border border-purple-200 dark:border-purple-900">
                                Generar PDF
                            </span>
                        </div>
                        <div>
                            <h4 class="avi-action-title text-slate-900 dark:text-white">Imprimir QR</h4>
                            <p class="avi-action-sub text-slate-500 dark:text-slate-400">
                                <span>Afiche mostrador</span>
                                <span>→</span>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- 4. FILA MEDIA: RENOVACIONES PRÓXIMAS & USO DE BENEFICIOS --}}
            <div class="avi-mid-grid">
                
                {{-- Caja Izquierda: Renovaciones Próximas --}}
                <div class="avi-mid-box">
                    <div>
                        <div class="flex items-center justify-between mb-3 pb-2.5 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-2">
                                <span class="text-amber-500 text-sm">🔔</span>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white">
                                    Renovaciones próximas
                                </h3>
                            </div>
                            <a href="/admin/{{ $tenantSlug }}/subscriptions" class="text-xs font-bold text-blue-600 dark:text-cyan-400 hover:underline flex items-center gap-1">
                                <span>Ver todas</span>
                                <span>→</span>
                            </a>
                        </div>

                        {{-- Empty State Limpio con Icono de Calendario --}}
                        <div class="py-5 text-center flex flex-col items-center justify-center">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-2xl mb-2 text-slate-400">
                                📅
                            </div>
                            <h4 class="text-xs sm:text-sm font-black text-slate-800 dark:text-slate-200">
                                Sin vencimientos en los próximos 15 días
                            </h4>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1 max-w-xs">
                                No tienes renovaciones pendientes. Siguiente revisión automática: mañana 08:00 AM
                            </p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="/admin/{{ $tenantSlug }}/plans" class="w-full py-2 px-3 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center justify-center gap-1.5 transition">
                            <span>Ver planes activos</span>
                            <span>›</span>
                        </a>
                    </div>
                </div>

                {{-- Caja Derecha: Uso de Beneficios Clínicos --}}
                <div class="avi-mid-box">
                    <div>
                        <div class="flex items-center justify-between mb-3 pb-2.5 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-2">
                                <span class="text-cyan-500 text-sm">💙</span>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white">
                                    Uso de beneficios clínicos
                                </h3>
                            </div>
                            <span class="text-xs font-black px-2 py-0.5 rounded-full bg-cyan-50 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300 border border-cyan-200 dark:border-cyan-800">
                                {{ $totalUsed }} / {{ $totalGranted }} ({{ $usagePercent }}%)
                            </span>
                        </div>

                        {{-- Barra de Progreso Visual --}}
                        <div class="space-y-1.5 my-3">
                            <div class="flex items-center justify-between text-xs font-bold text-slate-600 dark:text-slate-300">
                                <span>Progreso de redención</span>
                                <span class="text-cyan-600 dark:text-cyan-400">{{ $usagePercent }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-2.5 rounded-full transition-all duration-500" 
                                     style="width: {{ max(4, $usagePercent) }}%"></div>
                            </div>
                            <p class="text-[11px] text-slate-400 font-medium">Servicios canjeados este ciclo de facturación</p>
                        </div>

                        <p class="text-xs text-slate-500 dark:text-slate-400 text-center py-2">
                            Sin canjes registrados en este ciclo. Invita al tutor a redimir sus consultas.
                        </p>
                    </div>

                    <div class="pt-2">
                        <a href="{{ $redeemUrl }}" class="w-full py-2 px-3 rounded-xl bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-100 dark:hover:bg-blue-900/60 border border-blue-200 dark:border-blue-800 text-xs font-bold text-blue-700 dark:text-blue-300 flex items-center justify-center gap-1.5 transition">
                            <span>⚡ Abrir Terminal de Canje</span>
                            <span>›</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- 5. TARJETA INFERIOR: OPORTUNIDAD DE FIDELIZACIÓN (AVI RECOMIENDA) --}}
            <div class="rounded-2xl border border-blue-200/80 dark:border-blue-800/60 bg-gradient-to-r from-blue-50/70 via-white to-cyan-50/60 dark:from-slate-900 dark:via-slate-800/90 dark:to-blue-950/30 p-5 shadow-xs">
                <div class="flex items-center justify-between mb-3 pb-2.5 border-b border-blue-100 dark:border-slate-800 flex-wrap gap-2">
                    <div class="flex items-center gap-2">
                        <span class="text-lg text-amber-500">⭐</span>
                        <h3 class="text-sm font-black text-slate-900 dark:text-white">
                            Oportunidad de Fidelización
                        </h3>
                        <span class="text-[10.5px] font-black px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-900/80 text-blue-800 dark:text-blue-200 uppercase tracking-wider">
                            Recomendación IA
                        </span>
                    </div>
                    <span class="text-xs font-bold text-blue-700 dark:text-cyan-300 bg-white/80 dark:bg-slate-800 px-2.5 py-0.5 rounded-full border border-blue-200 dark:border-blue-800 shadow-2xs">
                        💡 Impacto: {{ $recommendation['impact_text'] ?? '1 oportunidad detectada' }}
                    </span>
                </div>

                <div class="space-y-3">
                    <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-200 leading-relaxed font-medium">
                        {{ $recommendation['title'] ?? 'Tienes 1 paciente con beneficios disponibles sin redimir.' }}
                    </p>

                    <div class="flex items-center gap-2.5 flex-wrap pt-1">
                        <a href="{{ $recommendation['pet_url'] ?? '#' }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200 transition shadow-2xs">
                            <span>👁️</span>
                            <span>Ver Paciente ({{ $recommendation['pet_name'] ?? 'Mascota' }})</span>
                        </a>

                        <a href="{{ $redeemUrl }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-xs font-bold text-blue-600 dark:text-cyan-400 transition shadow-2xs">
                            <span>⚡</span>
                            <span>Canje en Recepción</span>
                        </a>

                        @if(!empty($recommendation['whatsapp_url']))
                            <a href="{{ $recommendation['whatsapp_url'] }}" target="_blank"
                               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-xs">
                                <span>💬</span>
                                <span>Enviar WhatsApp a {{ $recommendation['customer_name'] ?? 'Tutor' }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- =========================================================
             COLUMNA DERECHA: ASISTENTE IA BETA DEDICADO
             ========================================================= --}}
        <div class="avi-ai-area">
            <div class="avi-ai-box">
                
                <div class="space-y-4">
                    {{-- Header Asistente IA --}}
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <span class="text-lg">🤖</span>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">
                                Asistente IA
                            </h3>
                            <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 text-white shadow-2xs">
                                Beta
                            </span>
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 dark:text-emerald-400">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>En línea</span>
                        </span>
                    </div>

                    {{-- 3D Robot Avatar Section --}}
                    <div class="flex flex-col items-center text-center py-2">
                        <div class="relative w-20 h-20 mb-2 flex items-center justify-center">
                            <!-- Glowing halo ring -->
                            <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-cyan-400/20 via-blue-500/20 to-purple-500/20 blur-md animate-pulse"></div>
                            
                            <!-- Sleek 3D Robot SVG -->
                            <div class="relative z-10 w-16 h-16 rounded-2xl bg-gradient-to-b from-slate-800 to-slate-950 p-2 shadow-lg border border-cyan-400/30 flex items-center justify-center">
                                <svg class="w-12 h-12" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Robot Antenna -->
                                    <circle cx="32" cy="8" r="3.5" fill="#06b6d4" />
                                    <line x1="32" y1="11.5" x2="32" y2="18" stroke="#38bdf8" stroke-width="2.5" stroke-linecap="round" />
                                    <!-- Head Shell -->
                                    <rect x="14" y="18" width="36" height="30" rx="10" fill="url(#bot_head_grad_modal)" stroke="#0ea5e9" stroke-width="1.5" />
                                    <!-- Glossy Visor Screen -->
                                    <rect x="18" y="24" width="28" height="15" rx="6" fill="#0b132b" />
                                    <!-- Robot Glowing Eyes -->
                                    <circle cx="26" cy="31" r="3" fill="#22d3ee" />
                                    <circle cx="38" cy="31" r="3" fill="#22d3ee" />
                                    <!-- Smile / Mouth -->
                                    <path d="M28 35C29.5 36.2 34.5 36.2 36 35" stroke="#38bdf8" stroke-width="1.8" stroke-linecap="round" />
                                    <!-- Ear Nodes -->
                                    <rect x="10" y="27" width="4" height="10" rx="2" fill="#38bdf8" />
                                    <rect x="50" y="27" width="4" height="10" rx="2" fill="#38bdf8" />
                                    <path d="M24 51L22 58H42L40 51" fill="#0284c7" />
                                    <defs>
                                        <linearGradient id="bot_head_grad_modal" x1="14" y1="18" x2="50" y2="48" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#1e293b"/>
                                            <stop offset="1" stop-color="#0f172a"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                        </div>

                        <!-- Warm Speech Bubble -->
                        <div class="relative bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-3 shadow-2xs">
                            <p class="text-xs text-slate-700 dark:text-slate-200 font-medium leading-relaxed">
                                "¡Hola! Soy tu asistente de IA de AVI. Puedo responder dudas, redactar recordatorios para tutores o sugerir promociones clínicas."
                            </p>
                        </div>
                    </div>

                    {{-- Quick Action Prompt Pills (4 Cards with Chevrons) --}}
                    <div class="space-y-2">
                        <button type="button" wire:click="selectPrompt('mrr')" class="avi-prompt-pill">
                            <span>📊 ¿Cómo va el MRR de este mes?</span>
                            <span class="text-slate-400 font-bold">›</span>
                        </button>

                        <button type="button" wire:click="selectPrompt('whatsapp')" class="avi-prompt-pill">
                            <span>💬 Redactar WhatsApp para María (Max)</span>
                            <span class="text-slate-400 font-bold">›</span>
                        </button>

                        <button type="button" wire:click="selectPrompt('renewals')" class="avi-prompt-pill">
                            <span>📅 ¿Qué planes vencen esta semana?</span>
                            <span class="text-slate-400 font-bold">›</span>
                        </button>

                        <button type="button" wire:click="selectPrompt('promo')" class="avi-prompt-pill">
                            <span>💡 Sugerir promoción para nuevos tutores</span>
                            <span class="text-slate-400 font-bold">›</span>
                        </button>
                    </div>

                    {{-- Chat History if user interacts --}}
                    @if(count($chatMessages) > 0)
                        <div class="space-y-2.5 max-h-48 overflow-y-auto p-2 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200/80 dark:border-slate-700">
                            @foreach($chatMessages as $msg)
                                @if($msg['role'] === 'user')
                                    <div class="flex justify-end">
                                        <div class="bg-blue-600 text-white text-[11.5px] font-medium px-3 py-1.5 rounded-xl rounded-br-xs max-w-[85%] shadow-2xs">
                                            {{ $msg['content'] }}
                                        </div>
                                    </div>
                                @else
                                    <div class="flex justify-start">
                                        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-[11.5px] font-medium px-3 py-2 rounded-xl rounded-bl-xs max-w-[95%] shadow-2xs leading-relaxed prose dark:prose-invert prose-xs">
                                            {!! \Illuminate\Support\Str::markdown($msg['content']) !!}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Interactive Input Field & Footer --}}
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 space-y-2 mt-2">
                    <form wire:submit.prevent="sendChatMessage" class="relative flex items-center">
                        <input type="text" 
                               wire:model="chatInput"
                               placeholder="Escribe tu consulta a la IA..."
                               class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white pr-9 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                        <button type="submit" 
                                class="absolute right-1.5 w-6 h-6 rounded-lg bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center text-xs font-bold transition shadow-2xs">
                            ➤
                        </button>
                    </form>

                    <div class="flex items-center justify-center gap-1.5 text-[10px] text-slate-400 font-semibold">
                        <span>⏱ Modelo AVI PetOps v1.2 · Respuestas en tiempo real</span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-filament-panels::page>
