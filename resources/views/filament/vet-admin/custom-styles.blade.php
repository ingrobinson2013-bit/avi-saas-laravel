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

    /* 2. MODO CLARO SANITARIO (Limpio y de Alto Contraste) */
    html:not(.dark) body,
    html:not(.dark) .fi-layout {
        background-color: #f8fafc !important;
        color: #0f172a !important;
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
        padding: 0.875rem 1rem !important;
        border-radius: 1rem !important;
        min-width: 0 !important;
        overflow: hidden !important;
    }
    .fi-wi-stats-overview-stat-value {
        font-size: 1.2rem !important;
        line-height: 1.2 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    .fi-wi-stats-overview-stat-label {
        font-size: 0.7rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    .fi-wi-stats-overview-stat-description {
        font-size: 0.725rem !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    /* FORZAR LOS 5 STATS EN UNA SOLA FILA HORIZONTAL (Desktop) */
    .fi-wi-stats-overview-stats-ctn {
        display: grid !important;
        grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
        gap: 0.75rem !important;
        width: 100% !important;
    }
    @media (max-width: 1200px) {
        .fi-wi-stats-overview-stats-ctn {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }
    }
    @media (max-width: 640px) {
        .fi-wi-stats-overview-stats-ctn {
            grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        }
    }

    /* 4. GRID DE OPERACIONES CLÍNICAS (4 columnas forzadas en desktop) */
    .avi-operations-grid {
        display: grid !important;
        grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        gap: 0.875rem !important;
        width: 100% !important;
    }
    @media (min-width: 640px) {
        .avi-operations-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }
    @media (min-width: 1024px) {
        .avi-operations-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
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
</style>
