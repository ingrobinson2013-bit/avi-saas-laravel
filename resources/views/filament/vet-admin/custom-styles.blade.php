<style>
    /* Custom High-End Dark Theme matching Vet-Pet Patitas Mockup */
    :root {
        --theme-dark-bg: #0b0f19;
        --theme-card-bg: #131b2e;
        --theme-card-border: rgba(255, 255, 255, 0.08);
        --theme-mint-primary: #10b981;
        --theme-mint-glow: rgba(16, 185, 129, 0.35);
        --theme-sky-primary: #38bdf8;
    }

    .dark body,
    .dark .fi-layout {
        background-color: #0b0f19 !important;
        color: #f1f5f9 !important;
    }

    .dark .fi-sidebar {
        background-color: #0d1322 !important;
        border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
    }

    .dark .fi-topbar {
        background-color: #0d1322 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
    }

    .dark .fi-section,
    .dark .fi-wi-stats-overview-stat,
    .dark .fi-ta-ctn,
    .dark .fi-modal-window {
        background-color: #131b2e !important;
        border-color: rgba(255, 255, 255, 0.07) !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.5) !important;
    }

    .dark .fi-ta-row:hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }

    .dark .fi-ta-header-cell {
        background-color: #0e1526 !important;
        color: #94a3b8 !important;
        font-weight: 700 !important;
        font-size: 0.75rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
    }

    /* Glowing Mint Button Effect */
    .glow-mint-cta {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%) !important;
        color: #0a0f1d !important;
        box-shadow: 0 0 25px -4px rgba(16, 185, 129, 0.5) !important;
        transition: all 0.2s ease !important;
    }

    .glow-mint-cta:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 0 35px -2px rgba(16, 185, 129, 0.7) !important;
    }

    /* Gradient Text & Highlights */
    .text-glow-mint {
        color: #34d399 !important;
        text-shadow: 0 0 12px rgba(52, 211, 153, 0.4);
    }
</style>
