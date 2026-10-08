<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50 text-slate-900 antialiased selection:bg-blue-600 selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    @php
        $gaId = env('GOOGLE_TAG_ID', 'G-YRPKPVXZ2T') ?: env('GOOGLE_ANALYTICS_ID', 'G-YRPKPVXZ2T');
        $canonicalUrl = "https://avipetapp.com/blog/{$post['slug']}";
    @endphp

    <title>{{ $post['title'] }} | Blog AVI-Plan</title>
    <meta name="description" content="{{ $post['excerpt'] }}">
    <meta name="keywords" content="{{ implode(', ', $post['keywords']) }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Open Graph / WhatsApp / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $post['title'] }}">
    <meta property="og:description" content="{{ $post['excerpt'] }}">
    <meta property="og:image" content="{{ $post['image'] }}">
    <meta property="og:site_name" content="AVI-Plan">
    <meta property="article:published_time" content="{{ $post['published_at'] }}">
    <meta property="article:modified_time" content="{{ $post['updated_at'] }}">
    <meta property="article:section" content="{{ $post['category'] }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post['title'] }}">
    <meta name="twitter:description" content="{{ $post['excerpt'] }}">
    <meta name="twitter:image" content="{{ $post['image'] }}">

    <!-- Schema.org JSON-LD Enriquecido para Google Article / BlogPosting -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BlogPosting",
      "mainEntityOfPage": {
        "@@type": "WebPage",
        "@@id": "{{ $canonicalUrl }}"
      },
      "headline": "{{ $post['title'] }}",
      "description": "{{ $post['excerpt'] }}",
      "image": "{{ $post['image'] }}",
      "author": {
        "@@type": "Person",
        "name": "{{ $post['author'] }}",
        "jobTitle": "{{ $post['author_role'] }}"
      },
      "publisher": {
        "@@type": "Organization",
        "name": "AVI-Plan",
        "logo": {
          "@@type": "ImageObject",
          "url": "https://avipetapp.com/logo-app.png"
        }
      },
      "datePublished": "{{ $post['published_at'] }}",
      "dateModified": "{{ $post['updated_at'] }}"
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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <img src="/logo-app.png" alt="AVI-Plan Logo" class="h-9 w-auto">
                <span class="font-extrabold text-lg tracking-tight text-slate-900">AVI<span class="text-blue-600">-Plan</span></span>
            </a>
            <div class="flex items-center gap-3">
                <a href="/blog" class="text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 transition">← Ver más Guías</a>
                <a href="/registro-clinica" class="text-xs sm:text-sm font-bold bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow-sm transition">Probar Gratis</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-6">
            <a href="/" class="hover:text-slate-900">Inicio</a>
            <span>/</span>
            <a href="/blog" class="hover:text-slate-900">Blog</a>
            <span>/</span>
            <span class="text-slate-900 truncate max-w-[200px] sm:max-w-md">{{ $post['category'] }}</span>
        </nav>

        <!-- Article Header -->
        <header class="mb-8">
            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-extrabold px-3 py-1 rounded-full mb-3">
                {{ $post['category'] }}
            </span>
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-950 tracking-tight leading-tight mb-4">
                {{ $post['title'] }}
            </h1>
            <div class="flex flex-wrap items-center gap-4 text-xs sm:text-sm text-slate-600 py-3 border-y border-slate-200">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-black flex items-center justify-center text-xs">
                        AVI
                    </div>
                    <div>
                        <div class="font-bold text-slate-900">{{ $post['author'] }}</div>
                        <div class="text-xs text-slate-500">{{ $post['author_role'] }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 ml-auto text-xs text-slate-500">
                    <span>⏱️ {{ $post['read_time'] }}</span>
                    <span>•</span>
                    <time datetime="{{ $post['published_at'] }}">📅 {{ date('d F, Y', strtotime($post['published_at'])) }}</time>
                </div>
            </div>
        </header>

        <!-- Featured Image -->
        <div class="rounded-2xl overflow-hidden aspect-[16/9] mb-10 shadow-md">
            <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover">
        </div>

        <!-- Article Body -->
        <article class="bg-white rounded-3xl p-6 sm:p-12 border border-slate-200 shadow-sm text-slate-800 leading-relaxed text-base sm:text-lg">
            {!! $post['content'] !!}
        </article>

        <!-- Share & Author Box -->
        <div class="mt-8 bg-white border border-slate-200 rounded-2xl p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 font-extrabold flex items-center justify-center text-sm">
                    NODIA
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">Escrito por Robinson R. y el equipo de NODIA</h4>
                    <p class="text-xs text-slate-500">Especialistas en arquitectura SaaS y soluciones digitales para el sector veterinario en Colombia.</p>
                </div>
            </div>
            <a href="https://wa.me/573508742543?text=Hola%20Robinson,%20le%C3%AD%20el%20art%C3%ADculo%20sobre%20{{ urlencode($post['title']) }}%20y%20quiero%20conocer%20m%C3%A1s" target="_blank" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs rounded-xl shadow transition">
                Consultar por WhatsApp
            </a>
        </div>

        <!-- Artículos Relacionados -->
        @if(count($relatedPosts) > 0)
        <section class="mt-16">
            <h3 class="text-xl sm:text-2xl font-black text-slate-900 mb-6">Artículos Recomendados</h3>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($relatedPosts as $rel)
                <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:shadow-md transition">
                    <span class="text-xs font-bold text-blue-600 uppercase">{{ $rel['category'] }}</span>
                    <h4 class="text-base font-bold text-slate-900 mt-1 mb-2">
                        <a href="/blog/{{ $rel['slug'] }}" class="hover:text-blue-600">
                            {{ $rel['title'] }}
                        </a>
                    </h4>
                    <p class="text-xs text-slate-600 line-clamp-2 mb-3">{{ $rel['excerpt'] }}</p>
                    <a href="/blog/{{ $rel['slug'] }}" class="text-xs font-bold text-blue-600 flex items-center gap-1">
                        Leer artículo →
                    </a>
                </div>
                @endforeach
            </div>
        </section>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 text-center text-xs text-slate-500">
        <div class="max-w-4xl mx-auto px-4">
            <p>© {{ date('Y') }} AVI-Plan · Potenciando clínicas veterinarias en Colombia con planes de salud y cobro recurrente.</p>
        </div>
    </footer>

</body>
</html>
