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
</style>
