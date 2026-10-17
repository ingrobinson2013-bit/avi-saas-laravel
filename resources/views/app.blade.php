<!DOCTYPE html>
<html lang="es" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $gaId = env('GOOGLE_TAG_ID', 'G-YRPKPVXZ2T') ?: env('GOOGLE_ANALYTICS_ID', 'G-YRPKPVXZ2T');
        $gtmId = env('GOOGLE_TAG_MANAGER_ID');
        $cfToken = env('CLOUDFLARE_ANALYTICS_TOKEN');
        $isPublicLanding = request()->is('/');
        $canonicalUrl = 'https://avipetapp.com';
    @endphp
    @if($isPublicLanding)
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="description" content="AviPetApp ayuda a tu clínica a gestionar planes de salud para mascotas, organizar la relación con tus clientes y aprovechar herramientas inteligentes desde una sola plataforma. 15 días gratis.">
    <meta name="keywords" content="avipetapp, software con ia para veterinarias, software veterinaria colombia, veterinarias socias colombia, software para clinicas veterinarias, planes de salud para mascotas, membresias veterinarias, facturacion recurrente veterinaria, carnet digital mascotas, saas veterinario">
    <meta name="application-name" content="AviPetApp">
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
            }
          ]
        }
      ]
    }
    </script>
    @else
    <meta name="robots" content="noindex, nofollow">
    @endif

    @if($gaId)
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $gaId }}');
    </script>
    @endif
    @if($gtmId)
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $gtmId }}');</script>
    @endif
    @if($cfToken)
    <script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "{{ $cfToken }}"}'></script>
    @endif
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @php
        $host = request()->getHost();
        $cleanHost = strtolower(trim($host));
        $hostNoWww = preg_replace('/^www\./', '', $cleanHost);
        $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');

        $tenantSlug = request()->route('slug') ?? request()->route('subdomain') ?? session('current_tenant_slug');
        $currentTenant = null;

        if ($tenantSlug) {
            $currentTenant = \App\Models\Tenant::where('slug', $tenantSlug)
                ->orWhere('domain', 'LIKE', "%{$tenantSlug}%")
                ->first();
        }

        if (!$currentTenant && !in_array($hostNoWww, ['localhost', '127.0.0.1', $baseDomain])) {
            $currentTenant = \App\Models\Tenant::where('domain', $cleanHost)
                ->orWhere('domain', $hostNoWww)
                ->first();

            if (!$currentTenant && str_ends_with($cleanHost, '.' . $baseDomain)) {
                $sub = str_replace('.' . $baseDomain, '', $hostNoWww);
                if ($sub !== 'www') {
                    $currentTenant = \App\Models\Tenant::where('slug', $sub)->first();
                }
            }
        }

        if (!$currentTenant) {
            $currentTenant = \App\Models\Tenant::where('slug', 'vet-pet-patitas')->first() ?? \App\Models\Tenant::first();
        }

        if ($isPublicLanding) {
            $clinicPageTitle = 'AviPetApp — Software con IA para veterinarias | Planes de salud para mascotas';
            $favIcon = '/brand/favicons/favicon.svg';
        } elseif (request()->is('super-admin*')) {
            $clinicPageTitle = 'Centro de control · AviPetApp Superadmin';
            $favIcon = '/brand/favicons/favicon.svg';
        } else {
            $favIcon = $currentTenant?->branding['logo_url'] ?? '/brand/favicons/favicon.svg';
            $clinicPageTitle = $currentTenant ? ($currentTenant->name . ' · AviPetApp') : 'AviPetApp · Software con IA para veterinarias';
        }
    @endphp
    <title inertia>{{ $clinicPageTitle }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ $favIcon }}">
    <link rel="icon" type="image/png" sizes="32x32" href="/brand/favicons/favicon-32.png">
    <link rel="shortcut icon" href="{{ $favIcon }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/brand/favicons/favicon-180.png">

    @viteReactRefresh
    @vite(['resources/js/app.tsx'])
    @inertiaHead
</head>
<body class="h-full font-sans antialiased bg-[#F4F7FC] text-[#15213B] selection:bg-[#6D28D9] selection:text-white">
    @inertia
</body>
</html>
