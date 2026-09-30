<!DOCTYPE html>
<html lang="es" class="h-full bg-[#FAFAF9] text-slate-900 antialiased selection:bg-emerald-600 selection:text-white overflow-x-hidden scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AVI-Plan — Plataforma de Planes de Bienestar y Salud para Veterinarias</title>
    <meta name="description" content="Crea y vende tus propios planes de bienestar para mascotas, recibe pagos mensuales recurrentes directos y deja que tus tutores consulten y canjeen sus beneficios desde el celular. 15 días gratis.">
    <meta name="keywords" content="software veterinaria, planes de bienestar mascotas, membresias veterinarias, facturacion recurrente veterinaria, carnet digital mascotas, retencion clinica veterinaria, colombia">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / WhatsApp / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="AVI-Plan — Planes de Bienestar y Salud para Veterinarias">
    <meta property="og:description" content="Convierte tus clientes ocasionales en ingresos mensuales recurrentes. Crea planes de salud con tu propia marca. 15 días gratis.">
    <meta property="og:image" content="{{ url('/logo-app.png') }}">
    <meta property="og:site_name" content="AVI-Plan">
    <meta property="og:locale" content="es_CO">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="AVI-Plan — Planes de Bienestar para Veterinarias">
    <meta name="twitter:description" content="Crea planes de salud para mascotas con tu propia marca y recibe pagos mensuales recurrentes.">
    <meta name="twitter:image" content="{{ url('/logo-app.png') }}">

    <!-- Schema.org JSON-LD para Google Search -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "SoftwareApplication",
      "name": "AVI-Plan",
      "operatingSystem": "All, Web, Cloud",
      "applicationCategory": "BusinessApplication, HealthApplication",
      "offers": {
        "@@type": "Offer",
        "price": "99000",
        "priceCurrency": "COP",
        "priceValidUntil": "2027-12-31"
      },
      "description": "Plataforma de marca blanca para que clínicas veterinarias creen, cobren y gestionen planes de bienestar y salud para mascotas.",
      "url": "{{ url('/') }}",
      "logo": "{{ url('/logo.svg') }}"
    }
    </script>

    <!-- Google Analytics 4 (opcional configurado en .env) -->
    @if(env('GOOGLE_ANALYTICS_ID'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_ID') }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ env('GOOGLE_ANALYTICS_ID') }}');
    </script>
    @endif

    <link rel="icon" type="image/svg+xml" href="/logo.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .glass-nav { background: rgba(255, 255, 255, 0.94); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(226, 232, 240, 0.9); }
        .clinic-card { background: #FFFFFF; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04); transition: all 0.25s ease; }
        .clinic-card:hover { border-color: #CBD5E1; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08); }
        .gradient-headline { 
            background: linear-gradient(135deg, #047857 0%, #059669 50%, #0D9488 100%); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent; 
        }
        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        .animate-pulse-subtle { animation: pulse-subtle 2.5s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between overflow-x-hidden bg-[#FAFAF9] text-slate-900">

    <!-- 1. HEADER / NAVBAR CLÍNICO -->
    <header class="sticky top-0 z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 sm:h-20 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3 group">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl shadow-md shadow-emerald-900/10 group-hover:scale-105 transition-transform shrink-0 flex items-center justify-center bg-white border border-slate-200">
                    <img src="/logo.svg" alt="AVI-Plan Logo" class="w-9 h-9 object-contain">
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center space-x-2">
                        <span class="text-xl sm:text-2xl font-black tracking-tight text-slate-900 leading-tight">AVI<span class="text-emerald-700">Plan</span></span>
                        <span class="hidden sm:inline-block px-2 py-0.5 text-[10px] font-bold uppercase bg-emerald-50 text-emerald-800 rounded-md border border-emerald-200">
                            by AviPetApp
                        </span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-800 -mt-0.5">
                        Planes de Bienestar para Veterinarias
                    </span>
                </div>
            </a>
            
            <nav class="hidden lg:flex items-center space-x-7 text-xs sm:text-sm font-semibold text-slate-600">
                <a href="#como-funciona" class="hover:text-emerald-700 transition-colors">Cómo Funciona</a>
                <a href="#recibes" class="hover:text-emerald-700 transition-colors">Lo que Recibes</a>
                <a href="#calculadora" class="hover:text-emerald-700 transition-colors">Calculadora</a>
                <a href="#carnet-interactivo" class="hover:text-emerald-700 transition-colors">Carnet Digital</a>
                <a href="#inteligencia" class="hover:text-emerald-700 transition-colors">AVI Intelligence</a>
                <a href="#precios" class="hover:text-emerald-700 transition-colors">Precios</a>
                <a href="#faq" class="hover:text-emerald-700 transition-colors">FAQ</a>
            </nav>

            <div class="flex items-center space-x-3">
                <a href="/admin" class="hidden sm:inline-flex px-3.5 py-2 text-xs font-bold text-slate-700 hover:text-slate-900 transition-colors rounded-xl border border-transparent hover:border-slate-200">
                    Iniciar Sesión
                </a>
                <button type="button" onclick="openRegisterModal('pro')" class="px-4 sm:px-5 py-2.5 text-xs sm:text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 rounded-xl shadow-sm transition-all transform hover:-translate-y-0.5 flex items-center space-x-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                    <span>Probar AVI-Plan gratis</span>
                </button>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- 2. HERO SPLIT: PRODUCTO VIVO (COPY CONCRETO + DASHBOARD EN VIVO) -->
        <section class="relative pt-10 sm:pt-16 pb-16 sm:pb-24 overflow-hidden bg-gradient-to-b from-white via-[#FAFAF9] to-[#F1F5F9] border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                    
                    <!-- COLUMNA IZQUIERDA: PROPUESTA DE VALOR CONCRETA -->
                    <div class="lg:col-span-7 space-y-6 text-left">
                        
                        <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/90 text-emerald-800 text-xs font-semibold tracking-wide">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                            <span>15 días gratis · Sin tarjeta · Listo en 5 minutos</span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.12]">
                            Convierte tus clientes actuales en <span class="gradient-headline">ingresos mensuales recurrentes.</span>
                        </h1>

                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed font-normal max-w-2xl">
                            Crea planes de bienestar para mascotas, recibe cobros mensuales y deja que tus tutores consulten y canjeen sus beneficios desde su celular.
                        </p>

                        <!-- POSICIONAMIENTO MARCA BLANCA -->
                        <div class="flex items-center space-x-2 text-xs sm:text-sm font-mono font-bold text-emerald-800 uppercase tracking-wide bg-emerald-50/70 border border-emerald-200/60 px-3.5 py-1.5 rounded-xl w-fit">
                            <span>🏥 Tu marca · Tus planes · Tus precios · Tus clientes</span>
                        </div>

                        <!-- CTAs UNIFICADOS -->
                        <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5">
                            <button type="button" onclick="openRegisterModal('pro')" class="px-7 py-4 rounded-2xl bg-emerald-700 text-white font-bold text-base hover:bg-emerald-800 shadow-md shadow-emerald-700/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2 text-center">
                                <span>🟢 Probar AVI-Plan gratis</span>
                            </button>
                            <a href="#como-funciona" class="px-6 py-4 rounded-2xl bg-white hover:bg-slate-50 text-slate-800 font-bold text-sm sm:text-base border border-slate-300 shadow-xs transition-all flex items-center justify-center space-x-2 text-center">
                                <span>Ver cómo funciona →</span>
                            </a>
                        </div>

                        <!-- EJEMPLO REAL DE BOLSILLO -->
                        <div class="pt-3 p-4 rounded-2xl bg-white border border-slate-200 shadow-xs max-w-xl">
                            <div class="flex items-center justify-between text-xs sm:text-sm font-semibold text-slate-700">
                                <span class="text-slate-500">Ejemplo estimado de clínica:</span>
                                <span class="text-emerald-800 font-black font-mono">50 mascotas × $65.000/mes</span>
                            </div>
                            <div class="flex items-baseline justify-between mt-1 pt-1 border-t border-slate-100">
                                <span class="text-xs text-slate-500 font-medium">Facturación mensual recurrente directa:</span>
                                <span class="text-base sm:text-lg font-black text-slate-900 font-mono">$3.250.000 COP / mes</span>
                            </div>
                        </div>

                        <!-- MICRO TRUST -->
                        <div class="pt-1 flex flex-wrap items-center gap-5 text-xs text-slate-500 font-semibold">
                            <div class="flex items-center space-x-1.5">
                                <span class="text-emerald-700 font-bold">✓</span>
                                <span>Afiche QR para tu recepción</span>
                            </div>
                            <div class="flex items-center space-x-1.5">
                                <span class="text-emerald-700 font-bold">✓</span>
                                <span>Validación de canje en 3 seg</span>
                            </div>
                            <div class="flex items-center space-x-1.5">
                                <span class="text-emerald-700 font-bold">✓</span>
                                <span>100% cobro a tus cuentas bancarias</span>
                            </div>
                        </div>

                    </div>

                    <!-- COLUMNA DERECHA: DASHBOARD VIVO (PRODUCTO EN ACCIÓN) -->
                    <div class="lg:col-span-5">
                        <div class="relative w-full max-w-md mx-auto bg-white rounded-3xl border-2 border-emerald-600/60 shadow-2xl p-6 space-y-5">
                            
                            <!-- HEADER DEL WIDGET EN VIVO -->
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div class="flex items-center space-x-2.5">
                                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <div>
                                        <h3 class="text-xs font-black uppercase tracking-wider text-slate-900">En Vivo · Consultorio Demo</h3>
                                        <p class="text-[10px] text-slate-400 font-medium">Panel de Control de Membresías</p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-[10px] font-bold font-mono">
                                    AVI Intelligence
                                </span>
                            </div>

                            <!-- MÉTRICAS EN VIVO -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold uppercase text-slate-500">Mascotas Activas</span>
                                        <span class="text-xs">🐶</span>
                                    </div>
                                    <div id="live-pets-counter" class="text-2xl font-black text-slate-900 font-mono mt-1">127</div>
                                    <span class="text-[10px] font-semibold text-emerald-700">↑ +14 este mes</span>
                                </div>

                                <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold uppercase text-slate-500">MRR Recurrente</span>
                                        <span class="text-xs">💰</span>
                                    </div>
                                    <div id="live-mrr-counter" class="text-xl font-black text-emerald-800 font-mono mt-1">$8.255.000</div>
                                    <span class="text-[10px] font-semibold text-slate-500">100% en tus cuentas</span>
                                </div>

                                <div class="bg-amber-50/60 p-3 rounded-2xl border border-amber-200/80">
                                    <span class="text-[9px] font-bold uppercase text-amber-800 block">⚠️ Por renovar</span>
                                    <span class="text-sm font-extrabold text-amber-900 font-mono">6 planes esta semana</span>
                                </div>

                                <div class="bg-emerald-50/60 p-3 rounded-2xl border border-emerald-200/80">
                                    <span class="text-[9px] font-bold uppercase text-emerald-800 block">✓ Canjes de hoy</span>
                                    <span class="text-sm font-extrabold text-emerald-900 font-mono">12 servicios aplicados</span>
                                </div>
                            </div>

                            <!-- RETENCIÓN ANUAL -->
                            <div class="space-y-1.5 bg-slate-50 p-3 rounded-2xl border border-slate-200">
                                <div class="flex justify-between text-[11px] font-bold text-slate-700">
                                    <span>Tasa de fidelización anual</span>
                                    <span class="text-emerald-800 font-mono">82%</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-emerald-600 h-2 rounded-full transition-all duration-1000" style="width: 82%"></div>
                                </div>
                            </div>

                            <!-- TICKER DE ACTIVIDAD EN VIVO (ANIMADO AUTOMÁTICAMENTE) -->
                            <div class="space-y-2 border-t border-slate-100 pt-3">
                                <div class="flex items-center justify-between text-[10px] font-bold uppercase text-slate-400">
                                    <span>Actividad de mostrador</span>
                                    <span class="text-emerald-700 font-mono">hace unos momentos</span>
                                </div>
                                <div id="live-activity-box" class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 transition-all flex items-center space-x-2">
                                    <span class="text-base" id="live-activity-icon">🐕</span>
                                    <div class="truncate">
                                        <strong id="live-activity-title" class="text-slate-900">Luna (Golden)</strong>
                                        <span id="live-activity-desc" class="text-slate-500 block text-[11px]">Canjeó Vacuna Séxtuple en recepción</span>
                                    </div>
                                </div>
                            </div>

                            <!-- LINK AL PILOTO -->
                            <a href="/v/vet-pet-patitas" target="_blank" class="w-full py-2.5 text-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center justify-center space-x-1.5">
                                <span>Ver Clínica Piloto Completa</span>
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 3. SECCIÓN DE COEXISTENCIA: NO REEMPLAZAMOS TU SOFTWARE -->
        <section class="py-8 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-start sm:items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-2xl font-bold shrink-0">
                            🤝
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-base sm:text-lg font-bold text-slate-900">
                                Tranquilo: AVI-Plan no reemplaza tu software veterinario actual
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 max-w-3xl leading-relaxed">
                                Si ya utilizas <strong>Vetlogy, SoftVet, Gesvet o Excel</strong> para fichas médicas e inventario, ¡sigue usándolos! AVI-Plan es la capa especializada en <strong>planes de bienestar, membresías de salud y cobro recurrente</strong> que se suma a tu mostrador sin interrumpir tu clínica.
                            </p>
                        </div>
                    </div>
                    <div class="shrink-0 flex items-center space-x-2 text-xs font-bold text-slate-700 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-xs">
                        <span class="text-emerald-700">✓</span>
                        <span>100% Complementario</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. CALCULADORA MRR PROTAGONISTA (HERRAMIENTA REACTIVA) -->
        <section id="calculadora" class="py-16 sm:py-20 bg-[#FAFAF9] border-b border-slate-200">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                        Simulador Financiero en Tiempo Real
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">¿Cuánto podría generar tu veterinaria?</h2>
                    <p class="text-xs sm:text-sm text-slate-600">Mueve el número de mascotas y la tarifa para proyectar tu facturación recurrente.</p>
                </div>

                <div class="clinic-card p-6 sm:p-10 rounded-3xl space-y-8 bg-white border-2 border-slate-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        
                        <!-- CONTROLES REACTIVOS -->
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-baseline mb-2">
                                    <label class="text-xs font-bold text-slate-700 uppercase">Mascotas activas en planes:</label>
                                    <div class="flex items-baseline space-x-1">
                                        <span id="pets-count-display" class="text-3xl font-black text-emerald-800 font-mono">50</span>
                                        <span class="text-xs font-bold text-slate-500">mascotas</span>
                                    </div>
                                </div>
                                <input type="range" id="pets-slider" min="10" max="300" step="5" value="50" class="w-full h-3 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-700">
                                <div class="flex justify-between text-[11px] text-slate-500 font-semibold mt-1.5 font-mono">
                                    <span>10</span>
                                    <span>75</span>
                                    <span>150</span>
                                    <span>225</span>
                                    <span>300</span>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-slate-700 uppercase block mb-2">Tarifa promedio mensual del plan:</label>
                                <div class="grid grid-cols-3 gap-2.5">
                                    <button type="button" onclick="setPlanPrice(49000)" class="price-btn py-2.5 px-3 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-700 hover:border-emerald-600 transition" data-price="49000">
                                        $49.000 <span class="block text-[10px] text-slate-400 font-normal">Básico</span>
                                    </button>
                                    <button type="button" onclick="setPlanPrice(65000)" class="price-btn py-2.5 px-3 rounded-xl border-2 border-emerald-700 bg-emerald-50 text-xs font-black text-emerald-900 transition shadow-xs" data-price="65000">
                                        $65.000 ⭐ <span class="block text-[10px] text-emerald-700 font-medium">Recomendado</span>
                                    </button>
                                    <button type="button" onclick="setPlanPrice(89000)" class="price-btn py-2.5 px-3 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-700 hover:border-emerald-600 transition" data-price="89000">
                                        $89.000 <span class="block text-[10px] text-slate-400 font-normal">Premium</span>
                                    </button>
                                </div>
                            </div>

                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 space-y-1">
                                <div class="font-bold text-slate-800">💡 Consejo comercial para tu clínica:</div>
                                <p class="text-[11px] leading-snug">
                                    Un plan promedio de $65.000/mes incluye 2 consultas al año, vacuna séxtuple, rabia y desparasitaciones periódicas. El cliente ahorra y tu clínica asegura el paciente todo el año.
                                </p>
                            </div>
                        </div>

                        <!-- RESULTADOS ESTIMADOS -->
                        <div class="bg-gradient-to-br from-emerald-50/50 via-white to-slate-50 p-6 sm:p-7 rounded-3xl border-2 border-emerald-600 space-y-4 text-center shadow-md">
                            <div class="space-y-1">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-800">Ingreso recurrente mensual estimado</span>
                                <div id="mrr-monthly" class="text-4xl sm:text-5xl font-black text-slate-900 font-mono tracking-tight">$3.250.000</div>
                                <span class="text-[11px] text-slate-500 block pt-1">
                                    Ejemplo calculado según el número de mascotas y tarifa mensual seleccionados.
                                </span>
                            </div>

                            <hr class="border-slate-200">

                            <div class="grid grid-cols-2 gap-3 text-left">
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-2xs">
                                    <span class="text-[9px] uppercase font-bold text-slate-500 block">Facturación Anual</span>
                                    <span id="mrr-annual" class="text-sm sm:text-base font-black text-emerald-800 font-mono">$39.000.000</span>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-2xs">
                                    <span class="text-[9px] uppercase font-bold text-slate-500 block">Costo AVI-Plan</span>
                                    <span id="mrr-tier-cost" class="text-sm sm:text-base font-black text-slate-700 font-mono">$99.000<span class="text-[10px] font-normal text-slate-500">/mes</span></span>
                                </div>
                            </div>

                            <div class="bg-emerald-100/70 p-2.5 rounded-xl border border-emerald-200 text-xs font-bold text-emerald-900 flex justify-between items-center">
                                <span>Margen que retiene tu clínica:</span>
                                <span id="mrr-net-margin" class="font-mono text-sm">~97% directo</span>
                            </div>

                            <div class="pt-1">
                                <button type="button" onclick="openRegisterModal('pro')" class="w-full py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                                    Comenzar mi programa de bienestar →
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- 5. CÓMO FUNCIONA AVI-PLAN (FLUJO DE 6 ETAPAS INTERACTIVO) -->
        <section id="como-funciona" class="py-16 sm:py-24 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-14 space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                        Flujo Operativo Simple
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Así funciona en tu clínica</h2>
                    <p class="text-xs sm:text-sm text-slate-600">Un circuito cerrado diseñado para la velocidad en clínica y recepción.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                    <!-- PASO 01 -->
                    <div class="clinic-card p-5 rounded-2xl flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-2xl font-black font-mono text-emerald-700">01</span>
                            <h3 class="text-sm font-bold text-slate-900 mt-1">Crea tus planes</h3>
                        </div>
                        <p class="text-xs text-slate-600 leading-snug">
                            Define consultas, vacunas, desparasitaciones y fija tu tarifa mensual con total libertad.
                        </p>
                    </div>

                    <!-- PASO 02 -->
                    <div class="clinic-card p-5 rounded-2xl flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-2xl font-black font-mono text-emerald-700">02</span>
                            <h3 class="text-sm font-bold text-slate-900 mt-1">Escaneo en QR</h3>
                        </div>
                        <p class="text-xs text-slate-600 leading-snug">
                            El tutor escanea el afiche oficial en la sala de espera o entra a tu enlace web desde WhatsApp.
                        </p>
                    </div>

                    <!-- PASO 03 -->
                    <div class="clinic-card p-5 rounded-2xl flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-2xl font-black font-mono text-emerald-700">03</span>
                            <h3 class="text-sm font-bold text-slate-900 mt-1">Afiliación digital</h3>
                        </div>
                        <p class="text-xs text-slate-600 leading-snug">
                            Registra los datos de su mascota y adquiere su membresía en 2 minutos sin papeles ni firmas.
                        </p>
                    </div>

                    <!-- PASO 04 -->
                    <div class="clinic-card p-5 rounded-2xl flex flex-col justify-between space-y-3 border-emerald-300 bg-emerald-50/20">
                        <div>
                            <span class="text-2xl font-black font-mono text-emerald-700">04</span>
                            <h3 class="text-sm font-bold text-slate-900 mt-1">Carnet digital</h3>
                        </div>
                        <p class="text-xs text-slate-600 leading-snug">
                            Recibe al instante su carnet con código de barras en su celular para consultar sus saldos.
                        </p>
                    </div>

                    <!-- PASO 05 -->
                    <div class="clinic-card p-5 rounded-2xl flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-2xl font-black font-mono text-emerald-700">05</span>
                            <h3 class="text-sm font-bold text-slate-900 mt-1">Canje en caja</h3>
                        </div>
                        <p class="text-xs text-slate-600 leading-snug">
                            La recepcionista digita la cédula o escanea el QR y descuenta cupos en 3 segundos.
                        </p>
                    </div>

                    <!-- PASO 06 -->
                    <div class="clinic-card p-5 rounded-2xl flex flex-col justify-between space-y-3 border-amber-200 bg-amber-50/20">
                        <div>
                            <span class="text-2xl font-black font-mono text-amber-700">06</span>
                            <h3 class="text-sm font-bold text-slate-900 mt-1">Renovaciones</h3>
                        </div>
                        <p class="text-xs text-slate-600 leading-snug">
                            El sistema gestiona vencimientos y te ayuda a reactivar planes automáticamente.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. CÓMO VENDERLO A TUS CLIENTES ACTUALES (3 CANALES COMERCIALES) -->
        <section class="py-16 sm:py-20 bg-[#FAFAF9] border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                        Estrategia Comercial Práctica
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Cómo venderlo a tus clientes actuales</h2>
                    <p class="text-xs sm:text-sm text-slate-600">No necesitas buscar clientes desconocidos en la calle. Ya tienes pacientes en tu clínica.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- CANAL 1: AFICHE QR -->
                    <div class="clinic-card p-6 rounded-3xl space-y-3 bg-white">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl font-bold border border-emerald-200">
                            🖨️
                        </div>
                        <h3 class="text-base font-bold text-slate-900">1. Afiche en la Sala de Espera</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            El tutor espera su turno y ve el afiche en el mostrador: <em>"Ahorra en las vacunas de tu peludo con nuestro Plan de Bienestar"</em>. Escanea con su celular y se afilia mientras espera.
                        </p>
                    </div>

                    <!-- CANAL 2: RECOMENDACIÓN CLÍNICA -->
                    <div class="clinic-card p-6 rounded-3xl space-y-3 bg-white">
                        <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl font-bold border border-amber-200">
                            🩺
                        </div>
                        <h3 class="text-base font-bold text-slate-900">2. En el Momento de la Consulta</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Al atender al paciente, el veterinario le explica: <em>"Hoy le toca desparasitación y el próximo mes la vacuna. Si te afilias a nuestro plan mensual, te sale más económico y no descuidamos su salud"</em>.
                        </p>
                    </div>

                    <!-- CANAL 3: CAMPAÑA WHATSAPP -->
                    <div class="clinic-card p-6 rounded-3xl space-y-3 bg-white">
                        <div class="w-11 h-11 rounded-xl bg-slate-50 text-slate-700 flex items-center justify-center text-xl font-bold border border-slate-200">
                            💬
                        </div>
                        <h3 class="text-base font-bold text-slate-900">3. Campaña WhatsApp a tu Base</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Envías tu enlace web personalizado a los clientes que ya te conocen y confían en ti. El tutor entra desde su teléfono, elige el plan y activa la membresía de su mascota.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. LO QUE TU VETERINARIA RECIBE (LOS 5 ACTIVOS CONCRETOS) -->
        <section id="recibes" class="py-20 sm:py-24 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                        Todo Incluido en tu Prueba
                    </span>
                    <h2 class="text-3xl sm:text-5xl font-black text-slate-900 mt-2">Lo que tu veterinaria recibe en 60 segundos</h2>
                    <p class="text-sm sm:text-base text-slate-600">Herramientas completas para operar desde el primer día.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- 1. PORTAL WEB -->
                    <div class="clinic-card p-7 rounded-3xl space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl font-bold border border-emerald-200">
                            🌐
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Portal Web Marca Blanca</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Tu propia página web personalizada con tu logo, fotos y colores (ej: <code class="text-emerald-800 bg-emerald-50 px-1 py-0.5 rounded font-mono">avipetapp.com/v/tu-clinica</code>). Tus clientes consultan planes y se afilian online.
                        </p>
                    </div>

                    <!-- 2. AFICHE QR -->
                    <div class="clinic-card p-7 rounded-3xl space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-2xl font-bold border border-amber-200">
                            🖨️
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Afiche de Mostrador con QR</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Generado en tamaño Carta listo para imprimir en 1 clic. Colócalo en recepción para que los tutores en sala de espera se afilien con su celular sin recargar a tu equipo.
                        </p>
                    </div>

                    <!-- 3. CARNET DIGITAL -->
                    <div class="clinic-card p-7 rounded-3xl space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl font-bold border border-emerald-200">
                            🪪
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Carnet Digital Oficial</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Cada mascota recibe un carnet interactivo con código de barras en el celular del tutor. Muestra datos del peludo, vigencia y saldos de beneficios disponibles.
                        </p>
                    </div>

                    <!-- 4. MOSTRADOR DE CANJE -->
                    <div class="clinic-card p-7 rounded-3xl space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-700 flex items-center justify-center text-2xl font-bold border border-slate-200">
                            ⚡
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Mostrador de Canje en Vivo</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Búsqueda instantánea por cédula, teléfono o lector QR. Tu recepcionista visualiza de inmediato a qué servicios tiene derecho la mascota y descuenta cupos con auditoría.
                        </p>
                    </div>

                    <!-- 5. ASISTENTE DE IA (AVI INTELLIGENCE) -->
                    <div class="clinic-card p-7 rounded-3xl lg:col-span-2 space-y-3 border-2 border-emerald-600/30 bg-gradient-to-br from-white to-emerald-50/40">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-700 text-white flex items-center justify-center text-2xl font-bold shadow-sm">
                                🤖
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-800">Inteligencia Operativa</span>
                                <h3 class="text-lg font-bold text-slate-900">Asistente de IA (AVI Intelligence)</h3>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Identifica vencimientos, consulta afiliados y te ayuda a crear acciones de retención automática para tu clínica:
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-1 font-mono text-[11px]">
                            <div class="bg-white p-3 rounded-xl border border-slate-200 text-slate-700 shadow-xs">
                                🔔 "12 planes vencen en los próximos 7 días."
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-200 text-slate-700 shadow-xs">
                                🩺 "8 clientes no han usado sus beneficios."
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-200 text-slate-700 shadow-xs">
                                💉 "5 mascotas tienen vacunas pendientes."
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. CARNET DIGITAL INTERACTIVO (EXPERIENCIA DEL PACIENTE) -->
        <section id="carnet-interactivo" class="py-20 bg-[#FAFAF9] border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <div class="lg:col-span-6 space-y-6">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                            Experiencia del Tutor
                        </span>
                        <h2 class="text-3xl sm:text-5xl font-black text-slate-900 leading-tight">
                            Tu cliente lleva su carnet interactivo en el celular
                        </h2>
                        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                            Una experiencia móvil de primer nivel para el tutor de la mascota. Accede a su carnet digital, consulta los beneficios incluidos y conoce con exactitud qué servicios preventivos ya utilizó y cuáles tiene disponibles.
                        </p>

                        <div class="space-y-3 text-xs sm:text-sm text-slate-700 font-medium">
                            <div class="flex items-center space-x-2.5">
                                <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs">✓</span>
                                <span>Cero carnets de papel arrugados o perdidos.</span>
                            </div>
                            <div class="flex items-center space-x-2.5">
                                <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs">✓</span>
                                <span>Transparencia total en saldos y fechas de renovación.</span>
                            </div>
                            <div class="flex items-center space-x-2.5">
                                <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs">✓</span>
                                <span>Mayor fidelidad y sentido de pertenencia con tu veterinaria.</span>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="/v/vet-pet-patitas/carnet/VP-2026-0001" target="_blank" class="inline-flex items-center space-x-2 px-5 py-3 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 text-slate-800 text-xs font-bold shadow-xs transition">
                                <span>Ver carnet digital real en navegador</span>
                                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- MOCKUP DEL CARNET CON INTERACTIVIDAD REAL -->
                    <div class="lg:col-span-6 flex justify-center">
                        <div class="w-full max-w-sm bg-white rounded-3xl p-6 border-2 border-emerald-600 shadow-xl space-y-4">
                            
                            <!-- CABECERA CARNET -->
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-2xl font-bold border border-amber-200">
                                        🐶
                                    </div>
                                    <div>
                                        <h4 class="text-base font-black text-slate-900">Luna</h4>
                                        <p class="text-[11px] text-slate-500 font-medium">Golden Retriever • 2 años</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase border border-emerald-200">
                                    Activo ✓
                                </span>
                            </div>

                            <!-- DATOS BÁSICOS -->
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 space-y-1.5 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-slate-500 font-medium">Plan:</span>
                                    <span class="font-bold text-slate-900">Plan Premium Patitas</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500 font-medium">Cédula Tutor:</span>
                                    <span class="font-mono text-slate-700">CC 1.020.345.***</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500 font-medium">Próximo vencimiento:</span>
                                    <span class="font-bold text-amber-700">15 Octubre 2026</span>
                                </div>
                            </div>

                            <!-- RESUMEN DE BENEFICIOS CON ACCORDEÓN INTERACTIVO -->
                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-xs font-bold text-slate-700">
                                    <span>Beneficios del plan:</span>
                                    <span class="text-emerald-800 font-mono">5 de 8 canjeados</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-2">
                                    <div class="bg-emerald-600 h-2 rounded-full" style="width: 62.5%"></div>
                                </div>

                                <!-- BOTÓN EXPANDIR BENEFICIOS -->
                                <button type="button" onclick="toggleCarnetBenefits()" id="toggle-benefits-btn" class="w-full mt-2 py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs flex items-center justify-between transition">
                                    <span>Detalle de beneficios incluidos</span>
                                    <span id="benefits-chevron" class="text-emerald-700 font-mono transition-transform">▼</span>
                                </button>

                                <!-- DETALLE DESPLEGABLE -->
                                <div id="carnet-benefits-drawer" class="hidden pt-2 space-y-2 text-xs">
                                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 flex justify-between items-center">
                                        <div>
                                            <span class="font-bold text-slate-800 block text-[11px]">🩺 Consulta médica preventiva</span>
                                            <span class="text-[10px] text-slate-500">2 de 2 utilizadas</span>
                                        </div>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-slate-200 text-slate-600">Agotado</span>
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 flex justify-between items-center">
                                        <div>
                                            <span class="font-bold text-emerald-950 block text-[11px]">💉 Vacuna Séxtuple Anual</span>
                                            <span class="text-[10px] text-emerald-700">1 disponible para aplicar</span>
                                        </div>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-200 text-emerald-900">Disponible</span>
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 flex justify-between items-center">
                                        <div>
                                            <span class="font-bold text-emerald-950 block text-[11px]">💊 Desparasitación interna</span>
                                            <span class="text-[10px] text-emerald-700">2 de 3 disponibles</span>
                                        </div>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-200 text-emerald-900">Disponible</span>
                                    </div>
                                </div>
                            </div>

                            <!-- CÓDIGO DE BARRAS SIMULADO -->
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-center space-y-1">
                                <div class="font-mono text-base tracking-[0.3em] font-black text-slate-800">||| | |||| | ||| ||</div>
                                <span class="text-[10px] font-mono text-slate-400">VP-2026-0001</span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 9. AVI INTELLIGENCE: LA IA TRABAJANDO EN VIVO -->
        <section id="inteligencia" class="py-20 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14 space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                        Inteligencia Proactiva
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Tu Asistente de IA trabaja mientras atiendes pacientes</h2>
                    <p class="text-xs sm:text-sm text-slate-600">AVI Intelligence detecta oportunidades de renovación y citas preventivas automáticamente.</p>
                </div>

                <div class="max-w-4xl mx-auto clinic-card p-6 sm:p-8 rounded-3xl border-2 border-emerald-600/50 bg-gradient-to-br from-white via-slate-50 to-emerald-50/20 space-y-6 shadow-lg">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-200 pb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white flex items-center justify-center text-xl font-bold shadow-xs">
                                🤖
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Simulación: Análisis del día de tu clínica</h3>
                                <p class="text-xs text-slate-500">Oportunidades de fidelización detectadas hoy</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-900 text-xs font-bold font-mono">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                            <span>3 Alertas de Retención</span>
                        </span>
                    </div>

                    <!-- TARJETAS DE ACCIÓN DE IA -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        
                        <div class="bg-white p-4 rounded-2xl border border-slate-200 space-y-3 shadow-xs">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-amber-700">⚠️ Vencimientos</span>
                                <span class="font-mono text-[10px] text-slate-400">Próximos 7 días</span>
                            </div>
                            <p class="text-xs text-slate-700 leading-snug">
                                <strong>12 planes por vencer</strong> este fin de mes.
                            </p>
                            <button type="button" onclick="simulateAiAction(this, 'WhatsApp de renovación preparado')" class="w-full py-2 px-3 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-[11px] font-bold border border-emerald-200 transition text-center">
                                Enviar WhatsApp con 1 Clic
                            </button>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border border-slate-200 space-y-3 shadow-xs">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-emerald-700">🩺 Chequeos Preventivos</span>
                                <span class="font-mono text-[10px] text-slate-400">Sin uso > 6 meses</span>
                            </div>
                            <p class="text-xs text-slate-700 leading-snug">
                                <strong>8 tutores</strong> no han usado su chequeo incluido.
                            </p>
                            <button type="button" onclick="simulateAiAction(this, 'Invitación a chequeo agendada')" class="w-full py-2 px-3 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-[11px] font-bold border border-emerald-200 transition text-center">
                                Invitar a Chequeo Gratuito
                            </button>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border border-slate-200 space-y-3 shadow-xs">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-indigo-700">💉 Vacunación Pendiente</span>
                                <span class="font-mono text-[10px] text-slate-400">Refuerzo Anual</span>
                            </div>
                            <p class="text-xs text-slate-700 leading-snug">
                                <strong>5 mascotas</strong> tienen refuerzo disponible.
                            </p>
                            <button type="button" onclick="simulateAiAction(this, 'Recordatorio de vacuna enviado')" class="w-full py-2 px-3 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-[11px] font-bold border border-emerald-200 transition text-center">
                                Notificar por WhatsApp
                            </button>
                        </div>

                    </div>

                    <div id="ai-toast" class="hidden p-3 rounded-xl bg-emerald-700 text-white text-xs font-bold text-center transition-all">
                        ¡Acción de IA simulada con éxito!
                    </div>

                </div>
            </div>
        </section>

        <!-- 10. EVOLUCIÓN: DE VISITAS OCASIONALES A RELACIÓN TODO EL AÑO -->
        <section class="py-20 bg-[#FAFAF9] border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14 space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                        Modelo de Atención
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">De visitas ocasionales a una relación todo el año</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- SIN PLANES -->
                    <div class="clinic-card p-6 sm:p-8 rounded-3xl border-rose-200 bg-rose-50/20 space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-xl">✕</div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Sin planes de salud</h3>
                                <p class="text-xs text-rose-700 font-medium">Ingresos dependientes de cada visita puntual</p>
                            </div>
                        </div>
                        <ul class="space-y-3 text-xs sm:text-sm text-slate-600">
                            <li class="flex items-start space-x-2">
                                <span class="text-rose-600 font-bold">✕</span>
                                <span>El cliente paga únicamente cuando necesita un servicio de urgencia o enfermedad.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-rose-600 font-bold">✕</span>
                                <span>Las visitas preventivas se pierden o se posponen indefinidamente.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-rose-600 font-bold">✕</span>
                                <span>El seguimiento clínico depende de llamadas manuales de la recepcionista.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-rose-600 font-bold">✕</span>
                                <span>La relación con el cliente se corta al terminar la consulta.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CON AVI-PLAN -->
                    <div class="clinic-card p-6 sm:p-8 rounded-3xl border-2 border-emerald-600 bg-emerald-50/20 space-y-4 shadow-md">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xl">✓</div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Con AVI-Plan</h3>
                                <p class="text-xs text-emerald-800 font-bold">Un programa para mantener la relación todo el año</p>
                            </div>
                        </div>
                        <ul class="space-y-3 text-xs sm:text-sm text-slate-700">
                            <li class="flex items-start space-x-2">
                                <span class="text-emerald-700 font-bold">✓</span>
                                <span>El cliente adquiere una membresía con cobertura programada.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-emerald-700 font-bold">✓</span>
                                <span>Los beneficios incluidos incentivan chequeos y vacunas preventivas.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-emerald-700 font-bold">✓</span>
                                <span>La clínica comunica renovaciones y vencimientos oportunamente.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-emerald-700 font-bold">✓</span>
                                <span>Creas nuevas oportunidades de venta y fidelización en cada visita.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- 11. SEGURIDAD Y CONFIANZA: ¿DÓNDE ESTÁ MI DINERO? -->
        <section class="py-16 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="p-8 sm:p-10 rounded-3xl bg-slate-50 border border-slate-200 space-y-6">
                    <div class="max-w-2xl space-y-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                            Transparencia y Cuentas Claras
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900">¿Dónde está el dinero de los planes?</h2>
                        <p class="text-xs sm:text-sm text-slate-600">
                            El 100% de los cobros ingresa directamente a tus cuentas bancarias o pasarelas de pago.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-2">
                            <div class="text-2xl">🏦</div>
                            <h4 class="text-sm font-bold text-slate-900">Tus Medios de Pago Habituales</h4>
                            <p class="text-xs text-slate-600">
                                Cobra por Bancolombia, Nequi, Daviplata, datafono o pasarelas online como Bold y Wompi.
                            </p>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-2">
                            <div class="text-2xl">🚫</div>
                            <h4 class="text-sm font-bold text-slate-900">Cero Comisión por Mascota</h4>
                            <p class="text-xs text-slate-600">
                                AVI-Plan no retiene tu dinero ni cobra porcentajes sobre tus ventas. Solo pagas una suscripción fija mensual de software.
                            </p>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-2">
                            <div class="text-2xl">🔒</div>
                            <h4 class="text-sm font-bold text-slate-900">Tus Datos son Tuyos</h4>
                            <p class="text-xs text-slate-600">
                                Tu base de datos de tutores y mascotas es 100% privada e intransferible, protegida con arquitectura multi-tenant aislada.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 12. PRECIOS TRANSPARENTES (CON JUSTIFICACIÓN ROI) -->
        <section id="precios" class="py-20 sm:py-24 bg-[#FAFAF9] border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                        Planes Transparentes
                    </span>
                    <h2 class="text-3xl sm:text-5xl font-black text-slate-900 mt-2">Prueba gratuita de 15 días</h2>
                    <p class="text-sm sm:text-base text-slate-600">Sin tarjeta de crédito requerida. Con solo 2 mascotas afiliadas el software se paga solo.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                    
                    <!-- STARTER -->
                    <div class="clinic-card p-8 rounded-3xl flex flex-col justify-between bg-white">
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Consultorios</span>
                            <h3 class="text-2xl font-black text-slate-900">Starter</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 font-mono">$99.000</span>
                                <span class="text-slate-500 text-sm">COP / mes</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Hasta 60 mascotas activas*. Ideal para consultorios independientes.
                            </p>
                            <hr class="border-slate-100">
                            <ul class="space-y-2.5 text-xs text-slate-700 font-medium">
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span>Portal web propio con tu marca</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span>Afiche de mostrador con QR</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span>1 Usuario para recepción</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span>Mostrador de canje en vivo</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span>Soporte por WhatsApp</span></li>
                            </ul>
                        </div>
                        <button type="button" onclick="openRegisterModal('starter')" class="mt-8 w-full py-3.5 text-center rounded-xl bg-white hover:bg-slate-50 text-slate-900 font-bold text-sm border border-slate-300 transition">
                            Elegir Starter
                        </button>
                    </div>

                    <!-- PROFESIONAL (POPULAR) -->
                    <div class="clinic-card p-8 rounded-3xl flex flex-col justify-between border-2 border-emerald-700 shadow-xl relative transform lg:-translate-y-2 bg-white">
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-emerald-700 text-white font-bold text-[11px] uppercase tracking-wider shadow-sm">
                            ⭐ MÁS ELEGIDO
                        </div>
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Clínicas en Crecimiento</span>
                            <h3 class="text-2xl font-black text-slate-900">Profesional</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-4xl sm:text-5xl font-extrabold text-emerald-800 font-mono">$229.000</span>
                                <span class="text-slate-500 text-sm">COP / mes</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Hasta 250 mascotas activas* + Usuarios ilimitados + AVI Intelligence.
                            </p>
                            <hr class="border-slate-100">
                            <ul class="space-y-2.5 text-xs text-slate-800 font-medium">
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span><strong>Todo lo del plan Starter</strong></span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span><strong>Usuarios ilimitados</strong> para tu equipo</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span><strong>AVI Intelligence:</strong> Detección automática de retención y vencimientos</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span>Reportes de facturación recurrente</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span>Soporte prioritario</span></li>
                            </ul>
                        </div>
                        <button type="button" onclick="openRegisterModal('pro')" class="mt-8 w-full py-4 text-center rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm shadow-md transition transform hover:scale-[1.02]">
                            Comenzar Prueba Gratuita →
                        </button>
                    </div>

                    <!-- ENTERPRISE -->
                    <div class="clinic-card p-8 rounded-3xl flex flex-col justify-between bg-white">
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hospitales y Redes</span>
                            <h3 class="text-2xl font-black text-slate-900">Enterprise</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 font-mono">$489.000</span>
                                <span class="text-slate-500 text-sm">COP / mes</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Mascotas ilimitadas + Multi-sucursal + Dominio Propio.</p>
                            <hr class="border-slate-100">
                            <ul class="space-y-2.5 text-xs text-slate-700 font-medium">
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span><strong>Mascotas y afiliados ilimitados</strong></span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span>Múltiples sedes y sucursales conectadas</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span>Dominio propio personalizado (<code class="text-emerald-800 font-mono">tuclinica.com</code>)</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span>Integración WhatsApp</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-700 font-bold">✓</span> <span>Acompañamiento en puesta en marcha</span></li>
                            </ul>
                        </div>
                        <a href="https://wa.me/573508742543?text=Hola%20Robinson,%20me%20interesa%20el%20plan%20Enterprise%20de%20AVI-Plan" target="_blank" class="mt-8 w-full py-3.5 text-center rounded-xl bg-white hover:bg-slate-50 text-slate-900 font-bold text-sm border border-slate-300 transition">
                            Contactar Asesor
                        </a>
                    </div>
                </div>

                <div class="mt-8 text-center text-xs text-slate-500">
                    * <strong>Mascota activa:</strong> Mascota que cuenta con un plan o membresía vigente en el mes. Si superas el límite de tu plan, puedes subir de nivel en cualquier momento sin perder datos ni interrumpir a tus afiliados.
                </div>
            </div>
        </section>

        <!-- 13. PREGUNTAS FRECUENTES (FAQ CLÍNICO) -->
        <section id="faq" class="py-16 sm:py-20 bg-white border-b border-slate-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <div class="text-center space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                        Dudas Frecuentes
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Preguntas Frecuentes</h2>
                </div>

                <div class="space-y-4">
                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿Tengo que reemplazar mi software actual de historia clínica?</span>
                            <span class="text-emerald-700 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            <strong>No.</strong> AVI-Plan no busca competir con tu software de historia médica o inventarios (SoftVet, Gesvet, Vetlogy, etc.). AVI-Plan es una <strong>plataforma especializada en planes de bienestar, membresías y facturación recurrente</strong>. Convive perfectamente con cualquier sistema que uses hoy.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿AVI-Plan cobra comisión por cada plan vendido?</span>
                            <span class="text-emerald-700 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            <strong>No.</strong> El 100% del dinero cobrado a tus clientes va directo a tus cuentas o medios de pago. No retenemos tu dinero ni cobramos porcentajes por transacción. Solo pagas la suscripción fija mensual de la plataforma.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿Puedo crear mis propios beneficios y precios?</span>
                            <span class="text-emerald-700 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            <strong>Sí, con total libertad.</strong> Puedes definir el nombre de tus planes, qué servicios incluye cada uno (número de consultas, vacunas, desparasitaciones, baños o profilaxis) y el precio que desees cobrar.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿Cómo pagan las suscripciones los clientes?</span>
                            <span class="text-emerald-700 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            Puedes configurar tus cuentas habituales: Nequi, Daviplata, transferencia Bancolombia, o enlazar botones de pago digitales como Bold o Wompi.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿Puedo utilizar mi propio dominio?</span>
                            <span class="text-emerald-700 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            Por defecto tienes un subdominio seguro (ej: <code class="text-emerald-800 bg-emerald-50 px-1 py-0.5 rounded font-mono">avipetapp.com/v/tu-clinica</code>). En el plan Enterprise, puedes conectar directamente tu propio dominio o subdominio corporativo (ej: <code class="text-emerald-800 bg-emerald-50 px-1 py-0.5 rounded font-mono">salud.tuclinica.com</code>).
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿Qué ocurre cuando terminan los 15 días gratis?</span>
                            <span class="text-emerald-700 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            No solicitamos tarjeta de crédito para iniciar. Antes de finalizar el periodo te consultaremos si deseas continuar con el plan Starter o Profesional. Si decides no continuar, tu cuenta se pausa sin ningún cargo ni penalidad.
                        </p>
                    </details>
                </div>
            </div>
        </section>

        <!-- 14. CTA FINAL LUMINOSO -->
        <section class="py-20 bg-gradient-to-b from-[#FAFAF9] to-white">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="clinic-card p-8 sm:p-14 rounded-3xl border-2 border-emerald-600/50 text-center space-y-6 shadow-lg bg-emerald-50/20">
                    <h2 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">
                        Crea el programa de salud de tu veterinaria hoy mismo
                    </h2>
                    <p class="text-sm sm:text-lg text-slate-600 max-w-2xl mx-auto font-normal">
                        Tu marca · Tus planes · Tus precios · Tus clientes
                    </p>
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button type="button" onclick="openRegisterModal('pro')" class="w-full sm:w-auto px-9 py-4 rounded-2xl bg-emerald-700 text-white font-bold text-base hover:bg-emerald-800 shadow-md transition transform hover:-translate-y-0.5">
                            🟢 Probar AVI-Plan gratis
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER B2B CLÍNICO -->
    <footer class="border-t border-slate-200 py-10 bg-white text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <img src="/logo.svg" alt="AVI-Plan Logo" class="w-7 h-7 object-contain">
                <div>
                    <span class="font-extrabold text-slate-900">AVI<span class="text-emerald-700">Plan</span></span>
                    <span class="text-xs text-slate-500"> — Plataforma de Planes de Bienestar para Veterinarias.</span>
                </div>
            </div>
            <div class="flex space-x-6 font-semibold">
                <a href="/admin" class="hover:text-emerald-700 transition-colors">Acceso Mostrador</a>
                <a href="/v/vet-pet-patitas" class="hover:text-emerald-700 transition-colors">Clínica Piloto</a>
                <a href="https://wa.me/573508742543" target="_blank" class="hover:text-emerald-700 transition-colors">Contacto WhatsApp</a>
            </div>
        </div>
    </footer>

    <!-- MODAL DE REGISTRO EXPRESS CLÍNICO -->
    <div id="register-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 hidden transition-opacity opacity-0 pointer-events-none">
        <div class="relative w-full max-w-lg bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 text-slate-900 transform scale-95 transition-transform">
            
            <button type="button" onclick="closeRegisterModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 p-2 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="space-y-1">
                <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-bold uppercase border border-emerald-200">
                    <span>Prueba Gratuita de 15 Días</span>
                </div>
                <h3 class="text-2xl font-black text-slate-900">Crea tu Clínica Veterinaria</h3>
                <p class="text-xs text-slate-500 font-medium">Empieza a configurar tus planes y tu afiche en 60 segundos.</p>
            </div>

            <!-- FORMULARIO AJAX -->
            <form id="clinic-onboarding-form" onsubmit="submitOnboarding(event)" class="space-y-4">
                @csrf
                <input type="hidden" name="saas_plan_tier" id="form-tier" value="pro">

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nombre de tu Veterinaria <span class="text-emerald-700">*</span></label>
                    <input type="text" name="clinic_name" id="clinic-name-input" required placeholder="Ej. Veterinaria San Roque" oninput="updateSlugPreview(this.value)" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:border-emerald-600 focus:bg-white transition placeholder:text-slate-400">
                    <p class="text-[10px] text-slate-500 mt-1 font-mono">
                        Tu web será: <span id="slug-preview" class="text-emerald-800 font-bold">avipetapp.com/v/tu-clinica</span>
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ciudad <span class="text-emerald-700">*</span></label>
                        <input type="text" name="city" required placeholder="Ej. Bogotá / Medellín" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:border-emerald-600 focus:bg-white transition placeholder:text-slate-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">WhatsApp de Contacto <span class="text-emerald-700">*</span></label>
                        <input type="tel" name="phone" required placeholder="Ej. 3101234567" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:border-emerald-600 focus:bg-white transition placeholder:text-slate-400">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Correo Electrónico (Tu usuario) <span class="text-emerald-700">*</span></label>
                    <input type="email" name="email" required placeholder="doctor@tuclinica.com" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:border-emerald-600 focus:bg-white transition placeholder:text-slate-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Contraseña <span class="text-emerald-700">*</span></label>
                    <input type="password" name="password" required minlength="6" placeholder="Mínimo 6 caracteres" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:border-emerald-600 focus:bg-white transition placeholder:text-slate-400">
                </div>

                <div id="form-error-alert" class="hidden p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium"></div>

                <button type="submit" id="submit-btn" class="w-full py-3.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm shadow-md transition transform active:scale-95 flex items-center justify-center space-x-2">
                    <span id="btn-text">🚀 Activar mi Clínica Gratis</span>
                    <span id="btn-spinner" class="hidden animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></span>
                </button>

                <p class="text-[10px] text-center text-slate-500">
                    Sin tarjeta de crédito requerida. Acceso inmediato.
                </p>
            </form>
        </div>
    </div>

    <!-- SCRIPTS INTERACTIVOS -->
    <script>
        // MODAL
        function openRegisterModal(tier = 'pro') {
            document.getElementById('form-tier').value = tier;
            const modal = document.getElementById('register-modal');
            modal.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
            setTimeout(() => document.getElementById('clinic-name-input').focus(), 150);
        }

        function closeRegisterModal() {
            const modal = document.getElementById('register-modal');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.querySelector('div').classList.remove('scale-100');
            modal.querySelector('div').classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 200);
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeRegisterModal();
        });

        function updateSlugPreview(name) {
            const clean = name.toLowerCase()
                .trim()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]/g, '-')
                .replace(/-+/g, '-');
            const preview = clean || 'tu-clinica';
            document.getElementById('slug-preview').innerText = `avipetapp.com/v/${preview}`;
        }

        async function submitOnboarding(event) {
            event.preventDefault();
            const form = event.target;
            const errorAlert = document.getElementById('form-error-alert');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnSpinner = document.getElementById('btn-spinner');

            errorAlert.classList.add('hidden');
            submitBtn.disabled = true;
            btnText.innerText = 'Creando tu plataforma y afiche...';
            btnSpinner.classList.remove('hidden');

            const formData = new FormData(form);

            try {
                const response = await fetch('/registro-clinica', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    let errorMsg = data.message || 'Error al procesar el registro.';
                    if (data.errors) {
                        const firstError = Object.values(data.errors)[0];
                        if (Array.isArray(firstError)) errorMsg = firstError[0];
                    }
                    throw new Error(errorMsg);
                }

                btnText.innerText = '¡Listo! Entrando a tu panel...';
                window.location.href = data.redirect_url;

            } catch (err) {
                errorAlert.innerText = err.message;
                errorAlert.classList.remove('hidden');
                submitBtn.disabled = false;
                btnText.innerText = '🚀 Activar mi Clínica Gratis';
                btnSpinner.classList.add('hidden');
            }
        }

        // CALCULADORA MRR
        let currentPlanPrice = 65000;
        const petsSlider = document.getElementById('pets-slider');
        const petsCountDisplay = document.getElementById('pets-count-display');
        const mrrMonthly = document.getElementById('mrr-monthly');
        const mrrAnnual = document.getElementById('mrr-annual');
        const mrrTierCost = document.getElementById('mrr-tier-cost');
        const mrrNetMargin = document.getElementById('mrr-net-margin');

        function formatCOP(num) {
            return '$' + num.toLocaleString('es-CO');
        }

        function calculateMRR() {
            const count = parseInt(petsSlider.value);
            petsCountDisplay.innerText = count;

            const monthly = count * currentPlanPrice;
            const annual = monthly * 12;

            mrrMonthly.innerText = formatCOP(monthly);
            mrrAnnual.innerText = formatCOP(annual);

            // Costo estimado según tier
            let cost = 99000;
            if (count > 60 && count <= 250) {
                cost = 229000;
            } else if (count > 250) {
                cost = 489000;
            }
            mrrTierCost.innerHTML = formatCOP(cost) + '<span class="text-[10px] font-normal text-slate-500">/mes</span>';

            const margin = Math.max(0, Math.round(((monthly - cost) / monthly) * 100));
            mrrNetMargin.innerText = `~${margin}% neto (${formatCOP(monthly - cost)}/mes)`;
        }

        petsSlider.addEventListener('input', calculateMRR);

        function setPlanPrice(price) {
            currentPlanPrice = price;
            document.querySelectorAll('.price-btn').forEach(btn => {
                const p = parseInt(btn.getAttribute('data-price'));
                if (p === price) {
                    btn.className = 'price-btn py-2.5 px-3 rounded-xl border-2 border-emerald-700 bg-emerald-50 text-xs font-black text-emerald-900 transition shadow-xs';
                } else {
                    btn.className = 'price-btn py-2.5 px-3 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-700 hover:border-emerald-600 transition';
                }
            });
            calculateMRR();
        }

        calculateMRR();

        // TICKER DE ACTIVIDAD EN VIVO EN EL HERO
        const activities = [
            { icon: '🐕', title: 'Luna (Golden Retriever)', desc: 'Canjeó Vacuna Séxtuple en recepción' },
            { icon: '🐈', title: 'Simba (Gato Mestizo)', desc: 'Nuevo afiliado desde el Afiche QR de mostrador' },
            { icon: '🐩', title: 'Max (Poodle Toy)', desc: 'Renovó Plan Patitas por $65.000 / mes' },
            { icon: '🐶', title: 'Rocky (Bulldog Francés)', desc: 'Completó chequeo médico y desparasitación' },
            { icon: '🐱', title: 'Mía (Persa)', desc: 'Canjeó baño medicado preventivo' }
        ];
        let currentActivityIndex = 0;

        function cycleLiveActivity() {
            currentActivityIndex = (currentActivityIndex + 1) % activities.length;
            const item = activities[currentActivityIndex];
            const box = document.getElementById('live-activity-box');
            
            box.style.opacity = '0';
            setTimeout(() => {
                document.getElementById('live-activity-icon').innerText = item.icon;
                document.getElementById('live-activity-title').innerText = item.title;
                document.getElementById('live-activity-desc').innerText = item.desc;
                box.style.opacity = '1';
            }, 300);
        }

        setInterval(cycleLiveActivity, 4000);

        // CARNET INTERACTIVO ACCORDEÓN
        function toggleCarnetBenefits() {
            const drawer = document.getElementById('carnet-benefits-drawer');
            const chevron = document.getElementById('benefits-chevron');
            if (drawer.classList.contains('hidden')) {
                drawer.classList.remove('hidden');
                chevron.innerText = '▲';
            } else {
                drawer.classList.add('hidden');
                chevron.innerText = '▼';
            }
        }

        // SIMULADOR DE ACCIÓN IA
        function simulateAiAction(btn, msg) {
            const originalText = btn.innerText;
            btn.innerText = '✓ Procesando...';
            btn.disabled = true;
            btn.classList.add('bg-emerald-700', 'text-white');

            const toast = document.getElementById('ai-toast');
            toast.innerText = `🤖 AVI Intelligence: ${msg}`;
            toast.classList.remove('hidden');

            setTimeout(() => {
                btn.innerText = '✓ ' + originalText;
                btn.disabled = false;
                btn.classList.remove('bg-emerald-700', 'text-white');
            }, 2500);

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 4000);
        }
    </script>
</body>
</html>
