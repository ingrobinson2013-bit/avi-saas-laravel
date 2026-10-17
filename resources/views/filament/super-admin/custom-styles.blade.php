<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* =========================================================
       AVIPETAPP SUPERADMIN: MOTOR DE DISEÑO PIXEL-PERFECT
       ========================================================= */

    *, html, body, .fi-body, .fi-main, .fi-sidebar, input, button, select, textarea {
        font-family: 'Inter', Arial, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    }

    /* Ocultar header por defecto en Dashboard customizado */
    .fi-page-dashboard .fi-header,
    .fi-dashboard-page .fi-header,
    .fi-page-dashboard header.fi-header {
        display: none !important;
    }

    /* Paddings del layout del Dashboard */
    .fi-page-dashboard .fi-page,
    .fi-dashboard-custom-page {
        padding: 1.25rem 1.5rem !important;
        max-width: 100% !important;
    }

    /* Fondo general */
    html:not(.dark) body,
    html:not(.dark) .fi-layout,
    html:not(.dark) .fi-main {
        background-color: #f8fafc !important;
        color: #0f172a !important;
    }

    /* Topbar */
    .fi-topbar {
        background: #ffffff !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    .dark .fi-topbar {
        background: #0f172a !important;
        border-bottom-color: #1e293b !important;
    }

    /* Sidebar */
    .fi-sidebar {
        background: #ffffff !important;
        border-right: 1px solid #e2e8f0 !important;
    }
    .dark .fi-sidebar {
        background: #0f172a !important;
        border-right-color: #1e293b !important;
    }

    /* Active sidebar item: Light Teal pill (#f0fdfa) with Dark Teal text (#0d9488) */
    .fi-sidebar-item-active .fi-sidebar-item-button,
    .fi-sidebar-item-active > a,
    .fi-sidebar-item[aria-current="page"] .fi-sidebar-item-button,
    .fi-sidebar-item[aria-current="page"] > a,
    li.fi-sidebar-item:has(a[href$="/super-admin"]) > a,
    li.fi-sidebar-item:has(a[href$="/super-admin"]) .fi-sidebar-item-button {
        background: #f0fdfa !important;
        color: #0d9488 !important;
        border-radius: 0.65rem !important;
        font-weight: 700 !important;
    }
    .fi-sidebar-item-active .fi-sidebar-item-button *,
    .fi-sidebar-item-active > a *,
    li.fi-sidebar-item:has(a[href$="/super-admin"]) * {
        color: #0d9488 !important;
        stroke: #0d9488 !important;
    }

    /* Hover sidebar items */
    .fi-sidebar-item-button:hover,
    .fi-sidebar-item > a:hover {
        background: #f8fafc !important;
        border-radius: 0.65rem !important;
    }

    /* =========================================================
       DASHBOARD COMPONENT CLASSES
       ========================================================= */

    /* Contenedor principal con espacio vertical */
    .avi-sa-container {
        display: flex !important;
        flex-direction: column !important;
        gap: 1.5rem !important;
        width: 100% !important;
    }

    /* Encabezado */
    .avi-sa-header-title {
        font-size: 1.75rem !important;
        font-weight: 900 !important;
        color: #0f172a !important;
        letter-spacing: -0.03em !important;
        line-height: 1.2 !important;
        margin: 0 !important;
    }
    .dark .avi-sa-header-title {
        color: #ffffff !important;
    }
    .avi-sa-header-sub {
        font-size: 0.875rem !important;
        font-weight: 500 !important;
        color: #64748b !important;
        margin: 0.25rem 0 0 0 !important;
    }
    .dark .avi-sa-header-sub {
        color: #94a3b8 !important;
    }

    /* Fila 1: Grid de 4 KPIs */
    .avi-sa-kpi-grid {
        display: grid !important;
        grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        gap: 1rem !important;
        width: 100% !important;
    }
    @media (min-width: 640px) {
        .avi-sa-kpi-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }
    @media (min-width: 1024px) {
        .avi-sa-kpi-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        }
    }

    .avi-sa-kpi-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 1rem !important;
        padding: 1.15rem 1.35rem !important;
        display: flex !important;
        align-items: center !important;
        gap: 1rem !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }
    .dark .avi-sa-kpi-card {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    .avi-sa-kpi-card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.08) !important;
    }

    .avi-sa-icon-circle-teal {
        width: 3.25rem !important;
        height: 3.25rem !important;
        border-radius: 9999px !important;
        background: #f0fdfa !important;
        color: #0d9488 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-shrink: 0 !important;
    }
    .dark .avi-sa-icon-circle-teal {
        background: rgba(13, 148, 136, 0.2) !important;
        color: #2dd4bf !important;
    }

    .avi-sa-icon-circle-purple {
        width: 3.25rem !important;
        height: 3.25rem !important;
        border-radius: 9999px !important;
        background: #faf5ff !important;
        color: #7c3aed !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-shrink: 0 !important;
    }
    .dark .avi-sa-icon-circle-purple {
        background: rgba(124, 58, 237, 0.2) !important;
        color: #c084fc !important;
    }

    .avi-sa-kpi-info {
        display: flex !important;
        flex-direction: column !important;
        min-width: 0 !important;
    }
    .avi-sa-kpi-label {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: #64748b !important;
    }
    .dark .avi-sa-kpi-label {
        color: #94a3b8 !important;
    }
    .avi-sa-kpi-value {
        font-size: 1.65rem !important;
        font-weight: 900 !important;
        color: #0f172a !important;
        letter-spacing: -0.025em !important;
        line-height: 1.15 !important;
        margin-top: 0.15rem !important;
    }
    .dark .avi-sa-kpi-value {
        color: #ffffff !important;
    }
    .avi-sa-kpi-trend {
        font-size: 0.725rem !important;
        font-weight: 700 !important;
        color: #0d9488 !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.25rem !important;
        margin-top: 0.25rem !important;
    }
    .dark .avi-sa-kpi-trend {
        color: #2dd4bf !important;
    }
    .avi-sa-kpi-trend-sub {
        font-weight: 400 !important;
        color: #94a3b8 !important;
    }

    /* Fila 2: Pipeline Comercial */
    .avi-sa-pipeline-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 1rem !important;
        padding: 1.35rem 1.65rem !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04) !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 1.5rem !important;
        width: 100% !important;
    }
    .dark .avi-sa-pipeline-card {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    @media (min-width: 1024px) {
        .avi-sa-pipeline-card {
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
        }
    }

    .avi-sa-pipeline-left {
        width: 100% !important;
        max-width: 260px !important;
    }
    .avi-sa-pipeline-center {
        flex: 1 1 0% !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
        padding: 0 1rem !important;
    }
    .avi-sa-pipeline-right {
        display: flex !important;
        align-items: center !important;
        gap: 2rem !important;
        border-top: 1px solid #f1f5f9 !important;
        padding-top: 1rem !important;
    }
    .dark .avi-sa-pipeline-right {
        border-top-color: #334155 !important;
    }
    @media (min-width: 1024px) {
        .avi-sa-pipeline-right {
            border-top: none !important;
            border-left: 1px solid #f1f5f9 !important;
            padding-top: 0 !important;
            padding-left: 2rem !important;
        }
        .dark .avi-sa-pipeline-right {
            border-left-color: #334155 !important;
        }
    }

    .avi-sa-btn-teal {
        background: #0d9488 !important;
        color: #ffffff !important;
        font-size: 0.8rem !important;
        font-weight: 700 !important;
        padding: 0.55rem 1.25rem !important;
        border-radius: 0.55rem !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.4rem !important;
        transition: background 0.2s ease, transform 0.2s ease !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
        margin-top: 0.75rem !important;
    }
    .avi-sa-btn-teal:hover {
        background: #0f766e !important;
        transform: translateY(-1px) !important;
        color: #ffffff !important;
    }

    /* Fila 3: Gráficas Analíticas */
    .avi-sa-charts-grid {
        display: grid !important;
        grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        gap: 1.25rem !important;
        width: 100% !important;
    }
    @media (min-width: 1024px) {
        .avi-sa-charts-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }

    .avi-sa-chart-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 1rem !important;
        padding: 1.35rem 1.5rem !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04) !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        min-height: 330px !important;
    }
    .dark .avi-sa-chart-card {
        background: #1e293b !important;
        border-color: #334155 !important;
    }

    .avi-sa-chart-header {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        margin-bottom: 0.85rem !important;
    }

    .avi-sa-chart-pill {
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.35rem !important;
        padding: 0.25rem 0.65rem !important;
        font-size: 0.725rem !important;
        font-weight: 600 !important;
        color: #475569 !important;
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 0.5rem !important;
    }
    .dark .avi-sa-chart-pill {
        background: #0f172a !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }

    .avi-sa-area-chart-container {
        width: 100% !important;
        height: 220px !important;
        position: relative !important;
        overflow: hidden !important;
    }
    .avi-sa-area-chart-container svg {
        width: 100% !important;
        height: 100% !important;
        display: block !important;
    }

    /* Donut chart layout */
    .avi-sa-donut-layout {
        display: grid !important;
        grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        align-items: center !important;
        gap: 1.5rem !important;
        height: 220px !important;
    }
    @media (min-width: 640px) {
        .avi-sa-donut-layout {
            grid-template-columns: 180px 1fr !important;
        }
    }

    .avi-sa-donut-wrapper {
        position: relative !important;
        width: 170px !important;
        height: 170px !important;
        margin: 0 auto !important;
    }
    .avi-sa-donut-wrapper svg {
        width: 100% !important;
        height: 100% !important;
        transform: rotate(-90deg) !important;
    }
    .avi-sa-donut-center {
        position: absolute !important;
        inset: 0 !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        pointer-events: none !important;
    }

    /* Fila 4: Actividad Reciente */
    .avi-sa-activity-grid {
        display: grid !important;
        grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        gap: 1rem !important;
        width: 100% !important;
    }
    @media (min-width: 768px) {
        .avi-sa-activity-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }
    }

    .avi-sa-activity-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 0.85rem !important;
        padding: 1rem 1.15rem !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03) !important;
        display: flex !important;
        align-items: flex-start !important;
        gap: 0.85rem !important;
        transition: box-shadow 0.2s ease !important;
    }
    .dark .avi-sa-activity-card {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    .avi-sa-activity-card:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05) !important;
    }

    /* Topbar Search Input Styling */
    .avi-topbar-search-input {
        width: 100% !important;
        padding: 0.45rem 1rem 0.45rem 2.25rem !important;
        font-size: 0.8rem !important;
        border-radius: 0.65rem !important;
        border: 1px solid #e2e8f0 !important;
        background: #f8fafc !important;
        color: #0f172a !important;
        transition: all 0.2s ease !important;
        outline: none !important;
    }
    .dark .avi-topbar-search-input {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }
    .avi-topbar-search-input:focus {
        border-color: #0d9488 !important;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15) !important;
        background: #ffffff !important;
    }
</style>
