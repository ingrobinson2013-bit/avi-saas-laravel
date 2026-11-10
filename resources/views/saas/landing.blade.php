<!DOCTYPE html>
<html lang="es-CO" class="h-full bg-[#F4F7FC] text-[#15213B] antialiased selection:bg-[#6D28D9] selection:text-white scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $gaId = env('GOOGLE_TAG_ID', 'G-YRPKPVXZ2T') ?: env('GOOGLE_ANALYTICS_ID', 'G-YRPKPVXZ2T');
        $canonicalUrl = "https://avipetapp.com/{$page['slug']}";
        $faqs = $page['faqs'] ?? [];
    @endphp

    <title>{{ $page['title'] }}</title>
    <meta name="description" content="{{ $page['meta_description'] }}">
    <meta name="keywords" content="{{ $page['keywords'] }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="googlebot" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="alternate" hreflang="es-CO" href="{{ $canonicalUrl }}">
    <link rel="alternate" hreflang="es" href="{{ $canonicalUrl }}">
    <link rel="alternate" hreflang="x-default" href="{{ $canonicalUrl }}">

    <!-- Open Graph / WhatsApp / LinkedIn -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $page['title'] }}">
    <meta property="og:description" content="{{ $page['meta_description'] }}">
    <meta property="og:image" content="https://avipetapp.com/brand/favicons/og-image-1200x630.png">
    <meta property="og:site_name" content="AviPetApp">
    <meta property="og:locale" content="es_CO">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $page['title'] }}">
    <meta name="twitter:description" content="{{ $page['meta_description'] }}">
    <meta name="twitter:image" content="https://avipetapp.com/brand/favicons/og-image-1200x630.png">

    <!-- Schema.org JSON-LD: WebPage + SoftwareApplication + BreadcrumbList + FAQPage -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@@type": "WebPage",
          "@@id": "{{ $canonicalUrl }}#webpage",
          "url": "{{ $canonicalUrl }}",
          "name": {!! json_encode($page['title'], JSON_UNESCAPED_UNICODE) !!},
          "description": {!! json_encode($page['meta_description'], JSON_UNESCAPED_UNICODE) !!},
          "inLanguage": "es-CO",
          "isPartOf": {
            "@@type": "WebSite",
            "name": "AviPetApp",
            "url": "https://avipetapp.com/"
          }
        },
        {
          "@@type": "SoftwareApplication",
          "@@id": "{{ $canonicalUrl }}#software",
          "name": "AviPetApp — Software con IA para veterinarias",
          "operatingSystem": "Web, Cloud, iOS, Android",
          "applicationCategory": "BusinessApplication, HealthApplication",
          "offers": {
            "@@type": "AggregateOffer",
            "lowPrice": "50000",
            "highPrice": "489000",
            "priceCurrency": "COP",
            "offerCount": "4"
          },
          "aggregateRating": {
            "@@type": "AggregateRating",
            "ratingValue": "4.9",
            "reviewCount": "38"
          },
          "url": "{{ $canonicalUrl }}"
        },
        {
          "@@type": "BreadcrumbList",
          "@@id": "{{ $canonicalUrl }}#breadcrumb",
          "itemListElement": [
            {
              "@@type": "ListItem",
              "position": 1,
              "name": "AviPetApp",
              "item": "https://avipetapp.com/"
            },
            {
              "@@type": "ListItem",
              "position": 2,
              "name": {!! json_encode($page['h1_highlight'], JSON_UNESCAPED_UNICODE) !!},
              "item": "{{ $canonicalUrl }}"
            }
          ]
        }@if(count($faqs) > 0),
        {
          "@@type": "FAQPage",
          "@@id": "{{ $canonicalUrl }}#faq",
          "mainEntity": [
            @foreach($faqs as $idx => $faq)
            {
              "@@type": "Question",
              "name": {!! json_encode($faq['question'], JSON_UNESCAPED_UNICODE) !!},
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": {!! json_encode($faq['answer'], JSON_UNESCAPED_UNICODE) !!}
              }
            }{{ $idx + 1 < count($faqs) ? ',' : '' }}
            @endforeach
          ]
        }
        @endif
      ]
    }
    </script>

    @if($gaId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $gaId }}');
    </script>
    @endif

    <link rel="icon" href="/favicon.ico?v=20261017" sizes="48x48">
    <link rel="icon" type="image/svg+xml" href="/brand/favicons/favicon.svg?v=20261017">
    <link rel="icon" type="image/png" sizes="48x48" href="/brand/favicons/favicon-48.png?v=20261017">
    <link rel="apple-touch-icon" sizes="180x180" href="/brand/favicons/favicon-180.png?v=20261017">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', Arial, sans-serif; }
        .tabular-nums { font-variant-numeric: tabular-nums; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between bg-[#F4F7FC] text-[#15213B]">

    <!-- Header Oficial AviPetApp (Manual Maestro de Marca v1.1) -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-[#D9E2F2]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            <a href="/" class="flex items-center py-3 shrink-0" aria-label="AviPetApp — Software con IA para veterinarias">
                <img src="/brand/svg/avipetapp-horizontal-fondo-claro.svg" alt="AviPetApp — Software con IA para veterinarias" width="170" height="36" class="h-8 sm:h-9 w-auto min-w-[148px] object-contain">
            </a>

            <nav class="hidden lg:flex items-center gap-5 text-[14px] font-medium text-[#5C6B85]">
                <a href="/software-planes-salud-veterinaria" class="{{ $pageKey === 'planes-salud' ? 'text-[#6D28D9] font-bold' : 'hover:text-[#15213B]' }}">Planes de Salud</a>
                <a href="/carnet-vacunacion-digital-mascotas-qr" class="{{ $pageKey === 'carnet-qr' ? 'text-[#6D28D9] font-bold' : 'hover:text-[#15213B]' }}">Carnet Digital QR</a>
                <a href="#precios-saas" class="hover:text-[#15213B]">Precios (0% Comisión)</a>
                <a href="/blog" class="hover:text-[#15213B]">Blog Veterinario</a>
                <a href="/biolab/dermo-gut-superboost" class="px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold hover:bg-emerald-100">🧬 AVIPET BioLab®</a>
            </nav>

            <div class="flex items-center gap-2.5">
                <a href="/admin/login" class="hidden sm:inline-flex px-4 py-2.5 rounded-xl border border-[#CBD5E1] bg-white text-[#15213B] text-[13px] font-semibold hover:border-[#6D28D9]">
                    Iniciar sesión
                </a>
                <a href="#crear-clinica" class="px-4 py-2.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white text-[13px] sm:text-[14px] font-semibold shadow-sm transition">
                    Probar 15 días gratis
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- HERO COMERCIAL + FORMULARIO DE ALTA EN 60 SEGUNDOS ABOVE THE FOLD -->
        <section class="relative bg-[#080B20] text-white py-12 lg:py-20 border-b border-[#1E2B58] overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Migas de pan -->
                <nav aria-label="Breadcrumb" class="text-xs text-slate-400 mb-6 flex items-center gap-2">
                    <a href="/" class="hover:text-[#35DDF5]">AviPetApp</a>
                    <span>/</span>
                    <span class="text-[#35DDF5] font-semibold">{{ $page['h1_highlight'] }}</span>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
                    <!-- Columna Izquierda: Propuesta de Valor Exacta -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#111936] border border-[#A855F7]/40 text-[#35DDF5] text-xs font-semibold">
                            <span>✨ {{ $page['badge'] }}</span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl font-bold tracking-tight leading-[1.12] text-white">
                            {{ $page['h1_prefix'] }}
                            <span class="text-[#35DDF5]">{{ $page['h1_highlight'] }}</span>
                            {{ $page['h1_suffix'] }}
                        </h1>

                        <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl">
                            {{ $page['lead'] }}
                        </p>

                        <div class="grid sm:grid-cols-3 gap-3 pt-2">
                            <div class="p-3.5 rounded-xl bg-[#111936] border border-[#1E2B58]">
                                <div class="text-xl font-extrabold text-[#35DDF5] tabular-nums">15 Días</div>
                                <div class="text-xs text-slate-300 mt-0.5">Prueba gratis sin tarjeta</div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-[#111936] border border-[#1E2B58]">
                                <div class="text-xl font-extrabold text-emerald-400 tabular-nums">0% Comisión</div>
                                <div class="text-xs text-slate-300 mt-0.5">El 100% del cobro es tuyo</div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-[#111936] border border-[#1E2B58]">
                                <div class="text-xl font-extrabold text-[#A855F7] tabular-nums">60 Seg</div>
                                <div class="text-xs text-slate-300 mt-0.5">Vitrina + Afiche QR listos</div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <a href="#herramienta-interactiva" class="px-5 py-3 rounded-xl bg-white/10 hover:bg-white/15 border border-white/20 text-white text-sm font-semibold transition">
                                Probar simulador en vivo ↓
                            </a>
                            <a href="https://wa.me/573235813942?text={{ urlencode('Hola AviPetApp, quiero información sobre ' . $page['h1_highlight'] . ' para mi clínica veterinaria') }}"
                               target="_blank" rel="noopener"
                               class="px-5 py-3 rounded-xl bg-[#0F9F9A] hover:bg-[#0E7490] text-white text-sm font-semibold transition">
                                💬 Hablar con asesor por WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Columna Derecha: Formulario Directo de Alta en 60 Segundos -->
                    <div id="crear-clinica" class="lg:col-span-5 bg-white text-[#15213B] rounded-2xl p-6 sm:p-7 shadow-2xl border border-[#D9E2F2]">
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="px-2.5 py-1 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] text-[11px] font-bold uppercase tracking-wide">
                                Activación Inmediata
                            </span>
                            <span class="text-xs font-semibold text-[#0F9F9A]">✓ Sin tarjeta de crédito</span>
                        </div>
                        <h2 class="text-xl font-bold text-[#15213B] mb-1">Crea la cuenta de tu veterinaria</h2>
                        <p class="text-xs text-[#5C6B85] mb-5">Recibe al instante tu panel administrativo, 2 planes preventivos configurables y tu afiche QR para recepción.</p>

                        <div id="saas-reg-error" class="hidden mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700 font-medium"></div>
                        <div id="saas-reg-success" class="hidden mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-sm text-emerald-900 font-semibold"></div>

                        <form id="saas-onboarding-form" action="/registro-clinica" method="POST" class="space-y-3.5">
                            @csrf
                            <input type="hidden" name="saas_plan_tier" value="pro">

                            <div>
                                <label class="block text-xs font-bold text-[#15213B] mb-1">Nombre de tu Clínica o Veterinaria *</label>
                                <input type="text" id="reg-clinic-name" name="clinic_name" required minlength="3" placeholder="Ej: Clínica Veterinaria San Roque"
                                       oninput="updateSlugPreview(this.value)"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-[#CBD5E1] text-sm text-[#15213B] focus:outline-none focus:border-[#6D28D9]">
                                <p class="text-[11px] text-[#5C6B85] mt-1">
                                    Tu vitrina será: <strong id="reg-slug-preview" class="text-[#6D28D9]">tu-veterinaria.avipetapp.com</strong>
                                </p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-[#15213B] mb-1">Tu Nombre / Dr(a).</label>
                                    <input type="text" name="doctor_name" placeholder="Ej: Dra. Laura Gómez"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-[#CBD5E1] text-sm text-[#15213B] focus:outline-none focus:border-[#6D28D9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#15213B] mb-1">Ciudad *</label>
                                    <input type="text" name="city" required placeholder="Ej: Bogotá, Medellín..."
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-[#CBD5E1] text-sm text-[#15213B] focus:outline-none focus:border-[#6D28D9]">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-[#15213B] mb-1">WhatsApp *</label>
                                    <input type="tel" name="phone" required minlength="7" placeholder="Ej: 310 123 4567"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-[#CBD5E1] text-sm text-[#15213B] focus:outline-none focus:border-[#6D28D9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#15213B] mb-1">Correo Electrónico *</label>
                                    <input type="email" name="email" required placeholder="doctor@clinica.com"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-[#CBD5E1] text-sm text-[#15213B] focus:outline-none focus:border-[#6D28D9]">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#15213B] mb-1">Crea tu Contraseña (mín. 6 caracteres) *</label>
                                <input type="password" name="password" required minlength="6" placeholder="••••••••"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-[#CBD5E1] text-sm text-[#15213B] focus:outline-none focus:border-[#6D28D9]">
                            </div>

                            <button type="submit" id="saas-reg-btn"
                                    class="w-full py-3.5 px-5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-bold text-sm shadow-md transition cursor-pointer">
                                Activar mis 15 días gratis ahora →
                            </button>

                            <p class="text-[11px] text-center text-[#5C6B85]">
                                Software con IA para veterinarias · Tus datos y pacientes son 100% privados de tu clínica.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- HERRAMIENTA INTERACTIVA SEGÚN INTENCIÓN DE BÚSQUEDA -->
        <section id="herramienta-interactiva" class="py-14 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($page['widget_type'] === 'mrr_simulator')
            <div class="bg-white rounded-2xl border border-[#D9E2F2] p-6 sm:p-9 shadow-sm">
                <div class="max-w-3xl mb-6">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#0E7490]">Calculadora Financiera para Clínicas Veterinarias</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-[#15213B] mt-1">Simula cuánto puede recaudar tu veterinaria con Planes de Salud Preventiva</h2>
                    <p class="text-sm text-[#5C6B85] mt-1">Ajusta la cantidad de mascotas afiliadas y el valor mensual de tu membresía (escenario ilustrativo; el 100% del recaudo ingresa directo a tu clínica).</p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div class="space-y-5">
                        <div>
                            <div class="flex justify-between text-sm font-semibold mb-1.5">
                                <span>Mascotas afiliadas en tu clínica:</span>
                                <span id="sim-pets-val" class="text-[#6D28D9] font-extrabold tabular-nums">80 mascotas</span>
                            </div>
                            <input type="range" id="sim-pets" min="10" max="300" step="10" value="80" oninput="recalcSaasMrr()" class="w-full accent-[#6D28D9]">
                        </div>
                        <div>
                            <div class="flex justify-between text-sm font-semibold mb-1.5">
                                <span>Tarifa mensual promedio del plan:</span>
                                <span id="sim-price-val" class="text-[#0E7490] font-extrabold tabular-nums">$55.000 COP / mes</span>
                            </div>
                            <input type="range" id="sim-price" min="35000" max="110000" step="5000" value="55000" oninput="recalcSaasMrr()" class="w-full accent-[#0E7490]">
                        </div>
                        <div class="p-4 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2] text-xs text-[#5C6B85]">
                            💡 <strong class="text-[#15213B]">Dato real en Colombia:</strong> Con solo <strong>2 mascotas afiliadas</strong> ya cubres la mensualidad Starter de AviPetApp ($99.000 COP/mes). De la mascota #3 en adelante, toda la utilidad se queda en tu clínica.
                        </div>
                    </div>

                    <div class="bg-[#080B20] text-white rounded-2xl p-6 space-y-4 border border-[#1E2B58]">
                        <div>
                            <div class="text-xs text-slate-400">Recaudo Mensual Recurrente Bruto (GMV Clínica):</div>
                            <div id="sim-mrr-out" class="text-3xl sm:text-4xl font-extrabold text-[#35DDF5] tabular-nums mt-1">$4.400.000 COP/mes</div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 pt-3 border-t border-[#1E2B58]">
                            <div>
                                <div class="text-[11px] text-slate-400">Flujo Anual Proyectado:</div>
                                <div id="sim-arr-out" class="text-lg font-bold text-white tabular-nums">$52.800.000 COP</div>
                            </div>
                            <div>
                                <div class="text-[11px] text-slate-400">Margen Operativo Est. (~65%):</div>
                                <div id="sim-margin-out" class="text-lg font-bold text-emerald-400 tabular-nums">$2.860.000 /mes</div>
                            </div>
                        </div>
                        <a href="#crear-clinica" class="block w-full text-center py-3 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-bold text-sm transition">
                            Configurar estos planes en mi clínica (15 días gratis) →
                        </a>
                    </div>
                </div>
            </div>
            @elseif($page['widget_type'] === 'qr_preview')
            <div class="bg-white rounded-2xl border border-[#D9E2F2] p-6 sm:p-9 shadow-sm">
                <div class="grid md:grid-cols-12 gap-8 items-center">
                    <div class="md:col-span-7 space-y-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#6D28D9]">Demostración Interactiva de Mostrador</span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#15213B]">Así se ve el Carnet Digital con Código QR en el celular de tu cliente</h2>
                        <p class="text-sm text-[#5C6B85] leading-relaxed">
                            Haz clic en <strong>"Simular canje en recepción"</strong> para ver cómo tu equipo descuenta una vacuna o consulta en 1 segundo con trazabilidad completa, evitando confusiones o carnets de papel extraviados.
                        </p>
                        <div class="flex flex-wrap gap-3 pt-2">
                            <button type="button" onclick="simulateQrRedeem()" class="px-5 py-3 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white text-sm font-bold shadow-sm transition cursor-pointer">
                                📲 Simular canje de vacuna en recepción
                            </button>
                            <a href="https://vet-pet-patitas.avipetapp.com/" target="_blank" rel="noopener" class="px-5 py-3 rounded-xl border border-[#CBD5E1] text-[#15213B] text-sm font-semibold hover:border-[#6D28D9] transition">
                                Ver vitrina real de Clínica Piloto ↗
                            </a>
                        </div>
                        <p id="qr-demo-toast" class="text-xs font-bold text-[#0F9F9A] hidden">
                            ✓ Canje registrado con fecha, hora y doctor responsable. El tutor ve su saldo actualizado al instante.
                        </p>
                    </div>

                    <div class="md:col-span-5">
                        <div class="rounded-2xl bg-[#080B20] text-white p-5 border border-[#1E2B58] shadow-xl max-w-sm mx-auto">
                            <div class="flex items-center justify-between pb-3 border-b border-[#1E2B58]">
                                <div>
                                    <div class="text-[11px] text-[#35DDF5] font-bold uppercase">Tu Clínica Veterinaria</div>
                                    <div class="text-base font-extrabold">Max · Golden Retriever</div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-bold">● Activo</span>
                            </div>
                            <div class="my-4 flex items-center gap-4 bg-[#111936] p-3.5 rounded-xl border border-[#1E2B58]">
                                <div class="w-16 h-16 bg-white rounded-lg p-1.5 shrink-0 flex items-center justify-center text-[#080B20] font-black text-[10px] text-center leading-tight">
                                    QR<br>VERIFICADO
                                </div>
                                <div class="text-xs space-y-1">
                                    <div class="font-bold text-white">Plan Bienestar Integral</div>
                                    <div class="text-slate-300">Tutor: Carlos Ramírez</div>
                                    <div class="text-[#35DDF5] font-semibold">Vigente · Cupos en vivo</div>
                                </div>
                            </div>
                            <div class="space-y-2 text-xs">
                                <div class="flex justify-between p-2 rounded-lg bg-[#111936]">
                                    <span>💉 Esquema Vacunal Anual</span>
                                    <strong id="qr-slot-vaccine" class="text-emerald-400 tabular-nums">2 / 2 disponibles</strong>
                                </div>
                                <div class="flex justify-between p-2 rounded-lg bg-[#111936]">
                                    <span>🩺 Consultas de Control</span>
                                    <strong id="qr-slot-consult" class="text-emerald-400 tabular-nums">4 / 4 disponibles</strong>
                                </div>
                                <div class="flex justify-between p-2 rounded-lg bg-[#111936]">
                                    <span>💊 Desparasitación Trimestral</span>
                                    <strong class="text-emerald-400 tabular-nums">4 / 4 disponibles</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl border border-[#D9E2F2] p-6 sm:p-9 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-wider text-[#0E7490]">Todo Incluido en tu Prueba de 15 Días</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-[#15213B] mt-1 mb-6">¿Qué recibe tu clínica veterinaria en el minuto 1 de registrarse?</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="p-5 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <div class="text-lg font-extrabold text-[#6D28D9] mb-1">1. Vitrina Web Propia</div>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">Subdominio exclusivo con tus colores, planes, WhatsApp y formulario de afiliación para tutores.</p>
                    </div>
                    <div class="p-5 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <div class="text-lg font-extrabold text-[#0E7490] mb-1">2. Afiche QR Imprimible</div>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">Descarga en PDF de alta calidad tu afiche oficial para sala de espera y consultorios.</p>
                    </div>
                    <div class="p-5 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <div class="text-lg font-extrabold text-[#15213B] mb-1">3. Carnets QR en WhatsApp</div>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">Emisión inmediata de carnets digitales con saldo de vacunas, consultas y beneficios en vivo.</p>
                    </div>
                    <div class="p-5 rounded-xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <div class="text-lg font-extrabold text-[#0F9F9A] mb-1">4. Asistente con IA</div>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">Sugerencias de seguimiento preventivo y mensajes listos para enviar. La IA organiza información; el criterio clínico es de tu equipo veterinario.</p>
                    </div>
                </div>
            </div>
            @endif
        </section>

        <!-- PILARES DE VALOR -->
        <section class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-[#15213B] mb-8 text-center">
                Por qué las clínicas veterinarias en Colombia eligen AviPetApp
            </h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($page['pillars'] as $pillar)
                <article class="bg-white p-6 rounded-2xl border border-[#D9E2F2] shadow-xs">
                    <h3 class="text-lg font-bold text-[#15213B] mb-2">{{ $pillar['title'] }}</h3>
                    <p class="text-sm text-[#5C6B85] leading-relaxed">{{ $pillar['desc'] }}</p>
                </article>
                @endforeach
            </div>
        </section>

        <!-- PASO A PASO DE IMPLEMENTACIÓN -->
        <section class="py-14 bg-white border-y border-[#D9E2F2]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-[#15213B] mb-8">
                    Cómo ponerlo a producir en tu veterinaria hoy mismo
                </h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($page['steps'] as $s)
                    <div class="p-5 rounded-2xl bg-[#F4F7FC] border border-[#D9E2F2]">
                        <span class="inline-block px-2.5 py-1 rounded-full bg-[#6D28D9]/10 text-[#6D28D9] text-xs font-bold mb-2">{{ $s['step'] }}</span>
                        <h3 class="text-base font-bold text-[#15213B] mb-1.5">{{ $s['title'] }}</h3>
                        <p class="text-xs text-[#5C6B85] leading-relaxed">{{ $s['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- PRECIOS TRANSPARENTES SAAS -->
        <section id="precios-saas" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-[#6D28D9]">Modelo Prepago Mes Anticipado · Cero Comisiones</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-[#15213B] mt-1">Precios claros pensados para la realidad de las veterinarias en Colombia</h2>
                <p class="text-sm text-[#5C6B85] mt-2">Empieza con <strong>15 días gratis</strong>. Luego elige recarga por cupos o mensualidad plana según el tamaño de tu clínica.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white p-6 rounded-2xl border border-[#D9E2F2] flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold text-[#0E7490]">Ideal para arrancar</span>
                        <h3 class="text-lg font-bold text-[#15213B] mt-1">Paquete 10 Mascotas</h3>
                        <div class="text-2xl font-extrabold text-[#15213B] tabular-nums my-3">$50.000 <span class="text-xs font-normal text-[#5C6B85]">COP / mes</span></div>
                        <p class="text-xs text-[#5C6B85]">Equivale a $5.000 COP por mascota activa. Sin compromiso fijo.</p>
                    </div>
                    <a href="#crear-clinica" class="mt-5 block text-center py-2.5 rounded-xl border border-[#6D28D9] text-[#6D28D9] text-xs font-bold hover:bg-[#6D28D9]/5">Probar 15 días gratis</a>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-[#D9E2F2] flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold text-[#5C6B85]">Hasta 60 mascotas</span>
                        <h3 class="text-lg font-bold text-[#15213B] mt-1">Plan Starter</h3>
                        <div class="text-2xl font-extrabold text-[#15213B] tabular-nums my-3">$99.000 <span class="text-xs font-normal text-[#5C6B85]">COP / mes</span></div>
                        <p class="text-xs text-[#5C6B85]">Se paga solo con apenas 2 planes preventivos vendidos en tu clínica.</p>
                    </div>
                    <a href="#crear-clinica" class="mt-5 block text-center py-2.5 rounded-xl border border-[#6D28D9] text-[#6D28D9] text-xs font-bold hover:bg-[#6D28D9]/5">Probar 15 días gratis</a>
                </div>

                <div class="bg-[#080B20] text-white p-6 rounded-2xl border-2 border-[#6D28D9] shadow-lg flex flex-col justify-between">
                    <div>
                        <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#6D28D9] text-white text-[11px] font-bold">Más elegido · Hasta 250 mascotas</span>
                        <h3 class="text-lg font-bold text-white mt-2">Plan Profesional + IA</h3>
                        <div class="text-2xl font-extrabold text-[#35DDF5] tabular-nums my-3">$229.000 <span class="text-xs font-normal text-slate-300">COP / mes</span></div>
                        <p class="text-xs text-slate-300">Vitrina web marca blanca, carnets QR, calculadora actuarial y seguimiento con IA.</p>
                    </div>
                    <a href="#crear-clinica" class="mt-5 block text-center py-2.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white text-xs font-bold">Activar 15 días gratis →</a>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-[#D9E2F2] flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold text-[#5C6B85]">Clínicas grandes y sedes</span>
                        <h3 class="text-lg font-bold text-[#15213B] mt-1">Plan Enterprise</h3>
                        <div class="text-2xl font-extrabold text-[#15213B] tabular-nums my-3">$489.000 <span class="text-xs font-normal text-[#5C6B85]">COP / mes</span></div>
                        <p class="text-xs text-[#5C6B85]">Mascotas ilimitadas, dominio propio personalizado y soporte prioritario VIP.</p>
                    </div>
                    <a href="#crear-clinica" class="mt-5 block text-center py-2.5 rounded-xl border border-[#6D28D9] text-[#6D28D9] text-xs font-bold hover:bg-[#6D28D9]/5">Probar 15 días gratis</a>
                </div>
            </div>
        </section>

        <!-- PREGUNTAS FRECUENTES (CONECTADAS CON FAQPAGE SCHEMA) -->
        <section class="py-14 bg-white border-t border-[#D9E2F2]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-[#15213B] mb-6">
                    Preguntas frecuentes sobre {{ $page['h1_highlight'] }}
                </h2>
                <div class="space-y-4">
                    @foreach($faqs as $faq)
                    <details class="group p-5 rounded-2xl bg-[#F4F7FC] border border-[#D9E2F2]" {{ $loop->first ? 'open' : '' }}>
                        <summary class="font-bold text-sm sm:text-base text-[#15213B] cursor-pointer list-none flex items-center justify-between gap-4">
                            <span>{{ $faq['question'] }}</span>
                            <span class="text-[#6D28D9] font-extrabold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-sm text-[#5C6B85] leading-relaxed mt-3 pt-3 border-t border-[#D9E2F2]">
                            {{ $faq['answer'] }}
                        </p>
                    </details>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ENLAZADO INTERNO ESTRATÉGICO: OTRAS SOLUCIONES SAAS + GUÍAS DEL BLOG -->
        <section class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-[#D9E2F2]">
            <div class="grid lg:grid-cols-3 gap-6 mb-10">
                @foreach($allPages as $k => $p)
                <a href="/{{ $p['slug'] }}" class="p-5 rounded-2xl border {{ $k === $pageKey ? 'bg-[#6D28D9]/5 border-[#6D28D9]' : 'bg-white border-[#D9E2F2] hover:border-[#6D28D9]' }} transition block">
                    <span class="text-[11px] font-bold uppercase text-[#0E7490]">Módulo AviPetApp</span>
                    <h3 class="text-base font-bold text-[#15213B] mt-1">{{ $p['h1_highlight'] }}</h3>
                    <p class="text-xs text-[#5C6B85] mt-1 line-clamp-2">{{ $p['meta_description'] }}</p>
                </a>
                @endforeach
            </div>

            <h2 class="text-xl font-bold text-[#15213B] mb-4">Guías recomendadas de rentabilidad veterinaria</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($blogPosts as $post)
                <a href="/blog/{{ $post['slug'] }}" class="bg-white p-5 rounded-2xl border border-[#D9E2F2] hover:border-[#6D28D9] transition block">
                    <span class="text-[11px] font-semibold text-[#0E7490]">{{ $post['category'] }}</span>
                    <h3 class="text-sm font-bold text-[#15213B] mt-1 line-clamp-2">{{ $post['title'] }}</h3>
                </a>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Footer Oficial AviPetApp -->
    <footer class="bg-[#080B20] text-slate-300 py-12 border-t border-[#1E2B58] text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <img src="/brand/svg/avipetapp-horizontal-fondo-oscuro.svg" alt="AviPetApp" width="160" height="32" class="h-8 w-auto mb-2">
                <p class="text-slate-400">Software con IA para veterinarias · Más inteligencia. Más bienestar. Más futuro.</p>
            </div>
            <div class="flex flex-wrap gap-5">
                <a href="/" class="hover:text-[#35DDF5]">Inicio</a>
                <a href="/software-planes-salud-veterinaria" class="hover:text-[#35DDF5]">Planes de Salud Veterinarios</a>
                <a href="/carnet-vacunacion-digital-mascotas-qr" class="hover:text-[#35DDF5]">Carnet Digital QR</a>
                <a href="/crear-clinica-veterinaria-gratis" class="hover:text-[#35DDF5]">Prueba Gratis 15 Días</a>
                <a href="/blog" class="hover:text-[#35DDF5]">Blog Veterinario</a>
                <a href="/biolab/dermo-gut-superboost" class="hover:text-[#35DDF5]">AVIPET BioLab® ($69.900)</a>
            </div>
        </div>
    </footer>

    <script>
        function updateSlugPreview(val) {
            var slug = (val || '')
                .toLowerCase()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '') || 'tu-veterinaria';
            var el = document.getElementById('reg-slug-preview');
            if (el) el.textContent = slug + '.avipetapp.com';
        }

        function formatCop(n) {
            return '$' + Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function recalcSaasMrr() {
            var petsEl = document.getElementById('sim-pets');
            var priceEl = document.getElementById('sim-price');
            if (!petsEl || !priceEl) return;
            var pets = parseInt(petsEl.value, 10) || 80;
            var price = parseInt(priceEl.value, 10) || 55000;
            var mrr = pets * price;
            var arr = mrr * 12;
            var margin = mrr * 0.65;
            document.getElementById('sim-pets-val').textContent = pets + ' mascotas';
            document.getElementById('sim-price-val').textContent = formatCop(price) + ' COP / mes';
            document.getElementById('sim-mrr-out').textContent = formatCop(mrr) + ' COP/mes';
            document.getElementById('sim-arr-out').textContent = formatCop(arr) + ' COP';
            document.getElementById('sim-margin-out').textContent = formatCop(margin) + ' /mes';
        }

        var qrRedeemed = false;
        function simulateQrRedeem() {
            qrRedeemed = !qrRedeemed;
            var slot = document.getElementById('qr-slot-vaccine');
            var toast = document.getElementById('qr-demo-toast');
            if (slot) {
                slot.textContent = qrRedeemed ? '1 / 2 disponibles (1 canjeada hoy)' : '2 / 2 disponibles';
                slot.className = qrRedeemed ? 'text-[#35DDF5] tabular-nums' : 'text-emerald-400 tabular-nums';
            }
            if (toast) {
                toast.classList.toggle('hidden', !qrRedeemed);
            }
        }

        (function() {
            var form = document.getElementById('saas-onboarding-form');
            if (!form) return;
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var btn = document.getElementById('saas-reg-btn');
                var errBox = document.getElementById('saas-reg-error');
                var okBox = document.getElementById('saas-reg-success');
                errBox.classList.add('hidden');
                btn.disabled = true;
                btn.textContent = 'Creando el panel de tu veterinaria...';

                fetch('/registro-clinica', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: new FormData(form)
                })
                .then(function(res) { return res.json().then(function(data) { return { status: res.status, data: data }; }); })
                .then(function(result) {
                    if (result.status >= 200 && result.status < 300 && result.data.success) {
                        okBox.textContent = '¡Clínica creada con éxito! Redirigiendo a tu panel administrativo...';
                        okBox.classList.remove('hidden');
                        window.location.href = result.data.redirect_url || '/admin';
                    } else {
                        var msg = (result.data && result.data.message) ? result.data.message : 'Verifica los datos ingresados e intenta nuevamente.';
                        if (result.data && result.data.errors) {
                            var firstKey = Object.keys(result.data.errors)[0];
                            if (firstKey && result.data.errors[firstKey][0]) {
                                msg = result.data.errors[firstKey][0];
                            }
                        }
                        errBox.textContent = msg;
                        errBox.classList.remove('hidden');
                        btn.disabled = false;
                        btn.textContent = 'Activar mis 15 días gratis ahora →';
                    }
                })
                .catch(function() {
                    form.submit();
                });
            });
        })();
    </script>
</body>
</html>
