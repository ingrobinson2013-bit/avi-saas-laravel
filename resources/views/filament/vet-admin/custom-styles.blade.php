<style>
    /* =========================================================
       ALTO CONTRASTE & LEGIBILIDAD TOTAL: MODO OSCURO Y CLARO
       Garantiza que todas las letras, números y tablas sean 100% nítidos
       ========================================================= */

    /* 1. MODO OSCURO CLÍNICO (Alto contraste y nitidez) */
    html.dark body,
    .dark .fi-layout,
    .dark .fi-main {
        background-color: #0b1120 !important; /* Navy Profundo */
        background-image: 
            radial-gradient(at 0% 0%, rgba(30, 58, 138, 0.22) 0px, transparent 55%),
            radial-gradient(at 100% 0%, rgba(14, 116, 144, 0.16) 0px, transparent 50%),
            radial-gradient(at 50% 100%, rgba(88, 28, 135, 0.10) 0px, transparent 55%) !important;
        background-attachment: fixed !important;
        color: #f8fafc !important;
    }

    .dark .fi-sidebar {
        background-color: #0f172a !important;
        border-right: 1px solid #1e293b !important;
    }

    .dark .fi-topbar {
        background-color: #0f172a !important;
        border-bottom: 1px solid #1e293b !important;
    }

    /* Tarjetas, Widgets y Secciones en Modo Oscuro */
    .dark .fi-section,
    .dark .fi-wi-stats-overview-stat,
    .dark .fi-ta-ctn,
    .dark .fi-modal-window,
    .dark .fi-dropdown-panel {
        background-color: #162036 !important;
        border: 1px solid #243452 !important;
        color: #f8fafc !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4) !important;
        border-radius: 0.875rem !important;
    }

    /* Encabezados y Títulos en Modo Oscuro (Blanco Puro) */
    .dark .fi-header-heading,
    .dark .fi-section-header-heading,
    .dark .fi-wi-stats-overview-stat-value,
    .dark .fi-ta-record-value,
    .dark h1, .dark h2, .dark h3, .dark h4 {
        color: #ffffff !important;
        font-weight: 800 !important;
    }

    /* Textos en Celdas de Tablas en Modo Oscuro */
    .dark .fi-ta-cell,
    .dark .fi-ta-cell * {
        color: #f1f5f9;
    }

    .dark .fi-ta-header-cell {
        background-color: #111a2e !important;
        color: #94a3b8 !important;
        font-weight: 800 !important;
        font-size: 0.75rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
    }

    /* Textos Secundarios y Subtítulos en Modo Oscuro */
    .dark .fi-wi-stats-overview-stat-label,
    .dark .fi-ta-cell-description,
    .dark .fi-section-header-description,
    .dark .text-gray-500,
    .dark .text-gray-400 {
        color: #94a3b8 !important;
    }

    /* Formularios, Inputs y Labels en Modo Oscuro */
    .dark input,
    .dark select,
    .dark textarea {
        background-color: #0b1120 !important;
        color: #ffffff !important;
        border-color: #334155 !important;
    }

    .dark label,
    .dark .fi-fo-field-wrp-label span {
        color: #e2e8f0 !important;
        font-weight: 700 !important;
    }

    /* Filas de Tabla en Hover */
    .dark .fi-ta-row:hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }

    /* 2. MODO CLARO CLÍNICO MODERNO (Estilo Apple Health / Epic MedTech) */
    html:not(.dark) body,
    html:not(.dark) .fi-layout,
    html:not(.dark) .fi-main {
        background-color: #f1f5f9 !important; /* Soft MedTech Ice Slate */
        background-image: 
            radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.05) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(14, 165, 233, 0.045) 0px, transparent 45%),
            radial-gradient(at 50% 100%, rgba(99, 102, 241, 0.03) 0px, transparent 50%) !important;
        background-attachment: fixed !important;
        color: #0f172a !important;
    }

    .fi-sidebar-header {
        padding-left: 1rem !important;
        padding-right: 0.75rem !important;
    }

    .fi-logo {
        height: auto !important;
        max-height: 4rem !important;
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    html:not(.dark) .fi-sidebar {
        background-color: #ffffff !important;
        border-right: 1px solid #e2e8f0 !important;
        box-shadow: 1px 0 2px 0 rgba(0, 0, 0, 0.02) !important;
    }

    html:not(.dark) .fi-topbar {
        background-color: #ffffff !important;
        border-bottom: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03) !important;
    }

    /* Elevación limpia para tarjetas y widgets en modo claro */
    html:not(.dark) .fi-section,
    html:not(.dark) .fi-wi-stats-overview-stat,
    html:not(.dark) .fi-ta-ctn {
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.04) !important;
        border-radius: 1rem !important;
    }

    html:not(.dark) .fi-header-heading,
    html:not(.dark) .fi-section-header-heading,
    html:not(.dark) .fi-wi-stats-overview-stat-value,
    html:not(.dark) h1, html:not(.dark) h2, html:not(.dark) h3 {
        color: #0f172a !important;
        font-weight: 800 !important;
    }

    /* Badges Médicos Redondeados */
    .fi-badge {
        border-radius: 9999px !important;
        font-weight: 700 !important;
    }

    /* 3. OPTIMIZACIÓN DE DENSIDAD CLÍNICA & REDUCCIÓN TOTAL DE ESPACIOS EN BLANCO */
    .fi-main {
        max-width: 100% !important;
        width: 100% !important;
    }
    .fi-main-ctn {
        max-width: 100% !important;
        width: 100% !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding-top: 1rem !important;
        padding-bottom: 2rem !important;
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
    }
    .fi-page-header {
        margin-bottom: 1rem !important;
    }
    .fi-widgets-ctn {
        gap: 1.25rem !important;
        width: 100% !important;
    }
    .fi-wi-stats-overview-stat {
        padding: 1.15rem 1.25rem !important;
        border-radius: 1.125rem !important;
        min-width: 0 !important;
        overflow: hidden !important;
        min-height: 110px !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
    }
    .fi-wi-stats-overview-stat-value {
        font-size: 1.65rem !important;
        font-weight: 900 !important;
        line-height: 1.25 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        letter-spacing: -0.035em !important;
        font-feature-settings: "tnum" on, "cv02" on, "cv03" on, "cv04" on !important;
        font-variant-numeric: tabular-nums !important;
    }
    .fi-wi-stats-overview-stat-label {
        font-size: 0.725rem !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        margin-bottom: 0.25rem !important;
    }
    .fi-wi-stats-overview-stat-description {
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        margin-top: 0.35rem !important;
    }

    /* ELIMINAR CUALQUIER CHART O POLÍGONO DE SPARKLINE QUE CREE MANCHAS O DEFORME LA TARJETA */
    .fi-wi-stats-overview-stat-chart,
    .fi-wi-stats-overview-stat svg {
        display: none !important;
    }
    .fi-wi-stats-overview-stat-description svg {
        display: inline-block !important;
        width: 1rem !important;
        height: 1rem !important;
    }

    /* 4 STATS OPERATIVOS EN FILA BALANCEADA (Desktop) */
    .fi-wi-stats-overview-stats-ctn {
        display: grid !important;
        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        gap: 0.875rem !important;
        width: 100% !important;
    }
    @media (max-width: 1024px) {
        .fi-wi-stats-overview-stats-ctn {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }
    @media (max-width: 640px) {
        .fi-wi-stats-overview-stats-ctn {
            grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        }
    }

    /* 4. GRID DE OPERACIONES CLÍNICAS (1 SOLA FILA HORIZONTAL DE 4 COLUMNAS) */
    .avi-operations-grid {
        display: grid !important;
        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        gap: 0.75rem !important;
        width: 100% !important;
    }
    @media (max-width: 768px) {
        .avi-operations-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }
    @media (max-width: 480px) {
        .avi-operations-grid {
            grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        }
    }

    /* 5. TARJETAS DE OPERACIONES EN MODO CLARO Y OSCURO */
    .avi-op-card {
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 1rem !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
        transition: all 0.15s ease-in-out !important;
    }
    .avi-op-card:hover {
        border-color: #3b82f6 !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-1px) !important;
    }
    .dark .avi-op-card {
        background-color: #162036 !important;
        border-color: #243452 !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3) !important;
    }
    .dark .avi-op-card:hover {
        border-color: #60a5fa !important;
    }

    /* 6. LAYOUT MAESTRO-DETALLE DEL TERMINAL DE CANJE EN MOSTRADOR */
    .avi-redeem-layout {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
        width: 100% !important;
    }
    @media (min-width: 1024px) {
        .avi-redeem-layout {
            grid-template-columns: 390px minmax(0, 1fr) !important;
        }
    }

    /* 7. BOTÓN DE TEMA & AVATAR EN TOPBAR */
    #avi-theme-toggle-btn {
        transition: all 0.15s ease-in-out !important;
    }
    #avi-theme-toggle-btn:hover {
        transform: translateY(-1px) !important;
    }
    .fi-user-avatar,
    .fi-avatar {
        width: 2.15rem !important;
        height: 2.15rem !important;
        min-width: 2.15rem !important;
        min-height: 2.15rem !important;
        border-radius: 9999px !important;
        border: 2px solid #3b82f6 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12) !important;
        display: block !important;
    }
    .dark .fi-user-avatar,
    .dark .fi-avatar {
        border-color: #38bdf8 !important;
    }

    /* 8. ANIMACIONES Y FÍSICAS DE INTERACCIÓN PREMIUM (Stripe & Linear Polish) */
    .fi-wi-stats-overview-stat,
    .fi-section,
    .fi-ta-ctn,
    .avi-operations-grid > a {
        transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.22s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.22s ease !important;
    }

    .fi-wi-stats-overview-stat:hover,
    .avi-operations-grid > a:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 4px 6px -2px rgba(15, 23, 42, 0.03) !important;
    }

    .dark .fi-wi-stats-overview-stat:hover,
    .dark .avi-operations-grid > a:hover {
        box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.5) !important;
    }

    /* Shimmer continuo en Hero CTA de Mostrador */
    @keyframes avi-shimmer-sweep {
        0% { transform: translateX(-150%); }
        35% { transform: translateX(150%); }
        100% { transform: translateX(150%); }
    }
    .avi-hero-cta {
        position: relative;
        overflow: hidden;
    }
    .avi-hero-cta::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.18) 50%, transparent 100%);
        transform: translateX(-150%);
        animation: avi-shimmer-sweep 6s infinite cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events-none;
    }

    /* Flujo de gradiente animado para la barra de beneficios */
    @keyframes avi-gradient-flow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .avi-progress-bar {
        background-size: 200% 200% !important;
        animation: avi-gradient-flow 3.5s ease infinite !important;
    }
</style>
