<!DOCTYPE html>
<html lang="es" class="h-full bg-[#FAFAF9] text-slate-900 antialiased selection:bg-blue-600 selection:text-white overflow-x-hidden scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $gaId = env('GOOGLE_TAG_ID', 'G-YRPKPVXZ2T') ?: env('GOOGLE_ANALYTICS_ID', 'G-YRPKPVXZ2T');
        $gtmId = env('GOOGLE_TAG_MANAGER_ID');
        $cfToken = env('CLOUDFLARE_ANALYTICS_TOKEN');
        $canonicalUrl = 'https://avipetapp.com';
    @endphp
    <title>AVI-Plan — Software de Planes de Salud Preventiva para Clínicas Veterinarias | Recurrencia Mensual</title>
    <meta name="description" content="Convierte clientes ocasionales en ingresos mensuales recurrentes fijos. Software SaaS para clínicas veterinarias en Colombia: planes de salud para mascotas, carnet digital, terminal de canje y retención anti-churn. 15 días gratis.">
    <meta name="keywords" content="software veterinaria colombia, software para clinicas veterinarias, planes de bienestar mascotas, membresias veterinarias, facturacion recurrente veterinaria, carnet digital mascotas, retencion clinica veterinaria, saas veterinario, software gestion veterinaria bogota medellin cali barranquilla cajica">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Open Graph / WhatsApp / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="AVI-Plan — Planes de Salud y Bienestar para Veterinarias | Ingresos Recurrentes">
    <meta property="og:description" content="Garantiza ingresos fijos mes a mes para tu clínica veterinaria. Crea planes de salud preventiva para mascotas con tu propia marca. 15 días gratis.">
    <meta property="og:image" content="{{ url('/logo-app.png') }}">
    <meta property="og:site_name" content="AVI-Plan">
    <meta property="og:locale" content="es_CO">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="AVI-Plan — Planes de Salud para Mascotas | Software Veterinario">
    <meta name="twitter:description" content="Crea planes de salud para mascotas con tu propia marca y recibe pagos mensuales recurrentes.">
    <meta name="twitter:image" content="{{ url('/logo-app.png') }}">

    <!-- Schema.org JSON-LD Enriquecido para Google Search -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@@type": "Organization",
          "@@id": "https://avipetapp.com/#organization",
          "name": "AVI-Plan",
          "url": "https://avipetapp.com",
          "logo": {
            "@@type": "ImageObject",
            "url": "{{ url('/logo-app.png') }}"
          },
          "contactPoint": {
            "@@type": "ContactPoint",
            "telephone": "+573235813942",
            "contactType": "sales",
            "areaServed": "CO",
            "availableLanguage": "Spanish"
          }
        },
        {
          "@@type": "SoftwareApplication",
          "@@id": "https://avipetapp.com/#software",
          "name": "AVI-Plan SaaS Veterinario",
          "operatingSystem": "All, Web, Cloud",
          "applicationCategory": "BusinessApplication, HealthApplication",
          "offers": {
            "@@type": "Offer",
            "price": "99000",
            "priceCurrency": "COP",
            "priceValidUntil": "2027-12-31"
          },
          "aggregateRating": {
            "@@type": "AggregateRating",
            "ratingValue": "4.9",
            "reviewCount": "38"
          },
          "description": "Software especializado para que clínicas veterinarias creen, cobren y gestionen planes de bienestar y salud preventiva para mascotas.",
          "url": "https://avipetapp.com",
          "image": "{{ url('/logo-app.png') }}"
        },
        {
          "@@type": "FAQPage",
          "@@id": "https://avipetapp.com/#faq",
          "mainEntity": [
            {
              "@@type": "Question",
              "name": "¿En qué momento se paga el servicio de AVI-Plan?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Siempre es mes anticipado (prepago), garantizando cero deudas acumuladas. Tienes 15 días gratis para probar la plataforma sin tarjeta de crédito. Luego puedes recargar paquetes prepago de 10 mascotas por $50.000 COP o activar mensualidad plana."
              }
            },
            {
              "@@type": "Question",
              "name": "¿Tengo que reemplazar mi software actual de historia clínica veterinaria?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "No. AVI-Plan no compite con tu software de historia clínica tradicional. Es una plataforma especializada en planes de bienestar, membresías y facturación recurrente para mascotas que convive perfectamente con cualquier sistema."
              }
            },
            {
              "@@type": "Question",
              "name": "¿AVI-Plan cobra comisión por cada plan de salud vendido en la clínica?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "No. El 100% del dinero cobrado a tus clientes va directo a tus cuentas o pasarelas de pago. No retenemos comisiones por transacción."
              }
            },
            {
              "@@type": "Question",
              "name": "¿Puedo crear mis propios planes de salud veterinaria con precios y servicios personalizados?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Sí, con total libertad. Puedes definir el nombre de tus planes, qué servicios incluye cada uno (vacunas, desparasitación, consultas, profilaxis o baños) y la cuota mensual en pesos colombianos."
              }
            },
            {
              "@@type": "Question",
              "name": "¿Cómo beneficia el Carnet Digital para mascotas a la clínica?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "El carnet digital con código QR se envía directamente por WhatsApp al tutor, permitiendo validar vigencias, coberturas y realizar canjes en recepción en 2 segundos sin papeleos ni carnets de cartón."
              }
            }
          ]
        }
      ]
    }
    </script>

    <!-- Google Tag / GA4 (Configurado vía .env en Easypanel: GOOGLE_TAG_ID o GOOGLE_ANALYTICS_ID) -->
    @if($gaId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $gaId }}', {
        page_path: window.location.pathname,
        send_page_view: true
      });
    </script>
    @endif

    <!-- Google Tag Manager (si está configurado GOOGLE_TAG_MANAGER_ID) -->
    @if($gtmId)
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $gtmId }}');</script>
    @endif

    <!-- Cloudflare Web Analytics (opcional sin cookies) -->
    @if($cfToken)
    <script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "{{ $cfToken }}"}'></script>
    @endif

    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="shortcut icon" href="/favicon.png">
    <link rel="apple-touch-icon" href="/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .glass-nav { background: rgba(255, 255, 255, 0.94); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(226, 232, 240, 0.9); }
        .clinic-card { background: #FFFFFF; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04); transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
        .clinic-card:hover { border-color: #CBD5E1; box-shadow: 0 16px 32px -6px rgba(15, 23, 42, 0.08); transform: translateY(-3px); }
        
        /* DEGRADADO AZUL CLÍNICO MODERNO (Royal Blue a Sky/Cyan) */
        .gradient-headline { 
            background: linear-gradient(135deg, #1D4ED8 0%, #2563EB 35%, #0284C7 75%, #06B6D4 100%); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent; 
        }

        /* ANIMACIONES MODERNAS SAAS */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(0.5deg); }
        }
        .animate-float { animation: floatSlow 5s ease-in-out infinite; }

        @keyframes floatReverse {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(8px) rotate(-0.5deg); }
        }
        .animate-float-reverse { animation: floatReverse 6s ease-in-out infinite; }

        @keyframes laserScan {
            0% { top: 0%; opacity: 0.9; }
            50% { top: 92%; opacity: 1; }
            100% { top: 0%; opacity: 0.9; }
        }
        .animate-laser { animation: laserScan 2.4s ease-in-out infinite; }

        @keyframes shimmerGlow {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
        .shimmer-effect {
            position: relative;
            overflow: hidden;
        }
        .shimmer-effect::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transform: translateX(-100%);
            animation: shimmerGlow 3s infinite;
        }

        @keyframes radarRipple {
            0% { transform: scale(0.95); opacity: 0.8; }
            100% { transform: scale(2.2); opacity: 0; }
        }
        .animate-radar { animation: radarRipple 2s cubic-bezier(0, 0.2, 0.8, 1) infinite; }

        /* REVEAL ANIMATIONS ON SCROLL */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between overflow-x-hidden bg-[#FAFAF9] text-slate-900">

    <!-- 1. HEADER / NAVBAR CLÍNICO -->
    <header class="sticky top-0 z-50 glass-nav transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 sm:h-20 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3 group">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl shadow-md shadow-blue-900/10 group-hover:scale-105 group-hover:rotate-2 transition-all duration-300 shrink-0 flex items-center justify-center bg-white border border-slate-200/90 p-1.5">
                    <img src="/images/dashboard/brand_logo.png" alt="AVI-Plan Logo" class="w-full h-full object-contain">
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center space-x-2">
                        <span class="text-xl sm:text-2xl font-black tracking-tight text-slate-900 leading-tight">AVI<span class="text-blue-600">Plan</span></span>
                        <span class="hidden sm:inline-block px-2 py-0.5 text-[10px] font-bold uppercase bg-blue-50 text-blue-800 rounded-md border border-blue-200 animate-pulse">
                            by AviPetApp
                        </span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-blue-700 -mt-0.5">
                        Planes de Bienestar para Veterinarias
                    </span>
                </div>
            </a>
            
            <nav class="hidden lg:flex items-center space-x-7 text-xs sm:text-sm font-semibold text-slate-600">
                <a href="#como-funciona" class="hover:text-blue-600 transition-colors">Cómo Funciona</a>
                <a href="#recibes" class="hover:text-blue-600 transition-colors">Lo que Recibes</a>
                <a href="#calculadora" class="hover:text-blue-600 transition-colors">Calculadora</a>
                <a href="#scanner-demo" class="hover:text-blue-600 transition-colors flex items-center space-x-1">
                    <span>Escáner QR</span>
                    <span class="px-1.5 py-0.2 text-[9px] font-bold bg-blue-100 text-blue-800 rounded-full">Demo</span>
                </a>
                <a href="#carnet-interactivo" class="hover:text-blue-600 transition-colors">Carnet Digital</a>
                <a href="#inteligencia" class="hover:text-blue-600 transition-colors">AVI Intelligence</a>
                <a href="#precios" class="hover:text-blue-600 transition-colors">Precios</a>
                <a href="#faq" class="hover:text-blue-600 transition-colors">FAQ</a>
                <a href="/blog" class="text-blue-600 font-bold hover:text-blue-800 transition-colors">Blog</a>
            </nav>

            <div class="flex items-center space-x-3">
                <a href="/admin" class="hidden sm:inline-flex px-3.5 py-2 text-xs font-bold text-slate-700 hover:text-slate-900 transition-colors rounded-xl border border-transparent hover:border-slate-200">
                    Iniciar Sesión
                </a>
                <button type="button" onclick="openRegisterModal('pro')" class="relative group px-4 sm:px-5 py-2.5 text-xs sm:text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md shadow-blue-600/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center space-x-2 overflow-hidden">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-300 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                    </span>
                    <span>Probar AVI-Plan gratis</span>
                </button>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- 2. HERO SPLIT: PRODUCTO VIVO ANIMADO EN AZUL CLÍNICO -->
        <section class="relative pt-10 sm:pt-16 pb-16 sm:pb-24 overflow-hidden bg-gradient-to-b from-white via-[#F8FAFC] to-[#EFF6FF]/40 border-b border-slate-200">
            <!-- ORBES LUMINOSOS AMBIENTALES EN AZUL & CYAN -->
            <div class="absolute -top-24 left-1/4 w-96 h-96 bg-blue-300/20 rounded-full blur-3xl pointer-events-none animate-float"></div>
            <div class="absolute top-1/2 -right-24 w-80 h-80 bg-cyan-300/15 rounded-full blur-3xl pointer-events-none animate-float-reverse"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                    
                    <!-- COLUMNA IZQUIERDA: PROPUESTA DE VALOR CONCRETA -->
                    <div class="lg:col-span-7 space-y-6 text-left reveal-on-scroll">
                        
                        <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200/90 text-blue-800 text-xs font-semibold tracking-wide shadow-xs">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-500 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                            </span>
                            <span>15 días gratis · Luego desde $50.000 COP (paquete 10 mascotas) o tarifa plana · Sin tarjeta</span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.12]">
                            Convierte tus clientes actuales en <span class="gradient-headline">ingresos mensuales recurrentes.</span>
                        </h1>

                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed font-normal max-w-2xl">
                            Crea planes de bienestar para mascotas, recibe cobros mensuales y deja que tus tutores consulten y canjeen sus beneficios desde su celular.
                        </p>

                        <!-- POSICIONAMIENTO MARCA BLANCA -->
                        <div class="flex items-center space-x-2 text-xs sm:text-sm font-mono font-bold text-blue-900 uppercase tracking-wide bg-blue-50/80 border border-blue-200/80 px-3.5 py-2 rounded-xl w-fit shadow-xs">
                            <span>🏥 Tu marca · Tus planes · Tus precios · Tus clientes</span>
                        </div>

                        <!-- CTAs UNIFICADOS -->
                        <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5">
                            <button type="button" onclick="openRegisterModal('pro')" class="px-7 py-4 rounded-2xl bg-blue-600 text-white font-bold text-base hover:bg-blue-700 shadow-lg shadow-blue-600/25 transition-all transform hover:-translate-y-1 hover:shadow-xl active:translate-y-0 flex items-center justify-center space-x-2 text-center group">
                                <span class="group-hover:rotate-12 transition-transform">🚀</span>
                                <span>Probar AVI-Plan gratis</span>
                            </button>
                            <a href="#como-funciona" class="px-6 py-4 rounded-2xl bg-white hover:bg-slate-50 text-slate-800 font-bold text-sm sm:text-base border border-slate-300 shadow-xs transition-all flex items-center justify-center space-x-2 text-center hover:border-blue-500">
                                <span>Ver cómo funciona →</span>
                            </a>
                        </div>

                        <!-- EJEMPLO REAL DE BOLSILLO ANIMADO -->
                        <div class="pt-2 p-4 rounded-2xl bg-white border border-slate-200 shadow-xs max-w-xl hover:border-blue-300 transition-colors">
                            <div class="flex items-center justify-between text-xs sm:text-sm font-semibold text-slate-700">
                                <span class="text-slate-500">Ejemplo de clínica en crecimiento:</span>
                                <span class="text-blue-700 font-black font-mono">50 mascotas × $65.000/mes</span>
                            </div>
                            <div class="flex items-baseline justify-between mt-1 pt-1.5 border-t border-slate-100">
                                <span class="text-xs text-slate-500 font-medium">Facturación mensual directa a tu cuenta:</span>
                                <span class="text-base sm:text-lg font-black text-blue-700 font-mono">$3.250.000 COP / mes</span>
                            </div>
                        </div>

                        <!-- MICRO TRUST CON CHECKMARKS AZULES -->
                        <div class="pt-1 flex flex-wrap items-center gap-5 text-xs text-slate-500 font-semibold">
                            <div class="flex items-center space-x-1.5">
                                <span class="text-blue-600 font-bold text-sm">✓</span>
                                <span>Afiche QR para recepción</span>
                            </div>
                            <div class="flex items-center space-x-1.5">
                                <span class="text-blue-600 font-bold text-sm">✓</span>
                                <span>Canje en mostrador en 3 seg</span>
                            </div>
                            <div class="flex items-center space-x-1.5">
                                <span class="text-blue-600 font-bold text-sm">✓</span>
                                <span>100% cobro a tus cuentas bancarias</span>
                            </div>
                        </div>

                    </div>

                    <!-- COLUMNA DERECHA: DASHBOARD VIVO EN AZUL CLÍNICO -->
                    <div class="lg:col-span-5 reveal-on-scroll">
                        <div class="relative w-full max-w-md mx-auto animate-float">
                            
                            <!-- GLOW RING DETRÁS DE LA TARJETA -->
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-3xl blur-md opacity-25 group-hover:opacity-40 transition duration-1000"></div>

                            <div class="relative bg-white rounded-3xl border-2 border-blue-500/70 shadow-2xl p-6 space-y-5">
                                
                                <!-- HEADER DEL WIDGET EN VIVO -->
                                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                    <div class="flex items-center space-x-2.5">
                                        <span class="relative flex h-3 w-3">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                                        </span>
                                        <div>
                                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-900">En Vivo · Consultorio Demo</h3>
                                            <p class="text-[10px] text-slate-400 font-medium">Panel de Membresías Activas</p>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-800 text-[10px] font-bold font-mono flex items-center space-x-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                        <span>AVI Intelligence</span>
                                    </span>
                                </div>

                                <!-- MÉTRICAS EN VIVO CON EFECTO COUNT-UP -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200 hover:border-blue-300 transition group cursor-default">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[10px] font-bold uppercase text-slate-500">Mascotas Activas</span>
                                            <span class="text-xs group-hover:scale-125 transition-transform">🐶</span>
                                        </div>
                                        <div id="live-pets-counter" class="text-2xl font-black text-slate-900 font-mono mt-1">127</div>
                                        <span class="text-[10px] font-semibold text-blue-600">↑ +14 este mes</span>
                                    </div>

                                    <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200 hover:border-blue-300 transition group cursor-default">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[10px] font-bold uppercase text-slate-500">MRR Recurrente</span>
                                            <span class="text-xs group-hover:scale-125 transition-transform">💰</span>
                                        </div>
                                        <div id="live-mrr-counter" class="text-xl font-black text-blue-700 font-mono mt-1">$8.255.000</div>
                                        <span class="text-[10px] font-semibold text-slate-500">100% en tus cuentas</span>
                                    </div>

                                    <div class="bg-amber-50/70 p-3 rounded-2xl border border-amber-200/90">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[9px] font-bold uppercase text-amber-800">⚠️ Por renovar</span>
                                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                                        </div>
                                        <span class="text-sm font-extrabold text-amber-900 font-mono">6 planes esta semana</span>
                                    </div>

                                    <div class="bg-blue-50/70 p-3 rounded-2xl border border-blue-200/90">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[9px] font-bold uppercase text-blue-800">✓ Canjes de hoy</span>
                                            <span class="text-[10px] text-blue-700 font-bold">12 aplicados</span>
                                        </div>
                                        <span class="text-sm font-extrabold text-blue-900 font-mono">3 vacunas · 9 citas</span>
                                    </div>
                                </div>

                                <!-- RETENCIÓN ANUAL ANIMADA CON SHIMMER EN AZUL -->
                                <div class="space-y-1.5 bg-slate-50 p-3.5 rounded-2xl border border-slate-200">
                                    <div class="flex justify-between text-[11px] font-bold text-slate-700">
                                        <span>Tasa de retención anual</span>
                                        <span class="text-blue-700 font-mono">82% (Excelente)</span>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden p-0.5">
                                        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-1.5 rounded-full shimmer-effect transition-all duration-1000" style="width: 82%"></div>
                                    </div>
                                </div>

                                <!-- TICKER DE ACTIVIDAD EN VIVO -->
                                <div class="space-y-2 border-t border-slate-100 pt-3">
                                    <div class="flex items-center justify-between text-[10px] font-bold uppercase text-slate-400">
                                        <div class="flex items-center space-x-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            <span>Actividad de mostrador</span>
                                        </div>
                                        <span class="text-blue-600 font-mono">tiempo real</span>
                                    </div>
                                    <div id="live-activity-box" class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 transition-all duration-500 flex items-center space-x-2.5 shadow-2xs">
                                        <span class="text-lg shrink-0 transform scale-110" id="live-activity-icon">🐕</span>
                                        <div class="truncate">
                                            <strong id="live-activity-title" class="text-slate-900 font-bold">Luna (Golden)</strong>
                                            <span id="live-activity-desc" class="text-slate-500 block text-[11px]">Canjeó Vacuna Séxtuple en recepción</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- LINK AL PILOTO -->
                                <a href="/v/vet-pet-patitas" target="_blank" class="w-full py-2.5 text-center rounded-xl bg-slate-100 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-200 text-slate-700 font-bold text-xs border border-transparent transition flex items-center justify-center space-x-1.5">
                                    <span>Ver Clínica Piloto Completa</span>
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 3. SECCIÓN DE COEXISTENCIA: NO REEMPLAZAMOS TU SOFTWARE -->
        <section class="py-8 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-6 reveal-on-scroll">
                    <div class="flex items-start sm:items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-2xl font-bold shrink-0 shadow-xs">
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
                    <div class="shrink-0 flex items-center space-x-2 text-xs font-bold text-blue-900 bg-blue-50 border border-blue-200 px-4 py-2.5 rounded-xl shadow-xs">
                        <span class="text-blue-600">✓</span>
                        <span>100% Complementario</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. CALCULADORA MRR PROTAGONISTA EN AZUL CLÍNICO -->
        <section id="calculadora" class="py-16 sm:py-24 bg-[#FAFAF9] border-b border-slate-200">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12 space-y-2 reveal-on-scroll">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                        Simulador Financiero en Tiempo Real
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">¿Cuánto podría generar tu veterinaria?</h2>
                    <p class="text-xs sm:text-sm text-slate-600">Arrastra el deslizador para proyectar tus ingresos recurrentes inmediatos.</p>
                </div>

                <div class="clinic-card p-6 sm:p-10 rounded-3xl space-y-8 bg-white border-2 border-slate-200 reveal-on-scroll shadow-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        
                        <!-- CONTROLES REACTIVOS -->
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-baseline mb-2">
                                    <label class="text-xs font-bold text-slate-700 uppercase">Mascotas activas en planes:</label>
                                    <div class="flex items-baseline space-x-1.5">
                                        <span id="pets-count-display" class="text-3xl font-black text-blue-700 font-mono transition-transform">50</span>
                                        <span class="text-xs font-bold text-slate-500">mascotas</span>
                                    </div>
                                </div>
                                <input type="range" id="pets-slider" min="10" max="300" step="5" value="50" class="w-full h-3 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-blue-600 hover:accent-blue-700 transition">
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
                                    <button type="button" onclick="setPlanPrice(49000)" class="price-btn py-2.5 px-3 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-700 hover:border-blue-600 transition" data-price="49000">
                                        $49.000 <span class="block text-[10px] text-slate-400 font-normal">Básico</span>
                                    </button>
                                    <button type="button" onclick="setPlanPrice(65000)" class="price-btn py-2.5 px-3 rounded-xl border-2 border-blue-600 bg-blue-50 text-xs font-black text-blue-900 transition shadow-xs" data-price="65000">
                                        $65.000 ⭐ <span class="block text-[10px] text-blue-600 font-medium">Recomendado</span>
                                    </button>
                                    <button type="button" onclick="setPlanPrice(89000)" class="price-btn py-2.5 px-3 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-700 hover:border-blue-600 transition" data-price="89000">
                                        $89.000 <span class="block text-[10px] text-slate-400 font-normal">Premium</span>
                                    </button>
                                </div>
                            </div>

                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 space-y-1">
                                <div class="font-bold text-slate-800 flex items-center space-x-1">
                                    <span>💡</span>
                                    <span>Consejo comercial para tu clínica:</span>
                                </div>
                                <p class="text-[11px] leading-snug">
                                    Un plan promedio de $65.000/mes incluye 2 consultas preventivas al año, vacuna séxtuple, rabia y desparasitaciones periódicas. El cliente ahorra y tu clínica asegura el paciente todo el año.
                                </p>
                            </div>
                        </div>

                        <!-- RESULTADOS ESTIMADOS CON ANIMACIÓN EN AZUL -->
                        <div class="bg-gradient-to-br from-blue-50/60 via-white to-slate-50 p-6 sm:p-7 rounded-3xl border-2 border-blue-500 space-y-4 text-center shadow-md relative overflow-hidden">
                            
                            <div class="space-y-1">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-blue-800">Ingreso recurrente mensual estimado</span>
                                <div id="mrr-monthly" class="text-4xl sm:text-5xl font-black text-slate-900 font-mono tracking-tight transition-all duration-300">$3.250.000</div>
                                <span class="text-[11px] text-slate-500 block pt-1">
                                    Ejemplo calculado según el número de mascotas y tarifa mensual seleccionados.
                                </span>
                            </div>

                            <hr class="border-slate-200">

                            <div class="grid grid-cols-2 gap-3 text-left">
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-2xs">
                                    <span class="text-[9px] uppercase font-bold text-slate-500 block">A $5.000 / Mascota</span>
                                    <span id="mrr-per-pet-cost" class="text-sm sm:text-base font-black text-slate-700 font-mono">$250.000<span class="text-[10px] font-normal text-slate-500">/mes</span></span>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-blue-200 bg-blue-50/40 shadow-2xs">
                                    <span class="text-[9px] uppercase font-bold text-blue-700 block">En Plan Fijo (Ahorro)</span>
                                    <span id="mrr-tier-cost" class="text-sm sm:text-base font-black text-blue-700 font-mono">$99.000<span class="text-[10px] font-normal text-slate-500">/mes</span></span>
                                </div>
                            </div>

                            <div class="bg-blue-100/70 p-2.5 rounded-xl border border-blue-200 text-xs font-bold text-blue-900 flex justify-between items-center">
                                <span>Margen que retiene tu clínica:</span>
                                <span id="mrr-net-margin" class="font-mono text-sm">~97% directo</span>
                            </div>

                            <div class="pt-1">
                                <button type="button" onclick="openRegisterModal('pro')" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition transform hover:-translate-y-0.5 active:translate-y-0">
                                    Comenzar mi programa de bienestar →
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- 5. FLUJO INTERACTIVO EN 6 PASOS (DISEÑO SAAS APPLE/STRIPE) -->
        <section id="como-funciona" class="py-16 sm:py-24 bg-gradient-to-b from-white via-slate-50/50 to-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-14 space-y-2 reveal-on-scroll">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 px-3.5 py-1.5 rounded-full border border-blue-200/90 shadow-2xs">
                        Flujo Operativo Simple
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Así funciona en tu clínica</h2>
                    <p class="text-xs sm:text-sm text-slate-600">Haz clic en cada etapa para ver cómo opera en tiempo real.</p>
                </div>

                <!-- CONTENEDOR SPLIT: ETAPAS INTERACTIVAS + PANTALLA DE SIMULACIÓN -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <!-- LISTA DE 6 ETAPAS CON SELECTOR ACTIVO -->
                    <div class="lg:col-span-6 space-y-3">
                        <div onclick="selectStep(1)" id="step-btn-1" class="step-card p-4 rounded-2xl border-2 border-blue-600 bg-blue-50/70 cursor-pointer transition-all flex items-start space-x-3.5 shadow-sm transform scale-[1.01]">
                            <span class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black font-mono text-sm shrink-0 shadow-xs">01</span>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Crea tus planes de salud</h4>
                                <p class="text-xs text-slate-600 mt-0.5">Define consultas, vacunas, desparasitaciones y fija tu tarifa mensual con total libertad.</p>
                            </div>
                        </div>

                        <div onclick="selectStep(2)" id="step-btn-2" class="step-card p-4 rounded-2xl border border-slate-200 bg-white hover:border-blue-300 cursor-pointer transition-all flex items-start space-x-3.5">
                            <span class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-black font-mono text-sm shrink-0">02</span>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Escaneo del Afiche QR en Mostrador</h4>
                                <p class="text-xs text-slate-600 mt-0.5">El tutor escanea el afiche oficial en la sala de espera o entra a tu enlace web desde WhatsApp.</p>
                            </div>
                        </div>

                        <div onclick="selectStep(3)" id="step-btn-3" class="step-card p-4 rounded-2xl border border-slate-200 bg-white hover:border-blue-300 cursor-pointer transition-all flex items-start space-x-3.5">
                            <span class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-black font-mono text-sm shrink-0">03</span>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Afiliación Digital en 2 Minutos</h4>
                                <p class="text-xs text-slate-600 mt-0.5">El tutor registra a su mascota y adquiere su membresía sin papeles ni trámites manuales.</p>
                            </div>
                        </div>

                        <div onclick="selectStep(4)" id="step-btn-4" class="step-card p-4 rounded-2xl border border-slate-200 bg-white hover:border-blue-300 cursor-pointer transition-all flex items-start space-x-3.5">
                            <span class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-black font-mono text-sm shrink-0">04</span>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Carnet Digital en el Celular</h4>
                                <p class="text-xs text-slate-600 mt-0.5">Recibe al instante su carnet con código de barras en su móvil para consultar sus saldos.</p>
                            </div>
                        </div>

                        <div onclick="selectStep(5)" id="step-btn-5" class="step-card p-4 rounded-2xl border border-slate-200 bg-white hover:border-blue-300 cursor-pointer transition-all flex items-start space-x-3.5">
                            <span class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-black font-mono text-sm shrink-0">05</span>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Canje en Recepción en 3 Segundos</h4>
                                <p class="text-xs text-slate-600 mt-0.5">La recepcionista digita la cédula o escanea el QR y descuenta cupos con auditoría.</p>
                            </div>
                        </div>

                        <div onclick="selectStep(6)" id="step-btn-6" class="step-card p-4 rounded-2xl border border-slate-200 bg-white hover:border-blue-300 cursor-pointer transition-all flex items-start space-x-3.5">
                            <span class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-black font-mono text-sm shrink-0">06</span>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Renovaciones y Retención Automática</h4>
                                <p class="text-xs text-slate-600 mt-0.5">El sistema gestiona vencimientos y te ayuda a reactivar planes automáticamente.</p>
                            </div>
                        </div>
                    </div>

                    <!-- PANTALLA DE SIMULACIÓN VISUAL DEL PASO ACTIVO (MODERN GLASS FRAME) -->
                    <div class="lg:col-span-6">
                        <div class="relative bg-[#0b1324] text-white rounded-3xl p-5 sm:p-7 shadow-2xl border border-slate-700/80 min-h-[460px] flex flex-col justify-between overflow-hidden">
                            <!-- Glow ambiental -->
                            <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>
                            
                            <!-- BARRA SUPERIOR DE VENTANA -->
                            <div class="flex items-center justify-between border-b border-slate-800/90 pb-3 relative z-10">
                                <div class="flex items-center space-x-2">
                                    <span class="w-3 h-3 rounded-full bg-rose-500/90"></span>
                                    <span class="w-3 h-3 rounded-full bg-amber-500/90"></span>
                                    <span class="w-3 h-3 rounded-full bg-emerald-500/90"></span>
                                </div>
                                <div class="hidden sm:flex items-center space-x-1.5 px-3 py-1 rounded-lg bg-slate-800/80 border border-slate-700/60 text-[11px] font-mono text-slate-300">
                                    <span class="text-emerald-400">🔒</span>
                                    <span>avipetapp.com/v/vet-patitas</span>
                                </div>
                                <span id="step-screen-tag" class="text-xs font-mono text-cyan-400 font-bold uppercase tracking-wider">
                                    Paso 01 · Configuración
                                </span>
                            </div>

                            <!-- CONTENIDO DINÁMICO DE LA PANTALLA -->
                            <div id="step-screen-content" class="py-4 relative z-10 transition-all duration-300 min-h-[290px] flex flex-col justify-center">
                                <!-- Se inyecta dinámicamente con selectStep() -->
                            </div>

                            <!-- BARRA DE PROGRESO DE AUTO-PLAY -->
                            <div class="space-y-2 border-t border-slate-800/90 pt-3 relative z-10">
                                <div class="flex justify-between text-[11px] text-slate-400">
                                    <span>Etapa <span id="step-current-number" class="text-white font-bold font-mono">1</span> de 6</span>
                                    <span class="text-cyan-400 font-mono text-[10px] uppercase tracking-wider flex items-center space-x-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-ping"></span>
                                        <span>Simulación Interactiva</span>
                                    </span>
                                </div>
                                <div class="w-full bg-slate-800/90 h-1.5 rounded-full overflow-hidden">
                                    <div id="step-progress-bar" class="bg-gradient-to-r from-blue-500 to-cyan-400 h-1.5 transition-all duration-500" style="width: 16.6%"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 6. DEMO INTERACTIVA: ESCÁNER QR DEL MOSTRADOR EN VIVO (AZUL/CYAN) -->
        <section id="scanner-demo" class="py-16 sm:py-24 bg-[#FAFAF9] border-b border-slate-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12 space-y-2 reveal-on-scroll">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 px-3.5 py-1.5 rounded-full border border-blue-200/90 shadow-2xs">
                        Experiencia en Sala de Espera
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Pruébalo: Simula el escaneo de recepción</h2>
                    <p class="text-xs sm:text-sm text-slate-600">Mira exactamente lo que ve y experimenta un tutor cuando escanea el afiche físico en tu clínica.</p>
                </div>

                <div class="p-6 sm:p-10 rounded-3xl bg-white border border-slate-200 shadow-xl reveal-on-scroll">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                        
                        <!-- COLUMNA IZQUIERDA: AFICHE FÍSICO EN ACRÍLICO REALISTA -->
                        <div class="lg:col-span-5 space-y-5 text-center">
                            
                            <!-- AFICHE EN BASE DE ACRÍLICO -->
                            <div class="relative inline-block w-full max-w-[280px] p-4 bg-gradient-to-b from-white via-slate-50 to-slate-100 rounded-2xl border-2 border-slate-300 shadow-xl mx-auto transform hover:-translate-y-1 transition duration-300">
                                
                                <!-- Soporte acrílico superior -->
                                <div class="w-16 h-1 bg-slate-300 rounded-full mx-auto mb-3"></div>

                                <!-- Rayo láser animado -->
                                <div id="qr-laser-beam" class="absolute left-4 right-4 h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent shadow-[0_0_12px_#06B6D4] animate-laser z-20 pointer-events-none opacity-80"></div>

                                <div class="p-4 bg-white rounded-xl border border-slate-200 space-y-3 shadow-inner">
                                    <!-- Header Afiche -->
                                    <div class="flex items-center justify-center space-x-2">
                                        <img src="/images/dashboard/brand_logo.png" alt="Logo Clínica" class="w-6 h-6 object-contain">
                                        <span class="text-xs font-black text-slate-900">Vet-Pet Patitas</span>
                                    </div>
                                    
                                    <div class="bg-blue-50 py-1 px-2 rounded-md border border-blue-200">
                                        <span class="text-[10px] font-black uppercase tracking-wider text-blue-800">
                                            Plan de Bienestar Mascotas
                                        </span>
                                    </div>

                                    <!-- QR CODE VECTORIAL REALISTA -->
                                    <div class="relative w-36 h-36 mx-auto bg-white p-2 rounded-xl border-2 border-slate-800 shadow-sm flex items-center justify-center">
                                        <svg class="w-full h-full text-slate-900" viewBox="0 0 100 100" fill="currentColor">
                                            <rect x="0" y="0" width="28" height="28" rx="4" fill="#0F172A"/>
                                            <rect x="4" y="4" width="20" height="20" rx="2" fill="#FFFFFF"/>
                                            <rect x="8" y="8" width="12" height="12" rx="1" fill="#2563EB"/>

                                            <rect x="72" y="0" width="28" height="28" rx="4" fill="#0F172A"/>
                                            <rect x="76" y="4" width="20" height="20" rx="2" fill="#FFFFFF"/>
                                            <rect x="80" y="8" width="12" height="12" rx="1" fill="#2563EB"/>

                                            <rect x="0" y="72" width="28" height="28" rx="4" fill="#0F172A"/>
                                            <rect x="4" y="76" width="20" height="20" rx="2" fill="#FFFFFF"/>
                                            <rect x="8" y="80" width="12" height="12" rx="1" fill="#2563EB"/>

                                            <rect x="34" y="6" width="6" height="6" rx="1"/>
                                            <rect x="46" y="6" width="6" height="6" rx="1"/>
                                            <rect x="58" y="6" width="6" height="6" rx="1"/>
                                            <rect x="34" y="18" width="6" height="6" rx="1" fill="#0284C7"/>
                                            <rect x="46" y="18" width="6" height="6" rx="1"/>
                                            <rect x="58" y="18" width="6" height="6" rx="1" fill="#0284C7"/>

                                            <rect x="6" y="34" width="6" height="6" rx="1"/>
                                            <rect x="18" y="34" width="6" height="6" rx="1"/>
                                            <rect x="6" y="46" width="6" height="6" rx="1"/>
                                            <rect x="18" y="46" width="6" height="6" rx="1"/>
                                            <rect x="6" y="58" width="6" height="6" rx="1"/>
                                            <rect x="18" y="58" width="6" height="6" rx="1"/>

                                            <rect x="34" y="34" width="32" height="32" rx="6" fill="#0F172A"/>
                                            <circle cx="50" cy="50" r="10" fill="#FFFFFF"/>
                                            <circle cx="50" cy="50" r="6" fill="#2563EB"/>

                                            <rect x="72" y="34" width="6" height="6" rx="1"/>
                                            <rect x="84" y="34" width="6" height="6" rx="1"/>
                                            <rect x="72" y="46" width="6" height="6" rx="1"/>
                                            <rect x="84" y="46" width="6" height="6" rx="1" fill="#0284C7"/>
                                            <rect x="72" y="58" width="6" height="6" rx="1"/>
                                            <rect x="84" y="58" width="6" height="6" rx="1"/>

                                            <rect x="34" y="72" width="6" height="6" rx="1"/>
                                            <rect x="46" y="72" width="6" height="6" rx="1"/>
                                            <rect x="58" y="72" width="6" height="6" rx="1"/>
                                            <rect x="34" y="84" width="6" height="6" rx="1" fill="#0284C7"/>
                                            <rect x="46" y="84" width="6" height="6" rx="1"/>
                                            <rect x="58" y="84" width="6" height="6" rx="1"/>
                                        </svg>
                                    </div>

                                    <p class="text-[9.5px] text-slate-600 font-semibold leading-tight">
                                        Escanea con tu celular para afiliar a tu mascota desde <strong class="text-blue-700">$50.000/mes</strong>
                                    </p>
                                </div>

                                <!-- Base Acrílica Inferior -->
                                <div class="w-full h-3 bg-gradient-to-r from-slate-300 via-slate-200 to-slate-300 rounded-b-xl mt-1 shadow-sm"></div>
                            </div>

                            <div>
                                <button type="button" onclick="triggerQrScanDemo()" id="scan-trigger-btn" class="relative group px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs shadow-lg shadow-blue-600/30 transition-all transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-2 mx-auto">
                                    <span class="text-base">📲</span>
                                    <span id="scan-btn-text">Simular Escaneo con Celular</span>
                                </button>
                                <span class="text-[10px] text-slate-400 block mt-1.5">Haz clic para ver la animación en vivo del teléfono</span>
                            </div>
                        </div>

                        <!-- COLUMNA DERECHA: TELÉFONO INTERACTIVO VIVO (MOCKUP IPHONE) -->
                        <div class="lg:col-span-7">
                            <div id="phone-container" class="relative max-w-sm mx-auto bg-slate-900 rounded-[40px] p-3.5 shadow-2xl border-4 border-slate-800 ring-1 ring-slate-700/50 transition-all duration-500">
                                
                                <!-- Dynamic Island -->
                                <div class="w-24 h-5 bg-black rounded-full mx-auto mb-2 flex items-center justify-center space-x-2">
                                    <span class="w-2 h-2 rounded-full bg-blue-900/60"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-800"></span>
                                </div>

                                <!-- PANTALLA DEL CELULAR -->
                                <div id="phone-screen" class="bg-white rounded-[30px] p-4 text-slate-900 min-h-[440px] flex flex-col justify-between overflow-hidden relative shadow-inner">
                                    
                                    <!-- VISTA 1: SCANNER EN VIVO -->
                                    <div id="phone-view-scanner" class="absolute inset-0 bg-slate-950 text-white p-6 flex flex-col justify-between items-center text-center z-30 transition-opacity duration-300">
                                        <div class="w-full flex justify-between items-center text-[10px] text-slate-400 font-mono">
                                            <span>CÁMARA QR</span>
                                            <span class="text-emerald-400 flex items-center space-x-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                                <span>LISTO PARA ESCANEAR</span>
                                            </span>
                                        </div>

                                        <!-- Retícula del visor de la cámara -->
                                        <div class="relative w-44 h-44 border-2 border-dashed border-cyan-400/80 rounded-2xl flex items-center justify-center p-4">
                                            <div class="absolute -top-1 -left-1 w-4 h-4 border-t-2 border-l-2 border-cyan-400"></div>
                                            <div class="absolute -top-1 -right-1 w-4 h-4 border-t-2 border-r-2 border-cyan-400"></div>
                                            <div class="absolute -bottom-1 -left-1 w-4 h-4 border-b-2 border-l-2 border-cyan-400"></div>
                                            <div class="absolute -bottom-1 -right-1 w-4 h-4 border-b-2 border-r-2 border-cyan-400"></div>
                                            
                                            <div class="absolute left-2 right-2 h-0.5 bg-cyan-400 shadow-[0_0_8px_#22d3ee] animate-laser"></div>
                                            
                                            <span class="text-[11px] text-cyan-200 font-semibold">Apunta al afiche...</span>
                                        </div>

                                        <div class="space-y-1">
                                            <p class="text-xs text-slate-300 font-bold">Presiona el botón azul</p>
                                            <p class="text-[10px] text-slate-500">Abre tu clínica en 1 segundo</p>
                                        </div>
                                    </div>

                                    <!-- VISTA 2: PORTAL MÓVIL ABIERTO TRAS ESCANEO -->
                                    <div id="phone-view-portal" class="space-y-3 opacity-0 transition-opacity duration-500">
                                        <!-- Header de la clínica -->
                                        <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                                            <div class="flex items-center space-x-2">
                                                <img src="/images/dashboard/brand_logo.png" alt="Logo" class="w-7 h-7 object-contain">
                                                <div>
                                                    <h4 class="text-xs font-black text-slate-900 leading-tight">Vet-Pet Patitas</h4>
                                                    <span class="text-[9px] text-emerald-600 font-bold">● Clínica Abierta</span>
                                                </div>
                                            </div>
                                            <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 font-bold text-[9px]">
                                                Portal Tutor
                                            </span>
                                        </div>

                                        <!-- Plan Elegido -->
                                        <div class="p-3 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white shadow-md space-y-1.5">
                                            <div class="flex justify-between items-center">
                                                <span class="text-[10px] font-bold uppercase tracking-wider text-blue-200">Plan Seleccionado</span>
                                                <span class="px-1.5 py-0.5 rounded bg-white/20 text-white text-[9px] font-bold">Recomendado</span>
                                            </div>
                                            <div class="text-base font-black">Plan Premium Patitas</div>
                                            <div class="text-xs font-bold text-cyan-200 font-mono">$65.000 COP / mes</div>
                                        </div>

                                        <!-- Formulario de Afiliación Express -->
                                        <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200 space-y-2 text-xs">
                                            <div class="text-[10px] font-bold text-slate-700 uppercase">Datos de la mascota:</div>
                                            <div class="flex items-center justify-between text-[11px] bg-white p-2 rounded-lg border border-slate-200">
                                                <span class="text-slate-500">Nombre:</span>
                                                <strong class="text-slate-900">Luna 🐕</strong>
                                            </div>
                                            <div class="flex items-center justify-between text-[11px] bg-white p-2 rounded-lg border border-slate-200">
                                                <span class="text-slate-500">Raza:</span>
                                                <span class="text-slate-800 font-medium">Golden Retriever</span>
                                            </div>
                                            <div class="flex items-center justify-between text-[11px] bg-white p-2 rounded-lg border border-slate-200">
                                                <span class="text-slate-500">Medio de pago:</span>
                                                <span class="text-blue-700 font-bold">Bancolombia / Nequi</span>
                                            </div>
                                        </div>

                                        <!-- Botón CTA en Celular -->
                                        <a href="/v/vet-pet-patitas" target="_blank" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-md transition flex items-center justify-center space-x-1.5">
                                            <span>✓ Confirmar y Activar Carnet</span>
                                        </a>
                                    </div>

                                </div>

                                <!-- Barra Home iPhone -->
                                <div class="w-28 h-1 bg-slate-700 rounded-full mx-auto mt-2"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- 7. CÓMO VENDERLO A TUS CLIENTES ACTUALES (3 CANALES COMERCIALES) -->
        <section class="py-16 sm:py-20 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12 space-y-2 reveal-on-scroll">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                        Estrategia Comercial Práctica
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Cómo venderlo a tus clientes actuales</h2>
                    <p class="text-xs sm:text-sm text-slate-600">No necesitas buscar clientes desconocidos en la calle. Ya tienes pacientes en tu clínica.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- CANAL 1: AFICHE QR -->
                    <div class="clinic-card p-6 rounded-3xl space-y-3 bg-white reveal-on-scroll">
                        <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl font-bold border border-blue-200">
                            🖨️
                        </div>
                        <h3 class="text-base font-bold text-slate-900">1. Afiche en la Sala de Espera</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            El tutor espera su turno y ve el afiche en el mostrador: <em>"Ahorra en las vacunas de tu peludo con nuestro Plan de Bienestar"</em>. Escanea con su celular y se afilia mientras espera.
                        </p>
                    </div>

                    <!-- CANAL 2: RECOMENDACIÓN CLÍNICA -->
                    <div class="clinic-card p-6 rounded-3xl space-y-3 bg-white reveal-on-scroll">
                        <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl font-bold border border-amber-200">
                            🩺
                        </div>
                        <h3 class="text-base font-bold text-slate-900">2. En el Momento de la Consulta</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Al atender al paciente, el veterinario le explica: <em>"Hoy le toca desparasitación y el próximo mes la vacuna. Si te afilias a nuestro plan mensual, te sale más económico y no descuidamos su salud"</em>.
                        </p>
                    </div>

                    <!-- CANAL 3: CAMPAÑA WHATSAPP -->
                    <div class="clinic-card p-6 rounded-3xl space-y-3 bg-white reveal-on-scroll">
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

        <!-- 8. LO QUE TU VETERINARIA RECIBE (LOS 5 ACTIVOS CONCRETOS) -->
        <section id="recibes" class="py-20 sm:py-24 bg-[#FAFAF9] border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-2 reveal-on-scroll">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                        Todo Incluido en tu Prueba
                    </span>
                    <h2 class="text-3xl sm:text-5xl font-black text-slate-900 mt-2">Lo que tu veterinaria recibe en 60 segundos</h2>
                    <p class="text-sm sm:text-base text-slate-600">Herramientas completas para operar desde el primer día.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- 1. PORTAL WEB -->
                    <div class="clinic-card p-7 rounded-3xl space-y-3 reveal-on-scroll">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center text-2xl font-bold border border-blue-200">
                            🌐
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Portal Web Marca Blanca</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Tu propia página web personalizada con tu logo, fotos y colores (ej: <code class="text-blue-800 bg-blue-50 px-1 py-0.5 rounded font-mono">avipetapp.com/v/tu-clinica</code>). Tus clientes consultan planes y se afilian online.
                        </p>
                    </div>

                    <!-- 2. AFICHE QR -->
                    <div class="clinic-card p-7 rounded-3xl space-y-3 reveal-on-scroll">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-2xl font-bold border border-amber-200">
                            🖨️
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Afiche de Mostrador con QR</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Generado en tamaño Carta listo para imprimir en 1 clic. Colócalo en recepción para que los tutores en sala de espera se afilien con su celular sin recargar a tu equipo.
                        </p>
                    </div>

                    <!-- 3. CARNET DIGITAL -->
                    <div class="clinic-card p-7 rounded-3xl space-y-3 reveal-on-scroll">
                        <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-700 flex items-center justify-center text-2xl font-bold border border-cyan-200">
                            🪪
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Carnet Digital Oficial</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Cada mascota recibe un carnet interactivo con código de barras en el celular del tutor. Muestra datos del peludo, vigencia y saldos de beneficios disponibles.
                        </p>
                    </div>

                    <!-- 4. MOSTRADOR DE CANJE -->
                    <div class="clinic-card p-7 rounded-3xl space-y-3 reveal-on-scroll">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-700 flex items-center justify-center text-2xl font-bold border border-slate-200">
                            ⚡
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Mostrador de Canje en Vivo</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Búsqueda instantánea por cédula, teléfono o lector QR. Tu recepcionista visualiza de inmediato a qué servicios tiene derecho la mascota y descuenta cupos con auditoría.
                        </p>
                    </div>

                    <!-- 5. ASISTENTE DE IA (AVI INTELLIGENCE) -->
                    <div class="clinic-card p-7 rounded-3xl lg:col-span-2 space-y-3 border-2 border-blue-500/40 bg-gradient-to-br from-white to-blue-50/40 reveal-on-scroll">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-2xl font-bold shadow-sm">
                                🤖
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-blue-800">Inteligencia Operativa</span>
                                <h3 class="text-lg font-bold text-slate-900">Asistente de IA (AVI Intelligence)</h3>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Identifica vencimientos, consulta afiliados y te ayuda a crear acciones de retención automática para tu clínica:
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-1 font-mono text-[11px]">
                            <div class="bg-white p-3 rounded-xl border border-slate-200 text-slate-700 shadow-xs hover:border-blue-400 transition">
                                🔔 "12 planes vencen en los próximos 7 días."
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-200 text-slate-700 shadow-xs hover:border-blue-400 transition">
                                🩺 "8 clientes no han usado sus beneficios."
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-200 text-slate-700 shadow-xs hover:border-blue-400 transition">
                                💉 "5 mascotas tienen vacunas pendientes."
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 9. CARNET DIGITAL INTERACTIVO (EXPERIENCIA DEL PACIENTE - VIP PASS) -->
        <section id="carnet-interactivo" class="py-20 sm:py-24 bg-gradient-to-b from-white via-slate-50/60 to-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- COLUMNA IZQUIERDA: BENEFICIOS COMERCIALES -->
                    <div class="lg:col-span-6 space-y-6 reveal-on-scroll">
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 px-3.5 py-1.5 rounded-full border border-blue-200/90 shadow-2xs">
                            Experiencia del Tutor
                        </span>
                        <h2 class="text-3xl sm:text-5xl font-black text-slate-900 leading-tight">
                            Tu cliente lleva su carnet interactivo en el celular
                        </h2>
                        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                            Una experiencia móvil de primer nivel para el tutor de la mascota. Accede a su carnet digital, consulta los beneficios incluidos y conoce con exactitud qué servicios preventivos ya utilizó y cuáles tiene disponibles en tiempo real.
                        </p>

                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-700 font-medium">
                            <div class="flex items-center space-x-3 p-2.5 rounded-xl bg-slate-50 border border-slate-200/80">
                                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">✓</span>
                                <span><strong>Cero carnets de papel</strong> arrugados, mojados o perdidos en el bolso.</span>
                            </div>
                            <div class="flex items-center space-x-3 p-2.5 rounded-xl bg-slate-50 border border-slate-200/80">
                                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs shrink-0">✓</span>
                                <span><strong>Transparencia total</strong> en saldos, fechas de vacunación y días de renovación.</span>
                            </div>
                            <div class="flex items-center space-x-3 p-2.5 rounded-xl bg-slate-50 border border-slate-200/80">
                                <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-xs shrink-0">✓</span>
                                <span><strong>Fidelización inquebrantable</strong> y orgullo de pertenencia con tu marca clínica.</span>
                            </div>
                        </div>

                        <div class="pt-2 flex flex-wrap items-center gap-3">
                            <a href="/v/vet-pet-patitas/carnet/VP-2026-0001" target="_blank" class="inline-flex items-center space-x-2 px-6 py-3.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold shadow-lg shadow-blue-600/25 transition-all transform hover:-translate-y-0.5">
                                <span>Ver Carnet Real en Pantalla Completa</span>
                                <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            <button type="button" onclick="simulateCarnetRedeem()" class="inline-flex items-center space-x-2 px-5 py-3.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold border border-slate-300 transition">
                                <span>⚡ Probar Canje de Vacuna</span>
                            </button>
                        </div>
                    </div>

                    <!-- MOCKUP IPHONE CON CARNET DIGITAL VIP -->
                    <div class="lg:col-span-6 flex justify-center reveal-on-scroll">
                        <div class="relative w-full max-w-[360px] bg-slate-900 rounded-[44px] p-3.5 shadow-2xl border-4 border-slate-800 ring-1 ring-slate-700/50">
                            
                            <!-- Dynamic Island & Status -->
                            <div class="w-28 h-5 bg-black rounded-full mx-auto mb-2 flex items-center justify-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-blue-900/60"></span>
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-800"></span>
                            </div>

                            <!-- PANTALLA CARNET (APPLE WALLET / VIP PASS STYLE) -->
                            <div class="bg-gradient-to-b from-slate-900 via-[#0d1b2a] to-slate-900 rounded-[32px] p-4 text-white min-h-[480px] flex flex-col justify-between overflow-hidden relative shadow-inner border border-slate-800">
                                
                                <!-- TARJETA VIP PRINCIPAL (GLASSMORPHISM CON DEGRADADO REAL) -->
                                <div class="relative rounded-2xl p-4 bg-gradient-to-br from-blue-700 via-indigo-800 to-slate-900 border border-blue-400/40 shadow-xl space-y-3.5 overflow-hidden">
                                    
                                    <!-- Brillo diagonal -->
                                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-cyan-400/20 rounded-full blur-2xl pointer-events-none"></div>

                                    <!-- Top Header Tarjeta -->
                                    <div class="flex items-center justify-between border-b border-white/15 pb-2.5">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-7 h-7 rounded-lg bg-white/95 p-1 flex items-center justify-center shadow-xs">
                                                <img src="/images/dashboard/brand_logo.png" alt="Logo" class="w-full h-full object-contain">
                                            </div>
                                            <div>
                                                <span class="text-[11px] font-black tracking-tight text-white block leading-tight">Vet-Pet Patitas</span>
                                                <span class="text-[8.5px] font-medium text-cyan-200">Sede Principal · Medellín</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-1.5">
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/25 border border-emerald-400/40 text-emerald-300 text-[9px] font-bold font-mono uppercase">
                                                ● Activo
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Perfil Mascota -->
                                    <div class="flex items-center space-x-3">
                                        <div class="relative w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-400 to-amber-200 p-0.5 shadow-md shrink-0">
                                            <div class="w-full h-full rounded-[14px] bg-slate-900 flex items-center justify-center text-2xl overflow-hidden">
                                                🐕
                                            </div>
                                            <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-emerald-500 border-2 border-slate-900 flex items-center justify-center text-[8px] text-white font-bold">✓</span>
                                        </div>
                                        <div class="space-y-0.5 min-w-0 flex-1">
                                            <div class="flex items-center space-x-1.5">
                                                <h4 class="text-base font-black text-white leading-tight">Luna</h4>
                                                <span class="text-[10px] text-amber-300 font-bold">★ VIP</span>
                                            </div>
                                            <p class="text-[11px] text-slate-200 font-medium truncate">Golden Retriever · 2 años</p>
                                            <div class="flex items-center space-x-2 text-[9.5px] font-mono text-cyan-300">
                                                <span>Chip: #98109823019</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Plan & Tutor -->
                                    <div class="grid grid-cols-2 gap-2 bg-black/30 backdrop-blur-md p-2.5 rounded-xl border border-white/10 text-[10px]">
                                        <div>
                                            <span class="text-slate-400 block text-[9px] uppercase">Plan Activo</span>
                                            <strong class="text-white font-bold truncate block">Plan Premium</strong>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 block text-[9px] uppercase">Tutor Responsable</span>
                                            <span class="text-slate-200 font-medium truncate block">Carlos Mendoza</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- BENEFICIOS DEL CARNET (DETALLE VISUAL EXPANDIDO) -->
                                <div class="bg-slate-900/90 rounded-2xl p-3 border border-slate-800 space-y-2 text-xs">
                                    <div class="flex justify-between items-center text-[10px] font-bold text-slate-300 uppercase tracking-wider">
                                        <span>Coberturas Incluidas</span>
                                        <span id="carnet-balance-count" class="text-cyan-400 font-mono">5 de 8 Utilizados</span>
                                    </div>

                                    <!-- Lista de beneficios en chips compactos -->
                                    <div class="space-y-1.5">
                                        <div class="p-2 rounded-xl bg-slate-800/80 border border-slate-700/60 flex justify-between items-center text-[11px]">
                                            <div class="flex items-center space-x-2">
                                                <span>🩺</span>
                                                <span class="text-slate-200 font-medium">Consultas Médicas</span>
                                            </div>
                                            <span class="px-2 py-0.5 rounded-md bg-blue-900/60 border border-blue-500/40 text-cyan-300 text-[10px] font-mono font-bold">2/2 Disp.</span>
                                        </div>

                                        <div id="benefit-vaccine-row" class="p-2 rounded-xl bg-slate-800/80 border border-slate-700/60 flex justify-between items-center text-[11px] transition-all">
                                            <div class="flex items-center space-x-2">
                                                <span>💉</span>
                                                <span class="text-slate-200 font-medium">Vacuna Séxtuple</span>
                                            </div>
                                            <span id="vaccine-status-badge" class="px-2 py-0.5 rounded-md bg-emerald-900/60 border border-emerald-500/40 text-emerald-300 text-[10px] font-mono font-bold">1/1 Aplicada ✓</span>
                                        </div>

                                        <div class="p-2 rounded-xl bg-slate-800/80 border border-slate-700/60 flex justify-between items-center text-[11px]">
                                            <div class="flex items-center space-x-2">
                                                <span>💊</span>
                                                <span class="text-slate-200 font-medium">Desparasitación</span>
                                            </div>
                                            <span class="px-2 py-0.5 rounded-md bg-blue-900/60 border border-blue-500/40 text-cyan-300 text-[10px] font-mono font-bold">3/3 Disp.</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- CÓDIGO DE BARRAS VECTORIAL VECTOR CODE128 -->
                                <div class="p-2.5 bg-white rounded-xl text-center space-y-1 shadow-sm">
                                    <div class="h-8 flex items-center justify-center space-x-1 px-2">
                                        <!-- Barcode Lines -->
                                        <div class="w-1 h-full bg-slate-950"></div>
                                        <div class="w-0.5 h-full bg-slate-950"></div>
                                        <div class="w-1.5 h-full bg-slate-950"></div>
                                        <div class="w-0.5 h-full bg-slate-950"></div>
                                        <div class="w-2 h-full bg-slate-950"></div>
                                        <div class="w-0.5 h-full bg-slate-950"></div>
                                        <div class="w-1 h-full bg-slate-950"></div>
                                        <div class="w-2 h-full bg-slate-950"></div>
                                        <div class="w-0.5 h-full bg-slate-950"></div>
                                        <div class="w-1.5 h-full bg-slate-950"></div>
                                        <div class="w-1 h-full bg-slate-950"></div>
                                        <div class="w-0.5 h-full bg-slate-950"></div>
                                        <div class="w-2 h-full bg-slate-950"></div>
                                        <div class="w-1 h-full bg-slate-950"></div>
                                        <div class="w-0.5 h-full bg-slate-950"></div>
                                        <div class="w-1.5 h-full bg-slate-950"></div>
                                    </div>
                                    <div class="text-[9px] font-mono font-bold text-slate-800 tracking-widest">VP-PAT-2026-0881</div>
                                </div>

                            </div>

                            <!-- Barra Home iPhone -->
                            <div class="w-28 h-1 bg-slate-700 rounded-full mx-auto mt-2"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 10. AVI INTELLIGENCE: LA IA TRABAJANDO EN VIVO (AZUL CLÍNICO) -->
        <section id="inteligencia" class="py-20 bg-[#FAFAF9] border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14 space-y-2 reveal-on-scroll">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                        Inteligencia Proactiva
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Tu Asistente de IA trabaja mientras atiendes pacientes</h2>
                    <p class="text-xs sm:text-sm text-slate-600">AVI Intelligence detecta oportunidades de renovación y citas preventivas automáticamente.</p>
                </div>

                <div class="max-w-4xl mx-auto clinic-card p-6 sm:p-8 rounded-3xl border-2 border-blue-500/50 bg-gradient-to-br from-white via-slate-50 to-blue-50/20 space-y-6 shadow-lg reveal-on-scroll">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-200 pb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl font-bold shadow-xs">
                                🤖
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Simulación: Análisis del día de tu clínica</h3>
                                <p class="text-xs text-slate-500">Oportunidades de fidelización detectadas hoy</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-900 text-xs font-bold font-mono">
                            <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                            <span>3 Alertas de Retención</span>
                        </span>
                    </div>

                    <!-- TARJETAS DE ACCIÓN DE IA -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        
                        <div class="bg-white p-4 rounded-2xl border border-slate-200 space-y-3 shadow-xs hover:border-amber-400 transition">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-amber-700">⚠️ Vencimientos</span>
                                <span class="font-mono text-[10px] text-slate-400">Próximos 7 días</span>
                            </div>
                            <p class="text-xs text-slate-700 leading-snug">
                                <strong>12 planes por vencer</strong> este fin de mes.
                            </p>
                            <button type="button" onclick="simulateAiAction(this, 'WhatsApp de renovación preparado')" class="w-full py-2 px-3 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-800 text-[11px] font-bold border border-blue-200 transition text-center active:scale-95">
                                Enviar WhatsApp con 1 Clic
                            </button>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border border-slate-200 space-y-3 shadow-xs hover:border-blue-400 transition">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-blue-600">🩺 Chequeos Preventivos</span>
                                <span class="font-mono text-[10px] text-slate-400">Sin uso > 6 meses</span>
                            </div>
                            <p class="text-xs text-slate-700 leading-snug">
                                <strong>8 tutores</strong> no han usado su chequeo incluido.
                            </p>
                            <button type="button" onclick="simulateAiAction(this, 'Invitación a chequeo agendada')" class="w-full py-2 px-3 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-800 text-[11px] font-bold border border-blue-200 transition text-center active:scale-95">
                                Invitar a Chequeo Gratuito
                            </button>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border border-slate-200 space-y-3 shadow-xs hover:border-indigo-400 transition">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-indigo-700">💉 Vacunación Pendiente</span>
                                <span class="font-mono text-[10px] text-slate-400">Refuerzo Anual</span>
                            </div>
                            <p class="text-xs text-slate-700 leading-snug">
                                <strong>5 mascotas</strong> tienen refuerzo disponible.
                            </p>
                            <button type="button" onclick="simulateAiAction(this, 'Recordatorio de vacuna enviado')" class="w-full py-2 px-3 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-800 text-[11px] font-bold border border-blue-200 transition text-center active:scale-95">
                                Notificar por WhatsApp
                            </button>
                        </div>

                    </div>

                    <div id="ai-toast" class="hidden p-3 rounded-xl bg-blue-600 text-white text-xs font-bold text-center transition-all animate-bounce">
                        ¡Acción de IA simulada con éxito!
                    </div>

                </div>
            </div>
        </section>

        <!-- 11. EVOLUCIÓN: DE VISITAS OCASIONALES A RELACIÓN TODO EL AÑO -->
        <section class="py-20 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14 space-y-2 reveal-on-scroll">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                        Modelo de Atención
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">De visitas ocasionales a una relación todo el año</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- SIN PLANES -->
                    <div class="clinic-card p-6 sm:p-8 rounded-3xl border-rose-200 bg-rose-50/20 space-y-4 reveal-on-scroll">
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

                    <!-- CON AVI-PLAN EN AZUL CLÍNICO -->
                    <div class="clinic-card p-6 sm:p-8 rounded-3xl border-2 border-blue-600 bg-blue-50/20 space-y-4 shadow-md reveal-on-scroll">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center font-bold text-xl">✓</div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Con AVI-Plan</h3>
                                <p class="text-xs text-blue-800 font-bold">Un programa para mantener la relación todo el año</p>
                            </div>
                        </div>
                        <ul class="space-y-3 text-xs sm:text-sm text-slate-700">
                            <li class="flex items-start space-x-2">
                                <span class="text-blue-600 font-bold">✓</span>
                                <span>El cliente adquiere una membresía con cobertura programada.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-blue-600 font-bold">✓</span>
                                <span>Los beneficios incluidos incentivan chequeos y vacunas preventivas.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-blue-600 font-bold">✓</span>
                                <span>La clínica comunica renovaciones y vencimientos oportunamente.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-blue-600 font-bold">✓</span>
                                <span>Creas nuevas oportunidades de venta y fidelización en cada visita.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- 12. SEGURIDAD Y CONFIANZA: ¿DÓNDE ESTÁ MI DINERO? -->
        <section class="py-16 bg-[#FAFAF9] border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="p-8 sm:p-10 rounded-3xl bg-white border border-slate-200 space-y-6 shadow-sm reveal-on-scroll">
                    <div class="max-w-2xl space-y-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                            Transparencia y Cuentas Claras
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900">¿Dónde está el dinero de los planes?</h2>
                        <p class="text-xs sm:text-sm text-slate-600">
                            El 100% de los cobros ingresa directamente a tus cuentas bancarias o pasarelas de pago.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-2 hover:border-blue-300 transition">
                            <div class="text-2xl">🏦</div>
                            <h4 class="text-sm font-bold text-slate-900">Tus Medios de Pago Habituales</h4>
                            <p class="text-xs text-slate-600">
                                Cobra por Bancolombia, Nequi, Daviplata, datafono o pasarelas online como Bold y Wompi.
                            </p>
                        </div>

                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-2 hover:border-blue-300 transition">
                            <div class="text-2xl">🚫</div>
                            <h4 class="text-sm font-bold text-slate-900">Cero Comisión por Venta</h4>
                            <p class="text-xs text-slate-600">
                                AVI-Plan no retiene tu dinero ni cobra porcentajes sobre tus ingresos. Solo pagas $5.000 por mascota activa o una suscripción mensual fija.
                            </p>
                        </div>

                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-2 hover:border-blue-300 transition">
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

        <!-- 13. PRECIOS TRANSPARENTES (CON JUSTIFICACIÓN ROI & OPCIÓN POR MASCOTA) -->
        <section id="precios" class="py-20 sm:py-24 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14 space-y-3 reveal-on-scroll">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                        Precios Flexibles y Transparentes
                    </span>
                    <h2 class="text-3xl sm:text-5xl font-black text-slate-900 mt-2">Prueba gratuita de 15 días</h2>
                    <p class="text-sm sm:text-base text-slate-600">
                        Sin tarjeta de crédito requerida. Luego tú decides: paquetes prepago desde $50.000 COP (10 mascotas) o tarifa plana mensual anticipada:
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                    
                    <!-- 1. MODALIDAD FLEXIBLE: POR MASCOTA ACTIVA (PREPAGO) -->
                    <div class="clinic-card p-6 sm:p-7 rounded-3xl flex flex-col justify-between bg-gradient-to-b from-blue-50/50 to-white border-2 border-blue-400/80 shadow-md reveal-on-scroll relative">
                        <div class="space-y-4">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[10px] font-black uppercase tracking-wider">
                                🌱 Cero Riesgo · Prepago
                            </span>
                            <h3 class="text-xl font-black text-slate-900">Por Mascota</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-3xl sm:text-4xl font-extrabold text-blue-700 font-mono">$5.000</span>
                                <span class="text-slate-500 text-xs font-semibold">COP / mascota</span>
                            </div>
                            <div class="text-[11px] font-bold text-blue-900 bg-blue-100/60 px-2.5 py-1 rounded-lg border border-blue-200">
                                Paquetes prepago desde 10 mascotas = $50.000 COP
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Sin deudas a mes vencido. Recargas cupos prepago a medida que tu clínica afilia mascotas.
                            </p>
                            <hr class="border-slate-200">
                            <ul class="space-y-2 text-xs text-slate-700 font-medium">
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span><strong>Paquete de 10 mascotas = $50.000 mes</strong></span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Recaudas ~$650.000 y pagas solo $50.000 (92% margen)</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Con 20+ mascotas pasas a Starter ($99k) y ahorras</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Mes anticipado: cero cartera ni sorpresas</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Portal web propio con tu marca</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Afiche de mostrador con QR oficial</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Carnet digital para tutores y mostrador</span></li>
                            </ul>
                        </div>
                        <button type="button" onclick="openRegisterModal('pay_per_pet')" class="mt-6 w-full py-3 text-center rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-800 font-bold text-xs border border-blue-300 transition">
                            Elegir Paquete 10 Mascotas ($50.000)
                        </button>
                    </div>

                    <!-- 2. STARTER (PLAN FIJO) -->
                    <div class="clinic-card p-6 sm:p-7 rounded-3xl flex flex-col justify-between bg-white reveal-on-scroll">
                        <div class="space-y-4">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider">
                                Consultorios
                            </span>
                            <h3 class="text-xl font-black text-slate-900">Starter</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-mono">$99.000</span>
                                <span class="text-slate-500 text-xs">COP / mes anticipado</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Hasta 60 mascotas activas*. Te sale a solo <strong>$1.650 por mascota</strong>.
                            </p>
                            <hr class="border-slate-100">
                            <ul class="space-y-2 text-xs text-slate-700 font-medium">
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span><strong>Ahorro de hasta el 67%</strong> frente a $5.000/mascota</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Mes anticipado sin permanencia forzosa</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Portal web propio con tu marca</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Afiche de mostrador con QR oficial</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>1 Usuario para recepción</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Mostrador de canje en vivo</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Soporte por WhatsApp</span></li>
                            </ul>
                        </div>
                        <button type="button" onclick="openRegisterModal('starter')" class="mt-6 w-full py-3 text-center rounded-xl bg-white hover:bg-slate-50 text-slate-900 font-bold text-xs border border-slate-300 transition">
                            Elegir Starter
                        </button>
                    </div>

                    <!-- 3. PROFESIONAL (POPULAR) EN AZUL CLÍNICO -->
                    <div class="clinic-card p-6 sm:p-7 rounded-3xl flex flex-col justify-between border-2 border-blue-600 shadow-xl relative transform lg:-translate-y-2 bg-white reveal-on-scroll">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3.5 py-0.5 rounded-full bg-blue-600 text-white font-bold text-[10px] uppercase tracking-wider shadow-sm">
                            ⭐ MÁS ELEGIDO
                        </div>
                        <div class="space-y-4">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold uppercase tracking-wider">
                                En Crecimiento
                            </span>
                            <h3 class="text-xl font-black text-slate-900">Profesional</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-3xl sm:text-4xl font-extrabold text-blue-700 font-mono">$229.000</span>
                                <span class="text-slate-500 text-xs">COP / mes</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Hasta 250 mascotas activas*. Te sale a menos de <strong>$916 por mascota</strong>.
                            </p>
                            <hr class="border-slate-100">
                            <ul class="space-y-2 text-xs text-slate-800 font-medium">
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span><strong>Todo lo del plan Starter</strong></span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span><strong>Usuarios ilimitados</strong> para tu equipo</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span><strong>AVI Intelligence:</strong> Detección de retención</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Reportes de facturación recurrente</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Soporte prioritario</span></li>
                            </ul>
                        </div>
                        <button type="button" onclick="openRegisterModal('pro')" class="mt-6 w-full py-3.5 text-center rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md transition transform hover:scale-[1.02] active:scale-95">
                            Comenzar Prueba Gratuita →
                        </button>
                    </div>

                    <!-- 4. ENTERPRISE -->
                    <div class="clinic-card p-6 sm:p-7 rounded-3xl flex flex-col justify-between bg-white reveal-on-scroll">
                        <div class="space-y-4">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider">
                                Redes y Hospitales
                            </span>
                            <h3 class="text-xl font-black text-slate-900">Enterprise</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-mono">$489.000</span>
                                <span class="text-slate-500 text-xs">COP / mes</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Mascotas ilimitadas + Multi-sucursal + Dominio Propio.</p>
                            <hr class="border-slate-100">
                            <ul class="space-y-2 text-xs text-slate-700 font-medium">
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span><strong>Mascotas y afiliados ilimitados</strong></span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Múltiples sedes y sucursales</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Dominio propio (<code class="text-blue-800 font-mono">tuclinica.com</code>)</span></li>
                                <li class="flex items-center space-x-2"><span class="text-blue-600 font-bold">✓</span> <span>Integración WhatsApp</span></li>
                            </ul>
                        </div>
                        <a href="https://wa.me/573235813942?text=Hola%20Robinson,%20me%20interesa%20el%20plan%20Enterprise%20de%20AVI-Plan" target="_blank" class="mt-6 w-full py-3 text-center rounded-xl bg-white hover:bg-slate-50 text-slate-900 font-bold text-xs border border-slate-300 transition">
                            Contactar Asesor
                        </a>
                    </div>
                </div>

                <div class="mt-8 text-center text-xs text-slate-500 max-w-2xl mx-auto">
                    * <strong>Modalidad Prepago / Mes Anticipado:</strong> Todo paquete o mensualidad se activa por mes anticipado. Así nunca tienes cobros sorpresa a mes vencido ni permanencias obligatorias.
                </div>
            </div>
        </section>

        <!-- 14. PREGUNTAS FRECUENTES (FAQ CLÍNICO) -->
        <section id="faq" class="py-16 sm:py-20 bg-[#FAFAF9] border-b border-slate-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <div class="text-center space-y-2 reveal-on-scroll">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                        Dudas Frecuentes
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Preguntas Frecuentes</h2>
                </div>

                <div class="space-y-4">
                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿En qué momento se paga el servicio? ¿Mes anticipado o mes vencido?</span>
                            <span class="text-blue-600 font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            <strong>Siempre es mes anticipado (prepago)</strong>, garantizando cero deudas acumuladas y total claridad. Tienes tus primeros <strong>15 días 100% gratuitos</strong> para probar todo sin tarjeta de crédito. Al finalizar la prueba, tú decides cómo continuar: puedes recargar un paquete prepago de 10 mascotas por solo $50.000 COP ($5.000 por mascota), o activar tu mensualidad plana (Starter por $99.000 o Profesional por $229.000). Pagas por adelantado el mes de servicio mediante Bancolombia, Nequi o transferencia. Nunca acumulas deudas a mes vencido.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿Tengo que reemplazar mi software actual de historia clínica?</span>
                            <span class="text-blue-600 font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            <strong>No.</strong> AVI-Plan no busca competir con tu software de historia médica o inventarios (SoftVet, Gesvet, Vetlogy, etc.). AVI-Plan es una <strong>plataforma especializada en planes de bienestar, membresías y facturación recurrente</strong>. Convive perfectamente con cualquier sistema que uses hoy.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿AVI-Plan cobra comisión por cada plan vendido?</span>
                            <span class="text-blue-600 font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            <strong>No.</strong> El 100% del dinero cobrado a tus clientes va directo a tus cuentas o medios de pago. No retenemos tu dinero ni cobramos porcentajes por transacción. Tú solo pagas el acceso al software: ya sea tu paquete de cupos prepago ($50.000 por 10 mascotas) o tu tarifa plana mensual fija.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿Cómo funciona la modalidad de paquetes de $5.000 COP por mascota?</span>
                            <span class="text-blue-600 font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            Es la modalidad de <strong>cero riesgo</strong> para empezar sin costo fijo grande. Funciona mediante <strong>paquetes prepago desde 10 mascotas por $50.000 COP</strong> ($5.000 por mascota activa al mes). Si cobras $65.000/mes a 10 tutores, tu clínica recauda $650.000 COP y el costo del software es de solo $50.000 COP (ganas el 92% limpio). Recargas más cupos solo cuando tu clínica afilie más pacientes. Y cuando alcances 20 o más mascotas, te conviene pasarte al plan Starter ($99.000 COP) para pagar aún menos por mascota.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿Puedo crear mis propios beneficios y precios?</span>
                            <span class="text-blue-600 font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            <strong>Sí, con total libertad.</strong> Puedes definir el nombre de tus planes, qué servicios incluye cada uno (número de consultas, vacunas, desparasitaciones, baños o profilaxis) y el precio que desees cobrar.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿Cómo pagan las suscripciones los clientes?</span>
                            <span class="text-blue-600 font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            Puedes configurar tus cuentas habituales: Nequi, Daviplata, transferencia Bancolombia, o enlazar botones de pago digitales como Bold o Wompi.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿Puedo utilizar mi propio dominio?</span>
                            <span class="text-blue-600 font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            Por defecto tienes un subdominio seguro (ej: <code class="text-blue-800 bg-blue-50 px-1 py-0.5 rounded font-mono">avipetapp.com/v/tu-clinica</code>). En el plan Enterprise, puedes conectar directamente tu propio dominio o subdominio corporativo (ej: <code class="text-blue-800 bg-blue-50 px-1 py-0.5 rounded font-mono">salud.tuclinica.com</code>).
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll">
                        <summary class="font-bold text-sm sm:text-base text-slate-900 flex justify-between items-center list-none">
                            <span>¿Qué ocurre cuando terminan los 15 días gratis?</span>
                            <span class="text-blue-600 font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            No solicitamos tarjeta de crédito para iniciar. Al finalizar tu prueba de 15 días, puedes elegir el modelo que prefieras: recargar un <strong>paquete prepago de 10 mascotas por $50.000 COP</strong> (sin compromisos fijos) o activar una <strong>tarifa mensual fija</strong> con ahorro por volumen (Starter desde $99.000 o Pro por $229.000). Si decides no continuar, tu cuenta se pausa sin ningún cobro forzoso ni penalidad.
                        </p>
                    </details>
                </div>
            </div>
        </section>

        <!-- 15. CTA FINAL LUMINOSO CON PULSO -->
        <section class="py-20 bg-gradient-to-b from-[#FAFAF9] to-white">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="clinic-card p-8 sm:p-14 rounded-3xl border-2 border-blue-500/50 text-center space-y-6 shadow-xl bg-gradient-to-b from-white to-blue-50/30 reveal-on-scroll">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold font-mono">
                        <span>🚀 Tu clínica en 60 segundos</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">
                        Crea el programa de salud de tu veterinaria hoy mismo
                    </h2>
                    <p class="text-sm sm:text-lg text-slate-600 max-w-2xl mx-auto font-normal">
                        Tu marca · Tus planes · Tus precios · Tus clientes
                    </p>
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button type="button" onclick="openRegisterModal('pro')" class="w-full sm:w-auto px-9 py-4 rounded-2xl bg-blue-600 text-white font-bold text-base hover:bg-blue-700 shadow-lg shadow-blue-600/25 transition transform hover:-translate-y-1 hover:shadow-xl active:translate-y-0 flex items-center justify-center space-x-2">
                            <span>🟢 Probar AVI-Plan gratis</span>
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
                <img src="/images/dashboard/brand_logo.png" alt="AVI-Plan Logo" class="w-8 h-8 object-contain">
                <div>
                    <span class="font-extrabold text-slate-900">AVI<span class="text-blue-600">Plan</span></span>
                    <span class="text-xs text-slate-500"> — Plataforma de Planes de Bienestar para Veterinarias.</span>
                </div>
            </div>
            <div class="flex space-x-6 font-semibold">
                <a href="/admin" class="hover:text-blue-600 transition-colors">Acceso Mostrador</a>
                <a href="/v/vet-pet-patitas" class="hover:text-blue-600 transition-colors">Clínica Piloto</a>
                <a href="https://wa.me/573235813942" target="_blank" class="hover:text-blue-600 transition-colors">Contacto WhatsApp</a>
            </div>
        </div>
    </footer>

    <!-- MODAL DE REGISTRO EXPRESS CLÍNICO -->
    <div id="register-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 hidden transition-opacity opacity-0 pointer-events-none duration-300">
        <div class="relative w-full max-w-lg bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 text-slate-900 transform scale-95 transition-transform duration-300">
            
            <button type="button" onclick="closeRegisterModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 p-2 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div id="onboarding-header-info" class="space-y-1">
                <div class="flex items-center space-x-2">
                    <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-800 text-[10px] font-bold uppercase border border-blue-200">
                        <span>Prueba Gratuita de 15 Días</span>
                    </div>
                    <span id="modal-tier-badge" class="inline-flex items-center px-2 py-0.5 rounded-full bg-blue-50 text-blue-800 border border-blue-200 text-[10px] font-bold">
                        Plan Profesional
                    </span>
                </div>
                <h3 class="text-2xl font-black text-slate-900">Crea tu Clínica Veterinaria</h3>
                <p class="text-xs text-slate-500 font-medium">Empieza a configurar tus planes y tu afiche en 60 segundos.</p>
            </div>

            <!-- FORMULARIO AJAX -->
            <form id="clinic-onboarding-form" onsubmit="submitOnboarding(event)" class="space-y-4">
                @csrf
                <input type="hidden" name="saas_plan_tier" id="form-tier" value="pro">

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nombre de tu Veterinaria <span class="text-blue-600">*</span></label>
                    <input type="text" name="clinic_name" id="clinic-name-input" required placeholder="Ej. Veterinaria San Roque" oninput="updateSlugPreview(this.value)" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition placeholder:text-slate-400">
                    <p class="text-[10px] text-slate-500 mt-1 font-mono">
                        Tu web será: <span id="slug-preview" class="text-blue-700 font-bold">avipetapp.com/v/tu-clinica</span>
                    </p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1 flex items-center justify-between">
                        <span>Nombre de la Doctora / Médico Veterinario</span>
                        <span class="text-[10px] text-slate-400 lowercase font-medium">(opcional)</span>
                    </label>
                    <input type="text" name="doctor_name" id="doctor-name-input" placeholder="Ej. Dra. Vicky Naranjo o Dr. Carlos Méndez" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition placeholder:text-slate-400">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ciudad <span class="text-blue-600">*</span></label>
                        <input type="text" name="city" required placeholder="Ej. Bogotá / Medellín" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition placeholder:text-slate-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">WhatsApp de Contacto <span class="text-blue-600">*</span></label>
                        <input type="tel" name="phone" required placeholder="Ej. 3101234567" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition placeholder:text-slate-400">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Correo Electrónico (Tu usuario) <span class="text-blue-600">*</span></label>
                    <input type="email" name="email" required placeholder="doctor@tuclinica.com" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition placeholder:text-slate-400">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-slate-700 uppercase">Contraseña <span class="text-blue-600">*</span></label>
                        <button type="button" onclick="togglePasswordVisibility()" class="text-[11px] font-bold text-blue-600 hover:text-blue-800 transition flex items-center space-x-1 cursor-pointer">
                            <span id="eye-icon">👁️</span>
                            <span id="toggle-pwd-text">Ver contraseña</span>
                        </button>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="password-input" required minlength="6" placeholder="Mínimo 6 caracteres" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 pr-10 text-sm text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition placeholder:text-slate-400">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700 cursor-pointer">
                            <svg id="eye-svg-show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eye-svg-hide" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Aviso de Ayuda y Olvido de Contraseña -->
                <div class="p-2.5 rounded-xl bg-blue-50/70 border border-blue-100 text-slate-700 text-[11px] flex items-start space-x-2">
                    <span class="text-sm shrink-0">💬</span>
                    <p class="leading-relaxed">
                        ¿Olvidaste tu contraseña o necesitas ayuda? Escríbenos a WhatsApp al <a href="https://wa.me/573235813942?text=Hola,%20necesito%20ayuda%20o%20soporte%20con%20mi%20cuenta%20de%20AVI-Plan" target="_blank" class="font-black text-blue-700 hover:underline">3235813942</a> o a <a href="mailto:contacto@avipetapp.com" class="font-black text-blue-700 hover:underline">contacto@avipetapp.com</a>.
                    </p>
                </div>

                <div id="form-error-alert" class="hidden p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium"></div>

                <button type="submit" id="submit-btn" class="w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md transition transform active:scale-95 flex items-center justify-center space-x-2">
                    <span id="btn-text">🚀 Activar mi Clínica Gratis</span>
                    <span id="btn-spinner" class="hidden animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></span>
                </button>

                <p class="text-[10px] text-center text-slate-500">
                    Sin tarjeta de crédito requerida. Acceso inmediato.
                </p>
            </form>

            <!-- 2. CARD DE ÉXITO CON RUTAS CREADAS (SE MUESTRA AL TERMINAR EL REGISTRO) -->
            <div id="onboarding-success-card" class="hidden space-y-4">
                <div class="text-center space-y-1.5 pt-2">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl shadow-xs border border-emerald-200">
                        🎉
                    </div>
                    <h3 class="text-xl font-black text-slate-900">¡Tu Clínica fue Creada con Éxito!</h3>
                    <p class="text-xs text-slate-600 font-medium">Tus 15 días de prueba gratis ya están activos. Guarda tus accesos oficiales:</p>
                </div>

                <!-- Bloque de URLs Creadas -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-3.5 space-y-3">
                    <!-- Vitrina Web -->
                    <div class="space-y-1">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-500">🌐 Vitrina Pública para tus Tutores:</span>
                        <div class="flex items-center justify-between bg-white border border-slate-200 rounded-xl px-3 py-2">
                            <span id="success-storefront-url" class="text-xs font-bold text-blue-600 truncate select-all"></span>
                            <button type="button" onclick="copyText('success-storefront-url')" class="text-[10px] font-bold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg hover:bg-blue-100 transition shrink-0 ml-2 cursor-pointer">Copiar</button>
                        </div>
                    </div>

                    <!-- Panel Admin -->
                    <div class="space-y-1">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-500">⚙️ Tu Panel Administrativo de Control:</span>
                        <div class="flex items-center justify-between bg-white border border-slate-200 rounded-xl px-3 py-2">
                            <span id="success-admin-url" class="text-xs font-bold text-slate-800 truncate select-all"></span>
                            <button type="button" onclick="copyText('success-admin-url')" class="text-[10px] font-bold bg-slate-100 text-slate-700 px-2.5 py-1 rounded-lg hover:bg-slate-200 transition shrink-0 ml-2 cursor-pointer">Copiar</button>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 pt-1">
                    <a id="success-enter-btn" href="#" class="w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md transition flex items-center justify-center space-x-2">
                        <span>🚀 Configurar mi Marca y Logotipo (Paso 1)</span>
                        <span id="countdown-timer" class="text-blue-200 text-xs font-normal">(redirigiendo en 6s...)</span>
                    </a>
                    <p class="text-[10px] text-center text-slate-400">Si no haces clic, entrarás automáticamente en unos segundos.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS INTERACTIVOS & MOTOR DE ANIMACIÓN -->
    <script>
        // 1. REVEAL ANIMATIONS ON SCROLL (INTERSECTION OBSERVER)
        document.addEventListener('DOMContentLoaded', () => {
            const reveals = document.querySelectorAll('.reveal-on-scroll');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.12 });
            reveals.forEach(el => observer.observe(el));
            
            // Iniciar simulador de flujo
            selectStep(1);
        });

        // 2. MODAL LOGIC
        function openRegisterModal(tier = 'pro') {
            document.getElementById('form-tier').value = tier;
            const badge = document.getElementById('modal-tier-badge');
            if (badge) {
                if (tier === 'pay_per_pet') {
                    badge.innerText = 'Paquete 10 Mascotas ($50.000)';
                    badge.className = 'inline-flex items-center px-2 py-0.5 rounded-full bg-cyan-50 text-cyan-800 border border-cyan-200 text-[10px] font-bold';
                } else if (tier === 'starter') {
                    badge.innerText = 'Plan Starter ($99k)';
                    badge.className = 'inline-flex items-center px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200 text-[10px] font-bold';
                } else if (tier === 'enterprise') {
                    badge.innerText = 'Plan Enterprise';
                    badge.className = 'inline-flex items-center px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-800 border border-indigo-200 text-[10px] font-bold';
                } else {
                    badge.innerText = 'Plan Profesional';
                    badge.className = 'inline-flex items-center px-2 py-0.5 rounded-full bg-blue-50 text-blue-800 border border-blue-200 text-[10px] font-bold';
                }
            }
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

        function togglePasswordVisibility() {
            const input = document.getElementById('password-input');
            const showSvg = document.getElementById('eye-svg-show');
            const hideSvg = document.getElementById('eye-svg-hide');
            const text = document.getElementById('toggle-pwd-text');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                showSvg.classList.add('hidden');
                hideSvg.classList.remove('hidden');
                text.innerText = 'Ocultar';
                icon.innerText = '🙈';
            } else {
                input.type = 'password';
                showSvg.classList.remove('hidden');
                hideSvg.classList.add('hidden');
                text.innerText = 'Ver contraseña';
                icon.innerText = '👁️';
            }
        }

        function copyText(elementId) {
            const el = document.getElementById(elementId);
            const text = el.innerText || el.textContent;
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('¡Enlace copiado al portapapeles!:\n' + text);
                }).catch(() => {
                    prompt('Copia este enlace:', text);
                });
            } else {
                prompt('Copia este enlace:', text);
            }
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

                // Mostrar Card de Éxito con las Rutas Creadas
                document.getElementById('clinic-onboarding-form').classList.add('hidden');
                document.getElementById('onboarding-header-info').classList.add('hidden');
                
                const successCard = document.getElementById('onboarding-success-card');
                const sfUrl = data.storefront_url || `https://avipetapp.com/v/${data.tenant_slug}`;
                const admUrl = data.admin_url || `https://avipetapp.com/admin/${data.tenant_slug}`;
                
                document.getElementById('success-storefront-url').innerText = sfUrl;
                document.getElementById('success-admin-url').innerText = admUrl;
                
                const enterBtn = document.getElementById('success-enter-btn');
                enterBtn.href = data.redirect_url || admUrl;
                
                successCard.classList.remove('hidden');

                // Conteo regresivo para entrar
                let timeLeft = 7;
                const timerEl = document.getElementById('countdown-timer');
                const interval = setInterval(() => {
                    timeLeft--;
                    if (timeLeft <= 0) {
                        clearInterval(interval);
                        window.location.href = data.redirect_url || admUrl;
                    } else {
                        timerEl.innerText = `(redirigiendo en ${timeLeft}s...)`;
                    }
                }, 1000);

            } catch (err) {
                errorAlert.innerText = err.message;
                errorAlert.classList.remove('hidden');
                submitBtn.disabled = false;
                btnText.innerText = '🚀 Activar mi Clínica Gratis';
                btnSpinner.classList.add('hidden');
            }
        }

        // 3. CALCULADORA MRR CON EFECTO SUAVE (EN AZUL CLÍNICO)
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

            const perPetCost = count * 5000;
            const perPetElem = document.getElementById('mrr-per-pet-cost');
            if (perPetElem) {
                perPetElem.innerHTML = formatCOP(perPetCost) + '<span class="text-[10px] font-normal text-slate-500">/mes</span>';
            }

            let cost = 99000;
            if (count > 60 && count <= 250) {
                cost = 229000;
            } else if (count > 250) {
                cost = 489000;
            }
            mrrTierCost.innerHTML = formatCOP(cost) + '<span class="text-[10px] font-normal text-slate-500">/mes</span>';

            const bestCost = Math.min(cost, perPetCost);
            const margin = Math.max(0, Math.round(((monthly - bestCost) / monthly) * 100));
            mrrNetMargin.innerText = `~${margin}% neto (${formatCOP(monthly - bestCost)}/mes)`;
        }

        petsSlider.addEventListener('input', calculateMRR);

        function setPlanPrice(price) {
            currentPlanPrice = price;
            document.querySelectorAll('.price-btn').forEach(btn => {
                const p = parseInt(btn.getAttribute('data-price'));
                if (p === price) {
                    btn.className = 'price-btn py-2.5 px-3 rounded-xl border-2 border-blue-600 bg-blue-50 text-xs font-black text-blue-900 transition shadow-xs';
                } else {
                    btn.className = 'price-btn py-2.5 px-3 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-700 hover:border-blue-600 transition';
                }
            });
            calculateMRR();
        }

        calculateMRR();

        // 4. TICKER DE ACTIVIDAD EN VIVO EN EL HERO
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
            
            box.style.transform = 'translateY(6px)';
            box.style.opacity = '0';
            setTimeout(() => {
                document.getElementById('live-activity-icon').innerText = item.icon;
                document.getElementById('live-activity-title').innerText = item.title;
                document.getElementById('live-activity-desc').innerText = item.desc;
                box.style.transform = 'translateY(0)';
                box.style.opacity = '1';
            }, 300);
        }

        setInterval(cycleLiveActivity, 4000);

        // 5. TIMELINE INTERACTIVO ULTRA-MODERNO
        const stepData = {
            1: {
                tag: 'Paso 01 · Configuración de Planes',
                html: `
                    <div class="space-y-3.5 animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-cyan-300 font-bold flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                                <span>Creador de Planes Activo</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-500/20 text-cyan-300 border border-blue-500/30 font-mono">100% Personalizable</span>
                        </div>
                        <div class="bg-slate-800/90 p-4 rounded-2xl border border-slate-700 space-y-3 shadow-lg">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h5 class="font-black text-white text-sm">Plan Premium Patitas</h5>
                                    <span class="text-[10px] text-slate-400">Caninos adultos (1 a 7 años)</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-mono text-cyan-400 font-extrabold text-base">$65.000</span>
                                    <span class="text-[9px] text-slate-400 block font-mono">COP / mes</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-200">
                                <div class="bg-slate-900/80 p-2 rounded-xl border border-slate-700/80 flex items-center space-x-1.5">
                                    <span class="text-emerald-400 font-bold">✓</span>
                                    <span>2 Consultas / año</span>
                                </div>
                                <div class="bg-slate-900/80 p-2 rounded-xl border border-slate-700/80 flex items-center space-x-1.5">
                                    <span class="text-emerald-400 font-bold">✓</span>
                                    <span>1 Vacuna Séxtuple</span>
                                </div>
                                <div class="bg-slate-900/80 p-2 rounded-xl border border-slate-700/80 flex items-center space-x-1.5">
                                    <span class="text-emerald-400 font-bold">✓</span>
                                    <span>3 Desparasitaciones</span>
                                </div>
                                <div class="bg-slate-900/80 p-2 rounded-xl border border-slate-700/80 flex items-center space-x-1.5">
                                    <span class="text-emerald-400 font-bold">✓</span>
                                    <span>2 Baños Medicados</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400">Tú decides los beneficios, exclusiones y tarifas mensuales de tu clínica sin ataduras.</p>
                    </div>
                `
            },
            2: {
                tag: 'Paso 02 · Escaneo QR Mostrador',
                html: `
                    <div class="space-y-3.5 animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-cyan-300 font-bold flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                                <span>Afiche en Sala de Espera</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 font-mono">Auto-atención</span>
                        </div>
                        <div class="bg-slate-800/90 p-4 rounded-2xl border border-slate-700 flex items-center space-x-4 shadow-lg">
                            <div class="w-16 h-16 bg-white rounded-xl p-1.5 flex items-center justify-center shrink-0 border-2 border-cyan-400 shadow-md">
                                <img src="/images/dashboard/brand_logo.png" alt="QR" class="w-full h-full object-contain">
                            </div>
                            <div class="space-y-1">
                                <h5 class="text-xs font-black text-white">El tutor escanea mientras espera</h5>
                                <p class="text-[11px] text-cyan-300 font-mono">avipetapp.com/v/tu-clinica</p>
                                <span class="inline-block text-[9.5px] bg-blue-500/20 text-blue-200 px-2 py-0.5 rounded font-mono border border-blue-500/30">Cero filas en recepción</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400">El afiche impreso atrae la atención de tus clientes y automatiza las ventas en el mostrador.</p>
                    </div>
                `
            },
            3: {
                tag: 'Paso 03 · Afiliación Digital',
                html: `
                    <div class="space-y-3.5 animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-cyan-300 font-bold flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                                <span>Formulario Express en Celular</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-500/20 text-cyan-300 border border-blue-500/30 font-mono">2 Minutos</span>
                        </div>
                        <div class="bg-slate-800/90 p-4 rounded-2xl border border-slate-700 space-y-2 text-xs shadow-lg font-mono">
                            <div class="flex justify-between border-b border-slate-700/80 pb-1.5">
                                <span class="text-slate-400">Tutor:</span>
                                <span class="text-white font-bold">Carlos Mendoza (CC 1.020.345.***)</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-700/80 pb-1.5">
                                <span class="text-slate-400">Mascota:</span>
                                <span class="text-cyan-300 font-bold">Luna 🐕 (Golden Retriever)</span>
                            </div>
                            <div class="flex justify-between items-center pt-0.5">
                                <span class="text-slate-400">Medio Pago:</span>
                                <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-bold text-[10px]">Bancolombia / Nequi / Bold</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400">Sin papeleos ni contratos físicos: la base de datos de tu clínica se actualiza al instante.</p>
                    </div>
                `
            },
            4: {
                tag: 'Paso 04 · Carnet Digital Móvil',
                html: `
                    <div class="space-y-3.5 animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-cyan-300 font-bold flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                                <span>Carnet Interactivo Oficial</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 font-mono">En WhatsApp</span>
                        </div>
                        <div class="bg-gradient-to-br from-blue-900 via-indigo-950 to-slate-900 p-4 rounded-2xl border border-blue-400/40 space-y-2.5 shadow-xl">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-2">
                                    <span class="text-lg">🐕</span>
                                    <span class="text-xs font-black text-white">LUNA · VIP HEALTH PASS</span>
                                </div>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-500/25 text-emerald-300 text-[9px] font-mono font-bold">ACTIVO ✓</span>
                            </div>
                            <div class="p-2 bg-white rounded-lg text-center font-mono text-[10px] text-slate-900 font-bold tracking-widest">
                                ||| | |||| | ||| || VP-PAT-2026-0881
                            </div>
                            <div class="text-[11px] text-slate-300 flex justify-between">
                                <span>Saldo Coberturas:</span>
                                <span class="text-cyan-300 font-bold font-mono">5 de 8 Utilizadas</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400">El tutor lo consulta 24/7 desde su móvil, reduciendo llamadas de preguntas a recepción.</p>
                    </div>
                `
            },
            5: {
                tag: 'Paso 05 · Canje Rápido en Mostrador',
                html: `
                    <div class="space-y-3.5 animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-cyan-300 font-bold flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                                <span>Validación en 3 Segundos</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-500/20 text-cyan-300 border border-blue-500/30 font-mono">Auditoría 100%</span>
                        </div>
                        <div class="bg-slate-800/90 p-4 rounded-2xl border border-slate-700 space-y-2.5 shadow-lg">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-400">Servicio Canjeado:</span>
                                <strong class="text-white font-mono">Vacuna Séxtuple</strong>
                            </div>
                            <div class="p-2.5 rounded-xl bg-emerald-950/60 border border-emerald-500/60 flex items-center space-x-2 text-xs text-emerald-200">
                                <span class="text-emerald-400 font-bold text-sm">✓</span>
                                <span>Cupo descontado. Auditoría registrada por Dra. Vicky Naranjo.</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400">Tu recepcionista digita la cédula o escanea el carnet y listo. Cero confusión de beneficios.</p>
                    </div>
                `
            },
            6: {
                tag: 'Paso 06 · Renovaciones y Fidelidad',
                html: `
                    <div class="space-y-3.5 animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-cyan-300 font-bold flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                                <span>Retención Proactiva con IA</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-purple-500/20 text-purple-300 border border-purple-500/30 font-mono">Gemini 2.5</span>
                        </div>
                        <div class="bg-slate-800/90 p-4 rounded-2xl border border-purple-500/40 space-y-2 text-xs shadow-lg">
                            <div class="text-amber-300 font-bold flex items-center space-x-1">
                                <span>⚠️</span>
                                <span>Alerta Preventiva de Vencimiento:</span>
                            </div>
                            <p class="text-slate-300 text-[11px] leading-relaxed">
                                El plan de Luna vence en 5 días. Mensaje WhatsApp automatizado listo para enviar con 1 clic.
                            </p>
                            <div class="pt-1 flex items-center justify-between text-[10px] font-mono text-cyan-300 border-t border-slate-700/80">
                                <span>Tasa de Retención Promedio:</span>
                                <strong class="text-emerald-400">82% Anual</strong>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400">Mantén los ingresos recurrentes fijos mes a mes sin desgastar a tu equipo en cobranzas.</p>
                    </div>
                `
            }
        };

        let currentActiveStep = 1;

        function selectStep(step) {
            currentActiveStep = step;
            for (let i = 1; i <= 6; i++) {
                const btn = document.getElementById(`step-btn-${i}`);
                if (!btn) continue;
                const num = btn.querySelector('span');
                if (i === step) {
                    btn.className = 'step-card p-4 rounded-2xl border-2 border-blue-600 bg-blue-50/70 cursor-pointer transition-all flex items-start space-x-3.5 shadow-sm transform scale-[1.01]';
                    num.className = 'w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black font-mono text-sm shrink-0 shadow-xs';
                } else {
                    btn.className = 'step-card p-4 rounded-2xl border border-slate-200 bg-white hover:border-blue-300 cursor-pointer transition-all flex items-start space-x-3.5';
                    num.className = 'w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-black font-mono text-sm shrink-0';
                }
            }

            const data = stepData[step];
            if (data) {
                const tag = document.getElementById('step-screen-tag');
                const content = document.getElementById('step-screen-content');
                const currentNum = document.getElementById('step-current-number');
                const progressBar = document.getElementById('step-progress-bar');
                
                if (tag) tag.innerText = data.tag;
                if (content) content.innerHTML = data.html;
                if (currentNum) currentNum.innerText = step;
                if (progressBar) progressBar.style.width = `${(step / 6) * 100}%`;
            }
        }

        // Ejecución inmediata al cargar la página
        selectStep(1);

        // Auto-recorrido cada 6 segundos si el usuario no interactúa
        let autoStepInterval = setInterval(() => {
            let next = (currentActiveStep % 6) + 1;
            selectStep(next);
        }, 6000);

        document.querySelectorAll('.step-card').forEach(card => {
            card.addEventListener('click', () => clearInterval(autoStepInterval));
        });

        // 6. DEMO INTERACTIVA DE ESCANEO DE QR (CON AUDIO SINTETIZADO Y ANIMACIÓN)
        function triggerQrScanDemo() {
            const scannerView = document.getElementById('phone-view-scanner');
            const portalView = document.getElementById('phone-view-portal');
            const btn = document.getElementById('scan-trigger-btn');
            const btnText = document.getElementById('scan-btn-text');

            if (!scannerView || !portalView) return;

            // Audio Chime de escaneo sintético
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(880, ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(1760, ctx.currentTime + 0.15);
                gain.gain.setValueAtTime(0.15, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.2);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.2);
            } catch (e) {}

            btnText.innerText = '⚡ Escaneando código QR...';
            btn.classList.add('scale-95');

            setTimeout(() => {
                scannerView.classList.add('opacity-0', 'pointer-events-none');
                portalView.classList.remove('opacity-0');
                btnText.innerText = '✓ ¡Portal Abierto en Celular!';
                btn.classList.remove('scale-95', 'bg-blue-600');
                btn.classList.add('bg-emerald-600');
            }, 600);
        }

        // 7. SIMULADOR DE CANJE EN EL CARNET INTERACTIVO
        function simulateCarnetRedeem() {
            const row = document.getElementById('benefit-vaccine-row');
            const badge = document.getElementById('vaccine-status-badge');
            const count = document.getElementById('carnet-balance-count');
            
            if (!row || !badge) return;

            badge.innerText = '✓ Canjeado Hoy';
            badge.className = 'px-2 py-0.5 rounded-md bg-emerald-500 text-white text-[10px] font-mono font-bold animate-bounce';
            row.classList.add('bg-emerald-950/80', 'border-emerald-500/80');
            if (count) count.innerText = '6 de 8 Utilizados';

            const toast = document.getElementById('ai-toast');
            if (toast) {
                toast.innerText = '💉 ¡Vacuna Séxtuple canjeada con éxito en mostrador! Auditoría en tiempo real registrada.';
                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 4000);
            }
        }

        // 8. CARNET INTERACTIVO ACCORDEÓN
        function toggleCarnetBenefits() {
            const drawer = document.getElementById('carnet-benefits-drawer');
            const chevron = document.getElementById('benefits-chevron');
            if (!drawer) return;
            if (drawer.classList.contains('hidden')) {
                drawer.classList.remove('hidden');
                if (chevron) chevron.innerText = '▲';
            } else {
                drawer.classList.add('hidden');
                if (chevron) chevron.innerText = '▼';
            }
        }

        // 9. SIMULADOR DE ACCIÓN IA
        function simulateAiAction(btn, msg) {
            const originalText = btn.innerText;
            btn.innerText = '✓ Procesando...';
            btn.disabled = true;
            btn.classList.add('bg-blue-600', 'text-white');

            const toast = document.getElementById('ai-toast');
            if (toast) {
                toast.innerText = `🤖 AVI Intelligence: ${msg}`;
                toast.classList.remove('hidden');
            }

            setTimeout(() => {
                btn.innerText = '✓ ' + originalText;
                btn.disabled = false;
                btn.classList.remove('bg-blue-600', 'text-white');
            }, 2500);

            setTimeout(() => {
                if (toast) toast.classList.add('hidden');
            }, 4500);
        }
    </script>
</body>
</html>
