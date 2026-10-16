<x-filament-panels::page class="fi-dashboard-custom-page">
    <div class="space-y-6">

        {{-- =========================================================
             1. HEADER: TÍTULO Y SUBTÍTULO (CENTRO DE CONTROL)
             ========================================================= --}}
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Centro de control
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Resumen de la red AVI Pet
            </p>
        </div>

        {{-- =========================================================
             2. FILA 1: 4 TARJETAS DE MÉTRICAS (MOCKUP EXACTO)
             ========================================================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Tarjeta 1: Clínicas activas --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/90 dark:border-slate-700/80 p-5 shadow-xs transition hover:shadow-md">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                            Clínicas activas
                        </div>
                        <div class="text-2xl font-black text-slate-900 dark:text-white leading-tight mt-0.5">
                            {{ $clinicasActivas }}
                        </div>
                        <div class="flex items-center gap-1 text-[11px] font-semibold text-teal-600 dark:text-teal-400 mt-1">
                            <span>&uarr; 100%</span>
                            <span class="text-slate-400 font-normal">vs. mes anterior</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tarjeta 2: Mascotas con membresía --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/90 dark:border-slate-700/80 p-5 shadow-xs transition hover:shadow-md">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-full bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                            <ellipse cx="6.5" cy="7.5" rx="2" ry="2.7" />
                            <ellipse cx="11" cy="5" rx="2" ry="2.7" />
                            <ellipse cx="16" cy="5.5" rx="2" ry="2.7" />
                            <ellipse cx="19.5" cy="8.5" rx="1.8" ry="2.5" />
                            <path d="M12 10.5c-3.2 0-5.8 2.2-5.8 5.2 0 2.2 1.6 3.8 3.5 3.8 1.1 0 1.8-.6 2.3-.6.5 0 1.2.6 2.3.6 1.9 0 3.5-1.6 3.5-3.8 0-3-2.6-5.2-5.8-5.2z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                            Mascotas con membresía
                        </div>
                        <div class="text-2xl font-black text-slate-900 dark:text-white leading-tight mt-0.5">
                            {{ $mascotasConMembresia }}
                        </div>
                        <div class="flex items-center gap-1 text-[11px] font-semibold text-teal-600 dark:text-teal-400 mt-1">
                            <span>&uarr; 33%</span>
                            <span class="text-slate-400 font-normal">vs. mes anterior</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tarjeta 3: MRR --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/90 dark:border-slate-700/80 p-5 shadow-xs transition hover:shadow-md">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                            MRR
                        </div>
                        <div class="text-2xl font-black text-slate-900 dark:text-white leading-tight mt-0.5">
                            ${{ number_format($mrr, 0, ',', '.') }} <span class="text-xs font-bold text-slate-500">COP</span>
                        </div>
                        <div class="flex items-center gap-1 text-[11px] font-semibold text-teal-600 dark:text-teal-400 mt-1">
                            <span>&uarr; 12%</span>
                            <span class="text-slate-400 font-normal">vs. mes anterior</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tarjeta 4: GMV mensual --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/90 dark:border-slate-700/80 p-5 shadow-xs transition hover:shadow-md">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-full bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                            GMV mensual
                        </div>
                        <div class="text-2xl font-black text-slate-900 dark:text-white leading-tight mt-0.5">
                            ${{ number_format($gmv, 0, ',', '.') }} <span class="text-xs font-bold text-slate-500">COP</span>
                        </div>
                        <div class="flex items-center gap-1 text-[11px] font-semibold text-teal-600 dark:text-teal-400 mt-1">
                            <span>&uarr; 18%</span>
                            <span class="text-slate-400 font-normal">vs. mes anterior</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- =========================================================
             3. FILA 2: PIPELINE COMERCIAL (BANNER GRANDE)
             ========================================================= --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/90 dark:border-slate-700/80 p-6 shadow-xs">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">

                {{-- Columna Izquierda: Título de sección --}}
                <div class="w-full lg:w-1/4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white leading-tight">
                                Pipeline comercial
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Gestiona tus oportunidades y haz crecer la red de clínicas.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Columna Central: Estado Vacío con CTA --}}
                <div class="w-full lg:w-1/2 flex flex-col items-center text-center px-4">
                    {{-- Ilustración de Documento con Plus verde --}}
                    <div class="relative w-14 h-14 flex items-center justify-center mb-1">
                        <div class="w-11 h-13 rounded-lg bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 flex flex-col justify-center px-2 py-2 gap-1.5 shadow-2xs">
                            <div class="h-1 bg-slate-300 dark:bg-slate-500 rounded-sm w-3/4"></div>
                            <div class="h-1 bg-slate-300 dark:bg-slate-500 rounded-sm w-full"></div>
                            <div class="h-1 bg-slate-300 dark:bg-slate-500 rounded-sm w-2/3"></div>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold text-sm shadow-xs ring-2 ring-white dark:ring-slate-800">
                            +
                        </div>
                    </div>

                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 mt-2">
                        No hay oportunidades registradas
                    </h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mt-1 leading-relaxed">
                        Aún no tienes demos, leads u oportunidades en el pipeline comercial. Empieza a generar nuevas oportunidades para hacer crecer AVI Pet.
                    </p>

                    <a href="/super-admin/prospecto-veterinarias/create" 
                       class="mt-3.5 inline-flex items-center gap-1.5 px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-lg shadow-sm transition hover:scale-102">
                        <span>Registrar oportunidad</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                {{-- Columna Derecha: Contadores Demos y Cobros --}}
                <div class="w-full lg:w-1/4 flex items-center justify-around lg:justify-end gap-6 sm:gap-8 pt-4 lg:pt-0 border-t lg:border-t-0 lg:border-l border-slate-100 dark:border-slate-700/70 lg:pl-6">
                    {{-- Demos Próximas --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                Demos próximas
                            </div>
                            <div class="text-2xl font-black text-slate-900 dark:text-white leading-tight">
                                {{ $demosProximas }}
                            </div>
                        </div>
                    </div>

                    {{-- Cobros Pendientes --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                Cobros pendientes
                            </div>
                            <div class="text-2xl font-black text-slate-900 dark:text-white leading-tight">
                                {{ $cobrosPendientes }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- =========================================================
             4. FILA 3: DOS GRÁFICAS ANALÍTICAS (MRR + DISTRIBUCIÓN)
             ========================================================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            {{-- Gráfica Izquierda: Ingresos recurrentes (Área MRR) --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/90 dark:border-slate-700/80 p-5 sm:p-6 shadow-xs">
                {{-- Header de la gráfica --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white leading-tight">
                                Ingresos recurrentes
                            </h3>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                                MRR en los últimos 6 meses
                            </p>
                        </div>
                    </div>

                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-700/60 border border-slate-200 dark:border-slate-600 rounded-lg cursor-pointer">
                            <span>Últimos 6 meses</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Chart SVG Responsivo Exacto del Mockup --}}
                <div class="w-full pt-2">
                    <svg viewBox="0 0 600 240" class="w-full h-auto overflow-visible" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="mrrTealGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#0d9488" stop-opacity="0.22" />
                                <stop offset="100%" stop-color="#0d9488" stop-opacity="0.01" />
                            </linearGradient>
                        </defs>

                        {{-- Líneas horizontales de guía (Grid) y Etiquetas Y --}}
                        {{-- $350.000 --}}
                        <text x="50" y="24" fill="#94a3b8" font-size="10.5" text-anchor="end" font-weight="500">$350.000</text>
                        <line x1="60" y1="20" x2="580" y2="20" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3" />

                        {{-- $262.500 --}}
                        <text x="50" y="69" fill="#94a3b8" font-size="10.5" text-anchor="end" font-weight="500">$262.500</text>
                        <line x1="60" y1="65" x2="580" y2="65" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3" />

                        {{-- $175.000 --}}
                        <text x="50" y="114" fill="#94a3b8" font-size="10.5" text-anchor="end" font-weight="500">$175.000</text>
                        <line x1="60" y1="110" x2="580" y2="110" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3" />

                        {{-- $87.500 --}}
                        <text x="50" y="159" fill="#94a3b8" font-size="10.5" text-anchor="end" font-weight="500">$87.500</text>
                        <line x1="60" y1="155" x2="580" y2="155" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3" />

                        {{-- $0 --}}
                        <text x="50" y="204" fill="#94a3b8" font-size="10.5" text-anchor="end" font-weight="500">$0</text>
                        <line x1="60" y1="200" x2="580" y2="200" stroke="#e2e8f0" stroke-width="1" />

                        {{-- Área bajo la curva con gradiente teal --}}
                        <path d="M 85 190 Q 185 180 285 170 T 385 150 T 485 130 T 550 95 L 550 200 L 85 200 Z"
                              fill="url(#mrrTealGradient)" />

                        {{-- Línea principal teal curvada suave --}}
                        <path d="M 85 190 Q 185 180 285 170 T 385 150 T 485 130 T 550 95"
                              fill="none" stroke="#0d9488" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />

                        {{-- Puntos de datos (Dots) --}}
                        <circle cx="85" cy="190" r="4" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                        <circle cx="185" cy="180" r="4" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                        <circle cx="285" cy="170" r="4" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                        <circle cx="385" cy="150" r="4" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                        <circle cx="485" cy="130" r="4" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                        <circle cx="550" cy="95" r="5" fill="#0d9488" stroke="#ffffff" stroke-width="2.5" />

                        {{-- Badge de valor actual encima del último punto: $198.000 --}}
                        <g transform="translate(515, 60)">
                            <rect x="0" y="0" width="70" height="24" rx="6" fill="#0f766e" />
                            <text x="35" y="16" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">$198.000</text>
                        </g>

                        {{-- Etiquetas del Eje X (Meses) --}}
                        <text x="85" y="222" fill="#94a3b8" font-size="10.5" text-anchor="middle" font-weight="500">May 2025</text>
                        <text x="185" y="222" fill="#94a3b8" font-size="10.5" text-anchor="middle" font-weight="500">Jun 2025</text>
                        <text x="285" y="222" fill="#94a3b8" font-size="10.5" text-anchor="middle" font-weight="500">Jul 2025</text>
                        <text x="385" y="222" fill="#94a3b8" font-size="10.5" text-anchor="middle" font-weight="500">Ago 2025</text>
                        <text x="485" y="222" fill="#94a3b8" font-size="10.5" text-anchor="middle" font-weight="500">Sep 2025</text>
                        <text x="550" y="222" fill="#94a3b8" font-size="10.5" text-anchor="middle" font-weight="500">Oct 2025</text>
                    </svg>
                </div>
            </div>

            {{-- Gráfica Derecha: Distribución de clínicas por plan (Donut) --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/90 dark:border-slate-700/80 p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                {{-- Header de la gráfica --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white leading-tight">
                                Distribución de clínicas por plan
                            </h3>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                                Participación de clínicas en cada plan
                            </p>
                        </div>
                    </div>

                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-700/60 border border-slate-200 dark:border-slate-600 rounded-lg cursor-pointer">
                            <span>2 clínicas</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Contenido: Donut Chart a la izquierda + Leyenda a la derecha --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 items-center gap-6 py-2">

                    {{-- Donut SVG --}}
                    <div class="flex items-center justify-center">
                        <div class="relative w-44 h-44">
                            <svg viewBox="0 0 160 160" class="w-full h-full transform -rotate-90">
                                {{-- Segmento Púrpura (50%): Circunferencia = 2 * PI * 55 = 345.57. Mitad = 172.8 --}}
                                <circle cx="80" cy="80" r="55"
                                        fill="transparent"
                                        stroke="#7c3aed"
                                        stroke-width="24"
                                        stroke-dasharray="172.8 172.8"
                                        stroke-dashoffset="0" />

                                {{-- Segmento Teal (50%) --}}
                                <circle cx="80" cy="80" r="55"
                                        fill="transparent"
                                        stroke="#0d9488"
                                        stroke-width="24"
                                        stroke-dasharray="172.8 172.8"
                                        stroke-dashoffset="172.8" />
                            </svg>

                            {{-- Porcentajes superpuestos en las mitades --}}
                            <div class="absolute inset-0 flex items-center justify-between px-3 pointer-events-none">
                                <span class="text-white font-bold text-xs pl-0.5">50%</span>
                                <span class="text-white font-bold text-xs pr-0.5">50%</span>
                            </div>

                            {{-- Centro del Donut (Hoyo blanco con texto) --}}
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                                <span class="text-2xl font-black text-slate-900 dark:text-white leading-tight">
                                    {{ $clinicasActivas }}
                                </span>
                                <span class="text-[11px] font-semibold text-slate-400 dark:text-slate-500">
                                    clínicas
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Leyenda y desglose --}}
                    <div class="space-y-4">
                        {{-- Plan Básico --}}
                        <div class="flex items-center justify-between text-xs py-1.5 border-b border-slate-100 dark:border-slate-700/60">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-teal-600 shrink-0"></span>
                                <span class="font-semibold text-slate-800 dark:text-slate-200">Plan Básico</span>
                            </div>
                            <div class="flex items-center gap-6">
                                <span class="text-slate-500 dark:text-slate-400">1 clínica</span>
                                <span class="font-bold text-slate-900 dark:text-white">50%</span>
                            </div>
                        </div>

                        {{-- Plan Premium --}}
                        <div class="flex items-center justify-between text-xs py-1.5 border-b border-slate-100 dark:border-slate-700/60">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-purple-600 shrink-0"></span>
                                <span class="font-semibold text-slate-800 dark:text-slate-200">Plan Premium</span>
                            </div>
                            <div class="flex items-center gap-6">
                                <span class="text-slate-500 dark:text-slate-400">1 clínica</span>
                                <span class="font-bold text-slate-900 dark:text-white">50%</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- =========================================================
             5. FILA 4: ACTIVIDAD RECIENTE (3 EVENT CARDS)
             ========================================================= --}}
        <div class="space-y-3">
            {{-- Header de la sección --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white leading-tight">
                            Actividad reciente
                        </h3>
                        <p class="text-xs text-slate-400 dark:text-slate-500">
                            Últimos eventos en la plataforma
                        </p>
                    </div>
                </div>

                <a href="/super-admin/tenants" class="text-xs font-bold text-teal-600 dark:text-teal-400 hover:text-teal-700 inline-flex items-center gap-1 transition">
                    <span>Ver todas</span>
                    <span>&rarr;</span>
                </a>
            </div>

            {{-- 3 Tarjetas Horizontales de Eventos --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($recentActivities as $activity)
                    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200/90 dark:border-slate-700/80 p-4 shadow-xs flex items-start gap-3 transition hover:shadow-sm">
                        @if($activity['type'] === 'clinic')
                            <div class="w-9 h-9 rounded-lg bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        @elseif($activity['type'] === 'user')
                            <div class="w-9 h-9 rounded-lg bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @else
                            <div class="w-9 h-9 rounded-lg bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-slate-800 dark:text-slate-100 truncate">
                                {{ $activity['title'] }}
                            </h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2">
                                {{ $activity['description'] }}
                            </p>
                            <span class="text-[10.5px] text-slate-400 dark:text-slate-500 mt-1 block">
                                {{ $activity['time'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-filament-panels::page>
