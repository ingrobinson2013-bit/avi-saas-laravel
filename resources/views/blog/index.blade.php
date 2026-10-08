<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50 text-slate-900 antialiased selection:bg-blue-600 selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    @php
        $gaId = env('GOOGLE_TAG_ID', 'G-YRPKPVXZ2T') ?: env('GOOGLE_ANALYTICS_ID', 'G-YRPKPVXZ2T');
        $canonicalUrl = 'https://avipetapp.com/blog';
    @endphp

    <title>Blog para Clínicas Veterinarias — Gestión, Rentabilidad e Ingresos Recurrentes | AVI-Plan</title>
    <meta name="description" content="Artículos, guías estratégicas y análisis de negocio para veterinarias en Colombia. Aprende a crear planes de salud preventiva, retener tutores de mascotas y facturar ingresos recurrentes.">
    <meta name="keywords" content="blog veterinaria colombia, gestion clinica veterinaria, marketing veterinario, planes de salud mascotas, rentabilidad veterinaria, software veterinario">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Open Graph -->
    <meta property="og:type" content="blog">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="Blog para Clínicas Veterinarias — Gestión e Ingresos Recurrentes | AVI-Plan">
    <meta property="og:description" content="Guías y estrategias probadas para transformar clínicas veterinarias con planes de salud y recurrencia mensual.">
    <meta property="og:image" content="{{ url('/logo-app.png') }}">
    <meta property="og:site_name" content="AVI-Plan">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Blog para Clínicas Veterinarias | AVI-Plan">
    <meta name="twitter:description" content="Guías para clínicas veterinarias: planes de bienestar, retención y tecnología SaaS.">
    <meta name="twitter:image" content="{{ url('/logo-app.png') }}">

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

    <link rel="icon" type="image/png" href="/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between bg-slate-50">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <img src="/logo-app.png" alt="AVI-Plan Logo" class="h-9 w-auto">
                <span class="font-extrabold text-lg tracking-tight text-slate-900">AVI<span class="text-blue-600">-Plan</span> <span class="text-xs font-semibold px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full ml-1">Blog</span></span>
            </a>
            <div class="flex items-center gap-3">
                <a href="/" class="text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 transition">← Volver al Inicio</a>
                <a href="/registro-clinica" class="text-xs sm:text-sm font-bold bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow-sm transition">Prueba 15 Días Gratis</a>
            </div>
        </div>
    </header>

    <!-- Hero del Blog -->
    <section class="bg-gradient-to-b from-white to-slate-50 py-12 sm:py-16 border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 mb-4">
                📚 Guías Estratégicas para Médicos Veterinarios y Directores de Clínicas
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight mb-4">
                Estrategia, Fidelización y Rentabilidad Veterinaria
            </h1>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Descubre cómo las clínicas veterinarias líderes en Colombia están transformando clientes ocasionales en comunidades fieles con ingresos mensuales fijos garantizados.
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
                    <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-slate-800 text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm">
                        {{ $post['category'] }}
                    </span>
                </a>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                            <span>{{ $post['read_time'] }}</span>
                            <span>•</span>
                            <time datetime="{{ $post['published_at'] }}">{{ date('d M, Y', strtotime($post['published_at'])) }}</time>
                        </div>
                        <h2 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition leading-snug mb-3">
                            <a href="/blog/{{ $post['slug'] }}">
                                {{ $post['title'] }}
                            </a>
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 line-clamp-3 leading-relaxed mb-4">
                            {{ $post['excerpt'] }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-700">{{ $post['author'] }}</span>
                        <a href="/blog/{{ $post['slug'] }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                            Leer Guía →
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Banner CTA Final -->
        <div class="mt-16 bg-gradient-to-r from-blue-900 to-indigo-900 rounded-3xl p-8 sm:p-12 text-white text-center shadow-xl">
            <h2 class="text-2xl sm:text-4xl font-black mb-4">¿Tienes una Veterinaria en Colombia?</h2>
            <p class="text-blue-200 text-sm sm:text-base max-w-2xl mx-auto mb-8 leading-relaxed">
                Crea tus propios planes de salud para mascotas con tu propia marca en menos de 10 minutos. Automatiza el cobro de membresías mensuales y fideliza a tus clientes con carnet digital.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/registro-clinica" class="w-full sm:w-auto px-8 py-4 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                    Crear mi Cuenta Gratis (15 Días) →
                </a>
                <a href="https://wa.me/573235813942?text=Hola%20AVI-Plan,%20quiero%20conocer%20c%C3%B3mo%20activar%20planes%20en%20mi%20veterinaria" target="_blank" class="w-full sm:w-auto px-6 py-4 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl border border-white/20 transition">
                    Hablar con un Especialista
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 text-center text-xs text-slate-500">
        <div class="max-w-6xl mx-auto px-4">
            <p>© {{ date('Y') }} AVI-Plan · Plataforma SaaS de Planes de Salud Preventiva para Clínicas Veterinarias en Colombia.</p>
        </div>
    </footer>

</body>
</html>
