<!DOCTYPE html>
<html lang="es" class="h-full bg-white text-slate-900 antialiased selection:bg-teal-500 selection:text-white overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>{{ $tenant->name }} — Planes de Salud & Bienestar Veterinario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @php
        $primaryColor = $tenant->branding['primary_color'] ?? '#0D9488';
        $secondaryColor = $tenant->branding['secondary_color'] ?? '#0B1120';
        $logoUrl = $tenant->branding['logo_url'] ?? null;
        $heroImage = $tenant->branding['hero_image_url'] ?? 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?w=700&auto=format&fit=crop&q=80';
        $bannerImage = $tenant->branding['banner_image_url'] ?? 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=1000';
        $bannerVideo = $tenant->branding['banner_video_url'] ?? null;
        $city = $tenant->branding['city'] ?? 'Cajicá, Cundinamarca';
        $address = $tenant->branding['address'] ?? 'Calle 7 # 4-73 Este';
        $phone = $tenant->branding['phone'] ?? '3508742543';
    @endphp

    <style>
        :root {
            --brand-primary: {{ $primaryColor }};
            --brand-secondary: {{ $secondaryColor }};
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { 
            background: radial-gradient(circle at 80% 20%, {{ $primaryColor }}20 0%, #f0fdfa30 40%, rgba(255, 255, 255, 0) 75%); 
        }
        .bg-brand-primary { background-color: var(--brand-primary); }
        .bg-brand-secondary { background-color: var(--brand-secondary); }
        .text-brand-primary { color: var(--brand-primary); }
        .border-brand-primary { border-color: var(--brand-primary); }
        .carnet-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            transform-style: preserve-3d;
        }
        .carnet-card:hover {
            transform: translateY(-4px) rotateX(2deg) rotateY(-2deg);
        }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between bg-white overflow-x-hidden">

    <!-- 1. TOP BAR DE ATENCIÓN MÉDICA -->
    <div class="bg-slate-900 text-white text-xs font-semibold py-2 px-3 sm:px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-1.5 sm:gap-2 text-center sm:text-left">
            <div class="flex items-center space-x-2 text-teal-200 text-[11px] sm:text-xs">
                <span class="animate-pulse">🩺</span>
                <span>Planes de Bienestar & Salud Preventiva • {{ $tenant->name }}</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="https://wa.me/57{{ preg_replace('/[^0-9]/', '', $phone) }}" target="_blank" class="flex items-center space-x-1.5 hover:text-teal-300 transition-colors text-[11px] sm:text-xs">
                    <svg class="w-3.5 h-3.5 fill-current text-teal-400" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                    </svg>
                    <span>Línea de Urgencias & Citas:</span>
                    <span class="text-white font-bold">{{ $phone }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. NAVBAR CON IDENTIDAD DE MARCA -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between gap-4">
            <div class="flex items-center space-x-3 min-w-0">
                @if(!empty($logoUrl))
                    <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="h-10 sm:h-12 w-auto max-w-[150px] object-contain rounded-lg shrink-0 shadow-xs" loading="lazy">
                @else
                    <div class="w-10 h-10 rounded-xl bg-brand-primary flex items-center justify-center text-white text-xl shadow-md shrink-0">
                        🐾
                    </div>
                @endif
                <div class="min-w-0">
                    <span class="text-base sm:text-lg font-black tracking-tight text-slate-900 truncate block">{{ $tenant->name }}</span>
                    <span class="inline-block text-[11px] font-bold text-teal-700 dark:text-teal-600 truncate">📍 {{ $city }}</span>
                </div>
            </div>

            <nav class="hidden md:flex items-center space-x-8 text-sm font-bold text-slate-600">
                <a href="#planes" class="hover:text-brand-primary transition-colors">Planes de Salud</a>
                <a href="#calculadora" class="hover:text-brand-primary transition-colors flex items-center space-x-1">
                    <span>🧮 Calculadora de Ahorro</span>
                    <span class="bg-amber-100 text-amber-800 text-[10px] font-extrabold px-2 py-0.5 rounded-full">Calcular</span>
                </a>
                <a href="#instalaciones" class="hover:text-brand-primary transition-colors">Instalaciones</a>
                <a href="#faq" class="hover:text-brand-primary transition-colors">Preguntas</a>
            </nav>

            <div class="flex items-center space-x-3 shrink-0">
                <a href="/admin/{{ $tenant->slug }}" class="hidden sm:inline-block px-4 py-2 text-xs font-bold text-slate-700 hover:text-slate-900 border border-slate-200 rounded-full hover:bg-slate-50 transition-all">
                    Acceso Clínica
                </a>
                <a href="#planes" class="px-5 py-2.5 text-xs sm:text-sm font-black text-white bg-brand-primary hover:opacity-90 rounded-full shadow-md transition-all whitespace-nowrap">
                    Afiliar Mascota 🐾
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- 3. HERO INTERACTIVO CON SIMULADOR DE CARNET DIGITAL Y FOTO DE IDENTIDAD -->
        <section class="hero-gradient relative pt-8 sm:pt-14 pb-16 sm:pb-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- COLUMNA IZQUIERDA: MENSAJE + INTERACTIVIDAD INICIAL -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <div class="inline-flex items-center space-x-3 bg-white px-4 py-1.5 rounded-full shadow-xs border border-slate-200">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                            </span>
                            <span class="text-xs font-black text-slate-800 uppercase tracking-wider">Afiliaciones Digitales Abiertas 2026</span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.12]">
                            Salud preventiva y <span class="text-brand-primary underline decoration-teal-300">cuidado continuo</span> para tu mascota
                        </h1>

                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl font-normal">
                            Planes de bienestar diseñados por veterinarios para garantizar consultas, vacunas, chequeos clínicos y ahorro real en <strong class="text-slate-900">{{ $tenant->name }}</strong>.
                        </p>

                        <!-- MINI SIMULADOR INTERACTIVO DEL CARNET -->
                        <div class="bg-white/90 backdrop-blur-md p-4 sm:p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3.5 max-w-xl">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                    <span>✨</span> Personaliza el carnet de tu peludo en vivo:
                                </span>
                                <span class="text-[10px] text-teal-700 font-extrabold bg-teal-50 border border-teal-200 px-2.5 py-0.5 rounded-full">Interactivo ⚡</span>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase mb-1">Nombre</label>
                                    <input type="text" id="live-pet-name" value="Max" oninput="updateLiveCarnet()" placeholder="Ej. Lucas" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase mb-1">Especie</label>
                                    <div class="flex bg-slate-100 p-0.5 rounded-xl border border-slate-200">
                                        <button type="button" onclick="setLivePetType('dog')" id="btn-pet-dog" class="flex-1 py-1.5 text-xs font-bold rounded-lg transition bg-white text-slate-900 shadow-xs text-center">
                                            🐶 Perro
                                        </button>
                                        <button type="button" onclick="setLivePetType('cat')" id="btn-pet-cat" class="flex-1 py-1.5 text-xs font-bold rounded-lg transition text-slate-500 hover:text-slate-900 text-center">
                                            🐱 Gato
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase mb-1">Raza</label>
                                    <input type="text" id="live-pet-breed" value="Golden Retriever" oninput="updateLiveCarnet()" placeholder="Ej. Criollo" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5">
                            <a href="#planes" class="px-7 py-4 rounded-full bg-brand-primary text-white font-extrabold text-sm shadow-lg hover:opacity-90 transition-all flex items-center justify-center space-x-2 text-center">
                                <span>Ver Planes & Tarifas</span>
                                <span>›</span>
                            </a>
                            <a href="#calculadora" class="px-6 py-4 rounded-full bg-white hover:bg-slate-50 text-slate-800 font-extrabold text-sm border border-slate-200 shadow-xs transition-all flex items-center justify-center space-x-2 text-center">
                                <span>🧮 Simular Mi Ahorro Anual</span>
                            </a>
                        </div>
                    </div>

                    <!-- COLUMNA DERECHA: CARNET DIGITAL 3D HOLOGRÁFICO CON IDENTIDAD DE LA CLÍNICA -->
                    <div class="lg:col-span-5 relative mt-4 lg:mt-0">
                        <div class="mx-auto max-w-sm sm:max-w-md space-y-4">
                            
                            <!-- CARNET DIGITAL CON LOGO Y COLORES CORPORATIVOS -->
                            <div id="live-carnet-card" class="carnet-card rounded-3xl p-6 sm:p-7 text-white shadow-2xl relative overflow-hidden border border-white/20 select-none" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
                                
                                <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-white/10 pointer-events-none"></div>
                                <div class="absolute -left-10 -bottom-10 w-32 h-32 rounded-full bg-white/5 pointer-events-none"></div>

                                <div class="relative z-10 space-y-5">
                                    <!-- Header Carnet -->
                                    <div class="flex items-center justify-between border-b border-white/15 pb-3.5">
                                        <div class="flex items-center space-x-2.5">
                                            @if(!empty($logoUrl))
                                                <img src="{{ $logoUrl }}" alt="Logo" class="h-8 w-8 object-contain bg-white/20 backdrop-blur-md rounded-lg p-0.5 border border-white/30">
                                            @else
                                                <span class="text-2xl">🐾</span>
                                            @endif
                                            <div>
                                                <p class="text-[10px] font-black uppercase tracking-widest text-teal-200">{{ $tenant->name }}</p>
                                                <p class="text-xs font-black text-white">Carnet Digital de Afiliado</p>
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
                                            <p id="card-pet-breed" class="text-xs text-teal-100 font-medium">Golden Retriever • Canino</p>
                                        </div>
                                        <div id="card-pet-emoji" class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center text-3xl shadow-inner border border-white/20">
                                            🐕
                                        </div>
                                    </div>

                                    <!-- Plan and Contract Info -->
                                    <div class="grid grid-cols-2 gap-3 pt-2 bg-black/25 p-3.5 rounded-2xl border border-white/10">
                                        <div>
                                            <p class="text-[8px] uppercase tracking-wider text-white/60 font-bold">Membresía</p>
                                            <p id="card-plan-name" class="text-xs font-black text-amber-300">Plan Patitas Básico</p>
                                        </div>
                                        <div>
                                            <p class="text-[8px] uppercase tracking-wider text-white/60 font-bold">Contrato Digital</p>
                                            <p id="card-contract-id" class="text-xs font-mono font-bold text-white">VP-2026-8842</p>
                                        </div>
                                    </div>

                                    <!-- Footer Carnet -->
                                    <div class="flex items-center justify-between pt-1 text-[10px] text-white/70">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-7 h-5 rounded bg-amber-400/90 border border-amber-300 flex items-center justify-center text-[7px] font-black text-slate-900">
                                                CHIP
                                            </div>
                                            <span>Validación inmediata en clínica</span>
                                        </div>
                                        <span class="font-mono text-[9px] text-white/50">AVI-SaaS</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado de Atención -->
                            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between text-xs">
                                <div class="flex items-center space-x-2.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                                    <span class="font-bold text-slate-700">Atención médica en {{ $city }}</span>
                                </div>
                                <a href="#planes" class="text-brand-primary font-black hover:underline">Afiliarme ahora →</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 4. CALCULADORA INTERACTIVA DE AHORRO ANUAL -->
        <section id="calculadora" class="py-16 sm:py-20 bg-slate-900 text-white relative overflow-hidden">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                
                <div class="text-center space-y-3 mb-12">
                    <div class="inline-flex items-center space-x-2 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-full text-emerald-400 text-xs font-bold uppercase tracking-wider">
                        <span>🧮 Ahorro Clínico Comprobado</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                        Calcula cuánto dinero ahorras con tu Plan de Salud
                    </h2>
                    <p class="text-slate-400 text-sm max-w-xl mx-auto">
                        Compara el gasto de pagar servicios veterinarios particulares vs tener tu membresía preventiva activa en <strong>{{ $tenant->name }}</strong>.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bg-slate-950/80 p-6 sm:p-10 rounded-3xl border border-slate-800 shadow-2xl">
                    
                    <!-- CONTROLES (IZQUIERDA) -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <!-- 1. Consultas -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <label class="font-bold text-slate-300">🩺 Consultas presenciales estimadas al año:</label>
                                <span id="calc-consultas-val" class="font-black text-teal-400 text-sm">3 consultas</span>
                            </div>
                            <input type="range" id="calc-consultas" min="1" max="8" value="3" oninput="calculateSavings()" class="w-full accent-teal-400 cursor-pointer h-2 bg-slate-800 rounded-lg">
                            <div class="flex justify-between text-[10px] text-slate-500">
                                <span>1 consulta</span>
                                <span>3 (Recomendado)</span>
                                <span>8 consultas</span>
                            </div>
                        </div>

                        <!-- 2. Baños -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <label class="font-bold text-slate-300">🛁 Baños y estética al año:</label>
                                <span id="calc-baths-val" class="font-black text-teal-400 text-sm">2 baños</span>
                            </div>
                            <input type="range" id="calc-baths" min="0" max="6" value="2" oninput="calculateSavings()" class="w-full accent-teal-400 cursor-pointer h-2 bg-slate-800 rounded-lg">
                            <div class="flex justify-between text-[10px] text-slate-500">
                                <span>0 baños</span>
                                <span>2 baños</span>
                                <span>6 baños</span>
                            </div>
                        </div>

                        <!-- 3. Vacunas y Exámenes -->
                        <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 space-y-2">
                            <p class="text-xs font-bold text-slate-300">💉 Servicios preventivos cubiertos por el plan:</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] text-slate-400">
                                <span>✓ Vacuna anual (Rabia + Pentavalente)</span>
                                <span>✓ 3 Desparasitaciones internas</span>
                                <span>✓ 2 Desparasitaciones externas (Credelio)</span>
                                <span>✓ 1 Examen de laboratorio completo</span>
                            </div>
                        </div>

                    </div>

                    <!-- RESULTADO (DERECHA) -->
                    <div class="lg:col-span-5 bg-gradient-to-br from-slate-900 to-slate-950 p-6 sm:p-8 rounded-3xl border border-teal-500/30 text-center space-y-5 shadow-xl relative overflow-hidden">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Costo particular promedio (Sin Plan)</p>
                            <p id="calc-particular-price" class="text-xl font-bold text-slate-400 line-through mt-0.5">$840.000 COP</p>
                        </div>

                        <div class="py-2 border-y border-slate-800">
                            <p class="text-xs font-black uppercase tracking-widest text-emerald-400">Con Plan Patitas Pagas Solo:</p>
                            <p id="calc-plan-price" class="text-3xl sm:text-4xl font-black text-white mt-1">$540.000 <span class="text-xs font-normal text-slate-400">COP/año</span></p>
                        </div>

                        <div class="bg-emerald-500/15 border border-emerald-500/30 p-4 rounded-2xl space-y-1">
                            <p class="text-xs font-bold text-emerald-300">¡Tu Ahorro Neto Anual Estimado!</p>
                            <p id="calc-savings-total" class="text-3xl font-black text-emerald-400">$300.000 COP</p>
                            <p id="calc-savings-percent" class="text-[11px] text-emerald-200 font-bold">Ahorras un 36% en salud veterinaria</p>
                        </div>

                        <a href="https://wa.me/57{{ preg_replace('/[^0-9]/', '', $phone) }}?text=Hola,%20hice%20el%20c%C3%A1lculo%20en%20la%20p%C3%A1gina%20y%20quiero%20afiliar%20a%20mi%20mascota%20para%20ahorrar" target="_blank" class="w-full py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs uppercase tracking-wider rounded-2xl shadow-lg transition-all flex items-center justify-center space-x-1.5">
                            <span>🐾 Afiliarme con este Ahorro</span>
                            <span>›</span>
                        </a>
                    </div>

                </div>

            </div>
        </section>

        <!-- 5. CATÁLOGO OFICIAL DE PLANES -->
        <section id="planes" class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center space-y-3 mb-10">
                    <div class="inline-flex items-center space-x-2 bg-teal-50 border border-teal-200 px-3 py-1 rounded-full text-brand-primary text-xs font-bold shadow-xs">
                        <span>🐾</span>
                        <span>Planes de Bienestar y Cobertura Preventiva</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Elige el plan ideal para tu peludo</h2>
                    <p class="text-slate-500 text-xs sm:text-sm max-w-2xl mx-auto font-medium">
                        Cuidado médico de primera categoría en <strong>{{ $tenant->name }}</strong>. Paga mes a mes o activa todos los servicios inmediatamente con el plan anual.
                    </p>

                    <!-- SELECTOR FACTURACIÓN -->
                    <div class="pt-4 flex items-center justify-center">
                        <div class="bg-slate-200/70 p-1.5 rounded-2xl inline-flex items-center gap-1 shadow-inner">
                            <button type="button" onclick="setBillingCycle('monthly')" id="btn-cycle-monthly" class="px-5 py-2 rounded-xl font-bold text-xs transition-all bg-white text-slate-900 shadow-xs">
                                📅 Pago Mensual
                            </button>
                            <button type="button" onclick="setBillingCycle('annual')" id="btn-cycle-annual" class="px-5 py-2 rounded-xl font-bold text-xs transition-all text-slate-600 hover:text-slate-900 flex items-center space-x-1.5">
                                <span>⭐ Pago Anual</span>
                                <span class="bg-emerald-600 text-white text-[9px] font-black px-2 py-0.5 rounded-full uppercase">-10%</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 max-w-5xl gap-8 mx-auto items-stretch">
                    
                    <!-- PLAN BÁSICO -->
                    <div id="plan-card-basico" onclick="selectPlanCard('basico')" class="plan-card cursor-pointer bg-white rounded-3xl p-6 sm:p-8 border-2 border-brand-primary ring-2 ring-brand-primary/20 shadow-md flex flex-col justify-between transition-all relative">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl font-bold shadow-xs bg-teal-50 text-teal-700">
                                        🛡️
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-slate-900">Plan Patitas Básico</h3>
                                        <p class="text-xs text-slate-500 font-medium">Prevención integral y consultas periódicas</p>
                                    </div>
                                </div>
                                <span id="badge-selected-basico" class="px-3 py-1 bg-brand-primary text-white text-[10px] font-black rounded-full uppercase tracking-wider">
                                    Seleccionado ✓
                                </span>
                            </div>

                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                                <div class="monthly-price-block">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900">$50.000</span>
                                        <span class="text-slate-500 text-xs font-bold">COP / mes</span>
                                    </div>
                                    <p class="text-[11px] text-teal-700 font-semibold pt-1">
                                        • Mes 1: <strong>$100.000 COP</strong> (Incluye $50.000 de afiliación única)<br>
                                        • Mes 2 en adelante: <strong>$50.000 COP/mes</strong>
                                    </p>
                                </div>
                                <div class="annual-price-block hidden">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900">$540.000</span>
                                        <span class="text-slate-500 text-xs font-bold">COP / año</span>
                                    </div>
                                    <p class="text-[11px] text-emerald-700 font-bold pt-1">
                                        🎁 Afiliación bonificada ($0) • 🚀 <strong>ACTIVACIÓN INMEDIATA</strong> sin esperas.
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-3 text-xs font-medium text-slate-700">
                                <p class="text-[11px] font-black uppercase tracking-wider text-slate-900">Beneficios Incluidos:</p>
                                <div class="flex items-start space-x-2">
                                    <span class="text-teal-600 font-black">✓</span>
                                    <span><strong>3 Consultas Presenciales</strong> al año con valoración médica.</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-teal-600 font-black">✓</span>
                                    <span><strong>Consultas Virtuales ILIMITADAS</strong> de lunes a domingo.</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-teal-600 font-black">✓</span>
                                    <span><strong>1 Vacunación Anual</strong> (Pentavalente/Triple + Rabia).</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-teal-600 font-black">✓</span>
                                    <span><strong>3 Desparasitaciones Internas</strong> periódicas.</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-teal-600 font-black">✓</span>
                                    <span><strong>1 Desparasitación Externa</strong> (Credelio / Pipeta).</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-teal-600 font-black">✓</span>
                                    <span><strong>1 Examen de Laboratorio</strong> (Hemograma o Perfil Renal).</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-teal-600 font-black">✓</span>
                                    <span><strong>2 Baños & Estética</strong> médica canina/felina.</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-teal-600 font-black">✓</span>
                                    <span><strong>Kit de Bienvenida</strong> (Cédula Digital + Placa + Collar).</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <a href="https://wa.me/57{{ preg_replace('/[^0-9]/', '', $phone) }}?text=Hola,%20quiero%20afiliar%20a%20mi%20mascota%20al%20Plan%20Patitas%20B%C3%A1sico%20en%20{{ urlencode($tenant->name) }}" target="_blank" class="w-full py-3.5 bg-brand-primary text-white font-black text-xs uppercase tracking-wider rounded-2xl shadow-md hover:opacity-95 transition-all flex items-center justify-center space-x-1.5">
                                <span>Afiliarme al Plan Básico</span>
                                <span>›</span>
                            </a>
                        </div>
                    </div>

                    <!-- PLAN PREMIUM -->
                    <div id="plan-card-premium" onclick="selectPlanCard('premium')" class="plan-card cursor-pointer bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-md flex flex-col justify-between transition-all relative">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl font-bold shadow-xs bg-purple-50 text-purple-700">
                                        💎
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-slate-900">Plan Patitas Premium</h3>
                                        <p class="text-xs text-slate-500 font-medium">Protección integral y máxima cobertura médica</p>
                                    </div>
                                </div>
                                <span id="badge-selected-premium" class="hidden px-3 py-1 bg-purple-600 text-white text-[10px] font-black rounded-full uppercase tracking-wider">
                                    Seleccionado ✓
                                </span>
                            </div>

                            <div class="p-4 rounded-2xl bg-purple-50/50 border border-purple-100 space-y-1">
                                <div class="monthly-price-block">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900">$80.000</span>
                                        <span class="text-slate-500 text-xs font-bold">COP / mes</span>
                                    </div>
                                    <p class="text-[11px] text-purple-700 font-semibold pt-1">
                                        • Mes 1: <strong>$130.000 COP</strong> (Incluye $50.000 de afiliación única)<br>
                                        • Mes 2 en adelante: <strong>$80.000 COP/mes</strong>
                                    </p>
                                </div>
                                <div class="annual-price-block hidden">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900">$864.000</span>
                                        <span class="text-slate-500 text-xs font-bold">COP / año</span>
                                    </div>
                                    <p class="text-[11px] text-emerald-700 font-bold pt-1">
                                        🎁 Afiliación bonificada ($0) • 🚀 <strong>ACTIVACIÓN INMEDIATA</strong> sin esperas.
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-3 text-xs font-medium text-slate-700">
                                <p class="text-[11px] font-black uppercase tracking-wider text-slate-900">Beneficios Premium Exclusivos:</p>
                                <div class="flex items-start space-x-2">
                                    <span class="text-purple-600 font-black">✓</span>
                                    <span><strong>Todo lo del Plan Básico</strong> reforzado.</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-purple-600 font-black">✓</span>
                                    <span><strong>1 Ecografía Abdominal</strong> o estudio de imagen anual.</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-purple-600 font-black">✓</span>
                                    <span><strong>Limpieza Dental (Profilaxis) con 50% de Descuento</strong>.</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-purple-600 font-black">✓</span>
                                    <span><strong>2 Exámenes de Laboratorio Completos</strong> (Hemograma + Bioquímica).</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-purple-600 font-black">✓</span>
                                    <span><strong>Servicio Funerario 100% Gratuito</strong> cubierto en el plan.</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <a href="https://wa.me/57{{ preg_replace('/[^0-9]/', '', $phone) }}?text=Hola,%20quiero%20afiliar%20a%20mi%20mascota%20al%20Plan%20Patitas%20Premium%20en%20{{ urlencode($tenant->name) }}" target="_blank" class="w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-black text-xs uppercase tracking-wider rounded-2xl shadow-md transition-all flex items-center justify-center space-x-1.5">
                                <span>Afiliarme al Plan Premium</span>
                                <span>›</span>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 6. SECCIÓN INSTALACIONES & CONSULTORIO VETERINARIO (FOTOS & VIDEO) -->
        <section id="instalaciones" class="py-16 sm:py-24 bg-white border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center space-y-3 mb-12">
                    <div class="inline-flex items-center space-x-2 bg-teal-50 border border-teal-200 text-teal-800 text-xs font-bold px-3 py-1 rounded-full">
                        <span>🏥 Atención Médica Presencial</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                        Conoce Nuestras Instalaciones en {{ $city }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto font-medium">
                        Un espacio moderno, cálido y equipado con tecnología veterinaria para brindarle a tu mascota el cuidado que se merece.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center max-w-6xl mx-auto">
                    
                    <!-- Cover Photo o Video Principal -->
                    <div class="lg:col-span-7 rounded-3xl overflow-hidden shadow-xl border border-slate-200 bg-slate-900 relative aspect-video flex items-center justify-center group">
                        @if(!empty($bannerVideo))
                            <video class="w-full h-full object-cover" controls autoplay muted loop playsinline poster="{{ $bannerImage }}">
                                <source src="{{ $bannerVideo }}" type="video/mp4">
                                Tu navegador no soporta video.
                            </video>
                        @elseif(!empty($bannerImage))
                            <img src="{{ $bannerImage }}" alt="Instalaciones de {{ $tenant->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        @else
                            <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=1000" alt="Consultorio Veterinario" class="w-full h-full object-cover" loading="lazy">
                        @endif

                        <div class="absolute bottom-3 left-3 right-3 bg-slate-950/85 backdrop-blur-md p-3.5 rounded-2xl text-white flex items-center justify-between text-xs border border-white/10">
                            <div class="flex items-center space-x-2 min-w-0">
                                <span class="text-base shrink-0">📍</span>
                                <span class="font-bold text-[11px] truncate">{{ $address }}</span>
                            </div>
                            <span class="text-[10px] text-emerald-400 font-black bg-emerald-950/80 px-2.5 py-0.5 rounded-full uppercase tracking-wider shrink-0">Abierto L-S</span>
                        </div>
                    </div>

                    <!-- Datos de la Clínica & Foto Secundaria de Pacientes -->
                    <div class="lg:col-span-5 space-y-5">
                        @if(!empty($heroImage))
                            <div class="rounded-3xl overflow-hidden shadow-md border border-slate-200 aspect-[16/9] relative group">
                                <img src="{{ $heroImage }}" alt="Pacientes de {{ $tenant->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-3 py-1 rounded-full text-[10px] font-black text-slate-900 shadow-sm border border-slate-100">
                                    🐾 Pacientes Felices
                                </div>
                            </div>
                        @endif

                        <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200 space-y-4">
                            <h3 class="font-black text-sm sm:text-base text-slate-900 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                Información de Atención & Consultorio
                            </h3>

                            <div class="space-y-2.5 text-xs text-slate-600 font-medium">
                                <div class="flex items-start gap-2.5">
                                    <span class="text-slate-400 font-bold">📍 Dirección:</span>
                                    <span class="font-bold text-slate-900">{{ $address }}</span>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <span class="text-slate-400 font-bold">🏙️ Ciudad:</span>
                                    <span class="font-bold text-slate-900">{{ $city }}</span>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <span class="text-slate-400 font-bold">📞 WhatsApp Oficial:</span>
                                    <span class="font-bold text-emerald-600">{{ $phone }}</span>
                                </div>
                            </div>

                            <a href="https://wa.me/57{{ preg_replace('/[^0-9]/', '', $phone) }}?text=Hola,%20quiero%20conocer%20la%20ubicaci%C3%B3n%20y%20agendar%20visita%20en%20{{ urlencode($tenant->name) }}" target="_blank" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-black text-xs rounded-2xl transition flex items-center justify-center gap-2">
                                <span>💬 Cómo Llegar por WhatsApp</span>
                                <span>↗</span>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 7. PREGUNTAS FRECUENTES (FAQ) -->
        <section id="faq" class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="text-center space-y-2">
                    <span class="text-xs font-black text-brand-primary uppercase tracking-widest">Resolvemos tus inquietudes</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900">Preguntas Frecuentes</h3>
                </div>

                <div class="space-y-3.5">
                    <!-- FAQ 1 -->
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                        <button type="button" onclick="toggleFaq(1)" class="w-full p-4 sm:p-5 text-left font-bold text-xs sm:text-sm text-slate-900 flex items-center justify-between gap-2 hover:bg-slate-50 transition">
                            <span>¿Cómo solicito una cita o servicio una vez afiliado?</span>
                            <span id="faq-icon-1" class="text-teal-600 font-black text-base">+</span>
                        </button>
                        <div id="faq-content-1" class="hidden px-4 pb-4 sm:px-5 sm:pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3 font-normal">
                            Solo debes comunicarte a nuestra línea única oficial de WhatsApp <strong>{{ $phone }}</strong>. Nuestro equipo valida tu carnet digital en recepción en segundos y agenda tu cita prioritaria.
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                        <button type="button" onclick="toggleFaq(2)" class="w-full p-4 sm:p-5 text-left font-bold text-xs sm:text-sm text-slate-900 flex items-center justify-between gap-2 hover:bg-slate-50 transition">
                            <span>¿Qué incluye el Kit de Bienvenida?</span>
                            <span id="faq-icon-2" class="text-teal-600 font-black text-base">+</span>
                        </button>
                        <div id="faq-content-2" class="hidden px-4 pb-4 sm:px-5 sm:pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3 font-normal">
                            Incluye la Cédula Digital de tu mascota, Collar con Placa de identificación física grabada, apertura de historia clínica y la primera dosis de desparasitación interna.
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                        <button type="button" onclick="toggleFaq(3)" class="w-full p-4 sm:p-5 text-left font-bold text-xs sm:text-sm text-slate-900 flex items-center justify-between gap-2 hover:bg-slate-50 transition">
                            <span>¿Qué diferencia hay entre pago mensual y pago anual?</span>
                            <span id="faq-icon-3" class="text-teal-600 font-black text-base">+</span>
                        </button>
                        <div id="faq-content-3" class="hidden px-4 pb-4 sm:px-5 sm:pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3 font-normal">
                            En el pago mensual los beneficios se habilitan progresivamente mes a mes. En el <strong>pago anual anticipado</strong> obtienes un 10% de descuento directo y todos los servicios se activan <strong>inmediatamente sin periodos de carencia</strong>.
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 8. BANNER WHATSAPP -->
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-3xl p-8 sm:p-12 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
                    <div class="flex items-center space-x-5 z-10">
                        <div class="w-16 h-16 rounded-2xl bg-white/15 flex items-center justify-center text-3xl shrink-0 backdrop-blur-md border border-white/20">
                            💬
                        </div>
                        <div>
                            <h3 class="text-2xl sm:text-3xl font-black">¿Tienes dudas sobre los planes?</h3>
                            <p class="text-teal-100 text-sm mt-1">Escríbenos directamente a nuestra línea oficial de {{ $tenant->name }}</p>
                        </div>
                    </div>
                    
                    <a href="https://wa.me/57{{ preg_replace('/[^0-9]/', '', $phone) }}?text=Hola,%20tengo%20dudas%20sobre%20los%20Planes%20de%20{{ urlencode($tenant->name) }}" target="_blank" class="z-10 px-8 py-4 bg-white text-slate-900 hover:bg-slate-50 font-black text-sm rounded-full shadow-lg transition-all flex items-center space-x-2 shrink-0">
                        <span>💬 Chatear por WhatsApp</span>
                        <span>›</span>
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- 9. FOOTER -->
    <footer id="contacto" class="bg-slate-950 text-slate-400 py-12 text-xs border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="space-y-3">
                <div class="flex items-center space-x-2">
                    @if(!empty($logoUrl))
                        <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="h-8 w-auto object-contain">
                    @else
                        <span class="text-teal-400 font-bold text-xl">🐾</span>
                    @endif
                    <span class="text-base font-black text-white">{{ $tenant->name }}</span>
                </div>
                <p class="text-slate-400 leading-relaxed">{{ $address }}, {{ $city }}.</p>
            </div>

            <div>
                <p class="font-black text-white uppercase tracking-wider mb-2">Horarios de Atención</p>
                <p class="text-slate-400">Lunes a Sábado: 8:00 AM - 7:00 PM</p>
                <p class="text-slate-400">Urgencias y Consultas Virtuales: 24/7</p>
            </div>

            <div>
                <p class="font-black text-white uppercase tracking-wider mb-2">Contacto Directo</p>
                <p class="text-slate-400">WhatsApp: <strong class="text-teal-400">{{ $phone }}</strong></p>
                <p class="text-slate-400">Email: {{ $tenant->branding['email'] ?? 'contacto@vetpetpatitas.com' }}</p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 mt-8 border-t border-slate-900 text-center text-slate-400 text-[11px]">
            © {{ date('Y') }} {{ $tenant->name }}. Plataforma de Membresías desarrollada con tecnología AVI-SaaS.
        </div>
    </footer>

    <!-- JAVASCRIPT INTERACTIVO -->
    <script>
        // Simulador de Carnet
        function updateLiveCarnet() {
            const name = document.getElementById('live-pet-name').value || 'TU MASCOTA';
            const breed = document.getElementById('live-pet-breed').value || 'Raza';
            document.getElementById('card-pet-name').innerText = name.toUpperCase();
            document.getElementById('card-pet-breed').innerText = breed;
        }

        function setLivePetType(type) {
            const emojiEl = document.getElementById('card-pet-emoji');
            const btnDog = document.getElementById('btn-pet-dog');
            const btnCat = document.getElementById('btn-pet-cat');

            if (type === 'cat') {
                emojiEl.innerText = '🐱';
                btnCat.className = 'flex-1 py-1.5 text-xs font-bold rounded-lg transition bg-white text-slate-900 shadow-xs text-center';
                btnDog.className = 'flex-1 py-1.5 text-xs font-bold rounded-lg transition text-slate-500 hover:text-slate-900 text-center';
            } else {
                emojiEl.innerText = '🐕';
                btnDog.className = 'flex-1 py-1.5 text-xs font-bold rounded-lg transition bg-white text-slate-900 shadow-xs text-center';
                btnCat.className = 'flex-1 py-1.5 text-xs font-bold rounded-lg transition text-slate-500 hover:text-slate-900 text-center';
            }
            updateLiveCarnet();
        }

        // Calculadora de Ahorro
        function calculateSavings() {
            const consultas = parseInt(document.getElementById('calc-consultas').value) || 3;
            const baths = parseInt(document.getElementById('calc-baths').value) || 2;

            document.getElementById('calc-consultas-val').innerText = consultas + (consultas === 1 ? ' consulta' : ' consultas');
            document.getElementById('calc-baths-val').innerText = baths + (baths === 1 ? ' baño' : ' baños');

            const valorConsultasPart = consultas * 65000;
            const valorBanosPart = baths * 45000;
            const valorPrevPart = 450000; // Vacunas + Desparasitaciones + Laboratorio
            const totalParticular = valorConsultasPart + valorBanosPart + valorPrevPart;

            const totalPlan = 540000;
            const ahorro = Math.max(0, totalParticular - totalPlan);
            const porcentaje = Math.round((ahorro / totalParticular) * 100);

            document.getElementById('calc-particular-price').innerText = '$' + totalParticular.toLocaleString('es-CO') + ' COP';
            document.getElementById('calc-savings-total').innerText = '$' + ahorro.toLocaleString('es-CO') + ' COP';
            document.getElementById('calc-savings-percent').innerText = 'Ahorras un ' + porcentaje + '% en salud médica';
        }

        // Selector Mensual vs Anual
        function setBillingCycle(cycle) {
            const btnMonthly = document.getElementById('btn-cycle-monthly');
            const btnAnnual = document.getElementById('btn-cycle-annual');
            const monthlyBlocks = document.querySelectorAll('.monthly-price-block');
            const annualBlocks = document.querySelectorAll('.annual-price-block');

            if (cycle === 'annual') {
                btnAnnual.className = 'px-5 py-2 rounded-xl font-bold text-xs transition-all bg-white text-slate-900 shadow-xs flex items-center space-x-1.5';
                btnMonthly.className = 'px-5 py-2 rounded-xl font-bold text-xs transition-all text-slate-600 hover:text-slate-900';
                monthlyBlocks.forEach(el => el.classList.add('hidden'));
                annualBlocks.forEach(el => el.classList.remove('hidden'));
            } else {
                btnMonthly.className = 'px-5 py-2 rounded-xl font-bold text-xs transition-all bg-white text-slate-900 shadow-xs';
                btnAnnual.className = 'px-5 py-2 rounded-xl font-bold text-xs transition-all text-slate-600 hover:text-slate-900 flex items-center space-x-1.5';
                monthlyBlocks.forEach(el => el.classList.remove('hidden'));
                annualBlocks.forEach(el => el.classList.add('hidden'));
            }
        }

        // Selección de tarjeta de plan
        function selectPlanCard(plan) {
            const cardBasico = document.getElementById('plan-card-basico');
            const cardPremium = document.getElementById('plan-card-premium');
            const badgeBasico = document.getElementById('badge-selected-basico');
            const badgePremium = document.getElementById('badge-selected-premium');

            if (plan === 'premium') {
                cardPremium.className = 'plan-card cursor-pointer bg-white rounded-3xl p-6 sm:p-8 border-2 border-purple-600 ring-2 ring-purple-600/20 shadow-xl flex flex-col justify-between transition-all relative';
                cardBasico.className = 'plan-card cursor-pointer bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-md flex flex-col justify-between transition-all relative';
                badgePremium.classList.remove('hidden');
                badgeBasico.classList.add('hidden');
                document.getElementById('card-plan-name').innerText = 'Plan Patitas Premium';
                document.getElementById('card-plan-name').className = 'text-xs font-black text-purple-300';
            } else {
                cardBasico.className = 'plan-card cursor-pointer bg-white rounded-3xl p-6 sm:p-8 border-2 border-brand-primary ring-2 ring-brand-primary/20 shadow-xl flex flex-col justify-between transition-all relative';
                cardPremium.className = 'plan-card cursor-pointer bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-md flex flex-col justify-between transition-all relative';
                badgeBasico.classList.remove('hidden');
                badgePremium.classList.add('hidden');
                document.getElementById('card-plan-name').innerText = 'Plan Patitas Básico';
                document.getElementById('card-plan-name').className = 'text-xs font-black text-amber-300';
            }
        }

        // FAQ Toggle
        function toggleFaq(index) {
            const content = document.getElementById('faq-content-' + index);
            const icon = document.getElementById('faq-icon-' + index);
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.innerText = '−';
            } else {
                content.classList.add('hidden');
                icon.innerText = '+';
            }
        }
    </script>
</body>
</html>
