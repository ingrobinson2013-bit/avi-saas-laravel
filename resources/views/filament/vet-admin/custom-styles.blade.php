<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* Tipografía Global Plus Jakarta Sans (Idéntica a la Landing) */
    *, html, body, .fi-body, .fi-main, .fi-sidebar, input, button, select, textarea {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    }

    /* Ocultar header por defecto en Dashboard customizado para que el Hero Welcome Card brille */
    .fi-page-dashboard .fi-header,
    .fi-dashboard-page .fi-header,
    .fi-page-dashboard header.fi-header {
        display: none !important;
    }

    /* 1. MODO OSCURO CLÍNICO (Alto contraste y nitidez) */
    html.dark body,
    .dark .fi-layout,
    .dark .fi-main {
        background-color: #0b1120 !important;
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

    /* 2. MODO CLARO CLÍNICO MODERNO */
    html:not(.dark) body,
    html:not(.dark) .fi-layout,
    html:not(.dark) .fi-main {
        background-color: #f8fafc !important;
        background-image: 
            radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.04) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(14, 165, 233, 0.035) 0px, transparent 45%) !important;
        background-attachment: fixed !important;
        color: #0f172a !important;
    }

    html:not(.dark) .fi-sidebar {
        background-color: #ffffff !important;
        border-right: 1px solid #e2e8f0 !important;
    }

    html:not(.dark) .fi-topbar {
        background-color: #ffffff !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }

    /* =========================================================
       AVI PETSALUD+ MOCKUP: MOTOR DE DISEÑO DE PRECISIÓN (1400px)
       Evita que pantallas ultrapanorámicas deformen el layout
       ========================================================= */
    .avi-dashboard-container {
        max-width: 1400px !important;
        margin-left: auto !important;
        margin-right: auto !important;
        width: 100% !important;
    }

    .avi-workspace-layout {
        display: flex !important;
        flex-direction: column !important;
        gap: 1.25rem !important;
        width: 100% !important;
        align-items: flex-start !important;
    }
    @media (min-width: 1200px) {
        .avi-workspace-layout {
            flex-direction: row !important;
        }
    }

    .avi-main-column {
        width: 100% !important;
        flex: 1 1 0% !important;
        min-width: 0 !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 1rem !important;
    }

    .avi-ai-column {
        width: 100% !important;
        flex-shrink: 0 !important;
    }
    @media (min-width: 1200px) {
        .avi-ai-column {
            width: 320px !important;
            position: sticky !important;
            top: 1rem !important;
        }
    }

    /* 4 KPIs en 1 fila */
    .avi-kpi-row {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 0.875rem !important;
        width: 100% !important;
    }
    @media (min-width: 1024px) {
        .avi-kpi-row {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        }
    }

    /* Acciones rápidas en 1 fila */
    .avi-ops-row {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 0.75rem !important;
        width: 100% !important;
    }
    @media (min-width: 1024px) {
        .avi-ops-row {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        }
    }

    /* Fila media (2 columnas) */
    .avi-middle-row {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
        width: 100% !important;
    }
    @media (min-width: 1024px) {
        .avi-middle-row {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }

    /* Elevación suave y hover en tarjetas */
    .avi-card-hover {
        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s ease !important;
    }
    .avi-card-hover:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08) !important;
    }
    .dark .avi-card-hover:hover {
        box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.5) !important;
    }
</style>
