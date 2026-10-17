<x-filament-panels::page class="fi-dashboard-custom-page">
    <div class="avi-sa-container">

        {{-- =========================================================
             1. HEADER: TÍTULO Y SUBTÍTULO (CENTRO DE CONTROL)
             ========================================================= --}}
        <div>
            <h1 class="avi-sa-header-title">
                Centro de control
            </h1>
            <p class="avi-sa-header-sub">
                Resumen de la red AviPetApp · Software con IA para veterinarias
            </p>
        </div>

        {{-- =========================================================
             2. FILA 1: 4 TARJETAS DE MÉTRICAS (MOCKUP EXACTO)
             ========================================================= --}}
        <div class="avi-sa-kpi-grid">

            {{-- Tarjeta 1: Clínicas activas --}}
            <div class="avi-sa-kpi-card">
                <div class="avi-sa-icon-circle-teal">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="avi-sa-kpi-info">
                    <span class="avi-sa-kpi-label">
                        Clínicas activas
                    </span>
                    <span class="avi-sa-kpi-value">
                        {{ $clinicasActivas }}
                    </span>
                    <span class="avi-sa-kpi-trend">
                        <span>&uarr; 100%</span>
                        <span class="avi-sa-kpi-trend-sub">vs. mes anterior</span>
                    </span>
                </div>
            </div>

            {{-- Tarjeta 2: Mascotas con membresía --}}
            <div class="avi-sa-kpi-card">
                <div class="avi-sa-icon-circle-purple">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                        <ellipse cx="6.5" cy="7.5" rx="2" ry="2.7" />
                        <ellipse cx="11" cy="5" rx="2" ry="2.7" />
                        <ellipse cx="16" cy="5.5" rx="2" ry="2.7" />
                        <ellipse cx="19.5" cy="8.5" rx="1.8" ry="2.5" />
                        <path d="M12 10.5c-3.2 0-5.8 2.2-5.8 5.2 0 2.2 1.6 3.8 3.5 3.8 1.1 0 1.8-.6 2.3-.6.5 0 1.2.6 2.3.6 1.9 0 3.5-1.6 3.5-3.8 0-3-2.6-5.2-5.8-5.2z" />
                    </svg>
                </div>
                <div class="avi-sa-kpi-info">
                    <span class="avi-sa-kpi-label">
                        Mascotas con membresía
                    </span>
                    <span class="avi-sa-kpi-value">
                        {{ $mascotasConMembresia }}
                    </span>
                    <span class="avi-sa-kpi-trend">
                        <span>&uarr; 33%</span>
                        <span class="avi-sa-kpi-trend-sub">vs. mes anterior</span>
                    </span>
                </div>
            </div>

            {{-- Tarjeta 3: MRR --}}
            <div class="avi-sa-kpi-card">
                <div class="avi-sa-icon-circle-teal">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="avi-sa-kpi-info">
                    <span class="avi-sa-kpi-label">
                        MRR (Plataforma SaaS)
                    </span>
                    <span class="avi-sa-kpi-value">
                        ${{ number_format($mrr, 0, ',', '.') }} <span style="font-size: 0.75rem; font-weight: 700; color: #64748b;">COP</span>
                    </span>
                    <span class="avi-sa-kpi-trend">
                        <span>&uarr; 12%</span>
                        <span class="avi-sa-kpi-trend-sub">vs. mes anterior</span>
                    </span>
                </div>
            </div>

            {{-- Tarjeta 4: GMV mensual --}}
            <div class="avi-sa-kpi-card">
                <div class="avi-sa-icon-circle-purple">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                </div>
                <div class="avi-sa-kpi-info">
                    <span class="avi-sa-kpi-label">
                        GMV mensual (Clínicas)
                    </span>
                    <span class="avi-sa-kpi-value">
                        ${{ number_format($gmv, 0, ',', '.') }} <span style="font-size: 0.75rem; font-weight: 700; color: #64748b;">COP</span>
                    </span>
                    <span class="avi-sa-kpi-trend">
                        <span>&uarr; 18%</span>
                        <span class="avi-sa-kpi-trend-sub">vs. mes anterior</span>
                    </span>
                </div>
            </div>

        </div>

        {{-- =========================================================
             3. FILA 2: PIPELINE COMERCIAL (BANNER GRANDE)
             ========================================================= --}}
        <div class="avi-sa-pipeline-card">

            {{-- Columna Izquierda: Título de sección --}}
            <div class="avi-sa-pipeline-left">
                <div style="display: flex; align-items: center; gap: 0.65rem;">
                    <div class="avi-sa-icon-circle-teal" style="width: 2.25rem !important; height: 2.25rem !important;">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
                            Pipeline comercial
                        </h3>
                        <p style="font-size: 0.75rem; color: #64748b; margin: 0.15rem 0 0 0;">
                            Gestiona tus oportunidades y haz crecer la red de clínicas.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Columna Central: Estado Vacío con CTA --}}
            <div class="avi-sa-pipeline-center">
                {{-- Ilustración de Documento con Plus verde --}}
                <div style="position: relative; width: 3.5rem; height: 3.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 0.25rem;">
                    <div style="width: 2.75rem; height: 3.25rem; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 0.5rem; display: flex; flex-direction: column; justify-content: center; padding: 0.4rem; gap: 0.3rem;">
                        <div style="height: 2.5px; background: #94a3b8; border-radius: 1px; width: 75%;"></div>
                        <div style="height: 2.5px; background: #94a3b8; border-radius: 1px; width: 100%;"></div>
                        <div style="height: 2.5px; background: #94a3b8; border-radius: 1px; width: 60%;"></div>
                    </div>
                    <div style="position: absolute; bottom: 0; right: 0; width: 1.35rem; height: 1.35rem; border-radius: 9999px; background: #0d9488; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 900; box-shadow: 0 1px 3px rgba(0,0,0,0.15); border: 2px solid #ffffff;">
                        +
                    </div>
                </div>

                <h4 style="font-size: 0.875rem; font-weight: 800; color: #0f172a; margin: 0.35rem 0 0 0;">
                    No hay oportunidades registradas
                </h4>
                <p style="font-size: 0.75rem; color: #64748b; max-width: 380px; margin: 0.25rem 0 0 0; line-height: 1.4;">
                    Aún no tienes demos, leads u oportunidades en el pipeline comercial. Empieza a generar nuevas oportunidades para hacer crecer AviPetApp.
                </p>

                <a href="/super-admin/prospecto-veterinarias/create" class="avi-sa-btn-teal">
                    <span>Registrar oportunidad</span>
                    <span>&rarr;</span>
                </a>
            </div>

            {{-- Columna Derecha: Contadores Demos y Cobros --}}
            <div class="avi-sa-pipeline-right">
                {{-- Demos Próximas --}}
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div class="avi-sa-icon-circle-teal" style="width: 2.5rem !important; height: 2.5rem !important; border-radius: 0.65rem !important;">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 600;">
                            Demos próximas
                        </div>
                        <div style="font-size: 1.5rem; font-weight: 900; color: #0f172a; line-height: 1.1;">
                            {{ $demosProximas }}
                        </div>
                    </div>
                </div>

                {{-- Cobros Pendientes --}}
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div class="avi-sa-icon-circle-teal" style="width: 2.5rem !important; height: 2.5rem !important; border-radius: 0.65rem !important;">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 600;">
                            Cobros pendientes
                        </div>
                        <div style="font-size: 1.5rem; font-weight: 900; color: #0f172a; line-height: 1.1;">
                            {{ $cobrosPendientes }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- =========================================================
             4. FILA 3: DOS GRÁFICAS ANALÍTICAS (MRR + DISTRIBUCIÓN)
             ========================================================= --}}
        <div class="avi-sa-charts-grid">

            {{-- Gráfica Izquierda: Ingresos recurrentes (Área MRR) --}}
            <div class="avi-sa-chart-card">
                {{-- Header de la gráfica --}}
                <div class="avi-sa-chart-header">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div class="avi-sa-icon-circle-teal" style="width: 2rem !important; height: 2rem !important; border-radius: 0.5rem !important;">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div>
                            <h3 style="font-size: 0.9rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
                                Ingresos recurrentes
                            </h3>
                            <p style="font-size: 0.725rem; color: #94a3b8; margin: 0.1rem 0 0 0;">
                                MRR en los últimos 6 meses
                            </p>
                        </div>
                    </div>

                    <div>
                        <span class="avi-sa-chart-pill">
                            <span>Últimos 6 meses</span>
                            <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Chart SVG Responsivo Exacto del Mockup --}}
                <div class="avi-sa-area-chart-container">
                    <svg viewBox="0 0 600 240" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="mrrTealGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#0d9488" stop-opacity="0.22" />
                                <stop offset="100%" stop-color="#0d9488" stop-opacity="0.01" />
                            </linearGradient>
                        </defs>

                        {{-- Líneas horizontales de guía (Grid) y Etiquetas Y --}}
                        {{-- $350.000 --}}
                        <text x="52" y="24" fill="#94a3b8" font-size="10" text-anchor="end" font-weight="500">$350.000</text>
                        <line x1="60" y1="20" x2="580" y2="20" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3" />

                        {{-- $262.500 --}}
                        <text x="52" y="69" fill="#94a3b8" font-size="10" text-anchor="end" font-weight="500">$262.500</text>
                        <line x1="60" y1="65" x2="580" y2="65" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3" />

                        {{-- $175.000 --}}
                        <text x="52" y="114" fill="#94a3b8" font-size="10" text-anchor="end" font-weight="500">$175.000</text>
                        <line x1="60" y1="110" x2="580" y2="110" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3" />

                        {{-- $87.500 --}}
                        <text x="52" y="159" fill="#94a3b8" font-size="10" text-anchor="end" font-weight="500">$87.500</text>
                        <line x1="60" y1="155" x2="580" y2="155" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3" />

                        {{-- $0 --}}
                        <text x="52" y="204" fill="#94a3b8" font-size="10" text-anchor="end" font-weight="500">$0</text>
                        <line x1="60" y1="200" x2="580" y2="200" stroke="#e2e8f0" stroke-width="1" />

                        {{-- Área bajo la curva con gradiente teal --}}
                        <path d="M 85 190 Q 185 180 285 170 T 385 150 T 485 130 T 545 95 L 545 200 L 85 200 Z"
                              fill="url(#mrrTealGradient)" />

                        {{-- Línea principal teal curvada suave --}}
                        <path d="M 85 190 Q 185 180 285 170 T 385 150 T 485 130 T 545 95"
                              fill="none" stroke="#0d9488" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />

                        {{-- Puntos de datos (Dots) --}}
                        <circle cx="85" cy="190" r="3.5" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                        <circle cx="185" cy="180" r="3.5" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                        <circle cx="285" cy="170" r="3.5" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                        <circle cx="385" cy="150" r="3.5" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                        <circle cx="485" cy="130" r="3.5" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                        <circle cx="545" cy="95" r="4.5" fill="#0d9488" stroke="#ffffff" stroke-width="2" />

                        {{-- Badge de valor actual encima del último punto: $198.000 --}}
                        <g transform="translate(510, 62)">
                            <rect x="0" y="0" width="65" height="22" rx="5" fill="#0f766e" />
                            <text x="32.5" y="15" fill="#ffffff" font-size="10.5" font-weight="bold" text-anchor="middle">$198.000</text>
                        </g>

                        {{-- Etiquetas del Eje X (Meses) --}}
                        <text x="85" y="222" fill="#94a3b8" font-size="10" text-anchor="middle" font-weight="500">May 2025</text>
                        <text x="185" y="222" fill="#94a3b8" font-size="10" text-anchor="middle" font-weight="500">Jun 2025</text>
                        <text x="285" y="222" fill="#94a3b8" font-size="10" text-anchor="middle" font-weight="500">Jul 2025</text>
                        <text x="385" y="222" fill="#94a3b8" font-size="10" text-anchor="middle" font-weight="500">Ago 2025</text>
                        <text x="485" y="222" fill="#94a3b8" font-size="10" text-anchor="middle" font-weight="500">Sep 2025</text>
                        <text x="545" y="222" fill="#94a3b8" font-size="10" text-anchor="middle" font-weight="500">Oct 2025</text>
                    </svg>
                </div>
            </div>

            {{-- Gráfica Derecha: Distribución de clínicas por plan (Donut) --}}
            <div class="avi-sa-chart-card">
                {{-- Header de la gráfica --}}
                <div class="avi-sa-chart-header">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div class="avi-sa-icon-circle-teal" style="width: 2rem !important; height: 2rem !important; border-radius: 0.5rem !important;">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                        <div>
                            <h3 style="font-size: 0.9rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
                                Distribución de clínicas por plan
                            </h3>
                            <p style="font-size: 0.725rem; color: #94a3b8; margin: 0.1rem 0 0 0;">
                                Participación de clínicas en cada plan
                            </p>
                        </div>
                    </div>

                    <div>
                        <span class="avi-sa-chart-pill">
                            <span>2 clínicas</span>
                            <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Contenido: Donut Chart a la izquierda + Leyenda a la derecha --}}
                <div class="avi-sa-donut-layout">

                    {{-- Donut SVG --}}
                    <div style="display: flex; align-items: center; justify-content: center;">
                        <div class="avi-sa-donut-wrapper">
                            <svg viewBox="0 0 160 160">
                                {{-- Segmento Púrpura (50%): Circunferencia = 2 * PI * 55 = 345.57. Mitad = 172.8 --}}
                                <circle cx="80" cy="80" r="55"
                                        fill="transparent"
                                        stroke="#7c3aed"
                                        stroke-width="22"
                                        stroke-dasharray="172.8 172.8"
                                        stroke-dashoffset="0" />

                                {{-- Segmento Teal (50%) --}}
                                <circle cx="80" cy="80" r="55"
                                        fill="transparent"
                                        stroke="#0d9488"
                                        stroke-width="22"
                                        stroke-dasharray="172.8 172.8"
                                        stroke-dashoffset="172.8" />
                            </svg>

                            {{-- Porcentajes superpuestos en las mitades --}}
                            <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: space-between; padding: 0 0.85rem; pointer-events: none;">
                                <span style="color: #ffffff; font-weight: 800; font-size: 0.75rem;">50%</span>
                                <span style="color: #ffffff; font-weight: 800; font-size: 0.75rem;">50%</span>
                            </div>

                            {{-- Centro del Donut (Hoyo blanco con texto) --}}
                            <div class="avi-sa-donut-center">
                                <span style="font-size: 1.5rem; font-weight: 900; color: #0f172a; line-height: 1;">
                                    {{ $clinicasActivas }}
                                </span>
                                <span style="font-size: 0.7rem; font-weight: 600; color: #64748b; margin-top: 0.15rem;">
                                    clínicas
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Leyenda y desglose --}}
                    <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                        {{-- Plan Básico --}}
                        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f1f5f9;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="width: 0.65rem; height: 0.65rem; border-radius: 9999px; background: #0d9488; display: inline-block;"></span>
                                <span style="font-weight: 700; color: #334155;">Plan Básico</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1.5rem;">
                                <span style="color: #64748b; font-size: 0.75rem;">1 clínica</span>
                                <span style="font-weight: 800; color: #0f172a;">50%</span>
                            </div>
                        </div>

                        {{-- Plan Premium --}}
                        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f1f5f9;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="width: 0.65rem; height: 0.65rem; border-radius: 9999px; background: #7c3aed; display: inline-block;"></span>
                                <span style="font-weight: 700; color: #334155;">Plan Premium</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1.5rem;">
                                <span style="color: #64748b; font-size: 0.75rem;">1 clínica</span>
                                <span style="font-weight: 800; color: #0f172a;">50%</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- =========================================================
             5. FILA 4: ACTIVIDAD RECIENTE (3 EVENT CARDS)
             ========================================================= --}}
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            {{-- Header de la sección --}}
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <div class="avi-sa-icon-circle-teal" style="width: 1.65rem !important; height: 1.65rem !important;">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size: 0.875rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
                            Actividad reciente
                        </h3>
                        <p style="font-size: 0.7rem; color: #94a3b8; margin: 0.05rem 0 0 0;">
                            Últimos eventos en la plataforma
                        </p>
                    </div>
                </div>

                <a href="/super-admin/tenants" style="font-size: 0.75rem; font-weight: 700; color: #0d9488; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;">
                    <span>Ver todas</span>
                    <span>&rarr;</span>
                </a>
            </div>

            {{-- 3 Tarjetas Horizontales de Eventos --}}
            <div class="avi-sa-activity-grid">
                @foreach($recentActivities as $activity)
                    <div class="avi-sa-activity-card">
                        @if($activity['type'] === 'clinic')
                            <div class="avi-sa-icon-circle-teal" style="width: 2.5rem !important; height: 2.5rem !important; border-radius: 0.65rem !important;">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        @elseif($activity['type'] === 'user')
                            <div class="avi-sa-icon-circle-purple" style="width: 2.5rem !important; height: 2.5rem !important; border-radius: 0.65rem !important;">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @else
                            <div class="avi-sa-icon-circle-teal" style="width: 2.5rem !important; height: 2.5rem !important; border-radius: 0.65rem !important;">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                        @endif

                        <div style="flex: 1 1 0%; min-width: 0;">
                            <h4 style="font-size: 0.8rem; font-weight: 800; color: #0f172a; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $activity['title'] }}
                            </h4>
                            <p style="font-size: 0.725rem; color: #64748b; margin: 0.2rem 0 0 0; line-height: 1.35;">
                                {{ $activity['description'] }}
                            </p>
                            <span style="font-size: 0.675rem; color: #94a3b8; margin-top: 0.35rem; display: block;">
                                {{ $activity['time'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-filament-panels::page>
