<x-filament-panels::page class="fi-dashboard-custom-page">
    <div class="avi-workspace-layout">
        
        {{-- =========================================================
             COLUMNA IZQUIERDA: ÁREA DE OPERACIÓN PRINCIPAL (~72%)
             ========================================================= --}}
        <div class="avi-main-column">
            
            {{-- 1. HERO WELCOME CARD --}}
            <div class="relative overflow-hidden rounded-2xl border border-cyan-100 dark:border-cyan-900/40 bg-gradient-to-r from-cyan-50/80 via-sky-50/40 to-white dark:from-slate-900 dark:via-slate-800/80 dark:to-cyan-950/30 p-5 sm:p-6 shadow-sm">
                <!-- Ambient radial light -->
                <div class="absolute -right-10 -top-10 w-60 h-60 bg-cyan-400/15 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <!-- Text and status badges -->
                    <div class="max-w-xl space-y-2">
                        <h1 class="text-xl sm:text-2xl md:text-[26px] font-black tracking-tight text-slate-900 dark:text-white leading-snug">
                            ¡Hola, {{ $greetingName }}! Bienvenida a {{ $brandName }} 👋
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-medium">
                            Gestiona tus planes de salud, clientes y mascotas en un solo lugar.
                        </p>
                        <div class="flex items-center gap-2 flex-wrap pt-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/90 dark:bg-slate-800/90 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 shadow-2xs">
                                <span>📍</span>
                                <span>Sede {{ $cleanCity }} · {{ $formattedDate }}</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-cyan-500/10 text-cyan-800 dark:text-cyan-200 border border-cyan-300 dark:border-cyan-800">
                                <span>⏱</span>
                                <span>Modo Sincronizado</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/70 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 shadow-2xs">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                <span>Sistema en línea</span>
                            </span>
                        </div>
                    </div>

                    <!-- Right Mascot Illustration with floating cyan heart -->
                    <div class="relative shrink-0 flex items-center justify-center md:justify-end self-center md:self-auto mt-2 md:mt-0">
                        <!-- Floating cyan heart doodle -->
                        <div class="absolute -top-3 left-4 sm:left-6 z-20 animate-bounce duration-1000">
                            <span class="text-2xl drop-shadow-md">💙</span>
                        </div>
                        <!-- Pet photo container -->
                        <div class="relative w-44 sm:w-52 h-32 sm:h-36 rounded-2xl overflow-hidden shadow-md border-2 border-white dark:border-slate-700 bg-cyan-100/40">
                            <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&w=600&q=80" 
                                 alt="Mascotas felices AVI" 
                                 class="w-full h-full object-cover object-center transform hover:scale-105 transition-transform duration-500" />
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/30 via-transparent to-transparent"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. 4 KPI CARDS (EN 1 SOLA FILA HORIZONTAL) --}}
            <div class="avi-kpi-row">
                <!-- KPI 1: MRR -->
                <div class="relative overflow-hidden rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 sm:p-5 shadow-xs hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg font-black border border-emerald-500/20">
                            $
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800">
                            <span>↗</span> +50K vs mes ant.
                        </span>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">${{ number_format($mrr, 0, ',', '.') }}</span>
                            <span class="text-xs font-bold text-slate-400 uppercase">COP</span>
                        </div>
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Ingresos recurrentes (MRR)</p>
                        <p class="text-[11px] text-slate-400 font-medium">Facturación proyectada mensual</p>
                    </div>
                </div>

                <!-- KPI 2: Mascotas Activas -->
                <div class="relative overflow-hidden rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 sm:p-5 shadow-xs hover:shadow-md transition-all">
                    <!-- Paw watermark -->
                    <span class="absolute -right-2 -bottom-2 text-6xl text-cyan-500/5 select-none pointer-events-none font-black">🐾</span>
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-9 h-9 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-lg font-black border border-cyan-500/20">
                            🐾
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-cyan-700 dark:text-cyan-400 bg-cyan-50 dark:bg-cyan-950/60 px-2 py-0.5 rounded-full border border-cyan-200 dark:border-cyan-800">
                            Activos
                        </span>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">{{ $petsCount }}</span>
                        </div>
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Mascotas activas</p>
                        <p class="text-[11px] text-slate-400 font-medium">{{ $activeSubsCount }} plan activo en cobertura</p>
                    </div>
                </div>

                <!-- KPI 3: Nuevas Afiliaciones -->
                <div class="relative overflow-hidden rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 sm:p-5 shadow-xs hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-9 h-9 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg font-black border border-purple-500/20">
                            📈
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-purple-700 dark:text-purple-400 bg-purple-50 dark:bg-purple-950/60 px-2 py-0.5 rounded-full border border-purple-200 dark:border-purple-800">
                            Este mes
                        </span>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">+{{ $newSubsThisMonth }}</span>
                        </div>
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Nuevas afiliaciones</p>
                        <p class="text-[11px] text-slate-400 font-medium">Adquisición últimos 30 días</p>
                    </div>
                </div>

                <!-- KPI 4: Renovaciones Próximas -->
                <div class="relative overflow-hidden rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 sm:p-5 shadow-xs hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg font-black border border-amber-500/20">
                            📅
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800">
                            ✓ Al día
                        </span>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">{{ $expiring15Days }}</span>
                        </div>
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Renovaciones próximas</p>
                        <p class="text-[11px] text-slate-400 font-medium">Próximos 15 días calendario</p>
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

                <div class="avi-ops-row">
                    {{-- 1. Canjear Beneficio (Destacado Azul Royal) --}}
                    <a href="{{ $redeemUrl }}" 
                       class="group relative overflow-hidden rounded-xl p-3 sm:p-3.5 flex flex-col justify-between h-[96px] text-white shadow-xs hover:shadow-md transition-all transform hover:-translate-y-0.5 border border-blue-600/50"
                       style="background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 55%, #0284c7 100%) !important;">
                        <div class="flex items-center justify-between">
                            <div class="w-7 h-7 rounded-lg bg-white/20 backdrop-blur-xs flex items-center justify-center text-sm font-black border border-white/30 shrink-0">
                                💳
                            </div>
                            <span class="text-[9.5px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded-md bg-white/20 border border-white/30 backdrop-blur-xs">
                                Mostrador
                            </span>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-white leading-tight truncate">Canjear Beneficio</h4>
                            <p class="text-[11px] font-bold text-blue-100 flex items-center justify-between mt-0.5">
                                <span>Abrir terminal</span>
                                <span class="transform group-hover:translate-x-1 transition-transform font-black">→</span>
                            </p>
                        </div>
                    </a>

                    {{-- 2. Afiliar Mascota (Destacado Esmeralda / Teal) --}}
                    <a href="{{ $newSubUrl }}" 
                       class="group relative overflow-hidden rounded-xl p-3 sm:p-3.5 flex flex-col justify-between h-[96px] text-white shadow-xs hover:shadow-md transition-all transform hover:-translate-y-0.5 border border-emerald-600/50"
                       style="background: linear-gradient(135deg, #059669 0%, #0d9488 55%, #0284c7 100%) !important;">
                        <div class="flex items-center justify-between">
                            <div class="w-7 h-7 rounded-lg bg-white/20 backdrop-blur-xs flex items-center justify-center text-sm font-black border border-white/30 shrink-0">
                                🐾
                            </div>
                            <span class="text-[9.5px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded-md bg-white/20 border border-white/30 backdrop-blur-xs">
                                Membresía
                            </span>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-white leading-tight truncate">Afiliar Mascota</h4>
                            <p class="text-[11px] font-bold text-emerald-100 flex items-center justify-between mt-0.5">
                                <span>Nueva afiliac.</span>
                                <span class="transform group-hover:translate-x-1 transition-transform font-black">→</span>
                            </p>
                        </div>
                    </a>

                    {{-- 3. Ver Portal Público (Tarjeta Blanca / B2C) --}}
                    <a href="{{ $portalUrl }}" target="_blank"
                       class="group rounded-xl p-3 sm:p-3.5 flex flex-col justify-between h-[96px] bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-2xs hover:border-blue-500/60 hover:shadow-xs transition-all transform hover:-translate-y-0.5">
                        <div class="flex items-center justify-between">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm font-black border border-blue-200 dark:border-blue-800 shrink-0">
                                🌐
                            </div>
                            <span class="text-[9.5px] font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/50 px-1.5 py-0.5 rounded-md border border-blue-200 dark:border-blue-900">
                                Web B2C
                            </span>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors leading-tight truncate">Ver Portal</h4>
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 flex items-center justify-between mt-0.5">
                                <span>Abrir portal</span>
                                <span class="transform group-hover:translate-x-1 transition-transform font-black">→</span>
                            </p>
                        </div>
                    </a>

                    {{-- 4. Imprimir QR Mostrador (Tarjeta Blanca / PDF) --}}
                    <a href="{{ $qrUrl }}" target="_blank"
                       class="group rounded-xl p-3 sm:p-3.5 flex flex-col justify-between h-[96px] bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-2xs hover:border-purple-500/60 hover:shadow-xs transition-all transform hover:-translate-y-0.5">
                        <div class="flex items-center justify-between">
                            <div class="w-7 h-7 rounded-lg bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-sm font-black border border-purple-200 dark:border-purple-800 shrink-0">
                                🖨️
                            </div>
                            <span class="text-[9.5px] font-bold text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-950/50 px-1.5 py-0.5 rounded-md border border-purple-200 dark:border-purple-900">
                                Generar PDF
                            </span>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors leading-tight truncate">Imprimir QR</h4>
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 flex items-center justify-between mt-0.5">
                                <span>Afiche mostrador</span>
                                <span class="transform group-hover:translate-x-1 transition-transform font-black">→</span>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- 4. FILA MEDIA: RENOVACIONES PRÓXIMAS & USO DE BENEFICIOS --}}
            <div class="avi-middle-row">
                
                {{-- Caja Izquierda: Renovaciones Próximas --}}
                <div class="rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-xs flex flex-col justify-between">
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
                            <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200">
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
                <div class="rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-xs flex flex-col justify-between">
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
             COLUMNA DERECHA: ASISTENTE IA BETA DEDICADO (~28% / 330px)
             ========================================================= --}}
        <div class="avi-ai-column">
            <div class="rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-xs flex flex-col justify-between min-h-[580px]">
                
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
                        <div class="relative w-24 h-24 mb-2 flex items-center justify-center">
                            <!-- Glowing halo ring -->
                            <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-cyan-400/20 via-blue-500/20 to-purple-500/20 blur-md animate-pulse"></div>
                            
                            <!-- Sleek 3D Robot SVG -->
                            <div class="relative z-10 w-20 h-20 rounded-2xl bg-gradient-to-b from-slate-800 to-slate-950 p-2 shadow-lg border border-cyan-400/30 flex items-center justify-center">
                                <svg class="w-14 h-14" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Robot Antenna -->
                                    <circle cx="32" cy="8" r="3.5" fill="#06b6d4" />
                                    <line x1="32" y1="11.5" x2="32" y2="18" stroke="#38bdf8" stroke-width="2.5" stroke-linecap="round" />
                                    <!-- Head Shell -->
                                    <rect x="14" y="18" width="36" height="30" rx="10" fill="url(#bot_head_grad)" stroke="#0ea5e9" stroke-width="1.5" />
                                    <!-- Glossy Visor Screen -->
                                    <rect x="18" y="24" width="28" height="15" rx="6" fill="#0b132b" />
                                    <!-- Robot Glowing Eyes -->
                                    <circle cx="26" cy="31" r="3" fill="#22d3ee">
                                        <animate attributeName="opacity" values="1;0.4;1" dur="2.5s" repeatCount="indefinite" />
                                    </circle>
                                    <circle cx="38" cy="31" r="3" fill="#22d3ee">
                                        <animate attributeName="opacity" values="1;0.4;1" dur="2.5s" repeatCount="indefinite" />
                                    </circle>
                                    <!-- Smile / Mouth -->
                                    <path d="M28 35C29.5 36.2 34.5 36.2 36 35" stroke="#38bdf8" stroke-width="1.8" stroke-linecap="round" />
                                    <!-- Ear Nodes / Audio receptors -->
                                    <rect x="10" y="27" width="4" height="10" rx="2" fill="#38bdf8" />
                                    <rect x="50" y="27" width="4" height="10" rx="2" fill="#38bdf8" />
                                    <!-- Neck / Body Accent -->
                                    <path d="M24 51L22 58H42L40 51" fill="#0284c7" />
                                    <defs>
                                        <linearGradient id="bot_head_grad" x1="14" y1="18" x2="50" y2="48" gradientUnits="userSpaceOnUse">
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
                        <button type="button" 
                                wire:click="selectPrompt('mrr')"
                                class="w-full text-left p-2.5 rounded-xl border border-slate-200/80 dark:border-slate-800 hover:border-blue-400 dark:hover:border-blue-600 bg-white dark:bg-slate-800/50 hover:bg-blue-50/50 dark:hover:bg-slate-800 transition flex items-center justify-between group shadow-2xs">
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-cyan-400">
                                📊 ¿Cómo va el MRR de este mes?
                            </span>
                            <span class="text-slate-400 group-hover:text-blue-600 dark:group-hover:text-cyan-400 font-bold transition">›</span>
                        </button>

                        <button type="button" 
                                wire:click="selectPrompt('whatsapp')"
                                class="w-full text-left p-2.5 rounded-xl border border-slate-200/80 dark:border-slate-800 hover:border-emerald-400 dark:hover:border-emerald-600 bg-white dark:bg-slate-800/50 hover:bg-emerald-50/50 dark:hover:bg-slate-800 transition flex items-center justify-between group shadow-2xs">
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400">
                                💬 Redactar WhatsApp para María (Max)
                            </span>
                            <span class="text-slate-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 font-bold transition">›</span>
                        </button>

                        <button type="button" 
                                wire:click="selectPrompt('renewals')"
                                class="w-full text-left p-2.5 rounded-xl border border-slate-200/80 dark:border-slate-800 hover:border-amber-400 dark:hover:border-amber-600 bg-white dark:bg-slate-800/50 hover:bg-amber-50/50 dark:hover:bg-slate-800 transition flex items-center justify-between group shadow-2xs">
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">
                                📅 ¿Qué planes vencen esta semana?
                            </span>
                            <span class="text-slate-400 group-hover:text-amber-600 dark:group-hover:text-amber-400 font-bold transition">›</span>
                        </button>

                        <button type="button" 
                                wire:click="selectPrompt('promo')"
                                class="w-full text-left p-2.5 rounded-xl border border-slate-200/80 dark:border-slate-800 hover:border-purple-400 dark:hover:border-purple-600 bg-white dark:bg-slate-800/50 hover:bg-purple-50/50 dark:hover:bg-slate-800 transition flex items-center justify-between group shadow-2xs">
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200 group-hover:text-purple-600 dark:group-hover:text-purple-400">
                                💡 Sugerir promoción para nuevos tutores
                            </span>
                            <span class="text-slate-400 group-hover:text-purple-600 dark:group-hover:text-purple-400 font-bold transition">›</span>
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
