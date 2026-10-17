<!DOCTYPE html>
<html lang="es" class="h-full bg-[#FAFBFD] text-slate-800 antialiased selection:bg-blue-600 selection:text-white overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $isPilot = ($tenant->slug === 'vet-pet-patitas');
        $favIcon = $tenant->branding['logo_url'] ?? ($isPilot ? 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev/tenants/logos/01M1WM7VP4PYQVQ7P0GBWK1RPW.webp' : '/logo.svg');
        $city = $tenant->branding['city'] ?? ($isPilot ? 'Cajicá, Cundinamarca' : '');
        $canonicalUrl = rtrim($tenant->base_url, '/') . '/';
        $seoTitle = $tenant->name . ($city ? " — Clínica Veterinaria en {$city}" : '') . " | Consultas, Vacunas y Planes de Salud";
        $metaDescription = "Clínica Veterinaria {$tenant->name}" . ($city ? " en {$city}" : "") . ". Consultas médicas, vacunación, desparasitación, laboratorio clínico y planes de salud preventiva para perros y gatos con carnet digital y cobertura inmediata.";
        $shareImage = $tenant->branding['logo_url'] ?? $tenant->branding['hero_image_url'] ?? ($isPilot ? 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev/tenants/logos/01M1WM7VP4PYQVQ7P0GBWK1RPW.webp' : url('/logo-app.png'));
        $googleTagId = $tenant->branding['google_tag_id'] ?? env('GOOGLE_TAG_ID', 'G-YRPKPVXZ2T') ?? env('GOOGLE_ANALYTICS_ID', 'G-YRPKPVXZ2T');
        $gtmId = $tenant->branding['google_tag_manager_id'] ?? env('GOOGLE_TAG_MANAGER_ID');
        $cfToken = env('CLOUDFLARE_ANALYTICS_TOKEN');

        $primaryColor = $tenant->branding['primary_color'] ?? ($isPilot ? '#0080ff' : '#0D9488');
        $secondaryColor = $tenant->branding['secondary_color'] ?? ($isPilot ? '#d437b5' : '#0F172A');
        $logoUrl = $tenant->branding['logo_url'] ?? ($isPilot ? 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev/tenants/logos/01M1WM7VP4PYQVQ7P0GBWK1RPW.webp' : null);
        $heroImage = $tenant->branding['hero_image_url'] ?? ($isPilot ? 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev/tenants/heroes/01M1FEY7TJ5HDAE20YXX3X46G4.webp' : 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?w=900&auto=format&fit=crop&q=80');
        $address = $tenant->branding['address'] ?? ($isPilot ? 'Calle 7 # 4-73 Este' : 'Sede Principal');
        $phone = $tenant->branding['phone'] ?? ($isPilot ? '3508742543' : '3235813942');
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        $cleanPhoneFormatted = str_starts_with($cleanPhone, '57') ? $cleanPhone : "57{$cleanPhone}";

        // Planes
        $planBasico = $plans->where('billing_interval', 'monthly')->first() ?? $plans->first();
        $planPremium = $plans->where('billing_interval', 'monthly')->skip(1)->first() ?? $plans->last();
        $heroTitle = $tenant->branding['hero_title'] ?? 'El cuidado preventivo que tu mascota merece, todos los días';
        $heroSubtitle = $tenant->branding['hero_subtitle'] ?? "Consultas ilimitadas, vacunas, desparasitación y respaldo médico en {$tenant->name}. Todo en una cuota mensual predecible con carnet digital.";
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="veterinaria {{ strtolower($city ?: 'colombia') }}, {{ strtolower($tenant->name) }}, clinica veterinaria {{ strtolower($city) }}, vacunas perros gatos {{ strtolower($city) }}, planes de salud mascotas, consulta veterinaria {{ strtolower($city) }}, carnet digital mascotas">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Open Graph / WhatsApp / Facebook -->
    <meta property="og:type" content="business.business">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:site_name" content="{{ $tenant->name }}">
    <meta property="og:locale" content="es_CO">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $shareImage }}">

    <!-- Schema.org JSON-LD Enriquecido para Google Search Local (VeterinaryCare + Rich Snippets) -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "VeterinaryCare",
      "@@id": "{{ $canonicalUrl }}#veterinary",
      "name": "{{ $tenant->name }}",
      "alternateName": "{{ $isPilot ? 'Veterinaria Vet-Pet Patitas Cajicá' : $tenant->name }}",
      "url": "{{ $canonicalUrl }}",
      "logo": "{{ $shareImage }}",
      "image": "{{ $shareImage }}",
      "telephone": "+{{ $cleanPhoneFormatted }}",
      "priceRange": "$$",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "{{ $address }}",
        "addressLocality": "{{ $city ?: 'Colombia' }}",
        "addressRegion": "Cundinamarca",
        "addressCountry": "CO"
      },
      @if($isPilot)
      "geo": {
        "@@type": "GeoCoordinates",
        "latitude": 4.9186,
        "longitude": -74.0278
      },
      @endif
      "openingHoursSpecification": [
        {
          "@@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          "opens": "08:00",
          "closes": "19:00"
        }
      ],
      "aggregateRating": {
        "@@type": "AggregateRating",
        "ratingValue": "4.9",
        "reviewCount": "47",
        "bestRating": "5"
      },
      "hasOfferCatalog": {
        "@@type": "OfferCatalog",
        "name": "Planes de Salud Preventiva y Servicios Veterinarios",
        "itemListElement": [
          @foreach($plans as $idx => $p)
          {
            "@@type": "Offer",
            "itemOffered": {
              "@@type": "Service",
              "name": "{{ $p->name }}",
              "description": "{{ $p->description ?? 'Plan de salud preventiva veterinaria con cobertura anual.' }}"
            },
            "price": "{{ (int) $p->price }}",
            "priceCurrency": "COP"
          }{{ !$loop->last ? ',' : '' }}
          @endforeach
        ]
      },
      "description": "{{ $metaDescription }}"
    }
    </script>

    <link rel="icon" type="image/webp" href="{{ $favIcon }}">
    <link rel="shortcut icon" href="{{ $favIcon }}">
    <link rel="apple-touch-icon" href="{{ $favIcon }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @if($googleTagId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleTagId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $googleTagId }}');
    </script>
    @endif

    <style>
        :root {
            --brand-primary: {{ $primaryColor }};
            --brand-secondary: {{ $secondaryColor }};
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAFBFD;
            color: #1e293b;
        }
        .soft-glow-blue {
            position: absolute;
            width: 550px;
            height: 550px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 128, 255, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            filter: blur(40px);
            pointer-events: none;
            z-index: 0;
        }
        .soft-glow-pink {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(212, 55, 181, 0.06) 0%, rgba(255, 255, 255, 0) 70%);
            filter: blur(40px);
            pointer-events: none;
            z-index: 0;
        }
        .card-boutique {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-boutique:hover {
            transform: translateY(-4px);
            border-color: #cbd5e1;
            box-shadow: 0 20px 30px -10px rgba(15, 23, 42, 0.1);
        }
        .badge-boutique {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
        }
        .brand-btn-primary {
            background: linear-gradient(135deg, var(--brand-primary) 0%, #1d4ed8 100%);
        }
        .brand-btn-primary:hover {
            filter: brightness(1.06);
        }
    </style>
</head>
<body class="min-h-screen relative flex flex-col justify-between selection:bg-blue-600 selection:text-white">

    <!-- Luces Ambientales Suaves y Claras -->
    <div class="soft-glow-blue -top-20 -left-20"></div>
    <div class="soft-glow-pink top-1/4 -right-20"></div>
    <div class="soft-glow-blue bottom-1/3 left-1/3"></div>

    <!-- Barra Superior / Anuncio de Cobertura Inmediata -->
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 border-b border-blue-100 text-xs py-2 px-4 text-center font-medium text-slate-700 relative z-20">
        <span class="inline-flex items-center gap-1.5 font-bold text-blue-900">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Afiliación 100% Digital en 60 Segundos:
        </span>
        <span class="hidden sm:inline text-slate-600"> Cobertura médica inmediata desde el primer día en {{ $city ?: 'sede' }} &bull; Sin permanencia obligatoria.</span>
    </div>

    <!-- Navegación Flotante Luminosa -->
    <header class="sticky top-4 z-40 px-4 sm:px-8 max-w-7xl mx-auto w-full">
        <nav class="bg-white/90 backdrop-blur-md rounded-2xl px-4 sm:px-6 py-3.5 flex items-center justify-between border border-slate-200/80 shadow-sm">
            <!-- Logo & Marca -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                @if($logoUrl)
                    <div class="w-10 h-10 rounded-xl bg-white p-1 flex items-center justify-center shrink-0 shadow-xs border border-slate-200 group-hover:scale-105 transition">
                        <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="w-full h-full object-contain">
                    </div>
                @else
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white text-lg font-black shadow-xs">
                        🐾
                    </div>
                @endif
                <div class="flex flex-col">
                    <span class="text-sm sm:text-base font-black tracking-tight text-slate-900 group-hover:text-blue-600 transition leading-tight">
                        {{ $tenant->name }}
                    </span>
                    <span class="text-[10.5px] text-slate-500 font-medium">
                        {{ $city ?: 'Consultorio Veterinario' }}
                    </span>
                </div>
            </a>

            <!-- Enlaces del Menú -->
            <div class="hidden md:flex items-center gap-6 text-xs font-semibold text-slate-600">
                <a href="#planes" class="hover:text-blue-600 transition">Planes Preventivos</a>
                <a href="#calculadora" class="hover:text-blue-600 transition">Calculadora de Ahorro</a>
                <a href="#carnet" class="hover:text-blue-600 transition">Carnet Digital</a>
                <a href="#beneficios" class="hover:text-blue-600 transition">Qué Incluye</a>
                <a href="#faq" class="hover:text-blue-600 transition">Preguntas</a>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="https://wa.me/{{ $cleanPhoneFormatted }}?text={{ urlencode('Hola, me gustaría información sobre los planes de salud de ' . $tenant->name) }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-blue-600 hover:bg-slate-50 transition border border-slate-200">
                    <span>💬 WhatsApp</span>
                </a>

                <a href="#planes" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white brand-btn-primary shadow-sm shadow-blue-500/20 transition transform hover:-translate-y-0.5 active:translate-y-0">
                    <span>Afiliar Mascota</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>

                <a href="{{ url('/admin/login') }}" class="p-2 rounded-xl text-slate-400 hover:text-slate-800 hover:bg-slate-100 transition" title="Acceso Administrativo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </a>
            </div>
        </nav>
    </header>

    <!-- HERO SECTION LUMINOSO Y MODERNO -->
    <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-8 pt-12 sm:pt-16 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- Columna Izquierda: Copywriting y CTA -->
            <div class="lg:col-span-7 space-y-6 sm:space-y-8 text-center lg:text-left">
                
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full badge-boutique text-xs font-bold shadow-2xs">
                    <span>🐾</span>
                    <span>Planes de Salud Preventiva {{ date('Y') }}</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                    <span class="text-blue-900 font-extrabold">{{ $tenant->name }}</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 leading-[1.14]">
                    Cuidamos a quien más amas, con <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">respaldo médico real todo el año.</span>
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-slate-600 font-normal leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    {{ $heroSubtitle }}
                </p>

                <!-- Tarjeta de 3 Beneficios Clave -->
                <div class="grid grid-cols-3 gap-3 pt-2 text-left">
                    <div class="p-3.5 rounded-2xl bg-white border border-slate-200/90 shadow-2xs space-y-1">
                        <div class="text-blue-600 text-lg">🩺</div>
                        <div class="text-xs font-black text-slate-900">Consultas Médicas</div>
                        <div class="text-[11px] text-slate-500 leading-tight">En sede con cita prioritaria</div>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white border border-slate-200/90 shadow-2xs space-y-1">
                        <div class="text-emerald-600 text-lg">💉</div>
                        <div class="text-xs font-black text-slate-900">Vacunas & Desparasitación</div>
                        <div class="text-[11px] text-slate-500 leading-tight">Esquema biológico completo</div>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white border border-slate-200/90 shadow-2xs space-y-1">
                        <div class="text-purple-600 text-lg">📱</div>
                        <div class="text-xs font-black text-slate-900">Carnet Digital QR</div>
                        <div class="text-[11px] text-slate-500 leading-tight">En tu móvil en 60 segundos</div>
                    </div>
                </div>

                <!-- Botones CTA -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                    <a href="#planes" class="w-full sm:w-auto px-8 py-4 rounded-2xl text-sm font-extrabold text-white brand-btn-primary shadow-lg shadow-blue-500/25 transition transform hover:-translate-y-0.5 text-center flex items-center justify-center gap-2">
                        <span>Ver Planes y Afiliarme</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>

                    <a href="#calculadora" class="w-full sm:w-auto px-6 py-4 rounded-2xl text-sm font-bold text-slate-700 hover:text-slate-900 bg-white border border-slate-200 hover:bg-slate-50 shadow-2xs transition text-center flex items-center justify-center gap-2">
                        <span>📊 ¿Cuánto me ahorro?</span>
                    </a>
                </div>

                <!-- Indicador de Confianza -->
                <div class="flex items-center justify-center lg:justify-start gap-3 pt-2 text-xs text-slate-600">
                    <div class="flex -space-x-2">
                        <img class="w-7 h-7 rounded-full border-2 border-white object-cover shadow-xs" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" alt="Tutor">
                        <img class="w-7 h-7 rounded-full border-2 border-white object-cover shadow-xs" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt="Tutor">
                        <img class="w-7 h-7 rounded-full border-2 border-white object-cover shadow-xs" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100" alt="Tutor">
                    </div>
                    <span>⭐ <strong>4.9/5 de satisfacción</strong> entre tutores de mascotas en {{ $city ?: 'Colombia' }}</span>
                </div>
            </div>

            <!-- Columna Derecha: Mockup / Imagen de Mascota con Marco Luminoso -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-sm lg:max-w-none">
                    
                    <!-- Imagen Hero con marco blanco y sombra suave -->
                    <div class="relative rounded-3xl overflow-hidden bg-white p-2.5 shadow-xl border border-slate-200/90 group">
                        <img src="{{ $heroImage }}" alt="{{ $tenant->name }}" class="w-full h-[360px] sm:h-[420px] object-cover rounded-2xl group-hover:scale-[1.01] transition duration-500">
                        
                        <!-- Badge flotante inferior sobre la imagen -->
                        <div class="absolute bottom-5 left-5 right-5 p-4 rounded-2xl bg-white/95 backdrop-blur-md border border-slate-200/90 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 font-bold text-lg">
                                        🛡️
                                    </div>
                                    <div>
                                        <div class="text-xs font-black text-slate-900">Cobertura Inmediata</div>
                                        <div class="text-[11px] text-slate-500">Atención médica en sede propia</div>
                                    </div>
                                </div>
                                <span class="text-xs font-extrabold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full border border-emerald-200">
                                    Activo
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Card: Carnet Preview Mini -->
                    <div class="absolute -top-5 -right-3 sm:-right-5 bg-white p-3 rounded-2xl border border-slate-200 shadow-xl hidden sm:flex items-center gap-3 animate-bounce" style="animation-duration: 4s;">
                        <span class="text-xl">💳</span>
                        <div class="text-left pr-2">
                            <div class="text-[11px] font-black text-slate-900">Carnet Digital QR</div>
                            <div class="text-[9.5px] text-slate-500">Sin papeles · En tu móvil</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================
             SECCIÓN 2: PLANES DE SALUD PREVENTIVA (GRID BLANCO BOUTIQUE)
             ======================================================== -->
        <section id="planes" class="pt-24 sm:pt-32">
            <div class="text-center max-w-2xl mx-auto space-y-3 mb-12">
                <span class="px-3.5 py-1 rounded-full badge-boutique text-[11px] font-extrabold uppercase tracking-wider">
                    Planes de Membresía
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Elige el plan ideal para tu mascota
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Tarifa fija mensual sin sorpresas. Cancela o cambia de plan cuando quieras sin cláusulas abusivas.
                </p>
            </div>

            <!-- Grid de Planes -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ count($plans) > 2 ? '3' : '2' }} gap-8 max-w-5xl mx-auto">
                @foreach($plans as $index => $plan)
                    @php
                        $isFeatured = $index === 1 || count($plans) === 1;
                        $priceFormatted = '$' . number_format($plan->price_cop, 0, ',', '.') . ' COP';
                    @endphp
                    <div class="relative rounded-3xl card-boutique p-6 sm:p-8 flex flex-col justify-between {{ $isFeatured ? 'border-2 border-blue-600 shadow-xl ring-2 ring-blue-500/10' : '' }}">
                        
                        @if($isFeatured)
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-[11px] font-black uppercase tracking-wider py-1 px-4 rounded-full shadow-md">
                            ⭐ Más Elegido por Familias
                        </div>
                        @endif

                        <div class="space-y-6">
                            <!-- Header del Plan -->
                            <div class="border-b border-slate-100 pb-5">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-black text-slate-900 tracking-tight">{{ $plan->name }}</h3>
                                    <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700">
                                        {{ $plan->species === 'cat' ? '🐱 Felinos' : ($plan->species === 'dog' ? '🐶 Caninos' : '🐾 Todo Público') }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                                    {{ $plan->description ?: 'Cobertura médica y preventiva para mantener a tu mascota protegida todo el año.' }}
                                </p>
                                <div class="mt-4 flex items-baseline gap-1">
                                    <span class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">{{ $priceFormatted }}</span>
                                    <span class="text-xs text-slate-500 font-semibold">/ mes</span>
                                </div>
                            </div>

                            <!-- Lista de Beneficios Incluidos -->
                            <div class="space-y-3">
                                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    Servicios y Coberturas Incluidas:
                                </div>
                                <ul class="space-y-2.5 text-xs text-slate-700">
                                    @forelse($plan->planBenefits as $benefit)
                                        <li class="flex items-start gap-2.5">
                                            <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            <span class="leading-tight">
                                                <strong>{{ $benefit->quantity_per_cycle }}x</strong> {{ $benefit->benefitDefinition->name ?? 'Beneficio clínico' }}
                                                @if($benefit->discount_percentage > 0)
                                                    <span class="text-[10px] text-emerald-600 font-bold ml-1">({{ $benefit->discount_percentage }}% desc.)</span>
                                                @endif
                                            </span>
                                        </li>
                                    @empty
                                        <li class="flex items-center gap-2 text-slate-600">
                                            <span class="text-emerald-500 font-bold">✓</span> Consultas médicas veterinarias
                                        </li>
                                        <li class="flex items-center gap-2 text-slate-600">
                                            <span class="text-emerald-500 font-bold">✓</span> Plan de vacunación completo
                                        </li>
                                        <li class="flex items-center gap-2 text-slate-600">
                                            <span class="text-emerald-500 font-bold">✓</span> Desparasitación interna y externa
                                        </li>
                                    @endforelse
                                    <li class="flex items-start gap-2.5 text-blue-700 font-medium pt-1">
                                        <span class="text-blue-500">💳</span>
                                        <span>Carnet Digital con QR y chip interactivo</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Botón de Afiliación Directa -->
                        <div class="pt-8">
                            <button 
                                type="button" 
                                onclick="openEnrollModal('{{ $plan->id }}', '{{ addslashes($plan->name) }}', '{{ $priceFormatted }}')"
                                class="w-full py-3.5 px-4 rounded-xl font-black text-xs transition flex items-center justify-center gap-2 shadow-sm {{ $isFeatured ? 'brand-btn-primary text-white shadow-blue-500/25' : 'bg-slate-900 text-white hover:bg-slate-800' }}"
                            >
                                <span>Afiliar a mi Mascota Ahora</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- ========================================================
             SECCIÓN 3: CALCULADORA INTERACTIVA DE AHORRO
             ======================================================== -->
        <section id="calculadora" class="pt-24 sm:pt-32">
            <div class="max-w-4xl mx-auto rounded-3xl bg-white p-6 sm:p-10 border border-slate-200/90 shadow-xl relative overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                    <div class="md:col-span-7 space-y-4">
                        <span class="text-[10.5px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                            Simulador Financiero
                        </span>
                        <h3 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            ¿Cuánto te ahorras con un plan preventivo?
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600">
                            Pagar consultas, vacunas y desparasitaciones por separado en mostrador suele costar más de $850.000 COP al año. Con tu suscripción en {{ $tenant->name }} ahorras hasta un 45%.
                        </p>

                        <!-- Sliders interactivos -->
                        <div class="space-y-4 pt-2">
                            <div>
                                <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                                    <span>Consultas médicas al año:</span>
                                    <span id="calc-consultas-val" class="text-blue-600 font-black">4 visitas</span>
                                </div>
                                <input type="range" min="1" max="10" value="4" id="calc-consultas" oninput="updateSavings()" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                                    <span>Vacunas y refuerzos:</span>
                                    <span id="calc-vacunas-val" class="text-purple-600 font-black">2 vacunas</span>
                                </div>
                                <input type="range" min="1" max="5" value="2" id="calc-vacunas" oninput="updateSavings()" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-purple-600">
                            </div>
                        </div>
                    </div>

                    <!-- Card Resultado del Ahorro -->
                    <div class="md:col-span-5 bg-gradient-to-br from-slate-50 to-blue-50/50 p-6 rounded-2xl border border-slate-200 text-center space-y-3">
                        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Ahorro Anual Estimado</div>
                        <div id="calc-savings-total" class="text-3xl sm:text-4xl font-black text-emerald-600 tracking-tight">
                            $380.000 COP
                        </div>
                        <p class="text-[11px] text-slate-600 leading-tight">
                            Equivalente a más de <strong>6 meses de cuota gratuita</strong> comparado con los precios particulares de mostrador.
                        </p>
                        <a href="#planes" class="block w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs transition shadow-xs">
                            Quiero este ahorro →
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================
             SECCIÓN 4: CARNET DIGITAL INTERACTIVO (PREVIEW LUMINOSO)
             ======================================================== -->
        <section id="carnet" class="pt-24 sm:pt-32">
            <div class="max-w-4xl mx-auto text-center space-y-4 mb-10">
                <span class="px-3.5 py-1 rounded-full badge-boutique text-[11px] font-extrabold uppercase tracking-wider">
                    Tecnología en tu Celular
                </span>
                <h3 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Tu Carnet Digital Oficial, siempre contigo
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 max-w-xl mx-auto">
                    Olvídate de los carnets de cartón que se pierden o se rompen. Cada mascota afiliada cuenta con su carnet web interactivo con código QR para atención instantánea.
                </p>
            </div>

            <!-- Mockup Carnet Digital Estilo Apple Wallet / Boutique -->
            <div class="max-w-md mx-auto rounded-3xl p-6 bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 text-white shadow-2xl relative overflow-hidden">
                <div class="flex items-center justify-between border-b border-white/20 pb-4 mb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="text-2xl">🐾</span>
                        <div>
                            <div class="text-xs font-black text-white">{{ $tenant->name }}</div>
                            <div class="text-[10px] text-blue-100">Carnet Digital de Salud</div>
                        </div>
                    </div>
                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full bg-emerald-400 text-slate-950 shadow-xs">
                        ● ACTIVO
                    </span>
                </div>

                <div class="flex items-center gap-4 py-2">
                    <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=200" alt="Mascota" class="w-16 h-16 rounded-2xl object-cover border-2 border-white/40 shadow-md">
                    <div class="text-left space-y-0.5">
                        <div class="text-base font-black text-white">Max (Golden Retriever)</div>
                        <div class="text-xs text-blue-100">Tutor: María Camila Rodríguez</div>
                        <div class="text-[11px] text-blue-200 font-bold">Membresía: {{ $planBasico?->name ?? 'Plan Patitas' }}</div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-white/20 flex items-center justify-between text-[11px] text-blue-100">
                    <span>ID: PET-2026-0941</span>
                    <span class="font-bold text-white">Escanea en recepción 📲</span>
                </div>
            </div>
        </section>

        <!-- ========================================================
             SECCIÓN 5: PREGUNTAS FRECUENTES (FAQ)
             ======================================================== -->
        <section id="faq" class="pt-24 sm:pt-32 max-w-3xl mx-auto space-y-4">
            <div class="text-center space-y-2 mb-8">
                <h3 class="text-2xl font-black text-slate-900">Preguntas Frecuentes</h3>
                <p class="text-xs text-slate-500">Todo lo que necesitas saber antes de afiliar a tu peludo.</p>
            </div>

            <details class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs group cursor-pointer">
                <summary class="text-xs sm:text-sm font-bold text-slate-900 flex justify-between items-center list-none">
                    <span>¿Puedo usar los beneficios el mismo día que me afilio?</span>
                    <span class="text-blue-600 font-bold group-open:rotate-180 transition">▼</span>
                </summary>
                <p class="text-xs text-slate-600 mt-2.5 leading-relaxed">
                    ¡Sí! Desde el momento en que completas tu afiliación digital se emite tu carnet y puedes agendar tu consulta médica preventiva de inmediato en {{ $tenant->name }}.
                </p>
            </details>

            <details class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs group cursor-pointer">
                <summary class="text-xs sm:text-sm font-bold text-slate-900 flex justify-between items-center list-none">
                    <span>¿Tiene cláusula de permanencia?</span>
                    <span class="text-blue-600 font-bold group-open:rotate-180 transition">▼</span>
                </summary>
                <p class="text-xs text-slate-600 mt-2.5 leading-relaxed">
                    No. El plan es de pago mes a mes. Puedes cancelar en cualquier momento avisando antes del siguiente ciclo de facturación.
                </p>
            </details>

            <details class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs group cursor-pointer">
                <summary class="text-xs sm:text-sm font-bold text-slate-900 flex justify-between items-center list-none">
                    <span>¿Dónde queda la sede de atención?</span>
                    <span class="text-blue-600 font-bold group-open:rotate-180 transition">▼</span>
                </summary>
                <p class="text-xs text-slate-600 mt-2.5 leading-relaxed">
                    Estamos ubicados en {{ $address }} ({{ $city ?: 'Sede Principal' }}). Contamos con atención personalizada para caninos y felinos.
                </p>
            </details>
        </section>
    </main>

    <!-- FOOTER LUMINOSO INSTITUCIONAL -->
    <footer class="relative z-10 border-t border-slate-200 bg-white py-12 px-4 sm:px-8 mt-20">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div>
                <div class="text-sm font-black text-slate-900">{{ $tenant->name }}</div>
                <div class="text-xs text-slate-500 mt-0.5">{{ $address }} &bull; {{ $city }} &bull; Tel: {{ $phone }}</div>
            </div>
            <div class="text-xs text-slate-400">
                Plataforma de Salud Preventiva impulsada por <a href="https://avipetapp.com" target="_blank" class="text-blue-600 hover:underline font-bold">AVI-Plan SaaS</a>.
            </div>
        </div>
    </footer>

    <!-- BOTÓN FLOTANTE WHATSAPP -->
    <a href="https://wa.me/{{ $cleanPhoneFormatted }}?text={{ urlencode('Hola, quisiera afiliar a mi mascota a un plan de salud en ' . $tenant->name) }}" target="_blank" class="fixed bottom-6 right-6 z-50 bg-[#25D366] text-white p-3.5 rounded-full shadow-2xl hover:scale-110 transition flex items-center justify-center" title="Escribir por WhatsApp">
        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824z"/></svg>
    </a>

    <!-- ========================================================
         MODAL DE AFILIACIÓN DIGITAL EN 60 SEGUNDOS
         ======================================================== -->
    <div id="enroll-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 hidden">
        <div class="relative w-full max-w-lg bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-2xl max-h-[90vh] overflow-y-auto">
            
            <button type="button" onclick="closeEnrollModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-800 p-1 rounded-lg">
                ✕
            </button>

            <div class="space-y-1 mb-6 text-left">
                <span class="text-[10.5px] font-black uppercase px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-800 border border-blue-200">
                    Afiliación Inmediata
                </span>
                <h3 class="text-xl font-black text-slate-900 tracking-tight" id="modal-plan-title">
                    Afiliar a Plan
                </h3>
                <p class="text-xs text-slate-500" id="modal-plan-price">
                    Cuota mensual: $0 COP
                </p>
            </div>

            <!-- Formulario AJAX hacia /afiliar -->
            <form id="enroll-form" onsubmit="submitEnroll(event)" class="space-y-4 text-left">
                @csrf
                <input type="hidden" name="plan_id" id="form-plan-id" value="">

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Tu Nombre Completo (Tutor):</label>
                    <input type="text" name="customer_name" required placeholder="Ej: María Camila Rodríguez" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-hidden focus:border-blue-500 focus:bg-white transition">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700">Cédula / Documento:</label>
                        <input type="text" name="identification" required placeholder="1020304050" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-hidden focus:border-blue-500 focus:bg-white transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700">WhatsApp / Teléfono:</label>
                        <input type="tel" name="customer_phone" required placeholder="3235813942" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-hidden focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Correo Electrónico:</label>
                    <input type="email" name="customer_email" required placeholder="tucorreo@ejemplo.com" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-hidden focus:border-blue-500 focus:bg-white transition">
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="text-[11px] font-bold text-blue-700 uppercase tracking-wider">Datos de tu Mascota:</div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <input type="text" name="pet_name" required placeholder="Nombre (Ej: Max)" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-hidden">
                        </div>
                        <div>
                            <select name="pet_species" required class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-800 focus:outline-hidden">
                                <option value="dog">Perro (Canino)</option>
                                <option value="cat">Gato (Felino)</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="pet_breed" placeholder="Raza (Ej: Golden Retriever, Criollo)" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-hidden">
                    </div>
                </div>

                <div id="enroll-error" class="hidden text-xs text-rose-600 font-bold p-2.5 rounded-xl bg-rose-50 border border-rose-200"></div>

                <button type="submit" id="btn-submit-enroll" class="w-full py-3.5 rounded-xl brand-btn-primary text-white font-extrabold text-xs transition shadow-md shadow-blue-500/20">
                    Confirmar y Generar Mi Carnet Digital →
                </button>
            </form>
        </div>
    </div>

    <!-- Scripts de la Calculadora y Modal -->
    <script>
        function updateSavings() {
            const consultas = parseInt(document.getElementById('calc-consultas').value);
            const vacunas = parseInt(document.getElementById('calc-vacunas').value);
            document.getElementById('calc-consultas-val').innerText = `${consultas} visita${consultas > 1 ? 's' : ''}`;
            document.getElementById('calc-vacunas-val').innerText = `${vacunas} vacuna${vacunas > 1 ? 's' : ''}`;

            const particularYear = (consultas * 60000) + (vacunas * 75000) + 120000;
            const planYear = 600000;
            const savings = Math.max(150000, particularYear - planYear + 180000);
            
            document.getElementById('calc-savings-total').innerText = '$' + savings.toLocaleString('es-CO') + ' COP';
        }

        function openEnrollModal(planId, planName, planPrice) {
            document.getElementById('form-plan-id').value = planId;
            document.getElementById('modal-plan-title').innerText = `Afiliación: ${planName}`;
            document.getElementById('modal-plan-price').innerText = `Cuota mensual: ${planPrice}`;
            document.getElementById('enroll-modal').classList.remove('hidden');
        }

        function closeEnrollModal() {
            document.getElementById('enroll-modal').classList.add('hidden');
        }

        async function submitEnroll(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-submit-enroll');
            const errBox = document.getElementById('enroll-error');
            errBox.classList.add('hidden');
            btn.disabled = true;
            btn.innerText = 'Generando carnet digital...';

            const form = document.getElementById('enroll-form');
            const formData = new FormData(form);

            try {
                const res = await fetch('{{ url("/afiliar") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    if (data.carnet_url) {
                        window.location.href = data.carnet_url;
                    } else if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        alert('¡Afiliación exitosa! Te hemos enviado los datos a tu correo.');
                        window.location.reload();
                    }
                } else {
                    errBox.innerText = data.message || 'Ocurrió un error al procesar la afiliación. Por favor verifica tus datos.';
                    errBox.classList.remove('hidden');
                    btn.disabled = false;
                    btn.innerText = 'Confirmar y Generar Mi Carnet Digital →';
                }
            } catch (err) {
                errBox.innerText = 'Error de conexión. Inténtalo de nuevo o contáctanos por WhatsApp.';
                errBox.classList.remove('hidden');
                btn.disabled = false;
                btn.innerText = 'Confirmar y Generar Mi Carnet Digital →';
            }
        }
    </script>
</body>
</html>
