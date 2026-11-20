@php
    $pageTitle = "Software Veterinario en {$city['name']} ({$city['department']}) — Planes de Salud y Carnet QR | AviPetApp";
    $metaDesc = "Programa para clínicas veterinarias en {$city['name']}: aumenta la retención de clientes con planes de salud preventivos, carnet de vacunación digital QR y página web propia.";
    $faqs = [
        [
            'q' => "¿Cómo ayuda AviPetApp a mejorar la retención de clientes en clínicas veterinarias de {$city['name']}?",
            'a' => "Permite lanzar planes de salud preventivos mensuales (desde {$city['avg_plan_cop']}/mes en promedio en {$city['name']}), automatizar recordatorios de vacunas y entregar un carnet digital QR con la marca de tu clínica.",
        ],
        [
            'q' => "¿Necesito instalar servidores o pagar licencias costosas?",
            'a' => "No. AviPetApp funciona 100% en la nube desde celular o computador y puedes crear el portal de tu clínica veterinaria en {$city['name']} gratis en menos de 5 minutos.",
        ],
        [
            'q' => "¿Incluye página web posicionada en Google para mi veterinaria en {$city['name']}?",
            'a' => "Sí. Cada clínica recibe su propio subdominio o dominio conectado con SEO local optimizado para aparecer cuando dueños de mascotas buscan veterinarias en {$city['name']}.",
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="es-CO">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
    <script src="https://cdn.tailwindcss.com"></script>

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'SoftwareApplication',
        'name' => "AviPetApp — Software Veterinario en {$city['name']}",
        'applicationCategory' => 'BusinessApplication',
        'operatingSystem' => 'Web, Android, iOS',
        'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'COP'],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn ($f) => [
            '@type' => 'Question',
            'name' => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], $faqs),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased">
    <header class="border-b border-white/10 bg-slate-900/90 sticky top-0 z-30">
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="/" class="font-black text-lg text-white">AviPet<span class="text-emerald-400">App</span></a>
            <a href="/crear-clinica-veterinaria-gratis" class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs px-4 py-2.5 rounded-xl transition">
                Crear Clínica Gratis →
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-10 space-y-8">
        <section class="space-y-4">
            <span class="inline-block bg-emerald-500/15 border border-emerald-400/30 text-emerald-300 text-xs font-extrabold px-3 py-1 rounded-full">
                Software para Clínicas Veterinarias en {{ $city['name'] }}, {{ $city['department'] }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-white leading-tight">
                Software Veterinario y Planes de Salud Preventiva en {{ $city['name'] }}
            </h1>
            <p class="text-base sm:text-lg text-slate-300 leading-relaxed">
                {{ $city['market_note'] }}
            </p>
            <div class="flex flex-wrap gap-3 pt-2">
                <a href="/crear-clinica-veterinaria-gratis" class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-sm px-6 py-3.5 rounded-2xl shadow-lg transition">
                    🚀 Probar AviPetApp Gratis en {{ $city['name'] }}
                </a>
                <a href="/software-planes-salud-veterinaria" class="bg-white/10 hover:bg-white/15 text-white font-bold text-sm px-5 py-3.5 rounded-2xl transition">
                    Ver Planes Preventivos
                </a>
            </div>
        </section>

        <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-slate-900 border border-white/10 rounded-2xl p-5">
                <p class="text-xs font-bold text-emerald-400 uppercase">Retención de Clientes</p>
                <p class="text-2xl font-black text-white mt-1">{{ $city['avg_plan_cop'] }}/mes</p>
                <p class="text-xs text-slate-400 mt-1">Ticket promedio de plan preventivo mensual en {{ $city['name'] }}.</p>
            </div>
            <div class="bg-slate-900 border border-white/10 rounded-2xl p-5">
                <p class="text-xs font-bold text-cyan-400 uppercase">Carnet Digital QR</p>
                <p class="text-2xl font-black text-white mt-1">100% Móvil</p>
                <p class="text-xs text-slate-400 mt-1">Historial de vacunas, desparasitación y canjes desde el celular del tutor.</p>
            </div>
            <div class="bg-slate-900 border border-white/10 rounded-2xl p-5">
                <p class="text-xs font-bold text-amber-400 uppercase">SEO Local Incluido</p>
                <p class="text-2xl font-black text-white mt-1">Google Top</p>
                <p class="text-xs text-slate-400 mt-1">Portal web propio optimizado para búsquedas de veterinarias en {{ $city['name'] }}.</p>
            </div>
        </section>

        <section class="bg-slate-900 border border-white/10 rounded-3xl p-6 space-y-4">
            <h2 class="text-xl font-black text-white">Preguntas Frecuentes — Veterinarias en {{ $city['name'] }}</h2>
            <div class="space-y-3">
                @foreach($faqs as $faq)
                    <div class="bg-slate-950/70 border border-white/10 rounded-2xl p-4">
                        <h3 class="font-bold text-white text-sm">{{ $faq['q'] }}</h3>
                        <p class="text-sm text-slate-300 mt-1">{{ $faq['a'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="bg-slate-900/60 border border-white/10 rounded-3xl p-6 space-y-3">
            <h2 class="text-sm font-black text-slate-300 uppercase">Otras Ciudades de Colombia</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($other_cities as $oc)
                    <a href="/software-veterinario/{{ $oc['slug'] }}" class="text-xs font-bold px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/20 text-slate-200">
                        Software Veterinario {{ $oc['name'] }}
                    </a>
                @endforeach
            </div>
        </section>
    </main>
</body>
</html>
