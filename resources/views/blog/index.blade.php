<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F4F7FC] text-[#15213B] antialiased selection:bg-[#6D28D9] selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    @php
        $gaId = env('GOOGLE_TAG_ID', 'G-YRPKPVXZ2T') ?: env('GOOGLE_ANALYTICS_ID', 'G-YRPKPVXZ2T');
        $canonicalUrl = 'https://avipetapp.com/blog';
    @endphp

    <title>Blog para Clínicas Veterinarias — Planes de Salud, Clientes e IA | AviPetApp</title>
    <meta name="description" content="Artículos, guías estratégicas y análisis de negocio para veterinarias en Colombia. Aprende a gestionar planes de salud para mascotas, organizar clientes y aprovechar herramientas de IA con AviPetApp.">
    <meta name="keywords" content="avipetapp, blog veterinaria colombia, gestion clinica veterinaria, marketing veterinario, planes de salud mascotas, rentabilidad veterinaria, software con ia para veterinarias">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Open Graph -->
    <meta property="og:type" content="blog">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="Blog para Clínicas Veterinarias — Planes de Salud e IA | AviPetApp">
    <meta property="og:description" content="Guías y estrategias probadas para clínicas veterinarias con planes de salud para mascotas e inteligencia artificial.">
    <meta property="og:image" content="{{ url('/brand/favicons/og-image-1200x630.png') }}">
    <meta property="og:site_name" content="AviPetApp">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Blog para Clínicas Veterinarias | AviPetApp">
    <meta name="twitter:description" content="Guías para clínicas veterinarias: planes de salud para mascotas, clientes e IA en una sola plataforma.">
    <meta name="twitter:image" content="{{ url('/brand/favicons/og-image-1200x630.png') }}">

    <!-- Schema.org JSON-LD para Portada del Blog AviPetApp -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@@type": "CollectionPage",
          "@@id": "https://avipetapp.com/blog#collection",
          "url": "https://avipetapp.com/blog",
          "name": "Blog para Clínicas Veterinarias — Planes de Salud, Clientes e IA | AviPetApp",
          "description": "Artículos, guías estratégicas y análisis de negocio para veterinarias en Colombia con AviPetApp.",
          "isPartOf": {
            "@@id": "https://avipetapp.com/#website"
          },
          "publisher": {
            "@@type": "Organization",
            "name": "AviPetApp",
            "url": "https://avipetapp.com",
            "logo": {
              "@@type": "ImageObject",
              "url": "https://avipetapp.com/brand/favicons/favicon-512.png",
              "width": 512,
              "height": 512
            }
          }
        },
        {
          "@@type": "BreadcrumbList",
          "@@id": "https://avipetapp.com/blog#breadcrumb",
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
              "name": "Blog para Clínicas Veterinarias",
              "item": "https://avipetapp.com/blog"
            }
          ]
        }
      ]
    }
    </script>

    <!-- Google Tag (gtag.js) -->
    @if($gaId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $gaId }}');
    </script>
    @endif

    <link rel="icon" href="/favicon.ico" sizes="48x48">
    <link rel="icon" type="image/svg+xml" href="/brand/favicons/favicon.svg">
    <link rel="icon" type="image/png" sizes="48x48" href="/brand/favicons/favicon-48.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/brand/favicons/favicon-192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/brand/favicons/favicon-512.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/brand/favicons/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/brand/favicons/favicon-16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/brand/favicons/favicon-180.png">
    <link rel="manifest" href="/site.webmanifest">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', Arial, sans-serif; }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between bg-[#F4F7FC] text-[#15213B]">

    <!-- Header / Navbar Oficial AviPetApp -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <img src="/brand/svg/avipetapp-horizontal-fondo-claro.svg" alt="AviPetApp" class="h-8 w-auto min-w-[140px] object-contain">
                <span class="text-xs font-semibold px-2.5 py-0.5 bg-[#6D28D9]/10 text-[#6D28D9] rounded-full">Blog</span>
            </a>
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="/" class="text-xs sm:text-sm font-semibold text-[#5C6B85] hover:text-[#15213B] px-2 sm:px-3 py-1.5 transition whitespace-nowrap">← <span class="hidden sm:inline">Volver al </span>Inicio</a>
                <a href="/registro-clinica" class="text-xs sm:text-sm font-semibold bg-[#6D28D9] hover:bg-[#5b21b6] text-white px-3 sm:px-4 py-2 rounded-xl shadow-sm transition whitespace-nowrap">Crear mi clínica</a>
            </div>
        </div>
    </header>

    <!-- Hero del Blog -->
    <section class="bg-gradient-to-b from-white to-[#F4F7FC] py-12 sm:py-16 border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#6D28D9]/10 text-[#6D28D9] border border-[#6D28D9]/20 mb-4">
                📚 Guías Estratégicas · Software con IA para veterinarias
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-[#15213B] tracking-tight leading-tight mb-4">
                Estrategia, Fidelización y Rentabilidad Veterinaria
            </h1>
            <p class="text-base sm:text-lg text-[#5C6B85] max-w-2xl mx-auto leading-relaxed">
                Descubre cómo las clínicas veterinarias en Colombia organizan planes de salud para mascotas, fortalecen la relación con las familias y aprovechan herramientas inteligentes.
            </p>
        </div>
    </section>

    <!-- Artículos Listado -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-12 flex-1">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
            <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col group">
                <a href="/blog/{{ $post['slug'] }}" class="relative block overflow-hidden aspect-[16/9] bg-slate-100">
                    <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-[#15213B] text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm">
                        {{ $post['category'] }}
                    </span>
                </a>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 text-xs text-[#5C6B85] mb-2">
                            <span>{{ $post['read_time'] }}</span>
                            <span>•</span>
                            <time datetime="{{ $post['published_at'] }}">{{ date('d M, Y', strtotime($post['published_at'])) }}</time>
                        </div>
                        <h2 class="text-lg font-bold text-[#15213B] group-hover:text-[#6D28D9] transition leading-snug mb-3">
                            <a href="/blog/{{ $post['slug'] }}">
                                {{ $post['title'] }}
                            </a>
                        </h2>
                        <p class="text-xs sm:text-sm text-[#5C6B85] line-clamp-3 leading-relaxed mb-4">
                            {{ $post['excerpt'] }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-[#15213B]">{{ $post['author'] }}</span>
                        <a href="/blog/{{ $post['slug'] }}" class="text-xs font-bold text-[#6D28D9] hover:text-[#5b21b6] flex items-center gap-1">
                            Leer Guía →
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Banner CTA Final en Midnight (#080B20) y Deep Navy (#111936) -->
        <div class="mt-16 bg-gradient-to-r from-[#080B20] to-[#111936] rounded-3xl p-8 sm:p-12 text-white text-center shadow-xl border border-[#A855F7]/20">
            <h2 class="text-2xl sm:text-4xl font-black mb-4">Tu clínica, conectada con el futuro del bienestar animal.</h2>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto mb-8 leading-relaxed">
                AviPetApp ayuda a tu clínica a gestionar planes de salud para mascotas, organizar la relación con tus clientes y aprovechar herramientas inteligentes desde una sola plataforma.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/registro-clinica" class="w-full sm:w-auto px-8 py-4 bg-[#6D28D9] hover:bg-[#5b21b6] text-white font-semibold rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                    Crear mi clínica →
                </a>
                <a href="https://wa.me/573235813942?text=Hola%20AviPetApp,%20quiero%20conocer%20c%C3%B3mo%20activar%20planes%20de%20salud%20en%20mi%20veterinaria" target="_blank" class="w-full sm:w-auto px-6 py-4 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl border border-white/20 transition">
                    Hablar con el equipo
                </a>
            </div>
        </div>
    </main>

    <!-- Footer Oficial -->
    <footer class="bg-[#080B20] border-t border-[#111936] py-8 text-center text-xs text-slate-400">
        <div class="max-w-6xl mx-auto px-4 space-y-1">
            <p class="text-white font-semibold">AviPetApp · Software con IA para veterinarias</p>
            <p class="text-[#35DDF5]">Más inteligencia. Más bienestar. Más futuro.</p>
        </div>
    </footer>

</body>
</html>
