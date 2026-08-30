<style>
    /* Paleta Profesional de Salud, Bienestar & Cuidado Veterinario */
    :root {
        --theme-medical-teal: #0d9488;
        --theme-medical-cyan: #0284c7;
        --theme-medical-emerald: #10b981;
        --theme-health-light-bg: #f8fafc;
        --theme-health-dark-bg: #0b1120;
        --theme-health-card-dark: #111c33;
    }

    /* Modo Oscuro Clínico */
    .dark body,
    .dark .fi-layout {
        background-color: #0b1120 !important;
        color: #f1f5f9 !important;
    }

    .dark .fi-sidebar {
        background-color: #0d1527 !important;
        border-right: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .dark .fi-topbar {
        background-color: #0d1527 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .dark .fi-section,
    .dark .fi-wi-stats-overview-stat,
    .dark .fi-ta-ctn,
    .dark .fi-modal-window {
        background-color: #111c33 !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.4) !important;
    }

    .dark .fi-ta-row:hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }

    .dark .fi-ta-header-cell {
        background-color: #0d162b !important;
        color: #94a3b8 !important;
        font-weight: 700 !important;
        font-size: 0.75rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
    }

    /* Botón de Canje con Estilo de Salud y Cuidado Clínico */
    .glow-health-cta {
        background: linear-gradient(135deg, #0d9488 0%, #10b981 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 15px -2px rgba(13, 148, 136, 0.4) !important;
        transition: all 0.2s ease !important;
    }

    .glow-health-cta:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 20px 0 rgba(13, 148, 136, 0.6) !important;
    }
</style>
