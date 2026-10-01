<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* =========================================================
       AVI PETSALUD+ MOCKUP: MOTOR DE DISEÑO PURO Y EXACTO
       ========================================================= */

    *, html, body, .fi-body, .fi-main, .fi-sidebar, input, button, select, textarea {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    }

    /* Ocultar header por defecto en Dashboard customizado para que el Hero Welcome Card brille */
    .fi-page-dashboard .fi-header,
    .fi-dashboard-page .fi-header,
    .fi-page-dashboard header.fi-header {
        display: none !important;
    }

    /* Quitar paddings restrictivos del layout de Filament */
    .fi-page-dashboard .fi-page {
        padding: 0.75rem 1rem !important;
        max-width: 100% !important;
    }

    /* Modo Claro Clínico Nítido */
    html:not(.dark) body,
    html:not(.dark) .fi-layout,
    html:not(.dark) .fi-main {
        background-color: #f8fafc !important;
        background-image: 
            radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.04) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(14, 165, 233, 0.035) 0px, transparent 45%) !important;
        color: #0f172a !important;
    }

    /* Modo Oscuro Clínico */
    html.dark body,
    html.dark .fi-layout,
    html.dark .fi-main {
        background-color: #0b1120 !important;
        color: #f8fafc !important;
    }

    /* LAYOUT PRINCIPAL DE 2 COLUMNAS (100% FLUIDO Y SIN HUECOS) */
    .avi-workspace {
        display: flex !important;
        flex-direction: column !important;
        gap: 1.25rem !important;
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
            width: 340px !important;
            position: sticky !important;
            top: 1rem !important;
        }
    }

    /* HERO WELCOME CARD */
    .avi-hero-card {
        background: linear-gradient(135deg, #e0f2fe 0%, #f0fdfa 55%, #ffffff 100%) !important;
        border: 1.5px solid #bae6fd !important;
        border-radius: 1.25rem !important;
        padding: 1.5rem 1.75rem !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        align-items: center !important;
        gap: 1.25rem !important;
        box-shadow: 0 4px 20px -2px rgba(14, 165, 233, 0.08) !important;
        position: relative !important;
        overflow: hidden !important;
    }
    .dark .avi-hero-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #082f49 100%) !important;
        border-color: #0369a1 !important;
    }
    @media (min-width: 768px) {
        .avi-hero-card {
            flex-direction: row !important;
        }
    }

    .avi-hero-title {
        font-size: 1.6rem !important;
        font-weight: 900 !important;
        color: #0f172a !important;
        letter-spacing: -0.025em !important;
        line-height: 1.25 !important;
        margin: 0 !important;
    }
    .dark .avi-hero-title {
        color: #ffffff !important;
    }

    .avi-hero-sub {
        font-size: 0.9375rem !important;
        font-weight: 500 !important;
        color: #475569 !important;
        margin: 0.35rem 0 0.85rem 0 !important;
    }
    .dark .avi-hero-sub {
        color: #cbd5e1 !important;
    }

    .avi-hero-badges {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 0.6rem !important;
        align-items: center !important;
    }

    .avi-pill-gray {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        color: #334155 !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        padding: 0.35rem 0.85rem !important;
        border-radius: 9999px !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }
    .dark .avi-pill-gray {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }

    .avi-pill-cyan {
        background: #ecfeff !important;
        border: 1px solid #a5f3fc !important;
        color: #0e7490 !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        padding: 0.35rem 0.85rem !important;
        border-radius: 9999px !important;
    }
    .dark .avi-pill-cyan {
        background: #082f49 !important;
        border-color: #0284c7 !important;
        color: #38bdf8 !important;
    }

    .avi-pill-green {
        background: #ecfdf5 !important;
        border: 1px solid #a7f3d0 !important;
        color: #047857 !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        padding: 0.35rem 0.85rem !important;
        border-radius: 9999px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.4rem !important;
    }
    .dark .avi-pill-green {
        background: #064e3b !important;
        border-color: #059669 !important;
        color: #6ee7b7 !important;
    }

    .avi-pulse-dot {
        width: 0.5rem !important;
        height: 0.5rem !important;
        border-radius: 9999px !important;
        background: #10b981 !important;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3) !important;
    }

    .avi-hero-mascot {
        position: relative !important;
        flex-shrink: 0 !important;
    }

    .avi-hero-img {
        width: 220px !important;
        height: 135px !important;
        object-fit: cover !important;
        border-radius: 1rem !important;
        border: 3px solid #ffffff !important;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.12) !important;
    }
    .dark .avi-hero-img {
        border-color: #334155 !important;
    }

    .avi-floating-heart {
        position: absolute !important;
        top: -12px !important;
        left: -10px !important;
        font-size: 1.75rem !important;
        z-index: 10 !important;
        animation: avi-bounce 2s infinite !important;
    }

    @keyframes avi-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }

    /* 4 KPIS EN 1 FILA */
    .avi-kpi-grid {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 1rem !important;
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
        border-radius: 1rem !important;
        padding: 1.25rem !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        min-height: 140px !important;
    }
    .dark .avi-kpi-card {
        background: #162036 !important;
        border-color: #243452 !important;
    }
    .avi-kpi-card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 20px -5px rgba(0,0,0,0.08) !important;
        border-color: #cbd5e1 !important;
    }

    .avi-kpi-icon-badge {
        width: 2.5rem !important;
        height: 2.5rem !important;
        border-radius: 0.75rem !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 1.15rem !important;
        font-weight: 900 !important;
    }

    .avi-kpi-val {
        font-size: 1.85rem !important;
        font-weight: 900 !important;
        color: #0f172a !important;
        letter-spacing: -0.02em !important;
        line-height: 1.1 !important;
        margin: 0.5rem 0 0.2rem 0 !important;
    }
    .dark .avi-kpi-val {
        color: #ffffff !important;
    }

    .avi-kpi-lbl {
        font-size: 0.8125rem !important;
        font-weight: 700 !important;
        color: #334155 !important;
        margin: 0 !important;
    }
    .dark .avi-kpi-lbl {
        color: #cbd5e1 !important;
    }

    .avi-kpi-sub {
        font-size: 0.725rem !important;
        color: #94a3b8 !important;
        margin: 0.15rem 0 0 0 !important;
    }

    /* ACCIONES RÁPIDAS EN 1 FILA */
    .avi-actions-grid {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 0.875rem !important;
        width: 100% !important;
    }
    @media (min-width: 1024px) {
        .avi-actions-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        }
    }

    .avi-action-btn {
        border-radius: 0.875rem !important;
        padding: 1rem 1.15rem !important;
        height: 92px !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        text-decoration: none !important;
    }
    .avi-action-btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 20px -5px rgba(0,0,0,0.12) !important;
    }

    .avi-action-blue {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 55%, #0284c7 100%) !important;
        color: #ffffff !important;
        border: 1px solid rgba(29, 78, 216, 0.4) !important;
    }
    .avi-action-green {
        background: linear-gradient(135deg, #059669 0%, #0d9488 55%, #0284c7 100%) !important;
        color: #ffffff !important;
        border: 1px solid rgba(5, 150, 105, 0.4) !important;
    }
    .avi-action-white {
        background: #ffffff !important;
        border: 1.5px solid #e2e8f0 !important;
        color: #0f172a !important;
    }
    .dark .avi-action-white {
        background: #162036 !important;
        border-color: #243452 !important;
        color: #f1f5f9 !important;
    }
    .avi-action-white:hover {
        border-color: #3b82f6 !important;
    }

    .avi-action-title {
        font-size: 0.9375rem !important;
        font-weight: 900 !important;
        margin: 0 !important;
        line-height: 1.2 !important;
    }

    .avi-action-sub {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        margin: 0.2rem 0 0 0 !important;
    }

    /* FILA MEDIA: RENOVACIONES Y USO DE BENEFICIOS */
    .avi-mid-grid {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
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
        border-radius: 1rem !important;
        padding: 1.25rem 1.5rem !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03) !important;
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
        padding: 1.35rem !important;
        box-shadow: 0 4px 15px -2px rgba(0,0,0,0.05) !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        min-height: 600px !important;
    }
    .dark .avi-ai-box {
        background: #162036 !important;
        border-color: #243452 !important;
    }

    .avi-prompt-pill {
        width: 100% !important;
        text-align: left !important;
        padding: 0.75rem 0.85rem !important;
        border-radius: 0.75rem !important;
        border: 1px solid #e2e8f0 !important;
        background: #f8fafc !important;
        font-size: 0.8125rem !important;
        font-weight: 700 !important;
        color: #334155 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        cursor: pointer !important;
        transition: all 0.15s ease !important;
    }
    .dark .avi-prompt-pill {
        background: #0f172a !important;
        border-color: #1e293b !important;
        color: #e2e8f0 !important;
    }
    .avi-prompt-pill:hover {
        background: #eff6ff !important;
        border-color: #60a5fa !important;
        color: #1d4ed8 !important;
        transform: translateX(2px) !important;
    }
    .dark .avi-prompt-pill:hover {
        background: #1e293b !important;
        border-color: #0284c7 !important;
        color: #38bdf8 !important;
    }
</style>
