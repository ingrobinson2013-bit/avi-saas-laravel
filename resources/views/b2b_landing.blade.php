<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F4F7FC] text-[#15213B] antialiased selection:bg-[#6D28D9] selection:text-white overflow-x-hidden scroll-smooth">
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
    <title>AviPetApp — Software con IA para veterinarias | Planes de salud para mascotas</title>
    <meta name="description" content="AviPetApp ayuda a tu clínica a gestionar planes de salud para mascotas, organizar la relación con tus clientes y aprovechar herramientas inteligentes desde una sola plataforma. 15 días gratis.">
    <meta name="keywords" content="avipetapp, software con ia para veterinarias, software veterinaria colombia, veterinarias socias colombia, software para clinicas veterinarias, planes de salud para mascotas, membresias veterinarias, facturacion recurrente veterinaria, carnet digital mascotas, saas veterinario">
    <meta name="application-name" content="AviPetApp">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Open Graph / WhatsApp / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="AviPetApp — Software con IA para veterinarias">
    <meta property="og:description" content="Planes de salud, clientes e IA en una sola plataforma. Organiza los planes de salud de tu clínica veterinaria en un solo lugar.">
    <meta property="og:image" content="{{ url('/brand/favicons/og-image-1200x630.png') }}">
    <meta property="og:site_name" content="AviPetApp">
    <meta property="og:locale" content="es_CO">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="AviPetApp — Software con IA para veterinarias">
    <meta name="twitter:description" content="Planes de salud, clientes e IA en una sola plataforma para clínicas veterinarias.">
    <meta name="twitter:image" content="{{ url('/brand/favicons/og-image-1200x630.png') }}">

    <!-- Schema.org JSON-LD Enriquecido para Google Search & Google AI Overview (GEO) -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@@type": "WebSite",
          "@@id": "https://avipetapp.com/#website",
          "name": "AviPetApp",
          "alternateName": ["AviPetApp", "Software con IA para veterinarias", "avipetapp.com"],
          "url": "https://avipetapp.com/"
        },
        {
          "@@type": "Organization",
          "@@id": "https://avipetapp.com/#organization",
          "name": "AviPetApp",
          "alternateName": ["AviPetApp", "Red de Clínicas Veterinarias Socias AviPetApp"],
          "url": "https://avipetapp.com",
          "description": "AviPetApp es una plataforma tecnológica para clínicas veterinarias que buscan digitalizar servicios, comercializar planes de salud para mascotas y mejorar la relación con sus clientes mediante software, automatización e inteligencia artificial.",
          "logo": {
            "@@type": "ImageObject",
            "url": "{{ url('/brand/png/avipetapp-icono-app.png') }}"
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
          "name": "AviPetApp — Software con IA para veterinarias",
          "alternateName": "AviPetApp",
          "operatingSystem": "All, Web, Cloud",
          "applicationCategory": "BusinessApplication, HealthApplication",
          "offers": {
            "@@type": "Offer",
            "price": "50000",
            "priceCurrency": "COP",
            "priceValidUntil": "2027-12-31"
          },
          "aggregateRating": {
            "@@type": "AggregateRating",
            "ratingValue": "4.9",
            "reviewCount": "38"
          },
          "description": "Software con IA para veterinarias en Colombia (avipetapp.com): planes de salud para mascotas, clientes e IA en una sola plataforma.",
          "url": "https://avipetapp.com",
          "image": "{{ url('/brand/favicons/og-image-1200x630.png') }}"
        },
        {
          "@@type": "FAQPage",
          "@@id": "https://avipetapp.com/#faq",
          "mainEntity": [
            {
              "@@type": "Question",
              "name": "¿Qué es AviPetApp y cómo funciona para las clínicas veterinarias?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "AviPetApp (en avipetapp.com) es una plataforma tecnológica con IA para clínicas veterinarias que permite digitalizar servicios, comercializar planes de salud para mascotas y organizar la relación con los clientes desde una sola plataforma."
              }
            },
            {
              "@@type": "Question",
              "name": "¿En qué momento se paga el servicio de AviPetApp?",
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
                "text": "No. AviPetApp no compite con tu software de historia clínica tradicional. Es una plataforma especializada en planes de salud para mascotas, membresías y comunicación que convive perfectamente con cualquier sistema."
              }
            },
            {
              "@@type": "Question",
              "name": "¿AviPetApp cobra comisión por cada plan de salud vendido en la clínica?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "No. El 100% del dinero cobrado a tus clientes va directo a tus cuentas o pasarelas de pago. No retenemos comisiones por transacción."
              }
            },
            {
              "@@type": "Question",
              "name": "¿Puedo crear mis propios planes de salud para mascotas con precios y servicios personalizados?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Sí, con total libertad. Puedes definir el nombre de tus planes de salud para mascotas, qué servicios incluye cada uno (vacunas, desparasitación, consultas, profilaxis o baños) y la cuota mensual en pesos colombianos."
              }
            },
            {
              "@@type": "Question",
              "name": "¿Cómo beneficia el Carnet Digital para mascotas a la clínica?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "El carnet digital con código QR se envía directamente por WhatsApp al tutor, permitiendo validar vigencias, coberturas y realizar canjes en recepción en segundos sin papeleos ni carnets de cartón."
              }
            }
          ]
        }
      ]
    }
    </script>

    <!-- Google Tag / GA4 -->
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

    <!-- Google Tag Manager -->
    @if($gtmId)
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $gtmId }}');</script>
    @endif

    <!-- Cloudflare Web Analytics -->
    @if($cfToken)
    <script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "{{ $cfToken }}"}'></script>
    @endif

    <link rel="icon" type="image/svg+xml" href="/brand/favicons/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/brand/favicons/favicon-32.png">
    <link rel="shortcut icon" href="/brand/favicons/favicon-32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/brand/favicons/favicon-180.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Tipografía oficial única del Manual Maestro de Marca v1.1 (Pág. 8): Inter (400, 500, 600, 700) con Arial como alternativa de sistema -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, html, body {
            font-family: 'Inter', Arial, sans-serif;
            font-feature-settings: "cv02", "cv03", "cv04", "cv11";
        }
        .font-mono {
            font-family: 'Inter', Arial, sans-serif;
            font-variant-numeric: tabular-nums;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #E2E8F0;
        }
        .clinic-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            box-shadow: 0 4px 20px -2px rgba(21, 33, 59, 0.05);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .clinic-card:hover {
            border-color: #CBD5E1;
            box-shadow: 0 14px 28px -6px rgba(21, 33, 59, 0.09);
            transform: translateY(-2px);
        }

        /* DEGRADADO DE MARCA AVIPETAPP (Violet Deep #6D28D9 -> Neon Violet #A855F7 -> Cyan Deep #0E7490) */
        .gradient-headline {
            background: linear-gradient(135deg, #6D28D9 0%, #A855F7 50%, #0E7490 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-headline-dark {
            background: linear-gradient(135deg, #A855F7 0%, #35DDF5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ANIMACIONES MODERNAS SAAS */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        .animate-float { animation: floatSlow 5s ease-in-out infinite; }

        @keyframes floatReverse {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(6px); }
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

        /* REVEAL ANIMATIONS ON SCROLL */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.55s cubic-bezier(0.16, 1, 0.3, 1), transform 0.55s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between overflow-x-hidden bg-[#F4F7FC] text-[#15213B]">

    <!-- 1. HEADER / NAVBAR OFICIAL AVIPETAPP (Págs. 5, 6 y 9: Logo Horizontal >= 140px con margen libre X y navegación en 1 sola línea) -->
    <header class="sticky top-0 z-50 glass-nav transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            <!-- Logo Horizontal Oficial para Cabeceras (sin texto invadiendo el espacio libre X) -->
            <a href="/" class="flex items-center py-3 shrink-0 group" aria-label="AviPetApp — Inicio">
                <img
                    src="/brand/svg/avipetapp-horizontal-fondo-claro.svg"
                    alt="AviPetApp"
                    class="h-8 sm:h-9 w-auto min-w-[148px] object-contain transition-transform duration-200 group-hover:scale-[1.02]"
                >
            </a>

            <!-- Arquitectura de la Web (Pág. 9): Navegación en 1 sola línea sin saltos de renglón -->
            <nav class="hidden xl:flex items-center gap-6 text-[14px] font-medium text-[#5C6B85]">
                <a href="#veterinarias-socias" class="text-[#0E7490] font-semibold hover:text-[#6D28D9] transition-colors whitespace-nowrap">
                    Para clínicas
                </a>
                <a href="#como-funciona" class="hover:text-[#15213B] transition-colors whitespace-nowrap">Planes de salud</a>
                <a href="#recibes" class="hover:text-[#15213B] transition-colors whitespace-nowrap">Módulos e IA</a>
                <a href="#calculadora" class="hover:text-[#15213B] transition-colors whitespace-nowrap">Calculadora</a>
                <a href="#scanner-demo" class="hover:text-[#15213B] transition-colors inline-flex items-center gap-1.5 whitespace-nowrap">
                    <span>Demo QR</span>
                    <span class="px-2 py-0.5 text-[11px] font-semibold bg-[#6D28D9]/10 text-[#6D28D9] rounded-full">Vivo</span>
                </a>
                <a href="#precios" class="hover:text-[#15213B] transition-colors whitespace-nowrap">Precios</a>
                <a href="#faq" class="hover:text-[#15213B] transition-colors whitespace-nowrap">FAQ</a>
                <a href="/blog" class="text-[#6D28D9] font-semibold hover:text-[#5B21B6] transition-colors whitespace-nowrap">Blog</a>
            </nav>

            <!-- Botones de Acción (Pág. 8 y 9: Botones 14-16px SemiBold, Violet Deep #6D28D9) -->
            <div class="flex items-center gap-2.5 sm:gap-3 shrink-0">
                <a href="/admin" class="hidden sm:inline-flex items-center px-4 py-2.5 text-[14px] font-semibold text-[#15213B] hover:text-[#6D28D9] transition-colors rounded-xl border border-transparent hover:border-slate-200 whitespace-nowrap">
                    Iniciar sesión
                </a>
                <button type="button" onclick="openRegisterModal('pro')" class="px-4 sm:px-5 py-2.5 text-[14px] font-semibold leading-none text-white bg-[#6D28D9] hover:bg-[#5B21B6] rounded-xl shadow-sm transition-all transform hover:-translate-y-0.5 active:translate-y-0 inline-flex items-center gap-2 whitespace-nowrap cursor-pointer">
                    <span class="w-2 h-2 rounded-full bg-[#35DDF5]"></span>
                    <span>Crear mi clínica</span>
                </button>
                <!-- BOTÓN HAMBURGUESA MÓVIL / TABLET -->
                <button type="button" onclick="toggleMobileMenu()" id="mobile-menu-btn" class="xl:hidden p-2 rounded-xl text-[#15213B] hover:text-[#6D28D9] hover:bg-slate-100 transition focus:outline-none" aria-label="Abrir menú de navegación">
                    <svg id="hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- MENÚ MÓVIL DESPLEGABLE -->
        <div id="mobile-menu" class="hidden xl:hidden bg-white border-b border-slate-200 px-4 pt-3 pb-6 space-y-3 shadow-xl">
            <nav class="flex flex-col space-y-1 text-[14px] font-medium text-[#15213B]">
                <a href="#veterinarias-socias" onclick="toggleMobileMenu()" class="px-3.5 py-2.5 rounded-xl bg-[#0F9F9A]/10 text-[#0E7490] font-semibold transition flex items-center justify-between">
                    <span>Para clínicas · Veterinarias Socias</span>
                    <span class="text-[11px] bg-[#0F9F9A] text-white px-2 py-0.5 rounded-full font-semibold">Cupos</span>
                </a>
                <a href="#como-funciona" onclick="toggleMobileMenu()" class="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between">
                    <span>Planes de salud · Cómo funciona</span>
                    <span class="text-xs text-[#5C6B85]">→</span>
                </a>
                <a href="#recibes" onclick="toggleMobileMenu()" class="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between">
                    <span>Módulos e IA · Lo que recibes</span>
                    <span class="text-xs text-[#5C6B85]">→</span>
                </a>
                <a href="#calculadora" onclick="toggleMobileMenu()" class="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between">
                    <span>Calculadora de ingresos</span>
                    <span class="text-xs text-[#5C6B85]">→</span>
                </a>
                <a href="#scanner-demo" onclick="toggleMobileMenu()" class="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between">
                    <span>Demo de escáner QR en mostrador</span>
                    <span class="px-2 py-0.5 text-[11px] font-semibold bg-[#6D28D9]/10 text-[#6D28D9] rounded-full">Demo</span>
                </a>
                <a href="#carnet-interactivo" onclick="toggleMobileMenu()" class="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between">
                    <span>Carnet digital del tutor</span>
                    <span class="text-xs text-[#5C6B85]">→</span>
                </a>
                <a href="#inteligencia" onclick="toggleMobileMenu()" class="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between">
                    <span>Herramientas de IA con supervisión</span>
                    <span class="text-xs text-[#5C6B85]">→</span>
                </a>
                <a href="#precios" onclick="toggleMobileMenu()" class="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between">
                    <span>Precios y planes</span>
                    <span class="text-xs text-[#5C6B85]">→</span>
                </a>
                <a href="#faq" onclick="toggleMobileMenu()" class="px-3.5 py-2.5 rounded-xl hover:bg-[#F4F7FC] hover:text-[#6D28D9] transition flex items-center justify-between">
                    <span>Preguntas frecuentes</span>
                    <span class="text-xs text-[#5C6B85]">→</span>
                </a>
                <a href="/blog" class="px-3.5 py-2.5 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] font-semibold transition flex items-center justify-between">
                    <span>Blog y guías para clínicas</span>
                    <span class="text-[11px] bg-[#6D28D9] text-white px-2 py-0.5 rounded-full font-semibold">Guías</span>
                </a>
            </nav>

            <div class="pt-3 border-t border-slate-200 flex flex-col gap-2.5">
                <a href="/admin" class="w-full py-2.5 px-4 text-center rounded-xl border border-[#6D28D9] text-[#6D28D9] font-semibold text-[14px] hover:bg-[#6D28D9]/5 transition">
                    Iniciar sesión en mi clínica
                </a>
                <a href="https://wa.me/573235813942?text=Hola%20AviPetApp,%20quiero%20solicitar%20una%20demo%20para%20mi%20cl%C3%ADnica%20veterinaria" target="_blank" class="w-full py-2.5 px-4 text-center rounded-xl bg-[#0F9F9A] hover:bg-[#0E7490] text-white font-semibold text-[14px] transition shadow-sm">
                    Hablar con el equipo (WhatsApp)
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- 2. HERO PRINCIPAL: DIRECCIÓN HÍBRIDA DEL MANUAL MAESTRO DE MARCA v1.1 (Págs. 3, 7, 8, 9 y 12) -->
        <section class="relative pt-12 sm:pt-16 pb-16 sm:pb-24 overflow-hidden bg-gradient-to-b from-white via-[#F4F7FC] to-[#F4F7FC] border-b border-slate-200">
            <!-- Orbes sutiles en Neon Violet (#A855F7) y Electric Cyan (#35DDF5) -->
            <div class="absolute -top-24 left-1/4 w-96 h-96 bg-[#A855F7]/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/2 -right-24 w-80 h-80 bg-[#35DDF5]/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">

                    <!-- COLUMNA IZQUIERDA: JERARQUÍA DE MENSAJES OFICIAL (Págs. 3, 8 y 12) -->
                    <div class="lg:col-span-7 space-y-6 text-left reveal-on-scroll">

                        <!-- Descriptor Oficial + Mensaje de Producto (Pág. 3) -->
                        <div class="inline-flex flex-wrap items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#6D28D9]/10 border border-[#6D28D9]/20 text-[#6D28D9] text-[13px] font-semibold">
                            <span class="w-2 h-2 rounded-full bg-[#6D28D9]"></span>
                            <span>Software con IA para veterinarias · 15 días de prueba sin tarjeta</span>
                        </div>

                        <!-- Titular Hero de Marketing (Pág. 8: 48-64px, interlineado 1.1, Bold, frase corta y clara) -->
                        <h1 class="text-4xl sm:text-5xl lg:text-[56px] font-bold tracking-tight text-[#15213B] leading-[1.1]">
                            Tu clínica, conectada con el <span class="gradient-headline">futuro del bienestar animal.</span>
                        </h1>

                        <!-- Mensaje Principal Oficial (Pág. 12: Texto base 14-16px, interlineado 1.5, < 75 caracteres por línea) -->
                        <p class="text-[15px] sm:text-[16px] text-[#5C6B85] leading-[1.5] font-normal max-w-[62ch]">
                            <strong class="text-[#15213B] font-semibold">Planes de salud, clientes e IA en una sola plataforma.</strong> AviPetApp ayuda a tu clínica a gestionar planes de salud para mascotas, organizar la relación con tus clientes y aprovechar herramientas inteligentes desde un solo lugar.
                        </p>

                        <!-- Sello de Colaboración y Marca Propia (Pág. 3: La clínica conserva el criterio profesional y la relación con sus clientes) -->
                        <div class="inline-flex items-center gap-2 text-[13px] font-semibold text-[#0E7490] bg-[#0E7490]/10 border border-[#0E7490]/20 px-3.5 py-2 rounded-xl">
                            <svg class="w-4 h-4 text-[#0E7490] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Tu marca · Tus planes de salud · Tus precios · Tus clientes</span>
                        </div>

                        <!-- Llamadas a la Acción Oficiales (Pág. 8, 9 y 12: Botones 14-16px SemiBold, Violet Deep #6D28D9 y Secundario con borde #6D28D9) -->
                        <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5">
                            <button type="button" onclick="openRegisterModal('pro')" class="px-7 py-4 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-[15px] leading-none shadow-md shadow-[#6D28D9]/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 cursor-pointer">
                                <span>Crear mi clínica (15 días gratis)</span>
                                <span>→</span>
                            </button>
                            <a href="#como-funciona" class="px-6 py-4 rounded-xl bg-white hover:bg-[#6D28D9]/5 text-[#6D28D9] font-semibold text-[15px] leading-none border-2 border-[#6D28D9] transition-all flex items-center justify-center gap-2 text-center">
                                <span>Conocer los planes</span>
                            </a>
                        </div>

                        <!-- Ejemplo Operativo con Regla de Datos Clara (Pág. 3 y Pág. 9: Valores ilustrativos con definición clara) -->
                        <div class="pt-1 p-4 rounded-2xl bg-white border border-slate-200 shadow-xs max-w-xl">
                            <div class="flex items-center justify-between text-[13px] font-semibold text-[#15213B]">
                                <span class="text-[#5C6B85]">Escenario ilustrativo de operación:</span>
                                <span class="text-[#6D28D9] font-bold tabular-nums">50 mascotas × $65.000 COP/mes</span>
                            </div>
                            <div class="flex items-baseline justify-between mt-1.5 pt-2 border-t border-slate-100">
                                <span class="text-[12px] text-[#5C6B85]">Recaudo mensual estimado directo a tu clínica:</span>
                                <span class="text-[16px] font-bold text-[#0E7490] tabular-nums">$3.250.000 COP / mes</span>
                            </div>
                        </div>

                        <!-- Pilares de Comunicación (Pág. 12) -->
                        <div class="pt-1 flex flex-wrap items-center gap-5 text-[13px] text-[#5C6B85] font-medium">
                            <div class="flex items-center gap-1.5">
                                <span class="text-[#0F9F9A] font-bold">✓</span>
                                <span>Afiche QR para recepción</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-[#0F9F9A] font-bold">✓</span>
                                <span>Canje en mostrador con auditoría</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-[#0F9F9A] font-bold">✓</span>
                                <span>100 % recaudo directo a tu clínica</span>
                            </div>
                        </div>

                    </div>

                    <!-- COLUMNA DERECHA: PANEL DEMO EN VIVO CON PALETA DE PRODUCTO Y ESTADOS OFICIALES (Págs. 7 y 9) -->
                    <div class="lg:col-span-5 reveal-on-scroll">
                        <div class="relative w-full max-w-md mx-auto animate-float">

                            <!-- Halo sutil de marca -->
                            <div class="absolute -inset-1 bg-gradient-to-r from-[#6D28D9] to-[#0E7490] rounded-3xl blur-md opacity-20 pointer-events-none"></div>

                            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-xl p-6 space-y-5">

                                <!-- Header del Widget Demo -->
                                <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <span class="relative flex h-2.5 w-2.5">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#0F9F9A] opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#0F9F9A]"></span>
                                        </span>
                                        <div>
                                            <h3 class="text-[13px] font-bold text-[#15213B]">Consultorio Demo · Vista de Producto</h3>
                                            <p class="text-[11px] text-[#5C6B85]">Valores ilustrativos · Periodo: Mes actual</p>
                                        </div>
                                    </div>
                                    <!-- Estado Oficial "Activa" (Pág. 9: Success Teal #0F9F9A con icono check) -->
                                    <span class="px-2.5 py-1 rounded-full bg-[#0F9F9A]/15 text-[#0E7490] text-[11px] font-semibold inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-[#0F9F9A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Activa</span>
                                    </span>
                                </div>

                                <!-- Indicadores con periodo y definición visibles (Pág. 9) -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-[#F4F7FC] p-3.5 rounded-xl border border-slate-200/80">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[11px] font-semibold text-[#5C6B85]">Mascotas con membresía</span>
                                        </div>
                                        <div id="live-pets-counter" class="text-2xl font-bold text-[#15213B] tabular-nums mt-1">127</div>
                                        <span class="text-[11px] font-medium text-[#0E7490]">Planes activos este mes</span>
                                    </div>

                                    <div class="bg-[#F4F7FC] p-3.5 rounded-xl border border-slate-200/80">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[11px] font-semibold text-[#5C6B85]">Recaudo de la clínica</span>
                                        </div>
                                        <div id="live-mrr-counter" class="text-xl font-bold text-[#6D28D9] tabular-nums mt-1">$8.255.000</div>
                                        <span class="text-[11px] font-medium text-[#5C6B85]">COP · Directo a la clínica</span>
                                    </div>

                                    <!-- Estado Oficial "Pendiente" (Pág. 9: Warning Amber #B45309 con icono reloj) -->
                                    <div class="bg-[#B45309]/10 p-3 rounded-xl border border-[#B45309]/25">
                                        <div class="flex items-center gap-1.5 text-[11px] font-semibold text-[#B45309]">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>Pendiente renovar</span>
                                        </div>
                                        <span class="text-[13px] font-bold text-[#15213B] block mt-1 tabular-nums">6 planes esta semana</span>
                                    </div>

                                    <!-- Estado Oficial Confirmado (Success Teal #0F9F9A) -->
                                    <div class="bg-[#0F9F9A]/10 p-3 rounded-xl border border-[#0F9F9A]/25">
                                        <div class="flex items-center gap-1.5 text-[11px] font-semibold text-[#0E7490]">
                                            <svg class="w-3.5 h-3.5 text-[#0F9F9A] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            <span>Canjes del día</span>
                                        </div>
                                        <span class="text-[13px] font-bold text-[#15213B] block mt-1 tabular-nums">3 vacunas · 9 consultas</span>
                                    </div>
                                </div>

                                <!-- Barra de Uso y Renovación -->
                                <div class="space-y-1.5 bg-[#F4F7FC] p-3.5 rounded-xl border border-slate-200/80">
                                    <div class="flex justify-between text-[12px] font-semibold text-[#15213B]">
                                        <span>Continuidad de planes (12 meses)</span>
                                        <span class="text-[#6D28D9] tabular-nums">82 %</span>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-[#6D28D9] to-[#0F9F9A] h-2 rounded-full shimmer-effect" style="width: 82%"></div>
                                    </div>
                                </div>

                                <!-- Actividad de Mostrador -->
                                <div class="space-y-2 border-t border-slate-100 pt-3">
                                    <div class="flex items-center justify-between text-[11px] font-semibold text-[#5C6B85]">
                                        <span>Último registro en recepción</span>
                                        <span class="text-[#0E7490]">Tiempo real</span>
                                    </div>
                                    <div id="live-activity-box" class="p-3 rounded-xl bg-[#F4F7FC] border border-slate-200/80 text-xs text-[#15213B] transition-all duration-500 flex items-center gap-2.5">
                                        <span class="text-base shrink-0" id="live-activity-icon">🐕</span>
                                        <div class="truncate">
                                            <strong id="live-activity-title" class="text-[#15213B] font-semibold">Luna (Golden Retriever)</strong>
                                            <span id="live-activity-desc" class="text-[#5C6B85] block text-[11px]">Canjeó Vacuna Séxtuple en recepción</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Acción Secundaria Oficial (Borde #6D28D9) -->
                                <a href="https://vet-pet-patitas.avipetapp.com" target="_blank" class="w-full py-2.5 px-4 text-center rounded-xl bg-white hover:bg-[#6D28D9]/5 text-[#6D28D9] font-semibold text-[13px] border border-[#6D28D9] transition flex items-center justify-center gap-1.5">
                                    <span>Explorar clínica piloto en vivo</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 3. SECCIÓN DE COLABORACIÓN: NO REEMPLAZAMOS TU SOFTWARE ACTUAL -->
        <section class="py-8 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="p-6 sm:p-8 rounded-2xl bg-[#F4F7FC] border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-6 reveal-on-scroll">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </div>
                        <div class="space-y-1">
                            <h2 class="text-[18px] sm:text-[20px] font-bold text-[#15213B] leading-[1.3]">
                                AviPetApp complementa tu software de historia clínica actual
                            </h2>
                            <p class="text-[14px] text-[#5C6B85] max-w-[68ch] leading-[1.5]">
                                Si ya utilizas <strong>Vetlogy, SoftVet, Gesvet o Excel</strong> para expedientes médicos e inventario, puedes seguir usándolos. AviPetApp organiza los <strong>planes de salud para mascotas, membresías, carnets digitales y recordatorios</strong> desde una plataforma conectada con tu recepción.
                            </p>
                        </div>
                    </div>
                    <div class="shrink-0 inline-flex items-center gap-2 text-[13px] font-semibold text-[#0E7490] bg-[#0F9F9A]/15 border border-[#0F9F9A]/30 px-4 py-2.5 rounded-xl">
                        <svg class="w-4 h-4 text-[#0F9F9A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span>100 % Complementario</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3.5 PIEZA DE MARCA OSCURA (Págs. 7 y 9: Midnight #080B20 + Deep Navy #111936 + Neon Violet #A855F7 + Electric Cyan #35DDF5) -->
        <section id="veterinarias-socias" class="py-16 sm:py-20 bg-[#080B20] text-white border-b border-[#111936] relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-10">
                <div class="text-center max-w-3xl mx-auto space-y-3 reveal-on-scroll">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#111936] border border-[#35DDF5]/30 text-[#35DDF5] text-[12px] font-semibold uppercase tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-[#35DDF5]"></span>
                        <span>Para clínicas · Red AviPetApp Colombia</span>
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-bold tracking-tight text-white leading-[1.2]">
                        Programa de <span class="text-[#35DDF5]">Clínicas Veterinarias Socias</span> en Colombia
                    </h2>
                    <p class="text-[15px] sm:text-[16px] text-slate-300 leading-[1.5] max-w-[65ch] mx-auto">
                        Digitaliza los planes de salud para mascotas en tu ciudad con tu propia identidad clínica, recordatorios oportunos y herramientas inteligentes para tu equipo.
                    </p>
                </div>

                <!-- 4 PILARES DE COMUNICACIÓN (Pág. 12: Gestión más simple, Relación continua, Inteligencia aplicada, Crecimiento medible) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 reveal-on-scroll">
                    <div class="bg-[#111936] border border-white/10 hover:border-[#35DDF5]/50 rounded-2xl p-6 space-y-2.5 transition">
                        <div class="w-10 h-10 rounded-xl bg-[#35DDF5]/15 text-[#35DDF5] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <h3 class="text-[16px] font-bold text-white">1. Gestión más simple</h3>
                        <p class="text-[13px] text-slate-300 leading-[1.5]">
                            Planes, membresías, clientes y operación en orden desde tu propio portal (<code class="text-[#35DDF5]">tu-clinica.avipetapp.com</code>).
                        </p>
                    </div>

                    <div class="bg-[#111936] border border-white/10 hover:border-[#A855F7]/50 rounded-2xl p-6 space-y-2.5 transition">
                        <div class="w-10 h-10 rounded-xl bg-[#A855F7]/15 text-[#A855F7] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-[16px] font-bold text-white">2. Recaudo 100 % directo</h3>
                        <p class="text-[13px] text-slate-300 leading-[1.5]">
                            Cero comisiones por mascota afiliada. Tus clientes pagan directamente a tu Nequi, Bancolombia o enlace Bold/Wompi.
                        </p>
                    </div>

                    <div class="bg-[#111936] border border-white/10 hover:border-[#35DDF5]/50 rounded-2xl p-6 space-y-2.5 transition">
                        <div class="w-10 h-10 rounded-xl bg-[#35DDF5]/15 text-[#35DDF5] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        </div>
                        <h3 class="text-[16px] font-bold text-white">3. Relación continua</h3>
                        <p class="text-[13px] text-slate-300 leading-[1.5]">
                            Afiche QR para recepción, carnet digital en el celular del tutor y recordatorios oportunos de vacunación y controles.
                        </p>
                    </div>

                    <div class="bg-[#111936] border border-white/10 hover:border-[#A855F7]/50 rounded-2xl p-6 space-y-2.5 transition">
                        <div class="w-10 h-10 rounded-xl bg-[#A855F7]/15 text-[#A855F7] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="text-[16px] font-bold text-white">4. Inteligencia aplicada</h3>
                        <p class="text-[13px] text-slate-300 leading-[1.5]">
                            Automatizaciones para tareas repetitivas con supervisión profesional, manteniendo siempre el criterio clínico de tu equipo.
                        </p>
                    </div>
                </div>

                <!-- CASO REAL + CTA DE DEMO (Pág. 9: Tarjeta Deep Navy #111936 con botón Electric Cyan #35DDF5 sobre Midnight #080B20) -->
                <div class="bg-[#111936] border border-[#A855F7]/30 rounded-2xl p-6 sm:p-8 flex flex-col lg:flex-row items-center justify-between gap-6 shadow-xl reveal-on-scroll">
                    <div class="space-y-3 max-w-2xl">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-[#0F9F9A]/20 border border-[#0F9F9A]/40 text-[#35DDF5] text-[11px] font-semibold">Clínica Piloto en Operación</span>
                            <span class="text-[12px] text-slate-300 font-medium">📍 Cajicá, Cundinamarca</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-white leading-[1.3]">
                            Conoce la experiencia real de <span class="text-[#35DDF5]">Vet-Pet Patitas Consultorio Veterinario</span>
                        </h3>
                        <p class="text-[14px] text-slate-300 leading-[1.5]">
                            Organiza sus planes de salud para mascotas con AviPetApp, entrega carnets digitales con código QR en recepción y facilita el seguimiento preventivo para las familias.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row lg:flex-col gap-3 w-full lg:w-auto shrink-0">
                        <button type="button" onclick="openRegisterModal('pro')" class="px-6 py-3.5 rounded-xl bg-[#35DDF5] hover:bg-[#22d3ee] text-[#080B20] font-semibold text-[14px] leading-none shadow-md transition text-center cursor-pointer">
                            Solicitar una demo (15 días gratis)
                        </button>
                        <a href="https://wa.me/573235813942?text=Hola%20AviPetApp,%20quiero%20informaci%C3%B3n%20para%20mi%20cl%C3%ADnica%20veterinaria" target="_blank" class="px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/15 text-white font-semibold text-[14px] leading-none border border-white/20 transition text-center">
                            Hablar con el equipo por WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </section>


        <!-- 4. CALCULADORA MRR PROTAGONISTA (Cloud White #F4F7FC · Violet Deep #6D28D9 · Cyan Deep #0E7490) -->
        <section id="calculadora" class="py-16 sm:py-24 bg-[#F4F7FC] border-b border-[#D9E2F2]">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12 space-y-2.5 reveal-on-scroll">
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-[#6D28D9] bg-[#6D28D9]/10 px-3.5 py-1 rounded-full border border-[#6D28D9]/20">
                        Simulador Financiero en Tiempo Real
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">¿Cuánto podría generar tu veterinaria?</h2>
                    <p class="text-sm text-[#5C6B85]">Arrastra el deslizador para proyectar tus ingresos recurrentes mensuales con planes de salud preventiva.</p>
                </div>

                <div class="clinic-card p-6 sm:p-10 rounded-2xl space-y-8 bg-white border border-[#D9E2F2] reveal-on-scroll shadow-md">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        
                        <!-- CONTROLES REACTIVOS -->
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-baseline mb-2">
                                    <label class="text-xs font-bold text-[#15213B] uppercase tracking-wide">Mascotas activas en planes:</label>
                                    <div class="flex items-baseline space-x-1.5">
                                        <span id="pets-count-display" class="text-3xl font-bold text-[#6D28D9] tabular-nums transition-transform">50</span>
                                        <span class="text-xs font-semibold text-[#5C6B85]">mascotas</span>
                                    </div>
                                </div>
                                <input type="range" id="pets-slider" min="10" max="300" step="5" value="50" class="w-full h-3 bg-[#E2E8F0] rounded-lg appearance-none cursor-pointer accent-[#6D28D9] hover:accent-[#5B21B6] transition">
                                <div class="flex justify-between text-[11px] text-[#5C6B85] font-semibold mt-1.5 tabular-nums">
                                    <span>10</span>
                                    <span>75</span>
                                    <span>150</span>
                                    <span>225</span>
                                    <span>300</span>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-[#15213B] uppercase tracking-wide block mb-2">Tarifa promedio mensual del plan:</label>
                                <div class="grid grid-cols-3 gap-1.5 sm:gap-2.5">
                                    <button type="button" onclick="setPlanPrice(49000)" class="price-btn py-2.5 px-2 sm:px-3 rounded-xl border border-[#D9E2F2] bg-white text-xs font-semibold text-[#15213B] hover:border-[#6D28D9] transition tabular-nums" data-price="49000">
                                        $49.000 <span class="block text-[10px] text-[#5C6B85] font-normal">Básico</span>
                                    </button>
                                    <button type="button" onclick="setPlanPrice(65000)" class="price-btn py-2.5 px-2 sm:px-3 rounded-xl border-2 border-[#6D28D9] bg-[#6D28D9]/10 text-xs font-bold text-[#6D28D9] transition shadow-2xs tabular-nums" data-price="65000">
                                        $65.000 ⭐ <span class="block text-[10px] text-[#6D28D9] font-medium">Recomendado</span>
                                    </button>
                                    <button type="button" onclick="setPlanPrice(89000)" class="price-btn py-2.5 px-2 sm:px-3 rounded-xl border border-[#D9E2F2] bg-white text-xs font-semibold text-[#15213B] hover:border-[#6D28D9] transition tabular-nums" data-price="89000">
                                        $89.000 <span class="block text-[10px] text-[#5C6B85] font-normal">Premium</span>
                                    </button>
                                </div>
                            </div>

                            <div class="p-4 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2] text-xs text-[#5C6B85] space-y-1">
                                <div class="font-bold text-[#15213B] flex items-center space-x-1.5">
                                    <span>💡</span>
                                    <span>Referencia operativa para tu clínica:</span>
                                </div>
                                <p class="text-xs leading-relaxed">
                                    Un plan promedio de $65.000/mes incluye 2 consultas preventivas al año, vacuna séxtuple, rabia y desparasitaciones periódicas. El tutor organiza su gasto y tu clínica mantiene al paciente activo todo el año.
                                </p>
                            </div>
                        </div>

                        <!-- RESULTADOS ESTIMADOS -->
                        <div class="bg-[#F4F7FC] p-6 sm:p-7 rounded-2xl border-2 border-[#6D28D9]/40 space-y-4 text-center shadow-sm relative overflow-hidden">
                            
                            <div class="space-y-1">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-[#6D28D9]">Ingreso recurrente mensual estimado</span>
                                <div id="mrr-monthly" class="text-4xl sm:text-5xl font-bold text-[#15213B] tabular-nums tracking-tight transition-all duration-300">$3.250.000</div>
                                <span class="text-[11px] text-[#5C6B85] block pt-1">
                                    Proyección anual: <strong id="mrr-annual" class="text-[#15213B] tabular-nums">$39.000.000</strong> COP / año
                                </span>
                            </div>

                            <hr class="border-[#D9E2F2]">

                            <div class="grid grid-cols-2 gap-3 text-left">
                                <div class="bg-white p-3 rounded-xl border border-[#D9E2F2] shadow-2xs">
                                    <span class="text-[10px] uppercase font-bold text-[#5C6B85] block">A $5.000 / Mascota</span>
                                    <span id="mrr-per-pet-cost" class="text-sm sm:text-base font-bold text-[#15213B] tabular-nums">$250.000<span class="text-[10px] font-normal text-[#5C6B85]">/mes</span></span>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-[#0E7490]/30 bg-[#0E7490]/5 shadow-2xs">
                                    <span class="text-[10px] uppercase font-bold text-[#0E7490] block">En Plan Fijo (Ahorro)</span>
                                    <span id="mrr-tier-cost" class="text-sm sm:text-base font-bold text-[#0E7490] tabular-nums">$99.000<span class="text-[10px] font-normal text-[#5C6B85]">/mes</span></span>
                                </div>
                            </div>

                            <div class="bg-[#ECFDF5] p-3 rounded-xl border border-[#0F9F9A]/30 text-xs font-bold text-[#065F46] flex justify-between items-center">
                                <span>Margen que retiene tu clínica:</span>
                                <span id="mrr-net-margin" class="tabular-nums text-sm">~97% directo</span>
                            </div>

                            <div class="pt-1">
                                <button type="button" onclick="openRegisterModal('pro')" class="w-full py-3.5 bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-sm rounded-xl shadow-md transition transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                                    Comenzar mi programa de bienestar →
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- 5. FLUJO INTERACTIVO EN 6 PASOS (Product Light + Midnight Frame) -->
        <section id="como-funciona" class="py-16 sm:py-24 bg-white border-b border-[#D9E2F2]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-14 space-y-2.5 reveal-on-scroll">
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-[#0E7490] bg-[#0E7490]/10 px-3.5 py-1.5 rounded-full border border-[#0E7490]/25">
                        Flujo Operativo Simple
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">Así funciona en tu clínica</h2>
                    <p class="text-sm text-[#5C6B85]">Haz clic en cada etapa para ver cómo opera en tiempo real.</p>
                </div>

                <!-- CONTENEDOR SPLIT: ETAPAS INTERACTIVAS + PANTALLA DE SIMULACIÓN -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <!-- LISTA DE 6 ETAPAS CON SELECTOR ACTIVO -->
                    <div class="lg:col-span-6 space-y-3">
                        <div onclick="selectStep(1)" id="step-btn-1" class="step-card p-4 rounded-2xl border-2 border-[#6D28D9] bg-[#6D28D9]/5 cursor-pointer transition-all flex items-start space-x-3.5 shadow-sm transform scale-[1.01]">
                            <span class="w-10 h-10 rounded-xl bg-[#6D28D9] text-white flex items-center justify-center font-bold tabular-nums text-sm shrink-0 shadow-xs">01</span>
                            <div>
                                <h4 class="text-sm font-bold text-[#15213B]">Crea tus planes de salud</h4>
                                <p class="text-xs text-[#5C6B85] mt-0.5">Define consultas, vacunas, desparasitaciones y fija tu tarifa mensual con total libertad.</p>
                            </div>
                        </div>

                        <div onclick="selectStep(2)" id="step-btn-2" class="step-card p-4 rounded-2xl border border-[#D9E2F2] bg-white hover:border-[#6D28D9]/50 cursor-pointer transition-all flex items-start space-x-3.5">
                            <span class="w-10 h-10 rounded-xl bg-[#F4F7FC] text-[#15213B] flex items-center justify-center font-bold tabular-nums text-sm shrink-0">02</span>
                            <div>
                                <h4 class="text-sm font-bold text-[#15213B]">Escaneo del Afiche QR en Mostrador</h4>
                                <p class="text-xs text-[#5C6B85] mt-0.5">El tutor escanea el afiche oficial en la sala de espera o entra a tu enlace web desde WhatsApp.</p>
                            </div>
                        </div>

                        <div onclick="selectStep(3)" id="step-btn-3" class="step-card p-4 rounded-2xl border border-[#D9E2F2] bg-white hover:border-[#6D28D9]/50 cursor-pointer transition-all flex items-start space-x-3.5">
                            <span class="w-10 h-10 rounded-xl bg-[#F4F7FC] text-[#15213B] flex items-center justify-center font-bold tabular-nums text-sm shrink-0">03</span>
                            <div>
                                <h4 class="text-sm font-bold text-[#15213B]">Afiliación Digital en 2 Minutos</h4>
                                <p class="text-xs text-[#5C6B85] mt-0.5">El tutor registra a su mascota y adquiere su membresía sin papeles ni trámites manuales.</p>
                            </div>
                        </div>

                        <div onclick="selectStep(4)" id="step-btn-4" class="step-card p-4 rounded-2xl border border-[#D9E2F2] bg-white hover:border-[#6D28D9]/50 cursor-pointer transition-all flex items-start space-x-3.5">
                            <span class="w-10 h-10 rounded-xl bg-[#F4F7FC] text-[#15213B] flex items-center justify-center font-bold tabular-nums text-sm shrink-0">04</span>
                            <div>
                                <h4 class="text-sm font-bold text-[#15213B]">Carnet Digital en el Celular</h4>
                                <p class="text-xs text-[#5C6B85] mt-0.5">Recibe al instante su carnet con código de barras en su móvil para consultar sus saldos.</p>
                            </div>
                        </div>

                        <div onclick="selectStep(5)" id="step-btn-5" class="step-card p-4 rounded-2xl border border-[#D9E2F2] bg-white hover:border-[#6D28D9]/50 cursor-pointer transition-all flex items-start space-x-3.5">
                            <span class="w-10 h-10 rounded-xl bg-[#F4F7FC] text-[#15213B] flex items-center justify-center font-bold tabular-nums text-sm shrink-0">05</span>
                            <div>
                                <h4 class="text-sm font-bold text-[#15213B]">Canje en Recepción en 3 Segundos</h4>
                                <p class="text-xs text-[#5C6B85] mt-0.5">La recepcionista digita la cédula o escanea el QR y descuenta cupos con auditoría.</p>
                            </div>
                        </div>

                        <div onclick="selectStep(6)" id="step-btn-6" class="step-card p-4 rounded-2xl border border-[#D9E2F2] bg-white hover:border-[#6D28D9]/50 cursor-pointer transition-all flex items-start space-x-3.5">
                            <span class="w-10 h-10 rounded-xl bg-[#F4F7FC] text-[#15213B] flex items-center justify-center font-bold tabular-nums text-sm shrink-0">06</span>
                            <div>
                                <h4 class="text-sm font-bold text-[#15213B]">Renovaciones y Retención Automática</h4>
                                <p class="text-xs text-[#5C6B85] mt-0.5">El sistema gestiona vencimientos y te ayuda a reactivar planes oportunamente.</p>
                            </div>
                        </div>
                    </div>

                    <!-- PANTALLA DE SIMULACIÓN VISUAL DEL PASO ACTIVO (Midnight #080B20 + Deep Navy #111936) -->
                    <div class="lg:col-span-6">
                        <div class="relative bg-[#080B20] text-white rounded-2xl p-5 sm:p-7 shadow-2xl border border-[#1E2B58] min-h-[460px] flex flex-col justify-between overflow-hidden">
                            <!-- Glow ambiental de marca -->
                            <div class="absolute -top-20 -right-20 w-64 h-64 bg-[#A855F7]/15 rounded-full blur-3xl pointer-events-none"></div>
                            
                            <!-- BARRA SUPERIOR DE VENTANA -->
                            <div class="flex items-center justify-between border-b border-[#1E2B58] pb-3 relative z-10">
                                <div class="flex items-center space-x-2">
                                    <span class="w-3 h-3 rounded-full bg-[#B91C1C]"></span>
                                    <span class="w-3 h-3 rounded-full bg-[#B45309]"></span>
                                    <span class="w-3 h-3 rounded-full bg-[#0F9F9A]"></span>
                                </div>
                                <div class="hidden sm:flex items-center space-x-1.5 px-3 py-1 rounded-lg bg-[#111936] border border-[#1E2B58] text-[11px] text-slate-300">
                                    <span class="text-[#0F9F9A]">🔒</span>
                                    <span>vet-pet-patitas.avipetapp.com</span>
                                </div>
                                <span id="step-screen-tag" class="text-xs text-[#35DDF5] font-bold uppercase tracking-wider">
                                    Paso 01 · Configuración
                                </span>
                            </div>

                            <!-- CONTENIDO DINÁMICO DE LA PANTALLA -->
                            <div id="step-screen-content" class="py-4 relative z-10 transition-all duration-300 min-h-[290px] flex flex-col justify-center">
                                <!-- Se inyecta dinámicamente con selectStep() -->
                            </div>

                            <!-- BARRA DE PROGRESO DE AUTO-PLAY -->
                            <div class="space-y-2 border-t border-[#1E2B58] pt-3 relative z-10">
                                <div class="flex justify-between text-[11px] text-slate-400">
                                    <span>Etapa <span id="step-current-number" class="text-white font-bold tabular-nums">1</span> de 6</span>
                                    <span class="text-[#35DDF5] text-[10px] font-semibold uppercase tracking-wider flex items-center space-x-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#35DDF5] animate-ping"></span>
                                        <span>Simulación Interactiva</span>
                                    </span>
                                </div>
                                <div class="w-full bg-[#111936] h-1.5 rounded-full overflow-hidden">
                                    <div id="step-progress-bar" class="bg-gradient-to-r from-[#A855F7] to-[#35DDF5] h-1.5 transition-all duration-500" style="width: 16.6%"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 6. DEMO INTERACTIVA: ESCÁNER QR DEL MOSTRADOR EN VIVO -->
        <section id="scanner-demo" class="py-16 sm:py-24 bg-[#F4F7FC] border-b border-[#D9E2F2]">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12 space-y-2.5 reveal-on-scroll">
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-[#6D28D9] bg-[#6D28D9]/10 px-3.5 py-1.5 rounded-full border border-[#6D28D9]/20">
                        Experiencia en Sala de Espera
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">Pruébalo: Simula el escaneo de recepción</h2>
                    <p class="text-sm text-[#5C6B85]">Mira exactamente lo que ve y experimenta un tutor cuando escanea el afiche físico en tu clínica.</p>
                </div>

                <div class="p-6 sm:p-10 rounded-2xl bg-white border border-[#D9E2F2] shadow-lg reveal-on-scroll">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                        
                        <!-- COLUMNA IZQUIERDA: AFICHE FÍSICO EN ACRÍLICO REALISTA -->
                        <div class="lg:col-span-5 space-y-5 text-center">
                            
                            <!-- AFICHE EN BASE DE ACRÍLICO -->
                            <div class="relative inline-block w-full max-w-[280px] p-4 bg-gradient-to-b from-white via-[#F4F7FC] to-slate-100 rounded-2xl border-2 border-[#D9E2F2] shadow-lg mx-auto transform hover:-translate-y-1 transition duration-300">
                                
                                <!-- Soporte acrílico superior -->
                                <div class="w-16 h-1 bg-slate-300 rounded-full mx-auto mb-3"></div>

                                <!-- Rayo láser animado -->
                                <div id="qr-laser-beam" class="absolute left-4 right-4 h-1 bg-gradient-to-r from-transparent via-[#35DDF5] to-transparent shadow-[0_0_12px_#35DDF5] animate-laser z-20 pointer-events-none opacity-80"></div>

                                <div class="p-4 bg-white rounded-xl border border-[#D9E2F2] space-y-3 shadow-inner">
                                    <!-- Header Afiche -->
                                    <div class="flex items-center justify-center space-x-2">
                                        <img src="/brand/svg/avipetapp-icono-app.svg" alt="Icono AviPetApp" class="w-6 h-6 rounded-md object-contain">
                                        <span class="text-xs font-bold text-[#15213B]">Vet-Pet Patitas</span>
                                    </div>
                                    
                                    <div class="bg-[#6D28D9]/10 py-1 px-2 rounded-md border border-[#6D28D9]/20">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#6D28D9]">
                                            Plan de Bienestar Mascotas
                                        </span>
                                    </div>

                                    <!-- QR CODE VECTORIAL CON COLORES DE MARCA (#15213B / #6D28D9 / #0E7490) -->
                                    <div class="relative w-36 h-36 mx-auto bg-white p-2 rounded-xl border-2 border-[#15213B] shadow-sm flex items-center justify-center">
                                        <svg class="w-full h-full text-[#15213B]" viewBox="0 0 100 100" fill="currentColor">
                                            <rect x="0" y="0" width="28" height="28" rx="4" fill="#15213B"/>
                                            <rect x="4" y="4" width="20" height="20" rx="2" fill="#FFFFFF"/>
                                            <rect x="8" y="8" width="12" height="12" rx="1" fill="#6D28D9"/>

                                            <rect x="72" y="0" width="28" height="28" rx="4" fill="#15213B"/>
                                            <rect x="76" y="4" width="20" height="20" rx="2" fill="#FFFFFF"/>
                                            <rect x="80" y="8" width="12" height="12" rx="1" fill="#6D28D9"/>

                                            <rect x="0" y="72" width="28" height="28" rx="4" fill="#15213B"/>
                                            <rect x="4" y="76" width="20" height="20" rx="2" fill="#FFFFFF"/>
                                            <rect x="8" y="80" width="12" height="12" rx="1" fill="#6D28D9"/>

                                            <rect x="34" y="6" width="6" height="6" rx="1"/>
                                            <rect x="46" y="6" width="6" height="6" rx="1"/>
                                            <rect x="58" y="6" width="6" height="6" rx="1"/>
                                            <rect x="34" y="18" width="6" height="6" rx="1" fill="#0E7490"/>
                                            <rect x="46" y="18" width="6" height="6" rx="1"/>
                                            <rect x="58" y="18" width="6" height="6" rx="1" fill="#0E7490"/>

                                            <rect x="6" y="34" width="6" height="6" rx="1"/>
                                            <rect x="18" y="34" width="6" height="6" rx="1"/>
                                            <rect x="6" y="46" width="6" height="6" rx="1"/>
                                            <rect x="18" y="46" width="6" height="6" rx="1"/>
                                            <rect x="6" y="58" width="6" height="6" rx="1"/>
                                            <rect x="18" y="58" width="6" height="6" rx="1"/>

                                            <rect x="34" y="34" width="32" height="32" rx="6" fill="#15213B"/>
                                            <circle cx="50" cy="50" r="10" fill="#FFFFFF"/>
                                            <circle cx="50" cy="50" r="6" fill="#6D28D9"/>

                                            <rect x="72" y="34" width="6" height="6" rx="1"/>
                                            <rect x="84" y="34" width="6" height="6" rx="1"/>
                                            <rect x="72" y="46" width="6" height="6" rx="1"/>
                                            <rect x="84" y="46" width="6" height="6" rx="1" fill="#0E7490"/>
                                            <rect x="72" y="58" width="6" height="6" rx="1"/>
                                            <rect x="84" y="58" width="6" height="6" rx="1"/>

                                            <rect x="34" y="72" width="6" height="6" rx="1"/>
                                            <rect x="46" y="72" width="6" height="6" rx="1"/>
                                            <rect x="58" y="72" width="6" height="6" rx="1"/>
                                            <rect x="34" y="84" width="6" height="6" rx="1" fill="#0E7490"/>
                                            <rect x="46" y="84" width="6" height="6" rx="1"/>
                                            <rect x="58" y="84" width="6" height="6" rx="1"/>
                                        </svg>
                                    </div>

                                    <p class="text-[10px] text-[#5C6B85] font-semibold leading-tight">
                                        Escanea con tu celular para afiliar a tu mascota desde <strong class="text-[#6D28D9] tabular-nums">$50.000/mes</strong>
                                    </p>
                                </div>

                                <!-- Base Acrílica Inferior -->
                                <div class="w-full h-3 bg-gradient-to-r from-slate-300 via-slate-200 to-slate-300 rounded-b-xl mt-1 shadow-sm"></div>
                            </div>

                            <div>
                                <button type="button" onclick="triggerQrScanDemo()" id="scan-trigger-btn" class="relative group px-6 py-3.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-xs shadow-md transition-all transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-2 mx-auto cursor-pointer">
                                    <span class="text-base">📲</span>
                                    <span id="scan-btn-text">Simular Escaneo con Celular</span>
                                </button>
                                <span class="text-[11px] text-[#5C6B85] block mt-1.5">Haz clic para ver la animación en vivo del teléfono</span>
                            </div>
                        </div>

                        <!-- COLUMNA DERECHA: TELÉFONO INTERACTIVO VIVO (MOCKUP IPHONE) -->
                        <div class="lg:col-span-7">
                            <div id="phone-container" class="relative max-w-sm mx-auto bg-[#080B20] rounded-[40px] p-3.5 shadow-2xl border-4 border-[#111936] ring-1 ring-[#1E2B58] transition-all duration-500">
                                
                                <!-- Dynamic Island -->
                                <div class="w-24 h-5 bg-black rounded-full mx-auto mb-2 flex items-center justify-center space-x-2">
                                    <span class="w-2 h-2 rounded-full bg-[#6D28D9]/60"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-800"></span>
                                </div>

                                <!-- PANTALLA DEL CELULAR -->
                                <div id="phone-screen" class="bg-white rounded-[30px] p-4 text-[#15213B] min-h-[440px] flex flex-col justify-between overflow-hidden relative shadow-inner">
                                    
                                    <!-- VISTA 1: SCANNER EN VIVO -->
                                    <div id="phone-view-scanner" class="absolute inset-0 bg-[#080B20] text-white p-6 flex flex-col justify-between items-center text-center z-30 transition-opacity duration-300">
                                        <div class="w-full flex justify-between items-center text-[10px] text-slate-400 font-semibold">
                                            <span>CÁMARA QR</span>
                                            <span class="text-[#0F9F9A] flex items-center space-x-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#0F9F9A] animate-ping"></span>
                                                <span>LISTO PARA ESCANEAR</span>
                                            </span>
                                        </div>

                                        <!-- Retícula del visor de la cámara -->
                                        <div class="relative w-44 h-44 border-2 border-dashed border-[#35DDF5]/80 rounded-2xl flex items-center justify-center p-4">
                                            <div class="absolute -top-1 -left-1 w-4 h-4 border-t-2 border-l-2 border-[#35DDF5]"></div>
                                            <div class="absolute -top-1 -right-1 w-4 h-4 border-t-2 border-r-2 border-[#35DDF5]"></div>
                                            <div class="absolute -bottom-1 -left-1 w-4 h-4 border-b-2 border-l-2 border-[#35DDF5]"></div>
                                            <div class="absolute -bottom-1 -right-1 w-4 h-4 border-b-2 border-r-2 border-[#35DDF5]"></div>
                                            
                                            <div class="absolute left-2 right-2 h-0.5 bg-[#35DDF5] shadow-[0_0_8px_#35DDF5] animate-laser"></div>
                                            
                                            <span class="text-[11px] text-[#35DDF5] font-semibold">Apunta al afiche...</span>
                                        </div>

                                        <div class="space-y-1">
                                            <p class="text-xs text-slate-200 font-bold">Presiona el botón de simulación</p>
                                            <p class="text-[10px] text-slate-400">Abre el portal de tu clínica en 1 segundo</p>
                                        </div>
                                    </div>

                                    <!-- VISTA 2: PORTAL MÓVIL ABIERTO TRAS ESCANEO -->
                                    <div id="phone-view-portal" class="space-y-3 opacity-0 transition-opacity duration-500">
                                        <!-- Header de la clínica -->
                                        <div class="flex items-center justify-between border-b border-[#D9E2F2] pb-2">
                                            <div class="flex items-center space-x-2">
                                                <img src="/brand/svg/avipetapp-icono-app.svg" alt="Logo" class="w-7 h-7 rounded-md object-contain">
                                                <div>
                                                    <h4 class="text-xs font-bold text-[#15213B] leading-tight">Vet-Pet Patitas</h4>
                                                    <span class="text-[9px] text-[#0F9F9A] font-bold">● Clínica Abierta</span>
                                                </div>
                                            </div>
                                            <span class="px-2 py-0.5 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] font-bold text-[9px]">
                                                Portal Tutor
                                            </span>
                                        </div>

                                        <!-- Plan Elegido -->
                                        <div class="p-3 rounded-2xl bg-gradient-to-br from-[#080B20] to-[#111936] text-white shadow-md space-y-1.5 border border-[#1E2B58]">
                                            <div class="flex justify-between items-center">
                                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#A855F7]">Plan Seleccionado</span>
                                                <span class="px-1.5 py-0.5 rounded bg-white/15 text-white text-[9px] font-bold">Recomendado</span>
                                            </div>
                                            <div class="text-base font-bold">Plan Premium Patitas</div>
                                            <div class="text-xs font-bold text-[#35DDF5] tabular-nums">$65.000 COP / mes</div>
                                        </div>

                                        <!-- Formulario de Afiliación Express -->
                                        <div class="p-3 bg-[#F4F7FC] rounded-2xl border border-[#D9E2F2] space-y-2 text-xs">
                                            <div class="text-[10px] font-bold text-[#15213B] uppercase">Datos de la mascota:</div>
                                            <div class="flex items-center justify-between text-[11px] bg-white p-2 rounded-lg border border-[#D9E2F2]">
                                                <span class="text-[#5C6B85]">Nombre:</span>
                                                <strong class="text-[#15213B]">Luna 🐕</strong>
                                            </div>
                                            <div class="flex items-center justify-between text-[11px] bg-white p-2 rounded-lg border border-[#D9E2F2]">
                                                <span class="text-[#5C6B85]">Raza:</span>
                                                <span class="text-[#15213B] font-medium">Golden Retriever</span>
                                            </div>
                                            <div class="flex items-center justify-between text-[11px] bg-white p-2 rounded-lg border border-[#D9E2F2]">
                                                <span class="text-[#5C6B85]">Medio de pago:</span>
                                                <span class="text-[#6D28D9] font-bold">Bancolombia / Nequi</span>
                                            </div>
                                        </div>

                                        <!-- Botón CTA en Celular -->
                                        <a href="https://vet-pet-patitas.avipetapp.com" target="_blank" class="w-full py-2.5 rounded-xl bg-[#0F9F9A] hover:bg-[#0d8a85] text-white font-semibold text-xs shadow-md transition flex items-center justify-center space-x-1.5">
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
        <section class="py-16 sm:py-20 bg-white border-b border-[#D9E2F2]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12 space-y-2.5 reveal-on-scroll">
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-[#0E7490] bg-[#0E7490]/10 px-3.5 py-1 rounded-full border border-[#0E7490]/25">
                        Estrategia Comercial Práctica
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">Cómo ofrecerlo a tus clientes actuales</h2>
                    <p class="text-sm text-[#5C6B85]">No necesitas buscar clientes desconocidos en la calle. Ya tienes pacientes en tu clínica.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- CANAL 1: AFICHE QR -->
                    <div class="clinic-card p-6 rounded-2xl space-y-3 bg-white reveal-on-scroll">
                        <div class="w-11 h-11 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] flex items-center justify-center text-xl font-bold border border-[#6D28D9]/20">
                            🖨️
                        </div>
                        <h3 class="text-base font-bold text-[#15213B]">1. Afiche en la Sala de Espera</h3>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">
                            El tutor espera su turno y ve el afiche en el mostrador: <em>"Ahorra en las vacunas de tu mascota con nuestro Plan de Bienestar"</em>. Escanea con su celular y se afilia mientras espera.
                        </p>
                    </div>

                    <!-- CANAL 2: RECOMENDACIÓN CLÍNICA -->
                    <div class="clinic-card p-6 rounded-2xl space-y-3 bg-white reveal-on-scroll">
                        <div class="w-11 h-11 rounded-xl bg-[#0E7490]/10 text-[#0E7490] flex items-center justify-center text-xl font-bold border border-[#0E7490]/20">
                            🩺
                        </div>
                        <h3 class="text-base font-bold text-[#15213B]">2. En el Momento de la Consulta</h3>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">
                            Al atender al paciente, el veterinario le explica: <em>"Hoy le toca desparasitación y el próximo mes la vacuna. Si te afilias a nuestro plan mensual, te sale más económico y mantenemos su esquema al día"</em>.
                        </p>
                    </div>

                    <!-- CANAL 3: CAMPAÑA WHATSAPP -->
                    <div class="clinic-card p-6 rounded-2xl space-y-3 bg-white reveal-on-scroll">
                        <div class="w-11 h-11 rounded-xl bg-[#0F9F9A]/10 text-[#0F9F9A] flex items-center justify-center text-xl font-bold border border-[#0F9F9A]/25">
                            💬
                        </div>
                        <h3 class="text-base font-bold text-[#15213B]">3. Enlace Directo por WhatsApp</h3>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">
                            Envías tu enlace web personalizado a los clientes que ya te conocen y confían en ti. El tutor entra desde su teléfono, elige el plan y activa la membresía de su mascota.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. LO QUE TU VETERINARIA RECIBE (MÓDULOS E IA) -->
        <section id="recibes" class="py-20 sm:py-24 bg-[#F4F7FC] border-b border-[#D9E2F2]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-2.5 reveal-on-scroll">
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-[#6D28D9] bg-[#6D28D9]/10 px-3.5 py-1 rounded-full border border-[#6D28D9]/20">
                        Módulos e Inteligencia
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">Lo que tu veterinaria recibe desde el primer día</h2>
                    <p class="text-sm sm:text-base text-[#5C6B85]">Herramientas completas para organizar tus planes preventivos y la atención en recepción.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- 1. PORTAL WEB -->
                    <div class="clinic-card p-7 rounded-2xl space-y-3 reveal-on-scroll bg-white">
                        <div class="w-12 h-12 rounded-xl bg-[#6D28D9]/10 text-[#6D28D9] flex items-center justify-center text-2xl font-bold border border-[#6D28D9]/20">
                            🌐
                        </div>
                        <h3 class="text-lg font-bold text-[#15213B]">Portal Web con tu Marca</h3>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">
                            Tu propia página web personalizada con tu subdominio exclusivo, logo, fotos y colores (ej: <code class="text-[#6D28D9] bg-[#6D28D9]/10 px-1.5 py-0.5 rounded font-semibold">tu-clinica.avipetapp.com</code>). Tus clientes consultan tus planes de salud y afilian a sus mascotas en línea.
                        </p>
                    </div>

                    <!-- 2. AFICHE QR -->
                    <div class="clinic-card p-7 rounded-2xl space-y-3 reveal-on-scroll bg-white">
                        <div class="w-12 h-12 rounded-xl bg-[#0E7490]/10 text-[#0E7490] flex items-center justify-center text-2xl font-bold border border-[#0E7490]/20">
                            🖨️
                        </div>
                        <h3 class="text-lg font-bold text-[#15213B]">Afiche de Mostrador con QR</h3>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">
                            Generado en tamaño Carta listo para imprimir en 1 clic. Colócalo en recepción para que los tutores en sala de espera se afilien con su celular sin recargar a tu equipo.
                        </p>
                    </div>

                    <!-- 3. CARNET DIGITAL -->
                    <div class="clinic-card p-7 rounded-2xl space-y-3 reveal-on-scroll bg-white">
                        <div class="w-12 h-12 rounded-xl bg-[#0F9F9A]/10 text-[#0F9F9A] flex items-center justify-center text-2xl font-bold border border-[#0F9F9A]/25">
                            🪪
                        </div>
                        <h3 class="text-lg font-bold text-[#15213B]">Carnet Digital Oficial</h3>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">
                            Cada mascota recibe un carnet interactivo con código de barras en el celular del tutor. Muestra datos del paciente, vigencia y saldos de beneficios disponibles.
                        </p>
                    </div>

                    <!-- 4. MOSTRADOR DE CANJE -->
                    <div class="clinic-card p-7 rounded-2xl space-y-3 reveal-on-scroll bg-white">
                        <div class="w-12 h-12 rounded-xl bg-[#F4F7FC] text-[#15213B] flex items-center justify-center text-2xl font-bold border border-[#D9E2F2]">
                            ⚡
                        </div>
                        <h3 class="text-lg font-bold text-[#15213B]">Mostrador de Canje en Vivo</h3>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">
                            Búsqueda instantánea por cédula, teléfono o lector QR. Tu recepcionista visualiza de inmediato a qué servicios tiene derecho la mascota y descuenta cupos con auditoría.
                        </p>
                    </div>

                    <!-- 5. ASISTENTE DE IA (AVI INTELLIGENCE) -->
                    <div class="clinic-card p-7 rounded-2xl lg:col-span-2 space-y-3 border-2 border-[#6D28D9]/35 bg-white reveal-on-scroll">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-xl bg-[#6D28D9] text-white flex items-center justify-center text-2xl font-bold shadow-sm">
                                🤖
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#6D28D9]">Inteligencia con Supervisión Humana</span>
                                <h3 class="text-lg font-bold text-[#15213B]">Asistente de IA (AVI Intelligence)</h3>
                            </div>
                        </div>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">
                            Organiza información operativa, identifica vencimientos próximos y te sugiere recordatorios preventivos para que tu equipo tome mejores decisiones:
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-1 text-xs font-medium">
                            <div class="bg-[#F4F7FC] p-3 rounded-xl border border-[#D9E2F2] text-[#15213B] shadow-2xs">
                                🔔 "12 planes vencen en los próximos 7 días."
                            </div>
                            <div class="bg-[#F4F7FC] p-3 rounded-xl border border-[#D9E2F2] text-[#15213B] shadow-2xs">
                                🩺 "8 clientes no han usado sus beneficios."
                            </div>
                            <div class="bg-[#F4F7FC] p-3 rounded-xl border border-[#D9E2F2] text-[#15213B] shadow-2xs">
                                💉 "5 mascotas tienen vacunas pendientes."
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 9. CARNET DIGITAL INTERACTIVO (EXPERIENCIA DEL PACIENTE) -->
        <section id="carnet-interactivo" class="py-20 sm:py-24 bg-white border-b border-[#D9E2F2]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- COLUMNA IZQUIERDA: BENEFICIOS COMERCIALES -->
                    <div class="lg:col-span-6 space-y-6 reveal-on-scroll">
                        <span class="inline-block text-xs font-semibold uppercase tracking-wider text-[#0E7490] bg-[#0E7490]/10 px-3.5 py-1.5 rounded-full border border-[#0E7490]/25">
                            Experiencia del Tutor
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight leading-tight">
                            Tu cliente lleva su carnet interactivo en el celular
                        </h2>
                        <p class="text-sm sm:text-base text-[#5C6B85] leading-relaxed">
                            Una experiencia móvil clara para el tutor de la mascota. Accede a su carnet digital, consulta los beneficios incluidos y conoce con exactitud qué servicios preventivos ya utilizó y cuáles tiene disponibles en tiempo real.
                        </p>

                        <div class="space-y-3 text-xs sm:text-sm text-[#15213B] font-medium">
                            <div class="flex items-center space-x-3 p-3 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                                <span class="w-6 h-6 rounded-full bg-[#ECFDF5] text-[#065F46] flex items-center justify-center font-bold text-xs shrink-0">✓</span>
                                <span><strong>Sin carnets de papel</strong> deteriorados o extraviados antes de la consulta.</span>
                            </div>
                            <div class="flex items-center space-x-3 p-3 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                                <span class="w-6 h-6 rounded-full bg-[#0E7490]/15 text-[#0E7490] flex items-center justify-center font-bold text-xs shrink-0">✓</span>
                                <span><strong>Claridad total</strong> en saldos, fechas de vacunación y días de renovación.</span>
                            </div>
                            <div class="flex items-center space-x-3 p-3 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                                <span class="w-6 h-6 rounded-full bg-[#6D28D9]/15 text-[#6D28D9] flex items-center justify-center font-bold text-xs shrink-0">✓</span>
                                <span><strong>Fidelización continua</strong> con la identidad visual de tu clínica veterinaria.</span>
                            </div>
                        </div>

                        <div class="pt-2 flex flex-wrap items-center gap-3">
                            <a href="/carnet/VP-2026-0881" target="_blank" class="inline-flex items-center space-x-2 px-6 py-3.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white text-xs sm:text-sm font-semibold shadow-md transition-all transform hover:-translate-y-0.5">
                                <span>Ver Carnet Real en Pantalla Completa</span>
                                <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            <button type="button" onclick="simulateCarnetRedeem()" class="inline-flex items-center space-x-2 px-5 py-3.5 rounded-xl bg-[#F4F7FC] hover:bg-[#E2E8F0] text-[#15213B] text-xs sm:text-sm font-semibold border border-[#D9E2F2] transition cursor-pointer">
                                <span>⚡ Probar Canje de Vacuna</span>
                            </button>
                        </div>
                    </div>

                    <!-- MOCKUP IPHONE CON CARNET DIGITAL VIP (Midnight #080B20 & Deep Navy #111936) -->
                    <div class="lg:col-span-6 flex justify-center reveal-on-scroll">
                        <div class="relative w-full max-w-[360px] bg-[#080B20] rounded-[44px] p-3.5 shadow-2xl border-4 border-[#111936] ring-1 ring-[#1E2B58]">
                            
                            <!-- Dynamic Island & Status -->
                            <div class="w-28 h-5 bg-black rounded-full mx-auto mb-2 flex items-center justify-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-[#6D28D9]/60"></span>
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-800"></span>
                            </div>

                            <!-- PANTALLA CARNET -->
                            <div class="bg-gradient-to-b from-[#080B20] via-[#111936] to-[#080B20] rounded-[32px] p-4 text-white min-h-[480px] flex flex-col justify-between overflow-hidden relative shadow-inner border border-[#1E2B58]">
                                
                                <!-- TARJETA VIP PRINCIPAL -->
                                <div class="relative rounded-2xl p-4 bg-gradient-to-br from-[#6D28D9] via-[#111936] to-[#080B20] border border-[#A855F7]/40 shadow-xl space-y-3.5 overflow-hidden">
                                    
                                    <!-- Brillo diagonal -->
                                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-[#35DDF5]/20 rounded-full blur-2xl pointer-events-none"></div>

                                    <!-- Top Header Tarjeta -->
                                    <div class="flex items-center justify-between border-b border-white/15 pb-2.5">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-7 h-7 rounded-lg bg-white/95 p-1 flex items-center justify-center shadow-xs">
                                                <img src="/brand/svg/avipetapp-icono-app.svg" alt="Logo" class="w-full h-full object-contain">
                                            </div>
                                            <div>
                                                <span class="text-[11px] font-bold tracking-tight text-white block leading-tight">Vet-Pet Patitas</span>
                                                <span class="text-[9px] font-medium text-[#35DDF5]">Sede Principal · Cajicá</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-1.5">
                                            <span class="px-2 py-0.5 rounded-full bg-[#0F9F9A]/25 border border-[#0F9F9A]/50 text-[#35DDF5] text-[9px] font-bold uppercase">
                                                ● Activa
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Perfil Mascota -->
                                    <div class="flex items-center space-x-3">
                                        <div class="relative w-14 h-14 rounded-2xl bg-gradient-to-tr from-[#A855F7] to-[#35DDF5] p-0.5 shadow-md shrink-0">
                                            <div class="w-full h-full rounded-[14px] bg-[#080B20] flex items-center justify-center text-2xl overflow-hidden">
                                                🐕
                                            </div>
                                            <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-[#0F9F9A] border-2 border-[#080B20] flex items-center justify-center text-[8px] text-white font-bold">✓</span>
                                        </div>
                                        <div class="space-y-0.5 min-w-0 flex-1">
                                            <div class="flex items-center space-x-1.5">
                                                <h4 class="text-base font-bold text-white leading-tight">Luna</h4>
                                                <span class="text-[10px] text-[#35DDF5] font-bold">★ Plan Activo</span>
                                            </div>
                                            <p class="text-[11px] text-slate-200 font-medium truncate">Golden Retriever · 2 años</p>
                                            <div class="flex items-center space-x-2 text-[10px] tabular-nums text-[#35DDF5]">
                                                <span>ID: #VP-2026-0881</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Plan & Tutor -->
                                    <div class="grid grid-cols-2 gap-2 bg-black/30 backdrop-blur-md p-2.5 rounded-xl border border-white/10 text-[10px]">
                                        <div>
                                            <span class="text-slate-400 block text-[9px] uppercase">Plan de Salud</span>
                                            <strong class="text-white font-bold truncate block">Plan Premium</strong>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 block text-[9px] uppercase">Tutor Responsable</span>
                                            <span class="text-slate-200 font-medium truncate block">Carlos Mendoza</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- BENEFICIOS DEL CARNET -->
                                <div class="bg-[#080B20]/90 rounded-2xl p-3 border border-[#1E2B58] space-y-2 text-xs">
                                    <div class="flex justify-between items-center text-[10px] font-bold text-slate-300 uppercase tracking-wider">
                                        <span>Coberturas Incluidas</span>
                                        <span id="carnet-balance-count" class="text-[#35DDF5] tabular-nums">5 de 8 Utilizados</span>
                                    </div>

                                    <!-- Lista de beneficios en chips compactos -->
                                    <div class="space-y-1.5">
                                        <div class="p-2 rounded-xl bg-[#111936] border border-[#1E2B58] flex justify-between items-center text-[11px]">
                                            <div class="flex items-center space-x-2">
                                                <span>🩺</span>
                                                <span class="text-slate-200 font-medium">Consultas Médicas</span>
                                            </div>
                                            <span class="px-2 py-0.5 rounded-md bg-[#0E7490]/40 border border-[#35DDF5]/30 text-[#35DDF5] text-[10px] tabular-nums font-bold">2/2 Disp.</span>
                                        </div>

                                        <div id="benefit-vaccine-row" class="p-2 rounded-xl bg-[#111936] border border-[#1E2B58] flex justify-between items-center text-[11px] transition-all">
                                            <div class="flex items-center space-x-2">
                                                <span>💉</span>
                                                <span class="text-slate-200 font-medium">Vacuna Séxtuple</span>
                                            </div>
                                            <span id="vaccine-status-badge" class="px-2 py-0.5 rounded-md bg-[#0F9F9A]/30 border border-[#0F9F9A]/50 text-[#35DDF5] text-[10px] tabular-nums font-bold">1/1 Aplicada ✓</span>
                                        </div>

                                        <div class="p-2 rounded-xl bg-[#111936] border border-[#1E2B58] flex justify-between items-center text-[11px]">
                                            <div class="flex items-center space-x-2">
                                                <span>💊</span>
                                                <span class="text-slate-200 font-medium">Desparasitación</span>
                                            </div>
                                            <span class="px-2 py-0.5 rounded-md bg-[#0E7490]/40 border border-[#35DDF5]/30 text-[#35DDF5] text-[10px] tabular-nums font-bold">3/3 Disp.</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- CÓDIGO DE BARRAS VECTORIAL -->
                                <div class="p-2.5 bg-white rounded-xl text-center space-y-1 shadow-sm">
                                    <div class="h-8 flex items-center justify-center space-x-1 px-2">
                                        <div class="w-1 h-full bg-[#080B20]"></div>
                                        <div class="w-0.5 h-full bg-[#080B20]"></div>
                                        <div class="w-1.5 h-full bg-[#080B20]"></div>
                                        <div class="w-0.5 h-full bg-[#080B20]"></div>
                                        <div class="w-2 h-full bg-[#080B20]"></div>
                                        <div class="w-0.5 h-full bg-[#080B20]"></div>
                                        <div class="w-1 h-full bg-[#080B20]"></div>
                                        <div class="w-2 h-full bg-[#080B20]"></div>
                                        <div class="w-0.5 h-full bg-[#080B20]"></div>
                                        <div class="w-1.5 h-full bg-[#080B20]"></div>
                                        <div class="w-1 h-full bg-[#080B20]"></div>
                                        <div class="w-0.5 h-full bg-[#080B20]"></div>
                                        <div class="w-2 h-full bg-[#080B20]"></div>
                                        <div class="w-1 h-full bg-[#080B20]"></div>
                                        <div class="w-0.5 h-full bg-[#080B20]"></div>
                                        <div class="w-1.5 h-full bg-[#080B20]"></div>
                                    </div>
                                    <div class="text-[9px] tabular-nums font-bold text-[#15213B] tracking-widest">VP-PAT-2026-0881</div>
                                </div>

                            </div>

                            <!-- Barra Home iPhone -->
                            <div class="w-28 h-1 bg-slate-700 rounded-full mx-auto mt-2"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 10. AVI INTELLIGENCE: LA IA CON SUPERVISIÓN HUMANA (Pág. 4 Manual Maestro de Marca v1.1) -->
        <section id="inteligencia" class="py-20 bg-[#F4F7FC] border-b border-[#D9E2F2]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14 space-y-2.5 reveal-on-scroll">
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-[#6D28D9] bg-[#6D28D9]/10 px-3.5 py-1 rounded-full border border-[#6D28D9]/20">
                        IA Práctica con Supervisión Humana
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">Tu asistente de IA organiza el seguimiento preventivo</h2>
                    <p class="text-sm text-[#5C6B85]">AVI Intelligence detecta oportunidades de renovación y chequeos pendientes para que tu equipo actúe a tiempo.</p>
                </div>

                <div class="max-w-4xl mx-auto clinic-card p-6 sm:p-8 rounded-2xl border-2 border-[#6D28D9]/35 bg-white space-y-6 shadow-md reveal-on-scroll">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-[#D9E2F2] pb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-[#6D28D9] text-white flex items-center justify-center text-xl font-bold shadow-xs">
                                🤖
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-[#15213B]">Simulación: Resumen operativo del día</h3>
                                <p class="text-xs text-[#5C6B85]">Oportunidades de seguimiento detectadas hoy</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] text-xs font-bold tabular-nums">
                            <span class="w-2 h-2 rounded-full bg-[#6D28D9] animate-pulse"></span>
                            <span>3 Sugerencias Operativas</span>
                        </span>
                    </div>

                    <!-- TARJETAS DE ACCIÓN DE IA -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        
                        <div class="bg-[#F4F7FC] p-4 rounded-xl border border-[#D9E2F2] space-y-3 shadow-2xs">
                            <div class="flex items-center justify-between text-xs">
                                <span class="px-2 py-0.5 rounded-full bg-[#FEF3C7] text-[#92400E] font-semibold text-[11px]">Pendiente</span>
                                <span class="tabular-nums text-[11px] text-[#5C6B85]">Próximos 7 días</span>
                            </div>
                            <p class="text-xs text-[#15213B] leading-snug">
                                <strong>12 planes por vencer</strong> este fin de mes.
                            </p>
                            <button type="button" onclick="simulateAiAction(this, 'WhatsApp de renovación preparado')" class="w-full py-2.5 px-3 rounded-xl bg-white hover:bg-[#6D28D9] hover:text-white text-[#6D28D9] text-xs font-semibold border border-[#6D28D9]/30 transition text-center active:scale-95 cursor-pointer">
                                Preparar WhatsApp con 1 Clic
                            </button>
                        </div>

                        <div class="bg-[#F4F7FC] p-4 rounded-xl border border-[#D9E2F2] space-y-3 shadow-2xs">
                            <div class="flex items-center justify-between text-xs">
                                <span class="px-2 py-0.5 rounded-full bg-[#0E7490]/15 text-[#0E7490] font-semibold text-[11px]">Preventivo</span>
                                <span class="tabular-nums text-[11px] text-[#5C6B85]">Sin uso > 6 meses</span>
                            </div>
                            <p class="text-xs text-[#15213B] leading-snug">
                                <strong>8 tutores</strong> no han usado su chequeo incluido.
                            </p>
                            <button type="button" onclick="simulateAiAction(this, 'Invitación a chequeo agendada')" class="w-full py-2.5 px-3 rounded-xl bg-white hover:bg-[#6D28D9] hover:text-white text-[#6D28D9] text-xs font-semibold border border-[#6D28D9]/30 transition text-center active:scale-95 cursor-pointer">
                                Invitar a Chequeo Preventivo
                            </button>
                        </div>

                        <div class="bg-[#F4F7FC] p-4 rounded-xl border border-[#D9E2F2] space-y-3 shadow-2xs">
                            <div class="flex items-center justify-between text-xs">
                                <span class="px-2 py-0.5 rounded-full bg-[#ECFDF5] text-[#065F46] font-semibold text-[11px]">Esquema</span>
                                <span class="tabular-nums text-[11px] text-[#5C6B85]">Refuerzo Anual</span>
                            </div>
                            <p class="text-xs text-[#15213B] leading-snug">
                                <strong>5 mascotas</strong> tienen refuerzo disponible.
                            </p>
                            <button type="button" onclick="simulateAiAction(this, 'Recordatorio de vacuna enviado')" class="w-full py-2.5 px-3 rounded-xl bg-white hover:bg-[#6D28D9] hover:text-white text-[#6D28D9] text-xs font-semibold border border-[#6D28D9]/30 transition text-center active:scale-95 cursor-pointer">
                                Notificar por WhatsApp
                            </button>
                        </div>

                    </div>

                    <!-- AVISO OBLIGATORIO DE IA DEL MANUAL DE MARCA (PÁG. 4) -->
                    <div class="p-3.5 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2] flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[11px] text-[#5C6B85]">
                        <span><strong class="text-[#15213B]">Aviso de supervisión:</strong> Sugerencia generada con IA. Revísala antes de usarla en una decisión clínica.</span>
                        <span class="text-[#6D28D9] font-semibold shrink-0">La IA organiza información; el criterio clínico es de tu equipo veterinario.</span>
                    </div>

                    <div id="ai-toast" class="hidden p-3 rounded-xl bg-[#6D28D9] text-white text-xs font-semibold text-center transition-all">
                        ¡Acción simulada con éxito!
                    </div>

                </div>
            </div>
        </section>

        <!-- 11. EVOLUCIÓN: DE VISITAS OCASIONALES A RELACIÓN TODO EL AÑO -->
        <section class="py-20 bg-white border-b border-[#D9E2F2]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14 space-y-2.5 reveal-on-scroll">
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-[#0E7490] bg-[#0E7490]/10 px-3.5 py-1 rounded-full border border-[#0E7490]/25">
                        Modelo de Atención
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">De visitas ocasionales a una relación todo el año</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- SIN PLANES (Error Red #B91C1C / #FEE2E2 / #991B1B) -->
                    <div class="clinic-card p-6 sm:p-8 rounded-2xl border border-[#B91C1C]/25 bg-[#FEE2E2]/25 space-y-4 reveal-on-scroll">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-[#FEE2E2] text-[#991B1B] flex items-center justify-center font-bold text-xl">✕</div>
                            <div>
                                <h3 class="text-lg font-bold text-[#15213B]">Sin planes de salud</h3>
                                <p class="text-xs text-[#991B1B] font-semibold">Ingresos dependientes de cada visita puntual</p>
                            </div>
                        </div>
                        <ul class="space-y-3 text-xs sm:text-sm text-[#5C6B85]">
                            <li class="flex items-start space-x-2">
                                <span class="text-[#B91C1C] font-bold">✕</span>
                                <span>El cliente acude únicamente cuando se presenta una urgencia o enfermedad.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-[#B91C1C] font-bold">✕</span>
                                <span>Las visitas preventivas se pierden o se posponen indefinidamente.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-[#B91C1C] font-bold">✕</span>
                                <span>El seguimiento depende de llamadas o apuntes manuales en recepción.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-[#B91C1C] font-bold">✕</span>
                                <span>La relación con el tutor se interrumpe al terminar la consulta.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CON AVIPETAPP (Violet Deep #6D28D9 / Success Teal #0F9F9A) -->
                    <div class="clinic-card p-6 sm:p-8 rounded-2xl border-2 border-[#6D28D9] bg-[#F4F7FC] space-y-4 shadow-md reveal-on-scroll">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-[#ECFDF5] text-[#065F46] flex items-center justify-center font-bold text-xl">✓</div>
                            <div>
                                <h3 class="text-lg font-bold text-[#15213B]">Con AviPetApp</h3>
                                <p class="text-xs text-[#6D28D9] font-bold">Un programa estructurado para acompañar al paciente todo el año</p>
                            </div>
                        </div>
                        <ul class="space-y-3 text-xs sm:text-sm text-[#15213B]">
                            <li class="flex items-start space-x-2">
                                <span class="text-[#0F9F9A] font-bold">✓</span>
                                <span>El tutor adquiere un plan preventivo con cobertura clara y programada.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-[#0F9F9A] font-bold">✓</span>
                                <span>Los beneficios incluidos impulsan la asistencia a chequeos y vacunación.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-[#0F9F9A] font-bold">✓</span>
                                <span>La clínica comunica renovaciones y vencimientos de forma oportuna.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-[#0F9F9A] font-bold">✓</span>
                                <span>Fortaleces la confianza y la recurrencia en cada visita a tu veterinaria.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- 12. SEGURIDAD Y CONFIANZA: ¿DÓNDE ESTÁ MI DINERO? -->
        <section class="py-16 bg-[#F4F7FC] border-b border-[#D9E2F2]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="p-8 sm:p-10 rounded-2xl bg-white border border-[#D9E2F2] space-y-6 shadow-sm reveal-on-scroll">
                    <div class="max-w-2xl space-y-2">
                        <span class="inline-block text-xs font-semibold uppercase tracking-wider text-[#0E7490] bg-[#0E7490]/10 px-3.5 py-1 rounded-full border border-[#0E7490]/25">
                            Transparencia y Cuentas Claras
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#15213B] tracking-tight">¿Dónde ingresa el dinero de los planes?</h2>
                        <p class="text-sm text-[#5C6B85]">
                            El 100% de los cobros de tus planes ingresa directamente a las cuentas bancarias o medios de pago de tu veterinaria.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                        <div class="bg-[#F4F7FC] p-5 rounded-xl border border-[#D9E2F2] space-y-2">
                            <div class="text-2xl">🏦</div>
                            <h4 class="text-sm font-bold text-[#15213B]">Tus Medios de Pago Habituales</h4>
                            <p class="text-xs text-[#5C6B85] leading-relaxed">
                                Cobra por Bancolombia, Nequi, Daviplata, datáfono o pasarelas en línea como Bold y Wompi.
                            </p>
                        </div>

                        <div class="bg-[#F4F7FC] p-5 rounded-xl border border-[#D9E2F2] space-y-2">
                            <div class="text-2xl">🚫</div>
                            <h4 class="text-sm font-bold text-[#15213B]">Cero Comisión por Venta</h4>
                            <p class="text-xs text-[#5C6B85] leading-relaxed">
                                AviPetApp no retiene tu dinero ni cobra porcentajes sobre tus ingresos. Solo pagas $5.000 por mascota activa o una suscripción mensual fija.
                            </p>
                        </div>

                        <div class="bg-[#F4F7FC] p-5 rounded-xl border border-[#D9E2F2] space-y-2">
                            <div class="text-2xl">🔒</div>
                            <h4 class="text-sm font-bold text-[#15213B]">Tus Datos son de tu Clínica</h4>
                            <p class="text-xs text-[#5C6B85] leading-relaxed">
                                Tu base de datos de tutores y mascotas es 100% privada e intransferible, protegida con arquitectura multi-tenant aislada.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 13. PRECIOS TRANSPARENTES (CON PLAN PROFESIONAL DESTACADO EN #6D28D9) -->
        <section id="precios" class="py-20 sm:py-24 bg-white border-b border-[#D9E2F2]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14 space-y-3 reveal-on-scroll">
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-[#6D28D9] bg-[#6D28D9]/10 px-3.5 py-1 rounded-full border border-[#6D28D9]/20">
                        Precios Flexibles y Transparentes
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#15213B] tracking-tight mt-2">Prueba gratuita de 15 días</h2>
                    <p class="text-sm sm:text-base text-[#5C6B85]">
                        Sin tarjeta de crédito requerida. Luego tú decides: paquetes prepago desde $50.000 COP (10 mascotas) o tarifa plana mensual anticipada:
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                    
                    <!-- 1. MODALIDAD FLEXIBLE: POR MASCOTA ACTIVA (PREPAGO) -->
                    <div class="clinic-card p-6 sm:p-7 rounded-2xl flex flex-col justify-between bg-[#F4F7FC] border-2 border-[#0E7490]/40 shadow-sm reveal-on-scroll relative">
                        <div class="space-y-4">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#0E7490]/15 text-[#0E7490] text-[10px] font-bold uppercase tracking-wider">
                                🌱 Cero Riesgo · Prepago
                            </span>
                            <h3 class="text-xl font-bold text-[#15213B]">Por Mascota</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-3xl sm:text-4xl font-bold text-[#0E7490] tabular-nums">$5.000</span>
                                <span class="text-[#5C6B85] text-xs font-semibold">COP / mascota</span>
                            </div>
                            <div class="text-[11px] font-bold text-[#0E7490] bg-white px-2.5 py-1 rounded-lg border border-[#0E7490]/25">
                                Paquetes prepago desde 10 mascotas = $50.000 COP
                            </div>
                            <p class="text-xs text-[#5C6B85] leading-relaxed">
                                Sin deudas a mes vencido. Recargas cupos prepago a medida que tu clínica afilia mascotas.
                            </p>
                            <hr class="border-[#D9E2F2]">
                            <ul class="space-y-2 text-xs text-[#15213B] font-medium">
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span><strong>Paquete de 10 mascotas = $50.000 mes</strong></span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Recaudas ~$650.000 y pagas solo $50.000 (92% margen)</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Con 20+ mascotas pasas a Starter ($99k) y ahorras</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Mes anticipado: cero cartera ni sorpresas</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Portal web propio con tu marca</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Afiche de mostrador con QR oficial</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Carnet digital para tutores y mostrador</span></li>
                            </ul>
                        </div>
                        <button type="button" onclick="openRegisterModal('pay_per_pet')" class="mt-6 w-full py-3 text-center rounded-xl bg-white hover:bg-[#0E7490] hover:text-white text-[#0E7490] font-semibold text-xs border border-[#0E7490]/40 transition cursor-pointer">
                            Elegir Paquete 10 Mascotas ($50.000)
                        </button>
                    </div>

                    <!-- 2. STARTER (PLAN FIJO) -->
                    <div class="clinic-card p-6 sm:p-7 rounded-2xl flex flex-col justify-between bg-white reveal-on-scroll">
                        <div class="space-y-4">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#F4F7FC] text-[#5C6B85] text-[10px] font-bold uppercase tracking-wider border border-[#D9E2F2]">
                                Consultorios
                            </span>
                            <h3 class="text-xl font-bold text-[#15213B]">Starter</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-3xl sm:text-4xl font-bold text-[#15213B] tabular-nums">$99.000</span>
                                <span class="text-[#5C6B85] text-xs">COP / mes anticipado</span>
                            </div>
                            <p class="text-xs text-[#5C6B85] leading-relaxed">
                                Hasta 60 mascotas activas*. Te sale a solo <strong>$1.650 por mascota</strong>.
                            </p>
                            <hr class="border-[#D9E2F2]">
                            <ul class="space-y-2 text-xs text-[#15213B] font-medium">
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span><strong>Ahorro de hasta el 67%</strong> frente a $5.000/mascota</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Mes anticipado sin permanencia forzosa</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Portal web propio con tu marca</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Afiche de mostrador con QR oficial</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>1 Usuario para recepción</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Mostrador de canje en vivo</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Soporte por WhatsApp</span></li>
                            </ul>
                        </div>
                        <button type="button" onclick="openRegisterModal('starter')" class="mt-6 w-full py-3 text-center rounded-xl bg-white hover:bg-[#F4F7FC] text-[#15213B] font-semibold text-xs border border-[#D9E2F2] transition cursor-pointer">
                            Elegir Starter
                        </button>
                    </div>

                    <!-- 3. PROFESIONAL (POPULAR) EN VIOLET DEEP #6D28D9 -->
                    <div class="clinic-card p-6 sm:p-7 rounded-2xl flex flex-col justify-between border-2 border-[#6D28D9] shadow-xl relative transform lg:-translate-y-2 bg-white reveal-on-scroll">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3.5 py-0.5 rounded-full bg-[#6D28D9] text-white font-bold text-[10px] uppercase tracking-wider shadow-sm">
                            ⭐ MÁS ELEGIDO
                        </div>
                        <div class="space-y-4">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] text-[10px] font-bold uppercase tracking-wider">
                                En Crecimiento
                            </span>
                            <h3 class="text-xl font-bold text-[#15213B]">Profesional</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-3xl sm:text-4xl font-bold text-[#6D28D9] tabular-nums">$229.000</span>
                                <span class="text-[#5C6B85] text-xs">COP / mes</span>
                            </div>
                            <p class="text-xs text-[#5C6B85] leading-relaxed">
                                Hasta 250 mascotas activas*. Te sale a menos de <strong>$916 por mascota</strong>.
                            </p>
                            <hr class="border-[#D9E2F2]">
                            <ul class="space-y-2 text-xs text-[#15213B] font-medium">
                                <li class="flex items-center space-x-2"><span class="text-[#6D28D9] font-bold">✓</span> <span><strong>Todo lo del plan Starter</strong></span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#6D28D9] font-bold">✓</span> <span><strong>Usuarios ilimitados</strong> para tu equipo</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#6D28D9] font-bold">✓</span> <span><strong>AVI Intelligence:</strong> Seguimiento preventivo</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#6D28D9] font-bold">✓</span> <span>Reportes de facturación recurrente</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#6D28D9] font-bold">✓</span> <span>Soporte prioritario</span></li>
                            </ul>
                        </div>
                        <button type="button" onclick="openRegisterModal('pro')" class="mt-6 w-full py-3.5 text-center rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-xs shadow-md transition transform hover:scale-[1.02] active:scale-95 cursor-pointer">
                            Comenzar Prueba Gratuita →
                        </button>
                    </div>

                    <!-- 4. ENTERPRISE -->
                    <div class="clinic-card p-6 sm:p-7 rounded-2xl flex flex-col justify-between bg-white reveal-on-scroll">
                        <div class="space-y-4">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#F4F7FC] text-[#5C6B85] text-[10px] font-bold uppercase tracking-wider border border-[#D9E2F2]">
                                Redes y Hospitales
                            </span>
                            <h3 class="text-xl font-bold text-[#15213B]">Enterprise</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-3xl sm:text-4xl font-bold text-[#15213B] tabular-nums">$489.000</span>
                                <span class="text-[#5C6B85] text-xs">COP / mes</span>
                            </div>
                            <p class="text-xs text-[#5C6B85] leading-relaxed">Mascotas ilimitadas + Multi-sucursal + Dominio Propio.</p>
                            <hr class="border-[#D9E2F2]">
                            <ul class="space-y-2 text-xs text-[#15213B] font-medium">
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span><strong>Mascotas y afiliados ilimitados</strong></span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Múltiples sedes y sucursales</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Dominio propio (<code class="text-[#6D28D9] font-semibold">tuclinica.com</code>)</span></li>
                                <li class="flex items-center space-x-2"><span class="text-[#0F9F9A] font-bold">✓</span> <span>Integración WhatsApp</span></li>
                            </ul>
                        </div>
                        <a href="https://wa.me/573235813942?text=Hola%20AviPetApp,%20me%20interesa%20el%20plan%20Enterprise" target="_blank" class="mt-6 w-full py-3 text-center rounded-xl bg-white hover:bg-[#F4F7FC] text-[#15213B] font-semibold text-xs border border-[#D9E2F2] transition">
                            Contactar Asesor
                        </a>
                    </div>
                </div>

                <div class="mt-8 text-center text-xs text-[#5C6B85] max-w-2xl mx-auto">
                    * <strong class="text-[#15213B]">Modalidad Prepago / Mes Anticipado:</strong> Todo paquete o mensualidad se activa por mes anticipado. Así nunca tienes cobros sorpresa a mes vencido ni permanencias obligatorias.
                </div>
            </div>
        </section>

        <!-- 14. PREGUNTAS FRECUENTES (FAQ) -->
        <section id="faq" class="py-16 sm:py-20 bg-[#F4F7FC] border-b border-[#D9E2F2]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <div class="text-center space-y-2.5 reveal-on-scroll">
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-[#0E7490] bg-[#0E7490]/10 px-3.5 py-1 rounded-full border border-[#0E7490]/25">
                        Dudas Frecuentes
                    </span>
                    <h2 class="text-3xl font-bold text-[#15213B] tracking-tight mt-2">Preguntas Frecuentes</h2>
                </div>

                <div class="space-y-4">
                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll bg-white">
                        <summary class="font-bold text-sm sm:text-base text-[#15213B] flex justify-between items-center list-none">
                            <span>¿En qué momento se paga el servicio? ¿Mes anticipado o mes vencido?</span>
                            <span class="text-[#6D28D9] font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-[#5C6B85] mt-3 leading-relaxed">
                            <strong class="text-[#15213B]">Siempre es mes anticipado (prepago)</strong>, garantizando cero deudas acumuladas y total claridad. Tienes tus primeros <strong class="text-[#15213B]">15 días 100% gratuitos</strong> para probar todo sin tarjeta de crédito. Al finalizar la prueba, tú decides cómo continuar: puedes recargar un paquete prepago de 10 mascotas por solo $50.000 COP ($5.000 por mascota), o activar tu mensualidad plana (Starter por $99.000 o Profesional por $229.000). Pagas por adelantado el mes de servicio mediante Bancolombia, Nequi o transferencia. Nunca acumulas deudas a mes vencido.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll bg-white">
                        <summary class="font-bold text-sm sm:text-base text-[#15213B] flex justify-between items-center list-none">
                            <span>¿Tengo que reemplazar mi software actual de historia clínica?</span>
                            <span class="text-[#6D28D9] font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-[#5C6B85] mt-3 leading-relaxed">
                            <strong class="text-[#15213B]">No.</strong> AviPetApp convive con tu software actual de historia médica o inventarios (SoftVet, Gesvet, Vetlogy, etc.) o puede ser tu centro operativo de planes preventivos, carnets digitales y seguimiento inteligente.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll bg-white">
                        <summary class="font-bold text-sm sm:text-base text-[#15213B] flex justify-between items-center list-none">
                            <span>¿AviPetApp cobra comisión por cada plan vendido?</span>
                            <span class="text-[#6D28D9] font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-[#5C6B85] mt-3 leading-relaxed">
                            <strong class="text-[#15213B]">No.</strong> El 100% del dinero cobrado a tus clientes va directo a tus cuentas o medios de pago. No retenemos tu dinero ni cobramos porcentajes por transacción. Tú solo pagas el acceso al software: ya sea tu paquete de cupos prepago ($50.000 por 10 mascotas) o tu tarifa plana mensual fija.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll bg-white">
                        <summary class="font-bold text-sm sm:text-base text-[#15213B] flex justify-between items-center list-none">
                            <span>¿Cómo funciona la modalidad de paquetes de $5.000 COP por mascota?</span>
                            <span class="text-[#6D28D9] font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-[#5C6B85] mt-3 leading-relaxed">
                            Es la modalidad de <strong class="text-[#15213B]">cero riesgo</strong> para empezar sin costo fijo alto. Funciona mediante <strong class="text-[#15213B]">paquetes prepago desde 10 mascotas por $50.000 COP</strong> ($5.000 por mascota activa al mes). Si cobras $65.000/mes a 10 tutores, tu clínica recauda $650.000 COP y el costo del software es de solo $50.000 COP (92% de margen directo). Recargas más cupos solo cuando tu clínica afilie más pacientes. Y cuando alcances 20 o más mascotas, te conviene pasarte al plan Starter ($99.000 COP) para pagar aún menos por mascota.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll bg-white">
                        <summary class="font-bold text-sm sm:text-base text-[#15213B] flex justify-between items-center list-none">
                            <span>¿Puedo crear mis propios beneficios y precios?</span>
                            <span class="text-[#6D28D9] font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-[#5C6B85] mt-3 leading-relaxed">
                            <strong class="text-[#15213B]">Sí, con total libertad.</strong> Puedes definir el nombre de tus planes, qué servicios incluye cada uno (número de consultas, vacunas, desparasitaciones, baños o profilaxis) y el precio que desees cobrar.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll bg-white">
                        <summary class="font-bold text-sm sm:text-base text-[#15213B] flex justify-between items-center list-none">
                            <span>¿Cómo pagan las suscripciones los clientes?</span>
                            <span class="text-[#6D28D9] font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-[#5C6B85] mt-3 leading-relaxed">
                            Puedes configurar tus cuentas habituales: Nequi, Daviplata, transferencia Bancolombia, o enlazar botones de pago digitales como Bold o Wompi.
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll bg-white">
                        <summary class="font-bold text-sm sm:text-base text-[#15213B] flex justify-between items-center list-none">
                            <span>¿Puedo utilizar mi propio dominio?</span>
                            <span class="text-[#6D28D9] font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-[#5C6B85] mt-3 leading-relaxed">
                            Por defecto tienes una ruta segura (ej: <code class="text-[#6D28D9] bg-[#6D28D9]/10 px-1.5 py-0.5 rounded font-semibold">avipetapp.com/v/tu-clinica</code>). En el plan Enterprise, puedes conectar directamente tu propio dominio o subdominio corporativo (ej: <code class="text-[#6D28D9] bg-[#6D28D9]/10 px-1.5 py-0.5 rounded font-semibold">salud.tuclinica.com</code>).
                        </p>
                    </details>

                    <details class="clinic-card p-5 rounded-2xl group cursor-pointer reveal-on-scroll bg-white">
                        <summary class="font-bold text-sm sm:text-base text-[#15213B] flex justify-between items-center list-none">
                            <span>¿Qué ocurre cuando terminan los 15 días gratis?</span>
                            <span class="text-[#6D28D9] font-bold text-lg group-open:rotate-45 transition-transform duration-200">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-[#5C6B85] mt-3 leading-relaxed">
                            No solicitamos tarjeta de crédito para iniciar. Al finalizar tu prueba de 15 días, puedes elegir el modelo que prefieras: recargar un <strong class="text-[#15213B]">paquete prepago de 10 mascotas por $50.000 COP</strong> (sin compromisos fijos) o activar una <strong class="text-[#15213B]">tarifa mensual fija</strong> con ahorro por volumen (Starter desde $99.000 o Profesional por $229.000). Si decides no continuar, tu cuenta se pausa sin ningún cobro forzoso ni penalidad.
                        </p>
                    </details>
                </div>
            </div>
        </section>

        <!-- 15. CTA FINAL SOBRE SUPERFICIE DE MARCA -->
        <section class="py-20 bg-white">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="p-8 sm:p-14 rounded-2xl bg-[#080B20] border border-[#1E2B58] text-center space-y-6 shadow-2xl relative overflow-hidden reveal-on-scroll">
                    <div class="absolute -top-24 -right-24 w-72 h-72 bg-[#A855F7]/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-[#35DDF5]/15 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative z-10 inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-[#111936] border border-[#A855F7]/35 text-[#35DDF5] text-xs font-semibold">
                        <span>Software con IA para veterinarias</span>
                    </div>
                    <h2 class="relative z-10 text-3xl sm:text-5xl font-bold text-white tracking-tight">
                        Crea el programa de salud preventiva de tu veterinaria hoy mismo
                    </h2>
                    <p class="relative z-10 text-sm sm:text-lg text-slate-300 max-w-2xl mx-auto font-normal">
                        Más inteligencia. Más bienestar. Más futuro.
                    </p>
                    <div class="relative z-10 pt-2 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button type="button" onclick="openRegisterModal('pro')" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#35DDF5] hover:bg-[#22d3ee] text-[#080B20] font-semibold text-base shadow-lg transition transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center space-x-2 cursor-pointer">
                            <span>Solicitar una demo (15 días gratis)</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER B2B OFICIAL AVIPETAPP (Midnight #080B20 · Manual Maestro de Marca v1.1) -->
    <footer class="border-t border-[#111936] py-14 bg-[#080B20] text-slate-300 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 border-b border-[#111936]">
                <div class="space-y-3.5">
                    <div class="flex flex-col items-start gap-1.5">
                        <img
                            src="/brand/svg/avipetapp-horizontal-fondo-oscuro.svg"
                            alt="AviPetApp"
                            class="h-9 w-auto min-w-[148px] object-contain"
                        >
                        <span class="text-[11px] font-semibold text-[#35DDF5] tracking-wide">
                            Software con IA para veterinarias
                        </span>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        AviPetApp ayuda a tu clínica a gestionar planes de salud para mascotas, organizar la relación con tus clientes y aprovechar herramientas inteligentes desde una sola plataforma.
                    </p>
                    <p class="text-xs font-semibold text-[#A855F7]">
                        Más inteligencia. Más bienestar. Más futuro.
                    </p>
                </div>

                <div class="space-y-2.5">
                    <h4 class="font-bold text-white uppercase tracking-wider text-[11px]">Guías de Rentabilidad Veterinaria</h4>
                    <ul class="space-y-2 font-medium text-slate-300">
                        <li><a href="/blog/planes-de-salud-preventiva-veterinaria-ingresos-recurrentes" class="hover:text-[#35DDF5] transition-colors">→ Cómo crear Planes de Salud Preventiva en tu Veterinaria</a></li>
                        <li><a href="/blog/fidelizacion-clientes-veterinaria-retencion-mascotas" class="hover:text-[#35DDF5] transition-colors">→ Retención de Clientes en Clínica Veterinaria (+80% Fidelidad)</a></li>
                        <li><a href="/blog/como-calcular-precio-planes-salud-veterinaria-plantilla-costos" class="hover:text-[#35DDF5] transition-colors">→ Calculadora y Plantilla de Costos para Planes de Mascotas</a></li>
                        <li><a href="/blog/mejores-software-veterinarios-colombia-comparativa-2026" class="hover:text-[#35DDF5] transition-colors">→ Comparativa de Software Veterinario en Colombia (2026)</a></li>
                    </ul>
                </div>

                <div class="space-y-2.5">
                    <h4 class="font-bold text-white uppercase tracking-wider text-[11px]">Accesos Directos</h4>
                    <ul class="space-y-2 font-semibold text-slate-300">
                        <li><a href="/blog" class="hover:text-[#35DDF5] transition-colors">📚 Blog para Clínicas Veterinarias</a></li>
                        <li><a href="/admin" class="hover:text-[#35DDF5] transition-colors">🔐 Iniciar Sesión / Acceso Mostrador</a></li>
                        <li><a href="https://vet-pet-patitas.avipetapp.com/" target="_blank" class="hover:text-[#35DDF5] transition-colors">🐾 Ver Clínica Piloto (Vet-Pet Patitas Cajicá)</a></li>
                        <li><a href="https://wa.me/573235813942" target="_blank" class="hover:text-[#35DDF5] transition-colors">💬 Soporte WhatsApp (+57 323 581 3942)</a></li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-400">
                <p>© {{ date('Y') }} AviPetApp · Software con IA para veterinarias · Todos los derechos reservados · Colombia & LATAM.</p>
                <a href="/sitemap.xml" class="hover:text-[#35DDF5] transition-colors">Mapa del Sitio (XML)</a>
            </div>
        </div>
    </footer>

    <!-- MODAL DE REGISTRO EXPRESS CLÍNICO -->
    <div id="register-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-[#080B20]/70 backdrop-blur-sm p-3 sm:p-4 hidden transition-opacity opacity-0 pointer-events-none duration-300 overflow-y-auto">
        <div class="relative w-full max-w-lg bg-white border border-[#D9E2F2] rounded-2xl p-5 sm:p-8 shadow-2xl space-y-4 sm:space-y-5 text-[#15213B] transform scale-95 transition-transform duration-300 max-h-[92vh] overflow-y-auto my-auto">
            
            <button type="button" onclick="closeRegisterModal()" class="absolute top-4 right-4 text-[#5C6B85] hover:text-[#15213B] p-2 rounded-xl bg-[#F4F7FC] hover:bg-[#E2E8F0] transition cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div id="onboarding-header-info" class="space-y-1.5">
                <div class="flex items-center space-x-2">
                    <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-[#ECFDF5] text-[#065F46] text-[10px] font-bold uppercase border border-[#0F9F9A]/30">
                        <span>Prueba Gratuita de 15 Días</span>
                    </div>
                    <span id="modal-tier-badge" class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] border border-[#6D28D9]/20 text-[10px] font-bold">
                        Plan Profesional
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-[#15213B] tracking-tight">Crea tu Clínica Veterinaria</h3>
                <p class="text-xs text-[#5C6B85] font-medium">Empieza a configurar tus planes y tu afiche en 60 segundos.</p>
            </div>

            <!-- FORMULARIO AJAX -->
            <form id="clinic-onboarding-form" onsubmit="submitOnboarding(event)" class="space-y-4">
                @csrf
                <input type="hidden" name="saas_plan_tier" id="form-tier" value="pro">

                <div>
                    <label class="block text-xs font-bold text-[#15213B] uppercase mb-1">Nombre de tu Veterinaria <span class="text-[#6D28D9]">*</span></label>
                    <input type="text" name="clinic_name" id="clinic-name-input" required placeholder="Ej. Veterinaria San Roque" oninput="updateSlugPreview(this.value)" class="w-full bg-[#F4F7FC] border border-[#D9E2F2] rounded-xl px-4 py-2.5 text-sm text-[#15213B] focus:outline-none focus:border-[#6D28D9] focus:bg-white transition placeholder:text-[#5C6B85]/60">
                    <p class="text-[11px] text-[#5C6B85] mt-1">
                        Tu web será: <span id="slug-preview" class="text-[#6D28D9] font-bold">tu-clinica.avipetapp.com</span>
                    </p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#15213B] uppercase mb-1 flex items-center justify-between">
                        <span>Nombre de la Doctora / Médico Veterinario</span>
                        <span class="text-[10px] text-[#5C6B85] lowercase font-medium">(opcional)</span>
                    </label>
                    <input type="text" name="doctor_name" id="doctor-name-input" placeholder="Ej. Dra. Vicky Naranjo o Dr. Carlos Méndez" class="w-full bg-[#F4F7FC] border border-[#D9E2F2] rounded-xl px-4 py-2.5 text-sm text-[#15213B] focus:outline-none focus:border-[#6D28D9] focus:bg-white transition placeholder:text-[#5C6B85]/60">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#15213B] uppercase mb-1">Ciudad <span class="text-[#6D28D9]">*</span></label>
                        <input type="text" name="city" required placeholder="Ej. Bogotá / Medellín" class="w-full bg-[#F4F7FC] border border-[#D9E2F2] rounded-xl px-4 py-2.5 text-sm text-[#15213B] focus:outline-none focus:border-[#6D28D9] focus:bg-white transition placeholder:text-[#5C6B85]/60">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#15213B] uppercase mb-1">WhatsApp de Contacto <span class="text-[#6D28D9]">*</span></label>
                        <input type="tel" name="phone" required placeholder="Ej. 3101234567" class="w-full bg-[#F4F7FC] border border-[#D9E2F2] rounded-xl px-4 py-2.5 text-sm text-[#15213B] focus:outline-none focus:border-[#6D28D9] focus:bg-white transition placeholder:text-[#5C6B85]/60">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#15213B] uppercase mb-1">Correo Electrónico (Tu usuario) <span class="text-[#6D28D9]">*</span></label>
                    <input type="email" name="email" required placeholder="doctor@tuclinica.com" class="w-full bg-[#F4F7FC] border border-[#D9E2F2] rounded-xl px-4 py-2.5 text-sm text-[#15213B] focus:outline-none focus:border-[#6D28D9] focus:bg-white transition placeholder:text-[#5C6B85]/60">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-[#15213B] uppercase">Contraseña <span class="text-[#6D28D9]">*</span></label>
                        <button type="button" onclick="togglePasswordVisibility()" class="text-[11px] font-semibold text-[#6D28D9] hover:text-[#5B21B6] transition flex items-center space-x-1 cursor-pointer">
                            <span id="eye-icon">👁️</span>
                            <span id="toggle-pwd-text">Ver contraseña</span>
                        </button>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="password-input" required minlength="6" placeholder="Mínimo 6 caracteres" class="w-full bg-[#F4F7FC] border border-[#D9E2F2] rounded-xl px-4 py-2.5 pr-10 text-sm text-[#15213B] focus:outline-none focus:border-[#6D28D9] focus:bg-white transition placeholder:text-[#5C6B85]/60">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#5C6B85] hover:text-[#15213B] cursor-pointer">
                            <svg id="eye-svg-show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eye-svg-hide" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Aviso de Ayuda y Olvido de Contraseña -->
                <div class="p-3 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2] text-[#5C6B85] text-[11px] flex items-start space-x-2">
                    <span class="text-sm shrink-0">💬</span>
                    <p class="leading-relaxed">
                        ¿Olvidaste tu contraseña o necesitas ayuda? Escríbenos a WhatsApp al <a href="https://wa.me/573235813942?text=Hola,%20necesito%20ayuda%20o%20soporte%20con%20mi%20cuenta%20de%20AviPetApp" target="_blank" class="font-bold text-[#6D28D9] hover:underline">3235813942</a> o a <a href="mailto:contacto@avipetapp.com" class="font-bold text-[#6D28D9] hover:underline">contacto@avipetapp.com</a>.
                    </p>
                </div>

                <div id="form-error-alert" class="hidden p-3 rounded-xl bg-[#FEE2E2] border border-[#B91C1C]/30 text-[#991B1B] text-xs font-medium"></div>

                <button type="submit" id="submit-btn" class="w-full py-3.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-sm shadow-md transition transform active:scale-95 flex items-center justify-center space-x-2 cursor-pointer">
                    <span id="btn-text">Activar mi Clínica Gratis</span>
                    <span id="btn-spinner" class="hidden animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></span>
                </button>

                <p class="text-[10px] text-center text-[#5C6B85]">
                    Sin tarjeta de crédito requerida. Acceso inmediato.
                </p>
            </form>

            <!-- 2. CARD DE ÉXITO CON RUTAS CREADAS (SE MUESTRA AL TERMINAR EL REGISTRO) -->
            <div id="onboarding-success-card" class="hidden space-y-4">
                <div class="text-center space-y-1.5 pt-2">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-[#ECFDF5] text-[#065F46] flex items-center justify-center text-3xl shadow-xs border border-[#0F9F9A]/30">
                        🎉
                    </div>
                    <h3 class="text-xl font-bold text-[#15213B]">¡Tu Clínica fue Creada con Éxito!</h3>
                    <p class="text-xs text-[#5C6B85] font-medium">Tus 15 días de prueba gratis ya están activos. Guarda tus accesos oficiales:</p>
                </div>

                <!-- Bloque de URLs Creadas -->
                <div class="bg-[#F4F7FC] border border-[#D9E2F2] rounded-2xl p-3.5 space-y-3">
                    <!-- Vitrina Web -->
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#5C6B85]">🌐 Vitrina Pública para tus Tutores:</span>
                        <div class="flex items-center justify-between bg-white border border-[#D9E2F2] rounded-xl px-3 py-2">
                            <span id="success-storefront-url" class="text-xs font-bold text-[#6D28D9] truncate select-all"></span>
                            <button type="button" onclick="copyText('success-storefront-url')" class="text-[10px] font-bold bg-[#6D28D9]/10 text-[#6D28D9] px-2.5 py-1 rounded-lg hover:bg-[#6D28D9]/20 transition shrink-0 ml-2 cursor-pointer">Copiar</button>
                        </div>
                    </div>

                    <!-- Panel Admin -->
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#5C6B85]">⚙️ Tu Panel Administrativo de Control:</span>
                        <div class="flex items-center justify-between bg-white border border-[#D9E2F2] rounded-xl px-3 py-2">
                            <span id="success-admin-url" class="text-xs font-bold text-[#15213B] truncate select-all"></span>
                            <button type="button" onclick="copyText('success-admin-url')" class="text-[10px] font-bold bg-[#F4F7FC] text-[#15213B] px-2.5 py-1 rounded-lg hover:bg-[#E2E8F0] transition shrink-0 ml-2 cursor-pointer">Copiar</button>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 pt-1">
                    <a id="success-enter-btn" href="#" class="w-full py-3.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold text-sm shadow-md transition flex items-center justify-center space-x-2">
                        <span>Configurar mi Marca y Logotipo (Paso 1)</span>
                        <span id="countdown-timer" class="text-white/80 text-xs font-normal">(redirigiendo en 6s...)</span>
                    </a>
                    <p class="text-[10px] text-center text-[#5C6B85]">Si no haces clic, entrarás automáticamente en unos segundos.</p>
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
                    badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#0E7490]/15 text-[#0E7490] border border-[#0E7490]/25 text-[10px] font-bold';
                } else if (tier === 'starter') {
                    badge.innerText = 'Plan Starter ($99k)';
                    badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#F4F7FC] text-[#15213B] border border-[#D9E2F2] text-[10px] font-bold';
                } else if (tier === 'enterprise') {
                    badge.innerText = 'Plan Enterprise';
                    badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#080B20] text-[#35DDF5] border border-[#1E2B58] text-[10px] font-bold';
                } else {
                    badge.innerText = 'Plan Profesional';
                    badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] border border-[#6D28D9]/25 text-[10px] font-bold';
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

        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('registro') === '1' || window.location.hash === '#onboarding' || window.location.hash === '#registro') {
                const tier = urlParams.get('tier') || 'pro';
                setTimeout(() => openRegisterModal(tier), 300);
            }
        });

        function updateSlugPreview(name) {
            const clean = name.toLowerCase()
                .trim()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]/g, '-')
                .replace(/-+/g, '-');
            const preview = clean || 'tu-clinica';
            document.getElementById('slug-preview').innerText = `${preview}.avipetapp.com`;
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
                const sfUrl = data.storefront_url || `https://${data.tenant_slug}.avipetapp.com`;
                const admUrl = data.admin_url || `https://${data.tenant_slug}.avipetapp.com/admin`;
                
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
                btnText.innerText = 'Activar mi Clínica Gratis';
                btnSpinner.classList.add('hidden');
            }
        }

        // 3. CALCULADORA MRR CON PALETA AVIPETAPP
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
            if (!petsSlider) return;
            const count = parseInt(petsSlider.value);
            if (petsCountDisplay) petsCountDisplay.innerText = count;

            const monthly = count * currentPlanPrice;
            const annual = monthly * 12;

            if (mrrMonthly) mrrMonthly.innerText = formatCOP(monthly);
            if (mrrAnnual) mrrAnnual.innerText = formatCOP(annual);

            const perPetCost = count * 5000;
            const perPetElem = document.getElementById('mrr-per-pet-cost');
            if (perPetElem) {
                perPetElem.innerHTML = formatCOP(perPetCost) + '<span class="text-[10px] font-normal text-[#5C6B85]">/mes</span>';
            }

            let cost = 99000;
            if (count > 60 && count <= 250) {
                cost = 229000;
            } else if (count > 250) {
                cost = 489000;
            }
            if (mrrTierCost) {
                mrrTierCost.innerHTML = formatCOP(cost) + '<span class="text-[10px] font-normal text-[#5C6B85]">/mes</span>';
            }

            const bestCost = Math.min(cost, perPetCost);
            const margin = Math.max(0, Math.round(((monthly - bestCost) / monthly) * 100));
            if (mrrNetMargin) {
                mrrNetMargin.innerText = `~${margin}% neto (${formatCOP(monthly - bestCost)}/mes)`;
            }
        }

        if (petsSlider) {
            petsSlider.addEventListener('input', calculateMRR);
        }

        function setPlanPrice(price) {
            currentPlanPrice = price;
            document.querySelectorAll('.price-btn').forEach(btn => {
                const p = parseInt(btn.getAttribute('data-price'));
                if (p === price) {
                    btn.className = 'price-btn py-2.5 px-2 sm:px-3 rounded-xl border-2 border-[#6D28D9] bg-[#6D28D9]/10 text-xs font-bold text-[#6D28D9] transition shadow-2xs tabular-nums';
                } else {
                    btn.className = 'price-btn py-2.5 px-2 sm:px-3 rounded-xl border border-[#D9E2F2] bg-white text-xs font-semibold text-[#15213B] hover:border-[#6D28D9] transition tabular-nums';
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
            if (!box) return;
            
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

        // 5. TIMELINE INTERACTIVO (Midnight #080B20 + Deep Navy #111936 + Neon Violet #A855F7 + Electric Cyan #35DDF5)
        const stepData = {
            1: {
                tag: 'Paso 01 · Configuración de Planes',
                html: `
                    <div class="space-y-3.5 animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-[#35DDF5] font-bold flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#35DDF5] animate-pulse"></span>
                                <span>Creador de Planes Activo</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-[#A855F7]/20 text-[#35DDF5] border border-[#A855F7]/30 font-semibold">100% Personalizable</span>
                        </div>
                        <div class="bg-[#111936] p-4 rounded-2xl border border-[#1E2B58] space-y-3 shadow-lg">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h5 class="font-bold text-white text-sm">Plan Premium Patitas</h5>
                                    <span class="text-[10px] text-slate-400">Caninos adultos (1 a 7 años)</span>
                                </div>
                                <div class="text-right">
                                    <span class="tabular-nums text-[#35DDF5] font-bold text-base">$65.000</span>
                                    <span class="text-[9px] text-slate-400 block">COP / mes</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-200">
                                <div class="bg-[#080B20]/80 p-2 rounded-xl border border-[#1E2B58] flex items-center space-x-1.5">
                                    <span class="text-[#0F9F9A] font-bold">✓</span>
                                    <span>2 Consultas / año</span>
                                </div>
                                <div class="bg-[#080B20]/80 p-2 rounded-xl border border-[#1E2B58] flex items-center space-x-1.5">
                                    <span class="text-[#0F9F9A] font-bold">✓</span>
                                    <span>1 Vacuna Séxtuple</span>
                                </div>
                                <div class="bg-[#080B20]/80 p-2 rounded-xl border border-[#1E2B58] flex items-center space-x-1.5">
                                    <span class="text-[#0F9F9A] font-bold">✓</span>
                                    <span>3 Desparasitaciones</span>
                                </div>
                                <div class="bg-[#080B20]/80 p-2 rounded-xl border border-[#1E2B58] flex items-center space-x-1.5">
                                    <span class="text-[#0F9F9A] font-bold">✓</span>
                                    <span>2 Baños Medicados</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-slate-300">Tú decides los beneficios, exclusiones y tarifas mensuales de tu clínica sin ataduras.</p>
                    </div>
                `
            },
            2: {
                tag: 'Paso 02 · Escaneo QR Mostrador',
                html: `
                    <div class="space-y-3.5 animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-[#35DDF5] font-bold flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#35DDF5] animate-pulse"></span>
                                <span>Afiche en Sala de Espera</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-[#0F9F9A]/20 text-[#35DDF5] border border-[#0F9F9A]/40 font-semibold">Auto-atención</span>
                        </div>
                        <div class="bg-[#111936] p-4 rounded-2xl border border-[#1E2B58] flex items-center space-x-4 shadow-lg">
                            <div class="w-16 h-16 bg-white rounded-xl p-2 flex items-center justify-center shrink-0 border-2 border-[#35DDF5] shadow-md">
                                <img src="/brand/svg/avipetapp-isotipo-color.svg" alt="QR" class="w-full h-full object-contain">
                            </div>
                            <div class="space-y-1">
                                <h5 class="text-xs font-bold text-white">El tutor escanea mientras espera</h5>
                                <p class="text-[11px] text-[#35DDF5] font-semibold">tu-clinica.avipetapp.com</p>
                                <span class="inline-block text-[9.5px] bg-[#A855F7]/20 text-white px-2 py-0.5 rounded border border-[#A855F7]/30">Cero filas en recepción</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-300">El afiche impreso capta la atención en sala de espera y facilita la afiliación desde el celular.</p>
                    </div>
                `
            },
            3: {
                tag: 'Paso 03 · Afiliación Digital',
                html: `
                    <div class="space-y-3.5 animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-[#35DDF5] font-bold flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#35DDF5] animate-pulse"></span>
                                <span>Formulario Express en Celular</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-[#A855F7]/20 text-[#35DDF5] border border-[#A855F7]/30 font-semibold">2 Minutos</span>
                        </div>
                        <div class="bg-[#111936] p-4 rounded-2xl border border-[#1E2B58] space-y-2 text-xs shadow-lg">
                            <div class="flex justify-between border-b border-[#1E2B58] pb-1.5">
                                <span class="text-slate-400">Tutor:</span>
                                <span class="text-white font-bold">Carlos Mendoza (CC 1.020.345.***)</span>
                            </div>
                            <div class="flex justify-between border-b border-[#1E2B58] pb-1.5">
                                <span class="text-slate-400">Mascota:</span>
                                <span class="text-[#35DDF5] font-bold">Luna 🐕 (Golden Retriever)</span>
                            </div>
                            <div class="flex justify-between items-center pt-0.5">
                                <span class="text-slate-400">Medio Pago:</span>
                                <span class="px-2 py-0.5 rounded bg-[#0F9F9A]/25 text-[#35DDF5] font-bold text-[10px]">Bancolombia / Nequi / Bold</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-300">Sin papeleos ni formatos manuales: el registro en tu clínica se actualiza al instante.</p>
                    </div>
                `
            },
            4: {
                tag: 'Paso 04 · Carnet Digital Móvil',
                html: `
                    <div class="space-y-3.5 animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-[#35DDF5] font-bold flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#35DDF5] animate-pulse"></span>
                                <span>Carnet Interactivo Oficial</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-[#0F9F9A]/20 text-[#35DDF5] border border-[#0F9F9A]/40 font-semibold">En WhatsApp</span>
                        </div>
                        <div class="bg-gradient-to-br from-[#6D28D9] via-[#111936] to-[#080B20] p-4 rounded-2xl border border-[#A855F7]/40 space-y-2.5 shadow-xl">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-2">
                                    <span class="text-lg">🐕</span>
                                    <span class="text-xs font-bold text-white">LUNA · CARNET PREVENTIVO</span>
                                </div>
                                <span class="px-2 py-0.5 rounded-full bg-[#0F9F9A]/30 text-[#35DDF5] text-[9px] font-bold">ACTIVA ✓</span>
                            </div>
                            <div class="p-2 bg-white rounded-lg text-center tabular-nums text-[10px] text-[#15213B] font-bold tracking-widest">
                                ||| | |||| | ||| || VP-PAT-2026-0881
                            </div>
                            <div class="text-[11px] text-slate-300 flex justify-between">
                                <span>Saldo Coberturas:</span>
                                <span class="text-[#35DDF5] font-bold tabular-nums">5 de 8 Utilizadas</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-300">El tutor lo consulta 24/7 desde su móvil, reduciendo consultas telefónicas a recepción.</p>
                    </div>
                `
            },
            5: {
                tag: 'Paso 05 · Canje Rápido en Mostrador',
                html: `
                    <div class="space-y-3.5 animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-[#35DDF5] font-bold flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#35DDF5] animate-pulse"></span>
                                <span>Validación en 3 Segundos</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-[#A855F7]/20 text-[#35DDF5] border border-[#A855F7]/30 font-semibold">Auditoría 100%</span>
                        </div>
                        <div class="bg-[#111936] p-4 rounded-2xl border border-[#1E2B58] space-y-2.5 shadow-lg">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-400">Servicio Canjeado:</span>
                                <strong class="text-white">Vacuna Séxtuple</strong>
                            </div>
                            <div class="p-2.5 rounded-xl bg-[#0F9F9A]/20 border border-[#0F9F9A]/50 flex items-center space-x-2 text-xs text-white">
                                <span class="text-[#35DDF5] font-bold text-sm">✓</span>
                                <span>Cupo descontado. Auditoría registrada por Dra. Vicky Naranjo.</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-300">Tu recepcionista digita la cédula o escanea el carnet y listo. Sin confusión de saldos.</p>
                    </div>
                `
            },
            6: {
                tag: 'Paso 06 · Renovaciones y Fidelidad',
                html: `
                    <div class="space-y-3.5 animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-[#35DDF5] font-bold flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#35DDF5] animate-pulse"></span>
                                <span>Seguimiento Inteligente</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-[#A855F7]/25 text-[#E879F9] border border-[#A855F7]/40 font-semibold">Supervisión Humana</span>
                        </div>
                        <div class="bg-[#111936] p-4 rounded-2xl border border-[#A855F7]/40 space-y-2 text-xs shadow-lg">
                            <div class="text-[#35DDF5] font-bold flex items-center space-x-1">
                                <span>🔔</span>
                                <span>Aviso Preventivo de Vencimiento:</span>
                            </div>
                            <p class="text-slate-300 text-[11px] leading-relaxed">
                                El plan de Luna vence en 5 días. Recordatorio de WhatsApp listo para revisión y envío con 1 clic.
                            </p>
                            <div class="pt-1 flex items-center justify-between text-[10px] tabular-nums text-[#35DDF5] border-t border-[#1E2B58]">
                                <span>Continuidad de Pacientes:</span>
                                <strong class="text-[#0F9F9A]">Relación Todo el Año</strong>
                            </div>
                        </div>
                        <p class="text-xs text-slate-300">Mantén la relación preventiva mes a mes sin recargar de tareas manuales a tu recepción.</p>
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
                    btn.className = 'step-card p-4 rounded-2xl border-2 border-[#6D28D9] bg-[#6D28D9]/5 cursor-pointer transition-all flex items-start space-x-3.5 shadow-sm transform scale-[1.01]';
                    num.className = 'w-10 h-10 rounded-xl bg-[#6D28D9] text-white flex items-center justify-center font-bold tabular-nums text-sm shrink-0 shadow-xs';
                } else {
                    btn.className = 'step-card p-4 rounded-2xl border border-[#D9E2F2] bg-white hover:border-[#6D28D9]/50 cursor-pointer transition-all flex items-start space-x-3.5';
                    num.className = 'w-10 h-10 rounded-xl bg-[#F4F7FC] text-[#15213B] flex items-center justify-center font-bold tabular-nums text-sm shrink-0';
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
                btn.classList.remove('scale-95', 'bg-[#6D28D9]');
                btn.classList.add('bg-[#0F9F9A]');
            }, 600);
        }

        // 7. SIMULADOR DE CANJE EN EL CARNET INTERACTIVO
        function simulateCarnetRedeem() {
            const row = document.getElementById('benefit-vaccine-row');
            const badge = document.getElementById('vaccine-status-badge');
            const count = document.getElementById('carnet-balance-count');
            
            if (!row || !badge) return;

            badge.innerText = '✓ Canjeado Hoy';
            badge.className = 'px-2 py-0.5 rounded-md bg-[#0F9F9A] text-white text-[10px] tabular-nums font-bold';
            row.classList.add('border-[#0F9F9A]');
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
            btn.classList.add('bg-[#6D28D9]', 'text-white');

            const toast = document.getElementById('ai-toast');
            if (toast) {
                toast.innerText = `🤖 AVI Intelligence: ${msg}`;
                toast.classList.remove('hidden');
            }

            setTimeout(() => {
                btn.innerText = '✓ ' + originalText;
                btn.disabled = false;
                btn.classList.remove('bg-[#6D28D9]', 'text-white');
            }, 2500);

            setTimeout(() => {
                if (toast) toast.classList.add('hidden');
            }, 4500);
        }

        // 10. MENÚ MÓVIL RESPONSIVE
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const hIcon = document.getElementById('hamburger-icon');
            const cIcon = document.getElementById('close-icon');
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                if (hIcon) hIcon.classList.add('hidden');
                if (cIcon) cIcon.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                if (hIcon) hIcon.classList.remove('hidden');
                if (cIcon) cIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
