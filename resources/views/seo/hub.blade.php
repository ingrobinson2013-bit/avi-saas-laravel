<!DOCTYPE html>
<html lang="es-CO">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guías de Salud para Perros y Gatos en Colombia | AVIPET BioLab® &amp; AviPetApp</title>
    <meta name="description" content="Directorio veterinario de guías por raza y ciudad en Colombia: lamido de patas, alergia al pollo, caída de pelo, dermatitis y software veterinario.">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta name="robots" content="index, follow">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">
    <header class="bg-[#1E1446] text-white py-6 px-4">
        <div class="max-w-6xl mx-auto flex flex-wrap items-center justify-between gap-4">
            <div>
                <a href="/" class="text-xl font-black tracking-tight">AVIPET <span class="text-emerald-400">BioLab®</span></a>
                <p class="text-xs text-indigo-200 mt-0.5">Guías Clínicas por Raza, Síntoma y Ciudad en Colombia</p>
            </div>
            <a href="https://biolab.avipetapp.com/dermo-gut-superboost?utm_source=seo&utm_medium=hub" class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs px-4 py-2.5 rounded-xl">
                🚚 Ver Dermo &amp; Gut Superboost →
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8 space-y-10">
        <section class="space-y-4">
            <h1 class="text-2xl sm:text-3xl font-black text-[#1E1446]">Guías Veterinarias por Síntoma y Raza</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($symptoms as $symptom)
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 space-y-3 shadow-sm">
                        <h2 class="font-black text-base text-[#1E1446]">{{ $symptom['short'] }}</h2>
                        <ul class="space-y-1.5 text-xs font-semibold text-indigo-700">
                            @foreach($breeds as $breed)
                                <li>
                                    <a href="/salud-mascotas/{{ $symptom['slug'] }}-en-{{ $breed['slug'] }}" class="hover:underline">
                                        → {{ $symptom['short'] }} en {{ $breed['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="space-y-4">
            <h2 class="text-2xl font-black text-[#1E1446]">Envíos Contraentrega AVIPET BioLab® por Ciudad</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($cityProblems as $problem)
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 space-y-3 shadow-sm">
                        <h3 class="font-black text-sm text-[#1E1446]">{{ $problem['title'] }}</h3>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($bioLabCities as $city)
                                <a href="/salud-mascotas/colombia/{{ $problem['slug'] }}-{{ $city['slug'] }}" class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 hover:bg-emerald-100">
                                    {{ $city['name'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="space-y-4">
            <h2 class="text-2xl font-black text-[#1E1446]">Software Veterinario y Planes de Salud por Ciudad (B2B)</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($saasCities as $city)
                    <a href="/software-veterinario/{{ $city['slug'] }}" class="text-xs font-bold px-3.5 py-2 rounded-xl bg-slate-900 text-white hover:bg-slate-800">
                        Software Veterinario en {{ $city['name'] }}
                    </a>
                @endforeach
            </div>
        </section>
    </main>
</body>
</html>
