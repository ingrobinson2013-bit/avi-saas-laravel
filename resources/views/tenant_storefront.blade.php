<!DOCTYPE html>
<html lang="es" class="h-full bg-white text-slate-900 antialiased selection:bg-sky-500 selection:text-white overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>{{ $tenant->name }} — Cuidado preventivo inteligente para tu mascota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @php
        $primaryColor = $tenant->branding['primary_color'] ?? '#0284c7';
        $secondaryColor = $tenant->branding['secondary_color'] ?? '#0f172a';
        $logoUrl = $tenant->branding['logo_url'] ?? null;
        $heroImage = $tenant->branding['hero_image_url'] ?? 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?w=700&auto=format&fit=crop&q=80';
        $bannerImage = $tenant->branding['banner_image_url'] ?? 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=1000';
        $bannerVideo = $tenant->branding['banner_video_url'] ?? null;
    @endphp

    <style>
        :root {
            --brand-primary: {{ $primaryColor }};
            --brand-secondary: {{ $secondaryColor }};
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { background: radial-gradient(circle at 80% 20%, {{ $primaryColor }}25 0%, #f0fdfa30 45%, rgba(255, 255, 255, 0) 75%); }
        .bg-brand-primary { background-color: var(--brand-primary); }
        .bg-brand-secondary { background-color: var(--brand-secondary); }
        .text-brand-primary { color: var(--brand-primary); }
        .border-brand-primary { border-color: var(--brand-primary); }
        .carnet-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            transform-style: preserve-3d;
        }
        .shimmer-badge {
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between bg-white overflow-x-hidden">

    <!-- 1. TOP BAR DINÁMICA -->
    <div class="bg-brand-secondary text-white text-xs font-semibold py-2 px-3 sm:px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-1.5 sm:gap-2 text-center sm:text-left">
            <div class="flex items-center space-x-2 text-sky-100 text-[11px] sm:text-xs">
                <span class="animate-bounce">🐾</span>
                <span>Planes de Bienestar y Prevención • Personaliza tu carnet digital en vivo</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}" target="_blank" class="flex items-center space-x-1.5 hover:opacity-90 transition-opacity text-[11px] sm:text-xs">
                    <svg class="w-3.5 h-3.5 fill-current text-sky-400" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                    </svg>
                    <span>Línea Oficial:</span>
                    <span class="text-white font-bold">{{ $tenant->branding['phone'] ?? '350 874 2543' }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. NAVBAR -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-2">
            <div class="flex items-center space-x-2 sm:space-x-3 min-w-0">
                @if(!empty($logoUrl))
                    <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="h-9 sm:h-12 max-h-14 w-auto object-contain rounded-lg shadow-sm shrink-0" loading="lazy">
                @else
                    <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-brand-primary flex items-center justify-center text-white text-lg sm:text-xl shadow-md shrink-0">
                        🐾
                    </div>
                @endif
                <div class="min-w-0">
                    <span class="text-sm sm:text-lg lg:text-xl font-extrabold tracking-tight text-slate-900 truncate block">{{ $tenant->name }}</span>
                    <span class="inline-block px-2 py-0.5 text-[9px] sm:text-xs font-semibold rounded-full truncate" style="background-color: {{ $primaryColor }}15; color: {{ $primaryColor }};">{{ $tenant->branding['city'] ?? 'Cajicá' }}</span>
                </div>
            </div>

            <nav class="hidden md:flex items-center space-x-7 text-sm font-semibold text-slate-600">
                <a href="#planes" class="hover:text-brand-primary transition-colors">Planes</a>
                <a href="#calculadora" class="hover:text-brand-primary transition-colors flex items-center space-x-1">
                    <span>🧮 Calculadora de Ahorro</span>
                    <span class="bg-amber-100 text-amber-800 text-[9px] font-bold px-1.5 py-0.5 rounded-full">Nuevo</span>
                </a>
                <a href="#beneficios" class="hover:text-brand-primary transition-colors">Beneficios</a>
                <a href="#faq" class="hover:text-brand-primary transition-colors">Preguntas</a>
            </nav>

            <div class="flex items-center space-x-2 sm:space-x-3 shrink-0">
                <a href="/v/{{ $tenant->slug }}/admin" class="hidden sm:inline-block px-3.5 sm:px-4 py-2 text-xs sm:text-sm font-bold text-slate-700 hover:text-slate-900 border border-slate-200 rounded-full hover:bg-slate-50 transition-all">
                    Panel
                </a>
                <a href="#planes" class="px-3.5 sm:px-5 py-2 text-xs sm:text-sm font-bold text-white bg-brand-primary hover:opacity-90 rounded-full shadow-md transition-all whitespace-nowrap">
                    Ver planes
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- 3. HERO INTERACTIVO CON SIMULADOR DE CARNET DIGITAL 3D -->
        <section class="hero-gradient relative pt-8 sm:pt-12 pb-16 sm:pb-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- COLUMNA IZQUIERDA: MENSAJE + INTERACTIVIDAD INICIAL -->
                    <div class="lg:col-span-7 space-y-5 sm:space-y-6">
                        <div class="inline-flex items-center space-x-2.5 sm:space-x-3 bg-white px-3 sm:px-3.5 py-1.5 rounded-full shadow-sm border border-slate-100">
                            <div class="flex -space-x-2 overflow-hidden">
                                <img class="inline-block h-5 w-5 sm:h-6 sm:w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" alt=""/>
                                <img class="inline-block h-5 w-5 sm:h-6 sm:w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt=""/>
                                <img class="inline-block h-5 w-5 sm:h-6 sm:w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt=""/>
                            </div>
                            <div class="flex items-center space-x-1 text-amber-400 text-xs">
                                <span>★★★★★</span>
                            </div>
                            <span class="text-[11px] sm:text-xs font-bold text-slate-700">+450 mascotas protegidas</span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                            Cuidado preventivo <span class="text-brand-primary underline decoration-sky-300">inteligente</span> para tu mascota
                        </h1>

                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl font-normal">
                            Planes de bienestar y salud preventiva diseñados por veterinarios para garantizar consultas, vacunas, chequeos y ahorro real en <strong class="text-slate-800">{{ $tenant->name }}</strong>.
                        </p>

                        <!-- MINI SIMULADOR INTERACTIVO DEL CARNET EN EL HERO -->
                        <div class="bg-white/80 backdrop-blur-md p-4 rounded-2xl border border-slate-200 shadow-sm space-y-3 max-w-xl">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                    <span>✨</span> Personaliza el carnet de tu mascota:
                                </span>
                                <span class="text-[10px] text-sky-600 font-bold bg-sky-50 px-2 py-0.5 rounded-full">En vivo ⚡</span>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nombre</label>
                                    <input type="text" id="live-pet-name" value="Max" oninput="updateLiveCarnet()" placeholder="Ej. Lucas" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Especie</label>
                                    <div class="flex bg-slate-100 p-0.5 rounded-xl border border-slate-200">
                                        <button type="button" onclick="setLivePetType('dog')" id="btn-pet-dog" class="flex-1 py-1.5 text-xs font-bold rounded-lg transition bg-white text-slate-900 shadow-sm text-center">
                                            🐶 Perro
                                        </button>
                                        <button type="button" onclick="setLivePetType('cat')" id="btn-pet-cat" class="flex-1 py-1.5 text-xs font-bold rounded-lg transition text-slate-500 hover:text-slate-900 text-center">
                                            🐱 Gato
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Raza</label>
                                    <input type="text" id="live-pet-breed" value="Golden Retriever" oninput="updateLiveCarnet()" placeholder="Ej. Criollo" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                            <a href="#planes" class="px-6 sm:px-7 py-3.5 rounded-full bg-brand-primary text-white font-bold text-xs sm:text-sm shadow-lg hover:opacity-90 transition-all flex items-center justify-center space-x-2 text-center">
                                <span>Ver Planes y Precios</span>
                                <span>›</span>
                            </a>
                            <a href="#calculadora" class="px-5 sm:px-6 py-3.5 rounded-full bg-white hover:bg-slate-50 text-slate-800 font-bold text-xs sm:text-sm border border-slate-200 shadow-sm transition-all flex items-center justify-center space-x-2 text-center">
                                <span>🧮 Calcular Mi Ahorro Anual</span>
                            </a>
                        </div>
                    </div>

                    <!-- COLUMNA DERECHA: CARNET DIGITAL 3D HOLOGRÁFICO EN VIVO -->
                    <div class="lg:col-span-5 relative mt-4 lg:mt-0">
                        <div class="mx-auto max-w-sm sm:max-w-md space-y-4">
                            
                            <!-- CARNET DIGITAL INTERACTIVO -->
                            <div id="live-carnet-card" class="carnet-card rounded-3xl p-6 text-white shadow-2xl relative overflow-hidden border border-white/20 select-none" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
                                
                                <!-- Decorative circles -->
                                <div class="absolute -right-10 -top-10 w-36 h-36 rounded-full bg-white/10 pointer-events-none"></div>
                                <div class="absolute -left-10 -bottom-10 w-28 h-28 rounded-full bg-white/5 pointer-events-none"></div>

                                <div class="relative z-10 space-y-4">
                                    <!-- Header Carnet -->
                                    <div class="flex items-center justify-between border-b border-white/15 pb-3">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xl">🐾</span>
                                            <div>
                                                <p class="text-[9px] font-black uppercase tracking-widest text-sky-200">{{ $tenant->name }}</p>
                                                <p class="text-xs font-extrabold text-white">Carnet Digital de Afiliado</p>
                                            </div>
                                        </div>
                                        <span class="px-2.5 py-0.5 bg-emerald-400/20 text-emerald-300 border border-emerald-300/30 text-[9px] font-black rounded-full uppercase tracking-wider">
                                            ● ACTIVO 2026
                                        </span>
                                    </div>

                                    <!-- Pet Info Display -->
                                    <div class="flex items-center justify-between pt-1">
                                        <div class="space-y-0.5">
                                            <p class="text-[9px] uppercase tracking-wider text-white/60 font-bold">Paciente</p>
                                            <h3 id="card-pet-name" class="text-2xl sm:text-3xl font-black tracking-tight text-white uppercase">MAX</h3>
                                            <p id="card-pet-breed" class="text-xs text-sky-100 font-medium">Golden Retriever • Canino</p>
                                        </div>
                                        <div id="card-pet-emoji" class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center text-3xl shadow-inner border border-white/20">
                                            🐕
                                        </div>
                                    </div>

                                    <!-- Plan and Contract Info -->
                                    <div class="grid grid-cols-2 gap-3 pt-2 bg-black/20 p-3 rounded-2xl border border-white/10">
                                        <div>
                                            <p class="text-[8px] uppercase tracking-wider text-white/60 font-bold">Membresía</p>
                                            <p id="card-plan-name" class="text-xs font-black text-amber-300">Plan Patitas Básico</p>
                                        </div>
                                        <div>
                                            <p class="text-[8px] uppercase tracking-wider text-white/60 font-bold">Contrato Digital</p>
                                            <p id="card-contract-id" class="text-xs font-mono font-bold text-white">VP-2026-8842</p>
                                        </div>
                                    </div>

                                    <!-- QR & Chip Footer -->
                                    <div class="flex items-center justify-between pt-1 text-[10px] text-white/70">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-7 h-5 rounded bg-amber-400/80 border border-amber-300 flex items-center justify-center text-[7px] font-black text-slate-900">
                                                CHIP
                                            </div>
                                            <span>Validación inmediata en recepción</span>
                                        </div>
                                        <span class="font-mono text-[9px] text-white/50">AVI-SaaS</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Micro-interacción: Estado de Afiliación -->
                            <div class="bg-white p-3.5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between text-xs">
                                <div class="flex items-center space-x-2.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                                    <span class="font-bold text-slate-700">Afiliaciones activas hoy en {{ $tenant->branding['city'] ?? 'Cajicá' }}</span>
                                </div>
                                <a href="#planes" class="text-brand-primary font-extrabold hover:underline">Afiliarme ahora →</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 4. CALCULADORA INTERACTIVA DE AHORRO ANUAL (ROI MASCOTA) -->
        <section id="calculadora" class="py-16 sm:py-20 bg-slate-900 text-white relative overflow-hidden">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                
                <div class="text-center space-y-3 mb-12">
                    <div class="inline-flex items-center space-x-2 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-full text-emerald-400 text-xs font-bold uppercase tracking-wider">
                        <span>🧮 Herramienta Interactiva</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                        Calcula cuánto dinero ahorras con el Plan de Salud
                    </h2>
                    <p class="text-slate-400 text-sm max-w-xl mx-auto">
                        Compara el gasto de pagar servicios particulares vs tener un plan de bienestar preventivo en <strong>{{ $tenant->name }}</strong>.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bg-slate-950/80 p-6 sm:p-10 rounded-3xl border border-slate-800 shadow-2xl">
                    
                    <!-- CONTROLES INTERACTIVOS (IZQUIERDA) -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <!-- 1. Consultas Veterinarias -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <label class="font-bold text-slate-300">🩺 Consultas presenciales al año:</label>
                                <span id="calc-consultas-val" class="font-black text-sky-400 text-sm">3 consultas</span>
                            </div>
                            <input type="range" id="calc-consultas" min="1" max="8" value="3" oninput="calculateSavings()" class="w-full accent-sky-400 cursor-pointer h-2 bg-slate-800 rounded-lg">
                            <div class="flex justify-between text-[10px] text-slate-500">
                                <span>1 consulta</span>
                                <span>3 (Recomendado)</span>
                                <span>8 consultas</span>
                            </div>
                        </div>

                        <!-- 2. Baños y Peluquerías -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <label class="font-bold text-slate-300">🛁 Baños y estética al año:</label>
                                <span id="calc-baths-val" class="font-black text-sky-400 text-sm">2 baños</span>
                            </div>
                            <input type="range" id="calc-baths" min="0" max="6" value="2" oninput="calculateSavings()" class="w-full accent-sky-400 cursor-pointer h-2 bg-slate-800 rounded-lg">
                            <div class="flex justify-between text-[10px] text-slate-500">
                                <span>0 baños</span>
                                <span>2 baños</span>
                                <span>6 baños</span>
                            </div>
                        </div>

                        <!-- 3. Vacunación y Prevención Anual -->
                        <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 space-y-2">
                            <p class="text-xs font-bold text-slate-300">💉 Servicios preventivos incluidos en el cálculo:</p>
                            <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-400">
                                <span>✓ Vacuna anual (Rabia + Pentavalente)</span>
                                <span>✓ 3 Desparasitaciones internas</span>
                                <span>✓ 2 Desparasitaciones externas (Credelio)</span>
                                <span>✓ 1 Examen de laboratorio 100%</span>
                            </div>
                        </div>

                    </div>

                    <!-- RESULTADO DEL AHORRO (DERECHA) -->
                    <div class="lg:col-span-5 bg-gradient-to-br from-slate-900 to-slate-950 p-6 sm:p-8 rounded-3xl border border-sky-500/30 text-center space-y-5 shadow-xl relative overflow-hidden">
                        <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-sky-500/10 pointer-events-none"></div>

                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Costo promedio particular (Sin Plan)</p>
                            <p id="calc-particular-price" class="text-xl font-bold text-slate-400 line-through mt-0.5">$840.000 COP</p>
                        </div>

                        <div class="py-2 border-y border-slate-800">
                            <p class="text-xs font-black uppercase tracking-widest text-emerald-400">Con Plan Patitas Pagas Solo:</p>
                            <p id="calc-plan-price" class="text-3xl sm:text-4xl font-black text-white mt-1">$540.000 <span class="text-xs font-normal text-slate-400">COP/año</span></p>
                        </div>

                        <div class="bg-emerald-500/15 border border-emerald-500/30 p-4 rounded-2xl space-y-1">
                            <p class="text-xs font-bold text-emerald-300">¡Tu Ahorro Neto Anual Estimado!</p>
                            <p id="calc-savings-total" class="text-3xl font-black text-emerald-400">$300.000 COP</p>
                            <p id="calc-savings-percent" class="text-[11px] text-emerald-200 font-bold">Ahorras un 36% en salud médica</p>
                        </div>

                        <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}?text=Hola,%20hice%20el%20c%C3%A1lculo%20en%20la%20p%C3%A1gina%20y%20quiero%20afiliar%20a%20mi%20mascota%20para%20ahorrar" target="_blank" class="w-full py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-xs uppercase tracking-wider rounded-2xl shadow-lg transition-all flex items-center justify-center space-x-1.5">
                            <span>🐾 Afiliarme con este Ahorro</span>
                            <span>›</span>
                        </a>
                    </div>

                </div>

            </div>
        </section>

        <!-- 5. CATÁLOGO DE PLANES CON SELECTOR DINÁMICO -->
        <section id="planes" class="py-16 sm:py-20 bg-[#fbfcfd] border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center space-y-3 mb-8 sm:mb-12">
                    <div class="inline-flex items-center space-x-2 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full text-brand-primary text-xs font-bold shadow-sm">
                        <span>🐾</span>
                        <span>Planes Oficiales de Salud & Prevención</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Elige el plan ideal para tu mascota</h2>
                    <p class="text-slate-500 text-xs sm:text-sm max-w-2xl mx-auto font-medium px-2">
                        Cuidado médico preventivo de alta calidad en <strong>{{ $tenant->name }}</strong>. Paga mes a mes o ahorra pagando el año completo con activación inmediata.
                    </p>

                    <!-- SELECTOR CICLO FACTURACIÓN: MENSUAL / ANUAL -->
                    <div class="pt-3 sm:pt-4 flex items-center justify-center px-2">
                        <div class="bg-slate-100 p-1 sm:p-1.5 rounded-2xl border border-slate-200 inline-flex flex-wrap items-center justify-center gap-1 shadow-inner w-full sm:w-auto max-w-xs sm:max-w-none" id="cycle-toggle-wrapper">
                            <button type="button" onclick="setBillingCycle('monthly')" id="btn-cycle-monthly" class="flex-1 sm:flex-initial px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl font-bold text-xs transition-all bg-white text-slate-900 shadow-sm text-center">
                                📅 Pago Mensual
                            </button>
                            <button type="button" onclick="setBillingCycle('annual')" id="btn-cycle-annual" class="flex-1 sm:flex-initial px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl font-bold text-xs transition-all text-slate-600 hover:text-slate-900 flex items-center justify-center space-x-1.5 text-center">
                                <span>⭐ Pago Anual</span>
                                <span class="bg-emerald-600 text-white text-[9px] sm:text-[10px] font-black px-1.5 sm:px-2 py-0.5 rounded-full uppercase tracking-wider">-10%</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 max-w-5xl gap-6 sm:gap-8 mx-auto items-stretch">
                    
                    <!-- 1. PLAN PATITAS BÁSICO -->
                    <div id="plan-card-basico" onclick="selectPlanCard('basico')" class="plan-card cursor-pointer bg-white rounded-3xl p-5 sm:p-8 border-2 border-brand-primary ring-2 ring-brand-primary/20 shadow-md flex flex-col justify-between transition-all relative">
                        <div class="space-y-5 sm:space-y-6 pt-2">
                            <!-- Encabezado del Plan -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl font-bold shrink-0 shadow-sm" style="background-color: {{ $primaryColor }}15; color: {{ $primaryColor }};">
                                        🛡️
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-extrabold text-slate-900">Plan Patitas Básico</h3>
                                        <p class="text-xs text-slate-500 font-medium">Prevención integral y bienestar preventivo</p>
                                    </div>
                                </div>
                                <span id="badge-selected-basico" class="badge-plan-status px-2.5 py-1 bg-brand-primary text-white text-[10px] font-black rounded-full uppercase tracking-wider">
                                    Seleccionado ✓
                                </span>
                            </div>

                            <!-- Precios Dinámicos Mensual vs Anual -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5">
                                <div class="monthly-price-block">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900">$50.000</span>
                                        <span class="text-slate-500 text-xs font-bold">COP / mes</span>
                                    </div>
                                    <p class="text-[11px] text-emerald-700 font-semibold pt-1 leading-relaxed">
                                        • Mes 1: <strong>$100.000 COP</strong> (Incluye $50.000 de afiliación única)<br>
                                        • A partir del 2do mes pagas solo <strong>$50.000 COP</strong>
                                    </p>
                                </div>

                                <div class="annual-price-block hidden">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900">$540.000</span>
                                        <span class="text-slate-500 text-xs font-bold">COP / año</span>
                                    </div>
                                    <p class="text-[11px] text-emerald-700 font-bold pt-1 leading-relaxed">
                                        🎁 Afiliación bonificada ($0) • 🚀 <strong>ACTIVACIÓN INMEDIATA</strong> sin carencias.
                                    </p>
                                </div>
                            </div>

                            <!-- Link interactivo a Carencias -->
                            <div class="flex items-center justify-between text-xs pt-1">
                                <button type="button" onclick="event.stopPropagation(); jumpToCarencias('basico');" class="text-brand-primary hover:underline font-bold flex items-center space-x-1">
                                    <span>⏳ Ver tiempos de carencia de este plan</span>
                                    <span>↓</span>
                                </button>
                            </div>

                            <hr class="border-slate-100">

                            <!-- BOLSA DE BENEFICIOS DETALLADOS -->
                            <div class="space-y-4 text-xs font-sans">
                                <p class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">¿QUÉ INCLUYE ESTE PLAN AL AÑO?</p>

                                <div class="space-y-2.5 text-slate-700 font-medium text-xs leading-snug">
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">3 Consultas Presenciales</strong> al año con valoración médica.
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">Inyectología de Estabilización</strong> en consulta (hasta $20.000 por evento).
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">Vacunación Anual Completa</strong> (1 dosis anual: Caninos Pentavalente+Rabia / Felinos Triple+Rabia).
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">1 Examen Básico 100% cubierto</strong> (Hemograma, Creatinina, ALT, BUN / Coprológico por evento) + 10% Dcto adicional.
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">2 Citologías de Oídos</strong> al año para control de otitis.
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">3 Desparasitaciones Internas</strong> al año (cada 4 meses).
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">2 Antipulgas / Desparasitación Externa</strong> al año (cada 6 meses: Credelio o pipeta).
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">Baño y Peluquería:</strong> 2 Baños (Razas Pequeñas/Medianas) ó 1 Baño (Razas Grandes/Gigantes).
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">Consultas Virtuales Gratuitas e Ilimitadas</strong> (Lunes a Domingo).
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">Kit Bienvenida:</strong> Cédula, Collar Placa, Desparasitación inicial e Historia Clínica.
                                        </div>
                                    </div>

                                    <!-- Descuentos Destacados -->
                                    <div class="mt-3 pt-3 border-t border-slate-100 space-y-1.5 text-[11px] text-slate-600 bg-slate-50 p-3 rounded-xl">
                                        <p class="font-bold text-slate-800 uppercase tracking-wider text-[10px]">🏷️ DESCUENTOS EN CLÍNICA:</p>
                                        <p>• <strong>20% Dcto:</strong> Profilaxis Dental y Certificado Médico de Vuelo.</p>
                                        <p>• <strong>10% Dcto:</strong> Hospitalización, Medicamentos, Procedimientos y Funeraria (100% si no usó servicios previos).</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Directo a WhatsApp -->
                        <div class="pt-6 space-y-2.5">
                            <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}?text=Hola%20{{ urlencode($tenant->name) }},%20deseo%20afiliar%20a%20mi%20mascota%20al%20Plan%20Patitas%20Básico%20(Línea%20Única%203508742543)" target="_blank" class="w-full py-4 text-center rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs sm:text-sm shadow-md transition-all flex items-center justify-center space-x-2">
                                <span>🐾 Afiliarme a Plan Patitas Básico</span>
                                <span>›</span>
                            </a>
                            <p class="text-[10px] text-center text-slate-400 font-medium">Línea única de atención y autorizaciones: <strong>{{ $tenant->branding['phone'] ?? '350 874 2543' }}</strong></p>
                        </div>
                    </div>

                    <!-- 2. PLAN PATITAS PREMIUM -->
                    <div id="plan-card-premium" onclick="selectPlanCard('premium')" class="plan-card cursor-pointer bg-white rounded-3xl p-5 sm:p-8 border border-slate-200 shadow-sm hover:shadow-md flex flex-col justify-between transition-all relative">
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 bg-brand-secondary text-white font-bold text-[10px] sm:text-[11px] rounded-full shadow-md uppercase tracking-wider whitespace-nowrap">
                            PLAN RECOMENDADO ★
                        </div>

                        <div class="space-y-5 sm:space-y-6">
                            <!-- Encabezado del Plan -->
                            <div class="flex items-center justify-between pt-2">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl font-bold shrink-0 shadow-sm" style="background-color: {{ $primaryColor }}15; color: {{ $primaryColor }};">
                                        💎
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-extrabold text-slate-900">Plan Patitas Premium</h3>
                                        <p class="text-xs text-slate-500 font-medium">Máxima cobertura médica y urgencias</p>
                                    </div>
                                </div>
                                <span id="badge-selected-premium" class="badge-plan-status hidden px-2.5 py-1 bg-brand-primary text-white text-[10px] font-black rounded-full uppercase tracking-wider">
                                    Seleccionado ✓
                                </span>
                            </div>

                            <!-- Precios Dinámicos Mensual vs Anual -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5">
                                <div class="monthly-price-block">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900">$80.000</span>
                                        <span class="text-slate-500 text-xs font-bold">COP / mes</span>
                                    </div>
                                    <p class="text-[11px] text-emerald-700 font-semibold pt-1 leading-relaxed">
                                        • Mes 1: <strong>$150.000 COP</strong> (Incluye $70.000 de afiliación única)<br>
                                        • A partir del 2do mes pagas solo <strong>$80.000 COP</strong>
                                    </p>
                                </div>

                                <div class="annual-price-block hidden">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900">$902.400</span>
                                        <span class="text-slate-500 text-xs font-bold">COP / año</span>
                                    </div>
                                    <p class="text-[11px] text-emerald-700 font-bold pt-1 leading-relaxed">
                                        🎁 Afiliación bonificada ($0) • 🚀 <strong>ACTIVACIÓN INMEDIATA</strong> sin carencias.
                                    </p>
                                </div>
                            </div>

                            <!-- Link interactivo a Carencias -->
                            <div class="flex items-center justify-between text-xs pt-1">
                                <button type="button" onclick="event.stopPropagation(); jumpToCarencias('premium');" class="text-brand-primary hover:underline font-bold flex items-center space-x-1">
                                    <span>⏳ Ver tiempos de carencia de este plan</span>
                                    <span>↓</span>
                                </button>
                            </div>

                            <hr class="border-slate-100">

                            <!-- BOLSA DE BENEFICIOS DETALLADOS -->
                            <div class="space-y-4 text-xs font-sans">
                                <p class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">¿QUÉ INCLUYE ESTE PLAN AL AÑO?</p>

                                <div class="space-y-2.5 text-slate-700 font-medium text-xs leading-snug">
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">3 Consultas Presenciales</strong> al año con valoración médica completa.
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">Inyectología de Estabilización</strong> en consulta (antibiótico, analgésico o antipirético hasta $20.000).
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">Vacunación Anual Completa</strong> (1 dosis al año: Caninos Pentavalente+Rabia / Felinos Triple+Rabia).
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">Cobertura 100% en Laboratorio:</strong> Coprológico o Parcial de Orina, Hemograma o Perfil Básico (Creatinina, ALT, BUN por enfermedad/urgencia).
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">Desparasitación Externa / Antipulgas:</strong> Credelio o pipeta cada 6 meses (2 al año).
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">Consultas Virtuales Gratuitas e Ilimitadas</strong> de lunes a domingo.
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">Kit Bienvenida:</strong> Cédula, Collar Placa y Control para Historia Clínica.
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-brand-primary font-extrabold text-sm leading-none mt-0.5 shrink-0">✓</span>
                                        <div>
                                            <strong class="text-slate-900 font-bold">Chequeos Preventivos Trimestrales</strong> + Campañas preventivas y Acompañamiento continuo.
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-2.5">
                                        <span class="text-emerald-600 font-extrabold text-sm leading-none mt-0.5 shrink-0">★</span>
                                        <div>
                                            <strong class="text-slate-900 text-emerald-800 font-bold">Servicio Funerario 100% Gratuito Incluido</strong> (A partir de los 8 meses en mensual, o inmediato en anual).
                                        </div>
                                    </div>

                                    <!-- Descuentos Destacados -->
                                    <div class="mt-3 pt-3 border-t border-slate-100 space-y-1.5 text-[11px] text-slate-600 bg-slate-50 p-3 rounded-xl">
                                        <p class="font-bold text-slate-800 uppercase tracking-wider text-[10px]">🏷️ DESCUENTOS EN CLÍNICA:</p>
                                        <p>• <strong>20% Dcto:</strong> Certificado Médico Nacional de Vuelo.</p>
                                        <p>• <strong>10% Dcto:</strong> Hospitalización, Procedimientos, Exámenes e Imagenología.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Directo a WhatsApp -->
                        <div class="pt-6 space-y-2.5">
                            <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}?text=Hola%20{{ urlencode($tenant->name) }},%20deseo%20afiliar%20a%20mi%20mascota%20al%20Plan%20Patitas%20Premium%20(Línea%20Única%203508742543)" target="_blank" class="w-full py-4 text-center rounded-2xl bg-brand-primary hover:opacity-90 text-white font-extrabold text-xs sm:text-sm shadow-lg transition-all flex items-center justify-center space-x-2">
                                <span>🐾 Afiliarme a Plan Patitas Premium</span>
                                <span>›</span>
                            </a>
                            <p class="text-[10px] text-center text-slate-400 font-medium">Línea única de atención y autorizaciones: <strong>{{ $tenant->branding['phone'] ?? '350 874 2543' }}</strong></p>
                        </div>
                    </div>

                </div>

                <!-- LÍNEA DE TIEMPO / PERIODOS DE CARENCIA (MODALIDAD MENSUAL) -->
                <div class="mt-10 sm:mt-16 max-w-5xl mx-auto bg-white rounded-3xl border border-slate-200 p-4 sm:p-8 lg:p-10 shadow-sm space-y-6" id="carencias-section">
                    <div class="text-center space-y-3">
                        <div class="inline-flex items-center space-x-1.5 text-xs font-bold text-amber-600 bg-amber-50 px-3.5 py-1 rounded-full border border-amber-200 shadow-sm">
                            <span>⏳</span>
                            <span>Modalidad Mensual: Activación Progresiva</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Periodos de Carencia (Activación de Beneficios)</h3>
                        <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto font-medium px-2">
                            Beneficios del <strong id="carencia-title-plan" class="text-slate-900">Plan Patitas Básico</strong>. Si eliges pago mensual, los servicios se habilitan paso a paso. <strong>O paga el año completo y activa TODO de manera INMEDIATA sin esperas.</strong>
                        </p>

                        <!-- Selector de Plan en Carencias -->
                        <div class="inline-flex bg-slate-100 p-1 sm:p-1.5 rounded-2xl border border-slate-200 text-xs font-bold shadow-inner">
                            <button type="button" onclick="selectPlanCard('basico')" id="btn-carencia-basico" class="px-3.5 sm:px-4 py-2 rounded-xl transition-all bg-white text-slate-900 shadow-sm">
                                🐾 Plan Básico
                            </button>
                            <button type="button" onclick="selectPlanCard('premium')" id="btn-carencia-premium" class="px-3.5 sm:px-4 py-2 rounded-xl transition-all text-slate-600 hover:text-slate-900">
                                💎 Plan Premium
                            </button>
                        </div>
                    </div>

                    <!-- CARENCIA PLAN BÁSICO -->
                    <div id="carencia-block-basico" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 sm:gap-4 pt-2">
                            <!-- Inmediato -->
                            <div class="bg-emerald-50/60 border border-emerald-200/80 rounded-2xl p-4 space-y-2">
                                <span class="inline-block px-2.5 py-0.5 bg-emerald-600 text-white font-black text-[10px] rounded-full uppercase">Inmediato</span>
                                <h4 class="font-bold text-xs text-slate-900">Al Pagar Afiliación:</h4>
                                <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                    <li>Kit de Bienvenida (Cédula/Placa)</li>
                                    <li>1ra Desparasitación interna</li>
                                    <li>Historia clínica de bienvenida</li>
                                    <li>Consultas virtuales ILIMITADAS (L-D)</li>
                                    <li>Dctos en hospitalización y medicamentos</li>
                                </ul>
                            </div>

                            <!-- 30 Días -->
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-2">
                                <span class="inline-block px-2.5 py-0.5 bg-slate-800 text-white font-black text-[10px] rounded-full uppercase">A los 30 Días</span>
                                <h4 class="font-bold text-xs text-slate-900">Mes 1+:</h4>
                                <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                    <li>1ra Consulta presencial</li>
                                    <li>Chequeos preventivos periódicos</li>
                                    <li>Inyectología de estabilización (hasta $20k)</li>
                                    <li>Acompañamiento y recordatorios</li>
                                    <li>Campañas preventivas</li>
                                </ul>
                            </div>

                            <!-- 3 Meses -->
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-2">
                                <span class="inline-block px-2.5 py-0.5 bg-slate-800 text-white font-black text-[10px] rounded-full uppercase">A los 3 Meses</span>
                                <h4 class="font-bold text-xs text-slate-900">90 Días+:</h4>
                                <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                    <li>Todo lo anterior</li>
                                    <li>Desparasitación externa / antipulgas (Credelio o pipeta)</li>
                                </ul>
                            </div>

                            <!-- 6 Meses -->
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-2">
                                <span class="inline-block px-2.5 py-0.5 bg-slate-800 text-white font-black text-[10px] rounded-full uppercase">A los 6 Meses</span>
                                <h4 class="font-bold text-xs text-slate-900">180 Días+:</h4>
                                <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                    <li>Todo lo anterior</li>
                                    <li>Exámenes de laboratorio 100% (Hemograma, ALT, BUN, Creatinina / Coprológico)</li>
                                    <li>Citología de oídos</li>
                                    <li>Vacunación anual completa</li>
                                    <li>20% Dcto en Certificado de vuelo</li>
                                </ul>
                            </div>

                            <!-- 8 Meses -->
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-2 sm:col-span-2 lg:col-span-1">
                                <span class="inline-block px-2.5 py-0.5 bg-slate-800 text-white font-black text-[10px] rounded-full uppercase">A los 8 Meses</span>
                                <h4 class="font-bold text-xs text-slate-900">240 Días+:</h4>
                                <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                    <li>Todo lo anterior</li>
                                    <li>Baños y peluquería (1 grande/gigante ó 2 pequeñas/medianas)</li>
                                    <li>Servicio Funerario 10% Dcto (100% si no ha usado ningún servicio)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- CARENCIA PLAN PREMIUM -->
                    <div id="carencia-block-premium" class="space-y-4 hidden">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4 pt-2">
                            <!-- Inmediato -->
                            <div class="bg-emerald-50/60 border border-emerald-200/80 rounded-2xl p-4 space-y-2">
                                <span class="inline-block px-2.5 py-0.5 bg-emerald-600 text-white font-black text-[10px] rounded-full uppercase">Inmediato</span>
                                <h4 class="font-bold text-xs text-slate-900">Al Pagar Afiliación:</h4>
                                <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                    <li>Kit de Bienvenida (Cédula/Collar Placa)</li>
                                    <li>Control de Bienvenida e Historia Clínica</li>
                                    <li>Consultas virtuales GRATUITAS e ILIMITADAS (L-D)</li>
                                </ul>
                            </div>

                            <!-- 30 Días -->
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-2">
                                <span class="inline-block px-2.5 py-0.5 bg-slate-800 text-white font-black text-[10px] rounded-full uppercase">A los 30 Días</span>
                                <h4 class="font-bold text-xs text-slate-900">Mes 1+:</h4>
                                <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                    <li>1ra Consulta presencial en clínica</li>
                                    <li>Seguimiento clínico inicial</li>
                                </ul>
                            </div>

                            <!-- 90 Días (3 Meses) -->
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-2">
                                <span class="inline-block px-2.5 py-0.5 bg-slate-800 text-white font-black text-[10px] rounded-full uppercase">A los 90 Días</span>
                                <h4 class="font-bold text-xs text-slate-900">Beneficios Premium:</h4>
                                <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                    <li>Consultas presenciales adicionales</li>
                                    <li>Chequeos preventivos cada 3 meses</li>
                                    <li>Acompañamiento y campañas preventivas</li>
                                    <li>Inyectología de estabilización (hasta $20k)</li>
                                    <li>Desparasitación externa (Credelio / Pipeta)</li>
                                    <li>Vacunación Anual Completa (dosis única)</li>
                                    <li>Laboratorio 100% (Hemograma, ALT, BUN, Creatinina / Coprológico)</li>
                                    <li>10% Dctos en clínica y 20% en Certificado de Vuelo</li>
                                </ul>
                            </div>

                            <!-- 8 Meses (240 Días) -->
                            <div class="bg-emerald-50/80 border border-emerald-300 rounded-2xl p-4 space-y-2">
                                <span class="inline-block px-2.5 py-0.5 bg-emerald-700 text-white font-black text-[10px] rounded-full uppercase">A los 8 Meses</span>
                                <h4 class="font-bold text-xs text-emerald-950">Servicio Funerario 100%:</h4>
                                <ul class="text-[11px] text-emerald-900 space-y-1.5 list-disc pl-3 font-medium">
                                    <li>Todo lo anterior descrito</li>
                                    <li><strong>SERVICIO FUNERARIO GRATUITO 100% INCLUIDO</strong> en el plan</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 text-center sm:text-left">
                        <div class="flex items-center space-x-3 text-xs text-emerald-900 text-left">
                            <span class="text-2xl shrink-0">💡</span>
                            <div>
                                <p class="font-bold">¿Deseas activar todos los beneficios hoy mismo sin carencias?</p>
                                <p class="text-emerald-700 text-[11px] sm:text-xs">Elige la modalidad de Pago Anual con 10% de descuento y $0 costo de afiliación.</p>
                            </div>
                        </div>
                        <a href="                            Activar Plan Anual ⭐
                        </a>
                    </div>
                </div>

                <!-- 7. ACORDEÓN DINÁMICO DE PREGUNTAS FRECUENTES (FAQ) -->
                <div id="faq" class="mt-12 sm:mt-16 max-w-4xl mx-auto space-y-6">
                    <div class="text-center space-y-2">
                        <span class="text-xs font-bold text-brand-primary uppercase tracking-widest">Resolvemos tus inquietudes</span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Preguntas Frecuentes</h3>
                    </div>

                    <div class="space-y-3">
                        <!-- FAQ 1 -->
                        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                            <button type="button" onclick="toggleFaq(1)" class="w-full p-4 sm:p-5 text-left font-bold text-xs sm:text-sm text-slate-900 flex items-center justify-between gap-2 hover:bg-slate-50 transition">
                                <span>¿Cómo solicito una cita o servicio una vez afiliado?</span>
                                <span id="faq-icon-1" class="text-brand-primary font-black text-base transition-transform duration-200">+</span>
                            </button>
                            <div id="faq-content-1" class="hidden px-4 pb-4 sm:px-5 sm:pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                                Solo debes comunicarte a nuestra línea única oficial de WhatsApp <strong>{{ $tenant->branding['phone'] ?? '350 874 2543' }}</strong>. Nuestro equipo valida tu carnet digital en el mostrador en segundos y agenda tu cita prioritaria.
                            </div>
                        </div>

                        <!-- FAQ 2 -->
                        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                            <button type="button" onclick="toggleFaq(2)" class="w-full p-4 sm:p-5 text-left font-bold text-xs sm:text-sm text-slate-900 flex items-center justify-between gap-2 hover:bg-slate-50 transition">
                                <span>¿Qué incluye exactamente el Kit de Bienvenida?</span>
                                <span id="faq-icon-2" class="text-brand-primary font-black text-base transition-transform duration-200">+</span>
                            </button>
                            <div id="faq-content-2" class="hidden px-4 pb-4 sm:px-5 sm:pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                                Incluye la Cédula Digital de tu mascota, Collar con Placa de identificación física, apertura de historia clínica y la primera dosis de desparasitación interna.
                            </div>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                            <button type="button" onclick="toggleFaq(3)" class="w-full p-4 sm:p-5 text-left font-bold text-xs sm:text-sm text-slate-900 flex items-center justify-between gap-2 hover:bg-slate-50 transition">
                                <span>¿Qué diferencia hay entre el pago mensual y el pago anual?</span>
                                <span id="faq-icon-3" class="text-brand-primary font-black text-base transition-transform duration-200">+</span>
                            </button>
                            <div id="faq-content-3" class="hidden px-4 pb-4 sm:px-5 sm:pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                                En el pago mensual los beneficios se habilitan progresivamente mes a mes. En el <strong>pago anual anticipado</strong> obtienes un 10% de descuento directo ($540.000 COP en plan básico) y todos los servicios se activan <strong>inmediatamente sin carencias</strong>.
                            </div>
                        </div>

                        <!-- FAQ 4 -->
                        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                            <button type="button" onclick="toggleFaq(4)" class="w-full p-4 sm:p-5 text-left font-bold text-xs sm:text-sm text-slate-900 flex items-center justify-between gap-2 hover:bg-slate-50 transition">
                                <span>¿Puedo afiliar más de una mascota?</span>
                                <span id="faq-icon-4" class="text-brand-primary font-black text-base transition-transform duration-200">+</span>
                            </button>
                            <div id="faq-content-4" class="hidden px-4 pb-4 sm:px-5 sm:pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                                ¡Sí! Cada peludo cuenta con su propio carnet digital y su bolsa individual de consultas, vacunas y peluquerías.
                            </div>
                        </div>
                    </div>
                </div>

        <!-- 7.5. INSTALACIONES & CONSULTORIO VETERINARIO (FOTOS & VIDEO) -->
        <section id="instalaciones" class="py-14 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-3 mb-10">
                    <div class="inline-flex items-center space-x-2 bg-sky-100 text-sky-800 text-xs font-bold px-3 py-1 rounded-full border border-sky-200">
                        <span>🏥 Cuidado Presencial & Instalaciones</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                        Conoce el Consultorio de {{ $tenant->name }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto">
                        Ubicados en <strong>{{ $tenant->branding['city'] ?? 'Cajicá, Cundinamarca' }}</strong> para brindarle a tu mascota la mejor atención médica con tecnología y cariño.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center max-w-6xl mx-auto">
                    
                    <!-- Media Principal (Video o Foto de Portada) -->
                    <div class="lg:col-span-7 rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-slate-900 relative aspect-video flex items-center justify-center group">
                        @if(!empty($bannerVideo))
                            <video class="w-full h-full object-cover" controls autoplay muted loop playsinline poster="{{ $bannerImage }}">
                                <source src="{{ $bannerVideo }}" type="video/mp4">
                                Tu navegador no soporta el reproductor de video.
                            </video>
                        @elseif(!empty($bannerImage))
                            <img src="{{ $bannerImage }}" alt="Instalaciones de {{ $tenant->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        @else
                            <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=1000" alt="Consultorio Veterinario" class="w-full h-full object-cover" loading="lazy">
                        @endif

                        <div class="absolute bottom-3 left-3 right-3 bg-slate-950/80 backdrop-blur-md p-3 rounded-2xl text-white flex items-center justify-between text-xs border border-white/10">
                            <div class="flex items-center space-x-2">
                                <span class="text-base">📍</span>
                                <span class="font-bold text-[11px] truncate">{{ $tenant->branding['address'] ?? 'Calle 7 # 4-73 Este' }}</span>
                            </div>
                            <span class="text-[10px] text-emerald-400 font-extrabold bg-emerald-950/60 px-2 py-0.5 rounded-full">Abierto Lunes a Sábado</span>
                        </div>
                    </div>

                    <!-- Datos de la Clínica & Foto Secundaria / Hero -->
                    <div class="lg:col-span-5 space-y-5">
                        @if(!empty($heroImage))
                            <div class="rounded-2xl overflow-hidden shadow-md border-2 border-white aspect-[16/9] relative group">
                                <img src="{{ $heroImage }}" alt="Mascotas y Atención en {{ $tenant->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-full text-[10px] font-black text-slate-900 shadow-sm">
                                    🐾 Pacientes Felices
                                </div>
                            </div>
                        @endif

                        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                            <h3 class="font-extrabold text-sm sm:text-base text-slate-900 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Información de Atención Presencial
                            </h3>

                            <div class="space-y-2.5 text-xs text-slate-600">
                                <div class="flex items-start gap-2.5">
                                    <span class="text-slate-400 font-bold">📍 Dirección:</span>
                                    <span class="font-bold text-slate-900">{{ $tenant->branding['address'] ?? 'Calle 7 # 4-73 Este (hacia El Parasol rojo)' }}</span>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <span class="text-slate-400 font-bold">🏙️ Ciudad:</span>
                                    <span class="font-bold text-slate-900">{{ $tenant->branding['city'] ?? 'Cajicá, Cundinamarca' }}</span>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <span class="text-slate-400 font-bold">📞 Teléfono / WhatsApp:</span>
                                    <span class="font-bold text-emerald-600">{{ $tenant->branding['phone'] ?? '3508742543' }}</span>
                                </div>
                            </div>

                            <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}?text=Hola,%20quiero%20conocer%20la%20ubicaci%C3%B3n%20y%20agendar%20visita%20en%20{{ urlencode($tenant->name) }}" target="_blank" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-2">
                                <span>💬 Cómo Llegar por WhatsApp</span>
                                <span>↗</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 8. BANNER WHATSAPP -->
        <section class="py-10 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-3xl p-8 sm:p-10 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
                    <div class="flex items-center space-x-5 z-10">
                        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-3xl shrink-0">
                            💬
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold">¿Tienes dudas? Escríbenos por WhatsApp</h3>
                            <p class="text-sky-100 text-sm">Te ayudamos a elegir el plan perfecto para tu peludo 🐶🐱</p>
                        </div>
                    </div>
                    
                    <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}?text=Hola,%20tengo%20dudas%20sobre%20los%20Planes%20de%20{{ urlencode($tenant->name) }}" target="_blank" class="z-10 px-8 py-4 bg-white text-slate-900 hover:bg-slate-50 font-extrabold text-sm rounded-full shadow-lg transition-all flex items-center space-x-2 shrink-0">
                        <span>💬 Chatear ahora</span>
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- STICKY ACTION BAR PARA CELULARES (APARECE AL HACER SCROLL) -->
    <div id="sticky-mobile-bar" class="sm:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 p-3 flex items-center justify-between gap-2 shadow-2xl transition-transform duration-300 translate-y-full">
        <div class="min-w-0">
            <p class="text-[10px] text-slate-400 font-bold uppercase">Plan Bienestar</p>
            <p class="text-xs font-black text-slate-900 truncate">Desde $50.000 COP</p>
        </div>
        <div class="flex items-center space-x-2 shrink-0">
            <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}" target="_blank" class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-200">
                💬
            </a>
            <a href="#planes" class="px-4 py-2.5 bg-brand-primary text-white font-black text-xs rounded-xl shadow-sm">
                Afiliar Mascota 🐾
            </a>
        </div>
    </div>

    <!-- 9. FOOTER -->
    <footer id="contacto" class="bg-[#f8fafc] border-t border-slate-200 py-14 text-slate-600 text-xs pb-20 sm:pb-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-5 gap-8">
            
            <div class="md:col-span-2 space-y-3">
                <div class="flex items-center space-x-2">
                    @if(!empty($logoUrl))
                        <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="h-8 max-h-10 w-auto object-contain">
                    @else
                        <span class="text-brand-primary font-bold text-xl">🐾</span>
                    @endif
                    <span class="text-base font-extrabold text-slate-900">{{ $tenant->name }}</span>
                </div>
                <p class="text-slate-500 leading-relaxed max-w-sm">Cuidado confiable y preventivo para tus mascotas con atención personalizada en {{ $tenant->branding['city'] ?? 'Cajicá' }}.</p>
            </div>

            <div>
                <h5 class="font-bold text-slate-900 text-xs uppercase mb-3">Enlaces rápidos</h5>
                <ul class="space-y-2">
                    <li><a href="#planes" class="hover:text-brand-primary">Planes</a></li>
                    <li><a href="#calculadora" class="hover:text-brand-primary">Calculadora de Ahorro</a></li>
                    <li><a href="#carencias-section" class="hover:text-brand-primary">Carencias</a></li>
                    <li><a href="#faq" class="hover:text-brand-primary">Preguntas frecuentes</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-bold text-slate-900 text-xs uppercase mb-3">Portal Operativo</h5>
                <ul class="space-y-2">
                    <li><a href="/v/{{ $tenant->slug }}/admin" class="hover:text-brand-primary">Mostrador de Recepción</a></li>
                    <li><a href="/v/{{ $tenant->slug }}/admin" class="hover:text-brand-primary">Gestor de Planes</a></li>
                    <li><a href="/v/{{ $tenant->slug }}/admin" class="hover:text-brand-primary">Marca y Colores</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-bold text-slate-900 text-xs uppercase mb-3">Contacto</h5>
                <ul class="space-y-2 text-slate-500">
                    <li class="font-semibold text-slate-800">📞 {{ $tenant->branding['phone'] ?? '350 874 2543' }}</li>
                    <li>✉️ {{ $tenant->branding['email'] ?? 'petmovilveterinario@gmail.com' }}</li>
                    <li>📍 {{ $tenant->branding['address'] ?? 'Calle 7 # 4-73 Este' }}, {{ $tenant->branding['city'] ?? 'Cajicá' }}</li>
                </ul>
            </div>

        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between text-slate-400 text-[11px] gap-2">
            <p>© 2026 {{ $tenant->name }}. Todos los derechos reservados.</p>
            <div class="flex space-x-4">
                <span>Privacidad</span>
                <span>Términos</span>
                <span>Protección de Datos</span>
            </div>
        </div>
    </footer>

    <!-- SCRIPTS DINÁMICOS -->
    <script>
        let currentPetType = 'dog';

        // 1. Actualización en tiempo real del carnet
        function updateLiveCarnet() {
            const nameInput = document.getElementById('live-pet-name').value.trim();
            const breedInput = document.getElementById('live-pet-breed').value.trim();
            
            document.getElementById('card-pet-name').innerText = nameInput ? nameInput.toUpperCase() : 'MI MASCOTA';
            document.getElementById('card-pet-breed').innerText = (breedInput || 'Raza') + ' • ' + (currentPetType === 'dog' ? 'Canino' : 'Felino');
        }

        function setLivePetType(type) {
            currentPetType = type;
            const btnDog = document.getElementById('btn-pet-dog');
            const btnCat = document.getElementById('btn-pet-cat');
            const cardEmoji = document.getElementById('card-pet-emoji');

            if (type === 'cat') {
                btnCat.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                btnCat.classList.remove('text-slate-500');
                btnDog.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                btnDog.classList.add('text-slate-500');
                cardEmoji.innerText = '🐈';
                if (document.getElementById('live-pet-name').value === 'Max') {
                    document.getElementById('live-pet-name').value = 'Mimi';
                    document.getElementById('live-pet-breed').value = 'Persa';
                }
            } else {
                btnDog.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                btnDog.classList.remove('text-slate-500');
                btnCat.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                btnCat.classList.add('text-slate-500');
                cardEmoji.innerText = '🐕';
                if (document.getElementById('live-pet-name').value === 'Mimi') {
                    document.getElementById('live-pet-name').value = 'Max';
                    document.getElementById('live-pet-breed').value = 'Golden Retriever';
                }
            }
            updateLiveCarnet();
        }

        // 2. Calculadora dinámica de ahorro
        function calculateSavings() {
            const consultas = parseInt(document.getElementById('calc-consultas').value);
            const baths = parseInt(document.getElementById('calc-baths').value);

            document.getElementById('calc-consultas-val').innerText = consultas + (consultas === 1 ? ' consulta' : ' consultas');
            document.getElementById('calc-baths-val').innerText = baths + (baths === 1 ? ' baño' : ' baños');

            // Costos referenciales particulares en Colombia
            const costoConsultaParticular = 65000;
            const costoBanoParticular = 45000;
            const costoVacunacionParticular = 90000;
            const costoDesparasitacionParticular = 70000;
            const costoExamenLaboratorioParticular = 110000;

            const totalParticular = (consultas * costoConsultaParticular) + 
                                    (baths * costoBanoParticular) + 
                                    costoVacunacionParticular + 
                                    costoDesparasitacionParticular + 
                                    costoExamenLaboratorioParticular;

            const totalPlan = 540000; // Plan básico anual
            const ahorro = Math.max(0, totalParticular - totalPlan);
            const porcentajeAhorro = Math.round((ahorro / totalParticular) * 100);

            document.getElementById('calc-particular-price').innerText = '$' + totalParticular.toLocaleString('es-CO') + ' COP';
            document.getElementById('calc-savings-total').innerText = '$' + ahorro.toLocaleString('es-CO') + ' COP';
            document.getElementById('calc-savings-percent').innerText = 'Ahorras un ' + porcentajeAhorro + '% en salud médica';
        }

        // 3. Selección interactiva de tarjeta de plan y sincronización con carnet/timeline
        function selectPlanCard(planType) {
            const cardBasico = document.getElementById('plan-card-basico');
            const cardPremium = document.getElementById('plan-card-premium');
            const badgeBasico = document.getElementById('badge-selected-basico');
            const badgePremium = document.getElementById('badge-selected-premium');
            const blockBasico = document.getElementById('carencia-block-basico');
            const blockPremium = document.getElementById('carencia-block-premium');
            const btnBasico = document.getElementById('btn-carencia-basico');
            const btnPremium = document.getElementById('btn-carencia-premium');
            const titlePlan = document.getElementById('carencia-title-plan');
            const cardPlanName = document.getElementById('card-plan-name');

            if (planType === 'premium') {
                if (cardBasico) {
                    cardBasico.classList.remove('border-2', 'border-brand-primary', 'ring-2', 'ring-brand-primary/20', 'shadow-md');
                    cardBasico.classList.add('border-slate-200');
                }
                if (badgeBasico) badgeBasico.classList.add('hidden');

                if (cardPremium) {
                    cardPremium.classList.add('border-2', 'border-brand-primary', 'ring-2', 'ring-brand-primary/20', 'shadow-md');
                    cardPremium.classList.remove('border-slate-200');
                }
                if (badgePremium) badgePremium.classList.remove('hidden');

                if (blockBasico) blockBasico.classList.add('hidden');
                if (blockPremium) blockPremium.classList.remove('hidden');
                if (btnPremium) {
                    btnPremium.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                    btnPremium.classList.remove('text-slate-600');
                }
                if (btnBasico) {
                    btnBasico.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                    btnBasico.classList.add('text-slate-600');
                }
                if (titlePlan) titlePlan.textContent = 'Plan Patitas Premium';
                if (cardPlanName) cardPlanName.textContent = 'Plan Patitas Premium';
            } else {
                if (cardPremium) {
                    cardPremium.classList.remove('border-2', 'border-brand-primary', 'ring-2', 'ring-brand-primary/20', 'shadow-md');
                    cardPremium.classList.add('border-slate-200');
                }
                if (badgePremium) badgePremium.classList.add('hidden');

                if (cardBasico) {
                    cardBasico.classList.add('border-2', 'border-brand-primary', 'ring-2', 'ring-brand-primary/20', 'shadow-md');
                    cardBasico.classList.remove('border-slate-200');
                }
                if (badgeBasico) badgeBasico.classList.remove('hidden');

                if (blockPremium) blockPremium.classList.add('hidden');
                if (blockBasico) blockBasico.classList.remove('hidden');
                if (btnBasico) {
                    btnBasico.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                    btnBasico.classList.remove('text-slate-600');
                }
                if (btnPremium) {
                    btnPremium.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                    btnPremium.classList.add('text-slate-600');
                }
                if (titlePlan) titlePlan.textContent = 'Plan Patitas Básico';
                if (cardPlanName) cardPlanName.textContent = 'Plan Patitas Básico';
            }
        }

        // 4. Selector mensual / anual
        function setBillingCycle(cycle) {
            const monthlyBlocks = document.querySelectorAll('.monthly-price-block');
            const annualBlocks = document.querySelectorAll('.annual-price-block');
            const btnMonthly = document.getElementById('btn-cycle-monthly');
            const btnAnnual = document.getElementById('btn-cycle-annual');

            if (cycle === 'annual') {
                monthlyBlocks.forEach(b => b.classList.add('hidden'));
                annualBlocks.forEach(b => b.classList.remove('hidden'));
                if (btnAnnual) {
                    btnAnnual.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                    btnAnnual.classList.remove('text-slate-600');
                }
                if (btnMonthly) {
                    btnMonthly.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                    btnMonthly.classList.add('text-slate-600');
                }
            } else {
                annualBlocks.forEach(b => b.classList.add('hidden'));
                monthlyBlocks.forEach(b => b.classList.remove('hidden'));
                if (btnMonthly) {
                    btnMonthly.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                    btnMonthly.classList.remove('text-slate-600');
                }
                if (btnAnnual) {
                    btnAnnual.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                    btnAnnual.classList.add('text-slate-600');
                }
            }
        }

        function jumpToCarencias(planType) {
            selectPlanCard(planType);
            const carenciasEl = document.getElementById('carencias-section');
            if (carenciasEl) {
                carenciasEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // 5. Toggle FAQ acordeón
        function toggleFaq(id) {
            const content = document.getElementById('faq-content-' + id);
            const icon = document.getElementById('faq-icon-' + id);
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.innerText = '−';
            } else {
                content.classList.add('hidden');
                icon.innerText = '+';
            }
        }

        // 6. Sticky Mobile Bar on Scroll
        window.addEventListener('scroll', function() {
            const bar = document.getElementById('sticky-mobile-bar');
            if (bar) {
                if (window.scrollY > 350) {
                    bar.classList.remove('translate-y-full');
                } else {
                    bar.classList.add('translate-y-full');
                }
            }
        });

        // Inicializar cálculos
        calculateSavings();
    </script>
</body>
</html>
