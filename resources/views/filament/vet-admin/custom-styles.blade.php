<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* =========================================================
       AVI PETSALUD+ MOCKUP: MOTOR DE DISEÑO MEDTECH PIXEL-PERFECT
       ========================================================= */

    *, html, body, .fi-body, .fi-main, .fi-sidebar, input, button, select, textarea {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    }

    /* Ocultar header por defecto en Dashboard customizado */
    .fi-page-dashboard .fi-header,
    .fi-dashboard-page .fi-header,
    .fi-page-dashboard header.fi-header {
        display: none !important;
    }

    /* Quitar paddings restrictivos del layout de Filament */
    .fi-page-dashboard .fi-page {
        padding: 0.75rem 1.25rem !important;
        max-width: 100% !important;
    }

    /* Fondo general gris clínico suave idéntico al mockup (#edf0f7) */
    html:not(.dark) body,
    html:not(.dark) .fi-layout,
    html:not(.dark) .fi-main {
        background-color: #edf0f7 !important;
        color: #0f172a !important;
    }

    /* Topbar styling: clean white topbar with shadow */
    .fi-topbar {
        background: #ffffff !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    .dark .fi-topbar {
        background: #0f172a !important;
        border-bottom-color: #1e293b !important;
    }

    /* Sidebar styling: clean white sidebar */
    .fi-sidebar {
        background: #ffffff !important;
        border-right: 1px solid #e2e8f0 !important;
    }
    .dark .fi-sidebar {
        background: #0f172a !important;
        border-right-color: #1e293b !important;
    }

    /* Active sidebar item: Solid Blue pill with white text & icon */
    .fi-sidebar-item-active .fi-sidebar-item-button,
    .fi-sidebar-item-active > a,
    .fi-sidebar-item[aria-current="page"] .fi-sidebar-item-button,
    .fi-sidebar-item[aria-current="page"] > a,
    li.fi-sidebar-item:has(a[href$="/admin/vet-pet-patitas"]) > a,
    li.fi-sidebar-item:has(a[href$="/admin/vet-pet-patitas"]) .fi-sidebar-item-button {
        background: #0284c7 !important;
        color: #ffffff !important;
        border-radius: 0.65rem !important;
    }
    .fi-sidebar-item-active .fi-sidebar-item-button *,
    .fi-sidebar-item-active > a *,
    li.fi-sidebar-item:has(a[href$="/admin/vet-pet-patitas"]) * {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }

    /* Soft purple Beta badge next to Inteligencia Artificial */
    li.fi-sidebar-item:has(a[href*="ai"])::after,
    li.fi-sidebar-item:has(a[href*="recomienda"])::after {
        content: "Beta";
        display: inline-block;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 1px 6px;
        border-radius: 9999px;
        background: #ede9fe;
        color: #7c3aed;
        margin-left: auto;
    }

    /* LAYOUT PRINCIPAL DE 2 COLUMNAS */
    .avi-workspace {
        display: flex !important;
        flex-direction: column !important;
        gap: 1.15rem !important;
        width: 100% !important;
        align-items: stretch !important;
    }
    @media (min-width: 1200px) {
        .avi-workspace {
            flex-direction: row !important;
            align-items: flex-start !important;
        }
    }

    .avi-main-area {
        flex: 1 1 0% !important;
        min-width: 0 !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 1.15rem !important;
    }

    .avi-ai-area {
        width: 100% !important;
        flex-shrink: 0 !important;
    }
    @media (min-width: 1200px) {
        .avi-ai-area {
            width: 325px !important;
            position: sticky !important;
            top: 1rem !important;
        }
    }

    /* HERO WELCOME CARD: BLANCO PURO CON ILUSTRACIÓN DE MASCOTAS */
    .avi-hero-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 1.25rem !important;
        padding: 1.35rem 1.65rem !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        align-items: center !important;
        gap: 1.25rem !important;
        box-shadow: 0 2px 10px -2px rgba(0, 0, 0, 0.03) !important;
        position: relative !important;
        overflow: hidden !important;
    }
    .dark .avi-hero-card {
        background: #162036 !important;
        border-color: #243452 !important;
    }
    @media (min-width: 768px) {
        .avi-hero-card {
            flex-direction: row !important;
        }
    }

    .avi-hero-title {
        font-size: 1.65rem !important;
        font-weight: 900 !important;
        color: #0f172a !important;
        letter-spacing: -0.025em !important;
        line-height: 1.15 !important;
        margin: 0 !important;
    }
    .dark .avi-hero-title {
        color: #ffffff !important;
    }

    .avi-hero-sub {
        font-size: 0.875rem !important;
        font-weight: 500 !important;
        color: #64748b !important;
        margin: 0.25rem 0 0.5rem 0 !important;
    }
    .dark .avi-hero-sub {
        color: #94a3b8 !important;
    }

    .avi-hero-badges {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 0.45rem !important;
        align-items: center !important;
    }

    .avi-pill-gray {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        color: #475569 !important;
        font-size: 0.725rem !important;
        font-weight: 600 !important;
        padding: 0.25rem 0.7rem !important;
        border-radius: 9999px !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
    }
    .dark .avi-pill-gray {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }

    .avi-pill-cyan {
        background: #f0fdfa !important;
        border: 1px solid #ccfbf1 !important;
        color: #0f766e !important;
        font-size: 0.725rem !important;
        font-weight: 600 !important;
        padding: 0.25rem 0.7rem !important;
        border-radius: 9999px !important;
    }
    .dark .avi-pill-cyan {
        background: #082f49 !important;
        border-color: #0284c7 !important;
        color: #38bdf8 !important;
    }

    .avi-pill-green {
        background: #f0fdf4 !important;
        border: 1px solid #bbf7d0 !important;
        color: #15803d !important;
        font-size: 0.725rem !important;
        font-weight: 600 !important;
        padding: 0.25rem 0.7rem !important;
        border-radius: 9999px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.35rem !important;
    }
    .dark .avi-pill-green {
        background: #064e3b !important;
        border-color: #059669 !important;
        color: #86efac !important;
    }

    .avi-pulse-dot {
        width: 0.45rem !important;
        height: 0.45rem !important;
        border-radius: 9999px !important;
        background: #22c55e !important;
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.25) !important;
    }

    .avi-hero-mascot {
        position: relative !important;
        flex-shrink: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .avi-hero-img {
        height: 105px !important;
        width: auto !important;
        object-fit: contain !important;
        border-radius: 0.75rem !important;
        display: block !important;
    }

    /* 4 KPIS EN 1 FILA */
    .avi-kpi-grid {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 0.875rem !important;
        width: 100% !important;
    }
    @media (min-width: 1024px) {
        .avi-kpi-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        }
    }

    .avi-kpi-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 1.15rem !important;
        padding: 1.15rem 1.25rem !important;
        box-shadow: 0 2px 6px -2px rgba(0,0,0,0.03) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        min-height: 125px !important;
    }
    .dark .avi-kpi-card {
        background: #162036 !important;
        border-color: #243452 !important;
    }
    .avi-kpi-card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 16px -4px rgba(0,0,0,0.06) !important;
        border-color: #cbd5e1 !important;
    }

    /* ACCIONES RÁPIDAS EN 1 FILA */
    .avi-actions-grid {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 0.75rem !important;
        width: 100% !important;
    }
    @media (min-width: 1024px) {
        .avi-actions-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        }
    }

    .avi-action-btn {
        border-radius: 0.875rem !important;
        padding: 0.85rem 1rem !important;
        height: 86px !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        text-decoration: none !important;
    }
    .avi-action-btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 18px -4px rgba(0,0,0,0.12) !important;
    }

    .avi-action-blue {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 60%, #0284c7 100%) !important;
        color: #ffffff !important;
        border: 1px solid rgba(29, 78, 216, 0.3) !important;
    }
    .avi-action-green {
        background: linear-gradient(135deg, #059669 0%, #0d9488 60%, #0284c7 100%) !important;
        color: #ffffff !important;
        border: 1px solid rgba(5, 150, 105, 0.3) !important;
    }
    .avi-action-white {
        background: #ffffff !important;
        border: 1.5px solid #e2e8f0 !important;
        color: #0f172a !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;
    }
    .dark .avi-action-white {
        background: #162036 !important;
        border-color: #243452 !important;
        color: #f1f5f9 !important;
    }
    .avi-action-white:hover {
        border-color: #3b82f6 !important;
    }

    /* FILA MEDIA: RENOVACIONES Y USO DE BENEFICIOS */
    .avi-mid-grid {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 0.875rem !important;
        width: 100% !important;
    }
    @media (min-width: 1024px) {
        .avi-mid-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }

    .avi-mid-box {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 1.15rem !important;
        padding: 1.25rem 1.35rem !important;
        box-shadow: 0 2px 6px -2px rgba(0,0,0,0.03) !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        min-height: 220px !important;
    }
    .dark .avi-mid-box {
        background: #162036 !important;
        border-color: #243452 !important;
    }

    /* ASISTENTE IA PANEL DERECHO */
    .avi-ai-box {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 1.25rem !important;
        padding: 1.25rem 1.35rem !important;
        box-shadow: 0 4px 15px -2px rgba(0,0,0,0.04) !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        min-height: 590px !important;
    }
    .dark .avi-ai-box {
        background: #162036 !important;
        border-color: #243452 !important;
    }

    .avi-ai-prompt-card {
        width: 100% !important;
        text-align: left !important;
        padding: 0.6rem 0.85rem !important;
        border-radius: 0.875rem !important;
        border: 1px solid #edf2f7 !important;
        background: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.65rem !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
    }
    .dark .avi-ai-prompt-card {
        background: #0f172a !important;
        border-color: #1e293b !important;
        color: #e2e8f0 !important;
    }
    .avi-ai-prompt-card:hover {
        background: #f0f9ff !important;
        border-color: #38bdf8 !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 12px -2px rgba(14, 165, 233, 0.12) !important;
    }
    .dark .avi-ai-prompt-card:hover {
        background: #1e293b !important;
        border-color: #0284c7 !important;
        color: #38bdf8 !important;
    }
</style>
