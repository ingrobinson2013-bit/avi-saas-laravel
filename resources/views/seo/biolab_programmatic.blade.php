@php
    $isBreed = ($mode ?? 'breed') === 'breed';
    if ($isBreed) {
        $pageTitle = "{$symptom['title_prefix']} en {$breed['name']}: Causas, Dosis y Solución | AVIPET BioLab® Colombia";
        $metaDesc = "{$symptom['short']} en {$breed['name']} ({$breed['weight_range']}): {$symptom['meta_hook']} Envío gratis y pago contraentrega en Colombia.";
        $h1 = "{$symptom['title_prefix']} en {$breed['name']}";
        $subjectName = $breed['name'];
    } else {
        $pageTitle = "{$problem['title']} en {$city['name']} ({$city['department']}) — Envío Gratis | AVIPET BioLab®";
        $metaDesc = "Compra Dermo & Gut Superboost en {$city['name']} con envío gratis y pago contraentrega ({$city['delivery_eta']}). {$symptom['meta_hook']}";
        $h1 = "{$problem['title']} en {$city['name']}";
        $subjectName = $city['name'];
    }

    $faqs = $isBreed ? [
        [
            'q' => "¿Cuál es la dosis de Dermo & Gut Superboost para un {$breed['name']}?",
            'a' => "Para un {$breed['name']} con peso típico de {$breed['weight_range']}, la dosis recomendada es {$breed['scoop_label']}. Una bolsa de 250g rinde {$breed['days_per_bag']}.",
        ],
        [
            'q' => "¿Es en pastillas o en polvo? ¿Qué pasa si mi {$breed['name']} es resabiado?",
            'a' => "Es un suplemento en polvo bio-activo (no son pastillas). Para que tu {$breed['name']} se lo coma garantizado, mezcla la dosis con un poquito de agua tibia o caldito sin sal hasta formar una salsita irresistible sobre su alimento diario.",
        ],
        [
            'q' => "¿En cuánto tiempo se ven resultados en {$symptom['keyword']}?",
            'a' => "Entre los días 7 y 14 suele notarse mejoría digestiva y menor enrojecimiento; a partir del día 21–30 se reduce visiblemente la picazón, el lamido de patas y la caída excesiva de pelo.",
        ],
        [
            'q' => "¿Tienen envío gratis y pago contraentrega en Colombia?",
            'a' => "Sí. Despachamos a toda Colombia con envío gratis y pagas en efectivo o transferencia (Nequi/Bancolombia) al recibir el paquete en tu casa.",
        ],
    ] : [
        [
            'q' => "¿Cuánto tarda el envío contraentrega a {$city['name']}?",
            'a' => "El envío a {$city['name']} ({$city['department']}) es gratis y tiene un tiempo estimado de entrega de {$city['delivery_eta']}. Pagas solo cuando recibes el paquete en tu puerta.",
        ],
        [
            'q' => "¿Cómo se administra Dermo & Gut Superboost?",
            'a' => "Viene en presentación de Polvo Bio-Activo de 250g con cuchara dosificadora (no son pastillas). Se mezcla con un poquito de agua o directamente en su comida para que se lo coma garantizado.",
        ],
        [
            'q' => "¿Sirve para perros con alergia al pollo en {$city['name']}?",
            'a' => "Sí. Su fórmula es 100% libre de pollo, res, lácteos, gluten y soya, diseñada específicamente para mascotas con piel sensible, pododermatitis y alergias alimentarias.",
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
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:site_name" content="AVIPET BioLab® Colombia">
    <script src="https://cdn.tailwindcss.com"></script>

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'AviPetApp', 'item' => 'https://avipetapp.com/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Guías de Salud para Mascotas', 'item' => 'https://avipetapp.com/salud-mascotas'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $h1, 'item' => $canonicalUrl],
        ],
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

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => 'AVIPET BioLab® Dermo & Gut Superboost (250g)',
        'description' => 'Suplemento nutricional biotecnológico 3 en 1 en polvo bio-activo hipoalergénico para piel, patas, pelaje y digestión de perros y gatos.',
        'brand' => ['@type' => 'Brand', 'name' => 'AVIPET BioLab®'],
        'offers' => [
            '@type' => 'Offer',
            'priceCurrency' => 'COP',
            'price' => '69900',
            'availability' => 'https://schema.org/InStock',
            'url' => 'https://biolab.avipetapp.com/dermo-gut-superboost',
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased pb-24">
    <div class="bg-[#1E1446] text-white text-center py-2 px-3 text-xs font-bold">
        🇨🇴 ENVÍO GRATIS EN TODA COLOMBIA • 🤝 PAGAS CONTRAENTREGA AL RECIBIR EN CASA
    </div>

    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-5xl mx-auto px-4 h-14 flex items-center justify-between gap-3">
            <a href="/salud-mascotas" class="font-black text-base text-[#1E1446] tracking-tight">
                AVIPET <span class="text-cyan-700">BioLab®</span>
            </a>
            <a href="{{ $ctaUrl }}" class="bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs px-3.5 py-2 rounded-xl shadow transition">
                🚚 Pedir Contraentrega ($69.900)
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-8 space-y-8">
        <nav class="text-xs text-slate-500 font-semibold flex flex-wrap items-center gap-1.5">
            <a href="/" class="hover:text-indigo-700">Inicio</a>
            <span>/</span>
            <a href="/salud-mascotas" class="hover:text-indigo-700">Guías de Salud</a>
            <span>/</span>
            <span class="text-slate-800">{{ $subjectName }}</span>
        </nav>

        <article class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-900 px-3 py-1 rounded-full text-xs font-extrabold">
                <span>🔬 Guía Veterinaria Colombia 2026</span>
                <span>•</span>
                <span>0% Pollo • Polvo Bio-Activo</span>
            </div>

            <h1 class="text-2xl sm:text-4xl font-black text-[#1E1446] leading-tight">
                {{ $h1 }}
            </h1>

            <p class="text-base text-slate-700 leading-relaxed">
                @if($isBreed)
                    {{ $breed['predisposition'] }} {{ $symptom['root_cause'] }}
                @else
                    {{ $city['climate_factor'] }} {{ $symptom['root_cause'] }}
                @endif
            </p>

            {{-- Tarjeta Destacada: Dosis / Entrega --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 bg-indigo-50/70 border border-indigo-200 rounded-2xl p-4">
                @if($isBreed)
                    <div>
                        <p class="text-[11px] font-bold uppercase text-indigo-700">Peso típico {{ $breed['name'] }}</p>
                        <p class="text-base font-black text-slate-900">{{ $breed['weight_range'] }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase text-indigo-700">Dosis recomendada</p>
                        <p class="text-sm font-black text-slate-900">{{ $breed['scoop_label'] }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase text-indigo-700">Rendimiento</p>
                        <p class="text-sm font-black text-emerald-800">{{ $breed['days_per_bag'] }}</p>
                    </div>
                @else
                    <div>
                        <p class="text-[11px] font-bold uppercase text-indigo-700">Entrega en {{ $city['name'] }}</p>
                        <p class="text-base font-black text-slate-900">{{ $city['delivery_eta'] }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase text-indigo-700">Modalidad de pago</p>
                        <p class="text-sm font-black text-emerald-800">Contraentrega + Envío Gratis</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase text-indigo-700">Presentación</p>
                        <p class="text-sm font-black text-slate-900">Polvo Bio-Activo 250g (50 dosis)</p>
                    </div>
                @endif
            </div>

            {{-- Señales de alerta --}}
            <section class="space-y-3">
                <h2 class="text-xl font-black text-[#1E1446]">
                    Señales de alerta de {{ $symptom['keyword'] }} en {{ $subjectName }}
                </h2>
                <ul class="space-y-2">
                    @foreach($symptom['signs'] as $sign)
                        <li class="flex items-start gap-2.5 text-sm sm:text-base text-slate-700">
                            <span class="text-emerald-600 font-black mt-0.5">✓</span>
                            <span>{{ $sign }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>

            {{-- Protocolo en 3 pasos --}}
            <section class="space-y-3">
                <h2 class="text-xl font-black text-[#1E1446]">
                    Protocolo práctico en casa (3 pasos)
                </h2>
                <ol class="space-y-2.5">
                    @foreach($symptom['protocol'] as $idx => $step)
                        <li class="flex items-start gap-3 bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-sm sm:text-base text-slate-800">
                            <span class="h-6 w-6 rounded-full bg-[#1E1446] text-white text-xs font-black flex items-center justify-center shrink-0">{{ $idx + 1 }}</span>
                            <span>{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>
            </section>

            {{-- Aviso clave de mezcla con agua --}}
            <div class="bg-amber-50 border-2 border-amber-300 rounded-2xl p-4 text-sm text-amber-950">
                <strong>🥄 Tip de palatabilidad garantizada:</strong> <strong>Dermo &amp; Gut Superboost®</strong> viene en <strong>Polvo Bio-Activo (no son pastillas)</strong>. Mézclalo con un poquito de agua tibia sobre su concentrado para formar una salsita irresistible que incluso las mascotas más resabiadas se comen al instante.
            </div>

            {{-- Bloque CTA principal --}}
            <div class="bg-gradient-to-br from-[#1E1446] to-[#2D1B69] text-white rounded-3xl p-6 sm:p-8 text-center space-y-4 shadow-xl">
                <span class="inline-block bg-amber-400 text-slate-950 text-xs font-black px-3 py-1 rounded-full">
                    🔥 OFERTA COLOMBIA • ENVÍO GRATIS + CONTRAENTREGA
                </span>
                <h2 class="text-xl sm:text-2xl font-black">
                    Alivia {{ $symptom['short'] }} con DERMO &amp; GUT SUPERBOOST®
                </h2>
                <p class="text-sm text-indigo-100 max-w-2xl mx-auto">
                    Fórmula 3 en 1 hipoalergénica (0% pollo, 0% granos) con Ácido Láurico Dermo-Activo, Omega 3-6-9 y Prebióticos Gut-Care®. Incluye Guía Clínica PDF y acceso a Comunidad con Médica Veterinaria.
                </p>
                <div class="pt-1 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ $ctaUrl }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-sm sm:text-base px-6 py-3.5 rounded-2xl shadow-lg transition">
                        <span>🚚 PEDIR AHORA CONTRAENTREGA ($69.900 COP) →</span>
                    </a>
                    <a href="https://wa.me/573235813942?text={{ rawurlencode('Hola AVIPET BioLab®, estoy leyendo sobre ' . $h1 . ' y quiero pedir Dermo & Gut Superboost ($69.900 envío gratis contraentrega).') }}" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-emerald-200 border border-emerald-400/40 font-black text-sm px-5 py-3.5 rounded-2xl transition">
                        <span>📲 Pedir por WhatsApp</span>
                    </a>
                </div>
            </div>

            {{-- Preguntas Frecuentes --}}
            <section class="space-y-3 pt-2">
                <h2 class="text-xl font-black text-[#1E1446]">Preguntas Frecuentes</h2>
                <div class="space-y-3">
                    @foreach($faqs as $faq)
                        <div class="border border-slate-200 rounded-2xl p-4 bg-slate-50">
                            <h3 class="font-extrabold text-sm sm:text-base text-slate-900">{{ $faq['q'] }}</h3>
                            <p class="text-sm text-slate-700 mt-1.5 leading-relaxed">{{ $faq['a'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        </article>

        {{-- Enlazado interno programático --}}
        <section class="bg-white rounded-3xl border border-slate-200 p-6 space-y-4">
            <h2 class="text-base font-black text-[#1E1446]">Guías Relacionadas en AVIPET BioLab®</h2>
            <div class="flex flex-wrap gap-2">
                @if($isBreed)
                    @foreach($related_symptoms as $rs)
                        <a href="/salud-mascotas/{{ $rs['slug'] }}-en-{{ $breed['slug'] }}" class="text-xs font-bold px-3 py-1.5 rounded-full bg-indigo-50 text-indigo-800 hover:bg-indigo-100">
                            {{ $rs['short'] }} en {{ $breed['name'] }}
                        </a>
                    @endforeach
                    @foreach($related_breeds as $rb)
                        <a href="/salud-mascotas/{{ $symptom['slug'] }}-en-{{ $rb['slug'] }}" class="text-xs font-bold px-3 py-1.5 rounded-full bg-slate-100 text-slate-800 hover:bg-slate-200">
                            {{ $symptom['short'] }} en {{ $rb['name'] }}
                        </a>
                    @endforeach
                @else
                    @foreach($related_problems as $rp)
                        <a href="/salud-mascotas/colombia/{{ $rp['slug'] }}-{{ $city['slug'] }}" class="text-xs font-bold px-3 py-1.5 rounded-full bg-indigo-50 text-indigo-800 hover:bg-indigo-100">
                            {{ $rp['title'] }} en {{ $city['name'] }}
                        </a>
                    @endforeach
                    @foreach($related_cities as $rc)
                        <a href="/salud-mascotas/colombia/{{ $problem['slug'] }}-{{ $rc['slug'] }}" class="text-xs font-bold px-3 py-1.5 rounded-full bg-slate-100 text-slate-800 hover:bg-slate-200">
                            {{ $problem['title'] }} en {{ $rc['name'] }}
                        </a>
                    @endforeach
                @endif
            </div>
        </section>
    </main>

    {{-- Sticky Mobile CTA --}}
    <div class="fixed bottom-0 inset-x-0 bg-slate-950/95 backdrop-blur border-t-2 border-emerald-400/60 p-2.5 z-40 sm:hidden">
        <div class="flex items-center gap-2">
            <a href="{{ $ctaUrl }}" class="flex-1 text-center bg-emerald-400 hover:bg-emerald-300 text-slate-950 font-black text-xs py-3 px-3 rounded-xl shadow-lg">
                🚚 Pedir Hoy ($69.900)
            </a>
            <a href="https://wa.me/573235813942?text={{ rawurlencode('Hola AVIPET BioLab®, estoy leyendo sobre ' . $h1 . ' y quiero pedir Dermo & Gut Superboost ($69.900 contraentrega).') }}" target="_blank" rel="noopener noreferrer" class="shrink-0 text-center bg-emerald-700 hover:bg-emerald-600 text-white font-black text-xs py-3 px-3.5 rounded-xl border border-emerald-400/40 shadow-lg">
                📲 WhatsApp
            </a>
        </div>
    </div>
</body>
</html>
