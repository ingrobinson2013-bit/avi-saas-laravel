<style>
    /* =========================================================
       AVI-SAAS: PALETA MÉDICA & SALUD VETERINARIA HIGH-END
       Inspirada en plataformas líderes de HealthTech & Clínicas
       ========================================================= */

    :root {
        --medical-primary: #0d9488;      /* Teal Clínico */
        --medical-primary-hover: #0f766e;
        --medical-emerald: #059669;      /* Verde Salud */
        --medical-cyan: #0284c7;         /* Cyan Médico */
        --medical-indigo: #4f46e5;       /* Indigo Hospitalario */
        --medical-amber: #d97706;        /* Ámbar Alerta */
        --medical-rose: #e11d48;         /* Rosa Urgencia */
    }

    /* 1. MODO OSCURO MÉDICO ELEGANTE (Slate Navy Profundo con Alto Contraste) */
    .dark body,
    .dark .fi-layout {
        background-color: #0c1322 !important;
        color: #f8fafc !important;
    }

    .dark .fi-sidebar {
        background-color: #0f172a !important;
        border-right: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .dark .fi-topbar {
        background-color: #0f172a !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .dark .fi-section,
    .dark .fi-wi-stats-overview-stat,
    .dark .fi-ta-ctn,
    .dark .fi-modal-window {
        background-color: #152238 !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 1rem !important;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.3) !important;
    }

    /* 2. MODO CLARO CLÍNICO IMPECABLE (Fresco, Limpio, Sanitario) */
    body:not(.dark),
    .fi-layout:not(.dark) {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
    }

    body:not(.dark) .fi-sidebar {
        background-color: #ffffff !important;
        border-right: 1px solid #e2e8f0 !important;
    }

    body:not(.dark) .fi-topbar {
        background-color: #ffffff !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }

    body:not(.dark) .fi-section,
    body:not(.dark) .fi-wi-stats-overview-stat,
    body:not(.dark) .fi-ta-ctn,
    body:not(.dark) .fi-modal-window {
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 1rem !important;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05) !important;
    }

    /* 3. TARJETAS DE KPIS & STATS CON ESTILO CLÍNICO */
    .fi-wi-stats-overview-stat {
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }

    .fi-wi-stats-overview-stat:hover {
        transform: translateY(-2px) !important;
    }

    /* 4. TABLAS MÉDICAS LIMPIAS SIN DESBORDES */
    .fi-ta-header-cell {
        font-weight: 800 !important;
        font-size: 0.75rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
    }

    .dark .fi-ta-header-cell {
        background-color: #111c30 !important;
        color: #94a3b8 !important;
    }

    body:not(.dark) .fi-ta-header-cell {
        background-color: #f8fafc !important;
        color: #64748b !important;
    }

    .dark .fi-ta-row:hover {
        background-color: rgba(255, 255, 255, 0.02) !important;
    }

    /* 5. BADGES MÉDICOS REDONDEADOS */
    .fi-badge {
        border-radius: 9999px !important;
        font-weight: 700 !important;
        padding-left: 0.625rem !important;
        padding-right: 0.625rem !important;
    }
</style>
