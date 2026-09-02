<!DOCTYPE html>
<html lang="es" class="h-full bg-white text-slate-900 antialiased selection:bg-teal-500 selection:text-white overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $tenant->name }} — Planes de Bienestar y Membresías Veterinarias</title>
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
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
    @endphp

    <style>
        :root {
            --brand-primary: {{ $primaryColor }};
            --brand-secondary: {{ $secondaryColor }};
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { 
            background: radial-gradient(circle at 80% 20%, {{ $primaryColor }}18 0%, #f0fdfa30 40%, rgba(255, 255, 255, 0) 75%); 
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
        .modal-backdrop {
            background-color: rgba(11, 17, 32, 0.75);
            backdrop-filter: blur(6px);
        }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between bg-white overflow-x-hidden">

    <!-- 1. TOP BAR DE ATENCIÓN MÉDICA -->
    <div class="bg-slate-950 text-white text-xs font-semibold py-2 px-3 sm:px-6 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-1.5 sm:gap-4 text-center sm:text-left">
            <div class="flex items-center space-x-2 text-teal-200 text-[11px] sm:text-xs">
                <span class="animate-pulse">🩺</span>
                <span class="font-bold">Membresías de Cuidado & Salud Preventiva • {{ $tenant->name }}</span>
            </div>
            <div class="flex items-center space-x-4 shrink-0">
                <a href="https://wa.me/57{{ $cleanPhone }}" target="_blank" class="flex items-center space-x-1.5 hover:text-teal-300 transition-colors text-[11px] sm:text-xs">
                    <svg class="w-3.5 h-3.5 fill-current text-teal-400 shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                    </svg>
                    <span>Línea Oficial:</span>
                    <span class="text-white font-bold">{{ $phone }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. NAVBAR CON IDENTIDAD DE MARCA COMPLETA -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-xs">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-2.5 sm:py-3.5 flex items-center justify-between gap-2 sm:gap-4">
            <div class="flex items-center space-x-2.5 sm:space-x-3.5 min-w-0">
                @if(!empty($logoUrl))
                    <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="h-10 sm:h-12 w-auto max-h-12 object-contain rounded-xl shrink-0 shadow-xs" loading="lazy">
                @else
                    <div class="w-10 h-10 rounded-xl bg-brand-primary flex items-center justify-center text-white text-xl shadow-md shrink-0">
                        🐾
                    </div>
                @endif
                <div class="min-w-0">
                    <span class="text-sm sm:text-base lg:text-lg font-black tracking-tight text-slate-900 leading-tight block">{{ $tenant->name }}</span>
                    <span class="inline-block text-[10px] sm:text-xs font-bold text-teal-700">📍 {{ $city }}</span>
                </div>
            </div>

            <nav class="hidden lg:flex items-center space-x-6 text-xs sm:text-sm font-bold text-slate-600 shrink-0">
                <a href="#por-que-un-plan" class="hover:text-brand-primary transition-colors">¿Por qué un Plan?</a>
                <a href="#calculadora" class="hover:text-brand-primary transition-colors flex items-center space-x-1">
                    <span>🧮 Calculadora</span>
                    <span class="bg-amber-100 text-amber-800 text-[10px] font-extrabold px-1.5 py-0.5 rounded-full">Ahorro</span>
                </a>
                <a href="#planes" class="hover:text-brand-primary transition-colors">Planes</a>
                <a href="#comparador" class="hover:text-brand-primary transition-colors">Comparar</a>
                <a href="#como-funciona" class="hover:text-brand-primary transition-colors">Cómo Funciona</a>
                <a href="#instalaciones" class="hover:text-brand-primary transition-colors">Instalaciones</a>
                <a href="#faq" class="hover:text-brand-primary transition-colors">Preguntas</a>
            </nav>

            <div class="flex items-center space-x-2 sm:space-x-3 shrink-0">
                <a href="/admin/{{ $tenant->slug }}" class="hidden sm:inline-block px-3.5 sm:px-4 py-2 text-xs font-bold text-slate-700 hover:text-slate-900 border border-slate-200 rounded-full hover:bg-slate-50 transition-all">
                    Panel
                </a>
                <button type="button" onclick="openEnrollModal('basico')" class="px-3.5 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-black text-white bg-brand-primary hover:opacity-90 rounded-full shadow-md transition-all whitespace-nowrap">
                    Afiliar Mascota 🐾
                </button>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- 01. HERO POTENTE CON PROPUESTA DE VALOR Y ELEMENTOS DE CONFIANZA -->
        <section class="hero-gradient relative pt-8 sm:pt-14 pb-16 sm:pb-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- COLUMNA IZQUIERDA: MENSAJE PRINCIPAL + LLAMADO A LA ACCIÓN -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <div class="inline-flex items-center space-x-3 bg-white px-4 py-1.5 rounded-full shadow-xs border border-slate-200">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                            </span>
                            <span class="text-xs font-black text-slate-800 uppercase tracking-wider">Membresías de Salud Preventiva 2026</span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.12]">
                            Salud preventiva y <span class="text-brand-primary underline decoration-teal-300">cuidado continuo</span> para tu mascota
                        </h1>

                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl font-normal">
                            Un plan diseñado por <strong class="text-slate-900">{{ $tenant->name }}</strong> para que cuides a tu mascota durante todo el año, con consultas, vacunas, controles incluidos y precios preferenciales en {{ $city }}.
                        </p>

                        <!-- ELEMENTOS DE CONFIANZA RÁPIDA (TRUST BADGES) -->
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 pt-1 text-xs font-bold text-slate-700">
                            <div class="flex items-center space-x-1.5 bg-white/80 backdrop-blur-xs px-3 py-1.5 rounded-xl border border-slate-200 shadow-xs">
                                <span>🐾</span>
                                <span>+450 mascotas atendidas</span>
                            </div>
                            <div class="flex items-center space-x-1.5 bg-white/80 backdrop-blur-xs px-3 py-1.5 rounded-xl border border-slate-200 shadow-xs">
                                <span>📍</span>
                                <span>Sede en {{ $city }}</span>
                            </div>
                            <div class="flex items-center space-x-1.5 bg-white/80 backdrop-blur-xs px-3 py-1.5 rounded-xl border border-slate-200 shadow-xs">
                                <span class="text-amber-400">⭐⭐⭐⭐⭐</span>
                                <span>Atención profesional</span>
                            </div>
                        </div>

                        <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5">
                            <a href="#planes" class="px-7 py-4 rounded-full bg-brand-primary text-white font-extrabold text-sm shadow-lg hover:opacity-90 transition-all flex items-center justify-center space-x-2 text-center">
                                <span>Ver Planes de Salud</span>
                                <span>›</span>
                            </a>
                            <a href="#calculadora" class="px-6 py-4 rounded-full bg-white hover:bg-slate-50 text-slate-800 font-extrabold text-sm border border-slate-200 shadow-xs transition-all flex items-center justify-center space-x-2 text-center">
                                <span>🧮 Calcular Mi Ahorro Anual</span>
                            </a>
                        </div>
                    </div>

                    <!-- COLUMNA DERECHA: FOTO PRINCIPAL + CARNET DIGITAL PREVIEW -->
                    <div class="lg:col-span-5 relative mt-4 lg:mt-0 space-y-4">
                        <div class="mx-auto max-w-sm sm:max-w-md space-y-4">
                            
                            <!-- TARJETA VISUAL DE LA CLÍNICA / FOTO HERO -->
                            <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-slate-900 relative aspect-[4/3] group">
                                <img src="{{ $heroImage }}" alt="Pacientes de {{ $tenant->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                                
                                <div class="absolute bottom-3.5 left-3.5 right-3.5 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-lg border border-slate-100 flex items-center justify-between gap-2">
                                    <div class="flex items-center space-x-2.5 min-w-0">
                                        <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-black text-sm shrink-0">
                                            🩺
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-black text-slate-900 truncate">Membresía Digital Activa</p>
                                            <p class="text-[10px] text-teal-700 font-bold truncate">Validación por Chip & QR</p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="openEnrollModal('basico')" class="px-3 py-1.5 bg-brand-primary text-white font-black text-xs rounded-xl shadow-xs shrink-0 hover:opacity-90">
                                        Afiliarme 🐾
                                    </button>
                                </div>
                            </div>

                            <!-- Estado de Atención -->
                            <div class="bg-white p-3.5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between text-xs">
                                <div class="flex items-center space-x-2.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                                    <span class="font-bold text-slate-700">Atención médica disponible en {{ $city }}</span>
                                </div>
                                <a href="#planes" class="text-brand-primary font-black hover:underline">Ver Planes →</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 02. ¿POR QUÉ UNA MEMBRESÍA DE SALUD? (PILARES DE VALOR) -->
        <section id="por-que-un-plan" class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-3 mb-12">
                    <div class="inline-flex items-center space-x-2 bg-teal-100 text-teal-800 text-xs font-bold px-3 py-1 rounded-full">
                        <span>🐾 Cuidado Inteligente</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight max-w-3xl mx-auto">
                        Cuidar a tu mascota no debería depender de cuándo aparece una urgencia
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-2xl mx-auto font-medium">
                        La medicina preventiva evita enfermedades complejas, alarga los años de vida de tu peludo y te protege de gastos imprevistos.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                    <!-- Tarjeta 1: Prevención -->
                    <div class="bg-white p-7 rounded-3xl border border-slate-200 shadow-xs hover:shadow-md transition space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center text-2xl font-black">
                            🛡️
                        </div>
                        <h3 class="text-lg font-black text-slate-900">Prevención Activa</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Mantén al día sus consultas, vacunaciones anuales, desparasitaciones y chequeos clínicos antes de que aparezcan síntomas graves.
                        </p>
                    </div>

                    <!-- Tarjeta 2: Ahorro -->
                    <div class="bg-white p-7 rounded-3xl border border-slate-200 shadow-xs hover:shadow-md transition space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl font-black">
                            💰
                        </div>
                        <h3 class="text-lg font-black text-slate-900">Ahorro Real y Predecible</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Accede a servicios esenciales 100% incluidos en una cuota fija mensual o anual, ahorrando hasta un 36% frente a tarifas particulares.
                        </p>
                    </div>

                    <!-- Tarjeta 3: Continuidad -->
                    <div class="bg-white p-7 rounded-3xl border border-slate-200 shadow-xs hover:shadow-md transition space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-700 flex items-center justify-center text-2xl font-black">
                            🩺
                        </div>
                        <h3 class="text-lg font-black text-slate-900">Continuidad Médica</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Tu mascota cuenta con historial clínico unificado, carnet digital y acompañamiento veterinario permanente en {{ $tenant->name }}.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 04. SIMULADOR DE AHORRO ANUAL ⭐ -->
        <section id="calculadora" class="py-16 sm:py-20 bg-slate-900 text-white relative overflow-hidden">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                
                <div class="text-center space-y-3 mb-12">
                    <div class="inline-flex items-center space-x-2 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-full text-emerald-400 text-xs font-bold uppercase tracking-wider">
                        <span>🧮 Simula el Ahorro de tu Mascota</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                        ¿Cuánto dinero ahorras con una Membresía de Salud?
                    </h2>
                    <p class="text-slate-400 text-sm max-w-xl mx-auto">
                        Selecciona el cuidado que necesita tu mascota durante el año y compara el costo particular vs el Plan de Bienestar en <strong>{{ $tenant->name }}</strong>.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bg-slate-950/80 p-6 sm:p-10 rounded-3xl border border-slate-800 shadow-2xl">
                    
                    <!-- CONTROLES (IZQUIERDA) -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <!-- 1. Consultas -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <label class="font-bold text-slate-300">🐶 Consultas presenciales al año:</label>
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
                            <p class="text-xs font-bold text-slate-300">💉 Servicios preventivos incluidos en el cálculo:</p>
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
                            <p class="text-xs font-black uppercase tracking-widest text-emerald-400">Con Membresía Pagas Solo:</p>
                            <p id="calc-plan-price" class="text-3xl sm:text-4xl font-black text-white mt-1">$540.000 <span class="text-xs font-normal text-slate-400">COP/año</span></p>
                        </div>

                        <div class="bg-emerald-500/15 border border-emerald-500/30 p-4 rounded-2xl space-y-1">
                            <p class="text-xs font-bold text-emerald-300">¡Tu Ahorro Neto Anual Estimado!</p>
                            <p id="calc-savings-total" class="text-3xl font-black text-emerald-400">$300.000 COP</p>
                            <p id="calc-savings-percent" class="text-[11px] text-emerald-200 font-bold">Ahorras un 36% en salud veterinaria</p>
                        </div>

                        <button type="button" onclick="openEnrollModal('basico')" class="w-full py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs uppercase tracking-wider rounded-2xl shadow-lg transition-all flex items-center justify-center space-x-1.5">
                            <span>🐾 Quiero Este Plan y Ahorrar</span>
                            <span>›</span>
                        </button>
                    </div>

                </div>

            </div>
        </section>

        <!-- 05. PLANES DE MEMBRESÍA -->
        <section id="planes" class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center space-y-3 mb-10">
                    <div class="inline-flex items-center space-x-2 bg-teal-50 border border-teal-200 px-3 py-1 rounded-full text-brand-primary text-xs font-bold shadow-xs">
                        <span>🐾</span>
                        <span>Membresías de Cuidado Preventivo</span>
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
                    <div id="plan-card-basico" class="plan-card bg-white rounded-3xl p-6 sm:p-8 border-2 border-brand-primary ring-2 ring-brand-primary/20 shadow-md flex flex-col justify-between transition-all relative">
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
                                <span class="px-3 py-1 bg-brand-primary text-white text-[10px] font-black rounded-full uppercase tracking-wider">
                                    Básico ✓
                                </span>
                            </div>

                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                                <div class="monthly-price-block">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900">$50.000</span>
                                        <span class="text-slate-500 text-xs font-bold">COP / mes</span>
                                    </div>
                                    <p class="text-[11px] text-teal-700 font-semibold pt-1">
                                        • Mes 1: <strong>$100.000 COP</strong> ($50.000 cuota + $50.000 inscripción y Kit de Bienvenida)<br>
                                        • Mes 2 en adelante: <strong>$50.000 COP/mes</strong>
                                    </p>
                                </div>
                                <div class="annual-price-block hidden">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900">$540.000</span>
                                        <span class="text-slate-500 text-xs font-bold">COP / año</span>
                                        <span class="text-xs text-slate-400 line-through ml-1">$600.000</span>
                                    </div>
                                    <p class="text-[11px] text-emerald-700 font-bold pt-1">
                                        🎁 Inscripción bonificada ($0) • 🚀 <strong>ACTIVACIÓN INMEDIATA</strong> sin carencias (Ahorras $60.000).
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-3 text-xs font-medium text-slate-700">
                                <p class="text-[11px] font-black uppercase tracking-wider text-slate-900">Beneficios Incluidos al Año:</p>
                                <div class="flex items-start space-x-2">
                                    <span class="text-teal-600 font-black">✓</span>
                                    <span><strong>3 Consultas Presenciales</strong> con valoración médica.</span>
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
                                    <span><strong>3 Desparasitaciones Internas</strong>.</span>
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
                                    <span><strong>2 Baños & Peluquería</strong> médica.</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-teal-600 font-black">✓</span>
                                    <span><strong>Kit de Bienvenida</strong> (Cédula Digital + Placa + Collar).</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="button" onclick="openEnrollModal('basico')" class="w-full py-3.5 bg-brand-primary text-white font-black text-xs uppercase tracking-wider rounded-2xl shadow-md hover:opacity-95 transition-all flex items-center justify-center space-x-1.5">
                                <span>🐾 Afiliarme al Plan Básico</span>
                                <span>›</span>
                            </button>
                        </div>
                    </div>

                    <!-- PLAN PREMIUM (MÁS ELEGIDO) -->
                    <div id="plan-card-premium" class="plan-card bg-white rounded-3xl p-6 sm:p-8 border-2 border-purple-600 ring-2 ring-purple-600/20 shadow-xl flex flex-col justify-between transition-all relative">
                        
                        <div class="absolute -top-3.5 right-6 bg-purple-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                            ⭐ MÁS ELEGIDO
                        </div>

                        <div class="space-y-6 pt-1">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl font-bold shadow-xs bg-purple-50 text-purple-700">
                                        💎
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-slate-900">Plan Patitas Premium</h3>
                                        <p class="text-xs text-slate-500 font-medium">Máxima cobertura preventiva y diagnóstica</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 rounded-2xl bg-purple-50/60 border border-purple-100 space-y-1">
                                <div class="monthly-price-block">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900">$80.000</span>
                                        <span class="text-slate-500 text-xs font-bold">COP / mes</span>
                                    </div>
                                    <p class="text-[11px] text-purple-700 font-semibold pt-1">
                                        • Mes 1: <strong>$130.000 COP</strong> ($80.000 cuota + $50.000 inscripción y Kit de Bienvenida)<br>
                                        • Mes 2 en adelante: <strong>$80.000 COP/mes</strong>
                                    </p>
                                </div>
                                <div class="annual-price-block hidden">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900">$864.000</span>
                                        <span class="text-slate-500 text-xs font-bold">COP / año</span>
                                        <span class="text-xs text-slate-400 line-through ml-1">$960.000</span>
                                    </div>
                                    <p class="text-[11px] text-emerald-700 font-bold pt-1">
                                        🎁 Inscripción bonificada ($0) • 🚀 <strong>ACTIVACIÓN INMEDIATA</strong> (Ahorras $96.000).
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-3 text-xs font-medium text-slate-700">
                                <p class="text-[11px] font-black uppercase tracking-wider text-slate-900">Beneficios Premium Exclusivos:</p>
                                <div class="flex items-start space-x-2">
                                    <span class="text-purple-600 font-black">✓</span>
                                    <span><strong>Todo lo del Plan Básico</strong> incluido.</span>
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
                            <button type="button" onclick="openEnrollModal('premium')" class="w-full py-3.5 bg-purple-700 hover:bg-purple-800 text-white font-black text-xs uppercase tracking-wider rounded-2xl shadow-md transition-all flex items-center justify-center space-x-1.5">
                                <span>💎 Afiliarme al Plan Premium</span>
                                <span>›</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 06. TABLA COMPARADORA DE PLANES ⭐ -->
        <section id="comparador" class="py-16 sm:py-20 bg-white border-t border-slate-100">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <div class="text-center space-y-2">
                    <span class="text-xs font-black text-brand-primary uppercase tracking-widest">Decide en segundos</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900">¿Cuál es el mejor plan para tu mascota?</h3>
                </div>

                <div class="overflow-x-auto rounded-3xl border border-slate-200 shadow-xs">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-slate-900 border-b border-slate-200">
                                <th class="p-4 sm:p-5 font-black">Beneficio / Servicio</th>
                                <th class="p-4 sm:p-5 font-black text-center text-teal-700">Plan Básico</th>
                                <th class="p-4 sm:p-5 font-black text-center text-purple-700 bg-purple-50/50">
                                    <span>Plan Premium</span>
                                    <span class="block text-[10px] text-purple-600 font-bold">⭐ Más Elegido</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            <tr>
                                <td class="p-4 sm:p-5 font-bold text-slate-900">🩺 Consultas Presenciales</td>
                                <td class="p-4 sm:p-5 text-center font-black">3 al año</td>
                                <td class="p-4 sm:p-5 text-center font-black bg-purple-50/20 text-purple-900">3 al año</td>
                            </tr>
                            <tr>
                                <td class="p-4 sm:p-5 font-bold text-slate-900">💬 Consultas Virtuales (L-D)</td>
                                <td class="p-4 sm:p-5 text-center text-emerald-600 font-black">ILIMITADAS</td>
                                <td class="p-4 sm:p-5 text-center text-emerald-600 font-black bg-purple-50/20">ILIMITADAS</td>
                            </tr>
                            <tr>
                                <td class="p-4 sm:p-5 font-bold text-slate-900">💉 Vacunación Anual Completa</td>
                                <td class="p-4 sm:p-5 text-center text-emerald-600 font-black">✓ Incluida</td>
                                <td class="p-4 sm:p-5 text-center text-emerald-600 font-black bg-purple-50/20">✓ Incluida</td>
                            </tr>
                            <tr>
                                <td class="p-4 sm:p-5 font-bold text-slate-900">💊 Desparasitación Interna</td>
                                <td class="p-4 sm:p-5 text-center font-black">3 dosis</td>
                                <td class="p-4 sm:p-5 text-center font-black bg-purple-50/20 text-purple-900">3 dosis</td>
                            </tr>
                            <tr>
                                <td class="p-4 sm:p-5 font-bold text-slate-900">🛡️ Desparasitación Externa (Credelio)</td>
                                <td class="p-4 sm:p-5 text-center font-black">1 dosis</td>
                                <td class="p-4 sm:p-5 text-center font-black bg-purple-50/20 text-purple-900">2 dosis</td>
                            </tr>
                            <tr>
                                <td class="p-4 sm:p-5 font-bold text-slate-900">🧪 Exámenes de Laboratorio</td>
                                <td class="p-4 sm:p-5 text-center font-black">1 prueba (Hemograma)</td>
                                <td class="p-4 sm:p-5 text-center font-black bg-purple-50/20 text-purple-900">2 pruebas completas</td>
                            </tr>
                            <tr>
                                <td class="p-4 sm:p-5 font-bold text-slate-900">🔬 Ecografía Abdominal</td>
                                <td class="p-4 sm:p-5 text-center text-slate-400">—</td>
                                <td class="p-4 sm:p-5 text-center font-black bg-purple-50/20 text-purple-900">1 al año (100% incluida)</td>
                            </tr>
                            <tr>
                                <td class="p-4 sm:p-5 font-bold text-slate-900">🦷 Profilaxis Dental</td>
                                <td class="p-4 sm:p-5 text-center text-slate-400">—</td>
                                <td class="p-4 sm:p-5 text-center font-black bg-purple-50/20 text-purple-900">50% de Descuento</td>
                            </tr>
                            <tr>
                                <td class="p-4 sm:p-5 font-bold text-slate-900">🕊️ Servicio Funerario</td>
                                <td class="p-4 sm:p-5 text-center font-black">10% Dcto</td>
                                <td class="p-4 sm:p-5 text-center font-black bg-purple-50/20 text-emerald-600">100% Gratuito Incluido</td>
                            </tr>
                            <tr>
                                <td class="p-4 sm:p-5 font-bold text-slate-900">🏷️ Kit de Bienvenida (Cédula + Placa)</td>
                                <td class="p-4 sm:p-5 text-center text-emerald-600 font-black">✓ Incluido</td>
                                <td class="p-4 sm:p-5 text-center text-emerald-600 font-black bg-purple-50/20">✓ Incluido</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-center gap-4 pt-2">
                    <button type="button" onclick="openEnrollModal('premium')" class="px-6 py-3 bg-purple-700 hover:bg-purple-800 text-white font-black text-xs rounded-full shadow-md transition">
                        💎 Elegir Plan Premium
                    </button>
                    <button type="button" onclick="openEnrollModal('basico')" class="px-6 py-3 bg-white text-slate-800 border border-slate-200 font-black text-xs rounded-full shadow-xs hover:bg-slate-50 transition">
                        🐾 Elegir Plan Básico
                    </button>
                </div>
            </div>
        </section>

        <!-- 06.5. CRONOGRAMA DE ACTIVACIÓN DE SERVICIOS (PERIODOS DE CARENCIA) -->
        <section id="carencias" class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
                <div class="text-center space-y-3">
                    <div class="inline-flex items-center space-x-2 bg-amber-100 text-amber-900 text-xs font-bold px-3 py-1 rounded-full border border-amber-200">
                        <span>⏳ Modalidad Mensual: Activación Progresiva</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                        Cronograma de Activación de Servicios
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-2xl mx-auto font-medium">
                        Si eliges pagar mes a mes, los beneficios se habilitan progresivamente. <strong>O paga el año completo y activa el 100% de los servicios el DÍA 1 sin esperas.</strong>
                    </p>

                    <!-- Selector de Plan en Carencias -->
                    <div class="pt-2 flex justify-center">
                        <div class="bg-slate-200/80 p-1 rounded-2xl inline-flex items-center gap-1 shadow-inner text-xs font-bold">
                            <button type="button" onclick="showCarenciaPlan('basico')" id="btn-car-basico" class="px-4 py-2 rounded-xl bg-white text-slate-900 shadow-xs transition-all">
                                🐾 Plan Básico
                            </button>
                            <button type="button" onclick="showCarenciaPlan('premium')" id="btn-car-premium" class="px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all">
                                💎 Plan Premium
                            </button>
                        </div>
                    </div>
                </div>

                <!-- BLOQUE CARENCIA: PLAN BÁSICO -->
                <div id="carencia-block-basico" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
                        
                        <!-- Día 0: Inmediato -->
                        <div class="bg-white p-5 rounded-2xl border border-teal-200 shadow-xs space-y-2.5">
                            <span class="inline-block px-2.5 py-0.5 bg-teal-600 text-white font-black text-[10px] rounded-full uppercase">Día 0 (Inmediato)</span>
                            <h4 class="font-black text-xs text-slate-900">Al Inscribirte:</h4>
                            <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                <li>Kit de Bienvenida (Cédula + Placa)</li>
                                <li>Apertura de Historia Clínica</li>
                                <li>1ra Desparasitación interna</li>
                                <li>Consultas virtuales ILIMITADAS (L-D)</li>
                                <li>Dctos en medicamentos y tienda</li>
                            </ul>
                        </div>

                        <!-- 30 Días (Mes 1+) -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-2.5">
                            <span class="inline-block px-2.5 py-0.5 bg-slate-800 text-white font-black text-[10px] rounded-full uppercase">A los 30 Días</span>
                            <h4 class="font-black text-xs text-slate-900">Mes 1+:</h4>
                            <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                <li>1ra Consulta presencial</li>
                                <li>Chequeo médico preventivo</li>
                                <li>Inyectología de estabilización (hasta $20k)</li>
                                <li>Recordatorios de salud preventiva</li>
                            </ul>
                        </div>

                        <!-- 90 Días (3 Meses+) -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-2.5">
                            <span class="inline-block px-2.5 py-0.5 bg-slate-800 text-white font-black text-[10px] rounded-full uppercase">A los 90 Días</span>
                            <h4 class="font-black text-xs text-slate-900">3 Meses+:</h4>
                            <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                <li>Todo lo anterior activo</li>
                                <li>Desparasitación externa antipulgas (Credelio o pipeta)</li>
                                <li>2da Consulta presencial</li>
                            </ul>
                        </div>

                        <!-- 180 Días (6 Meses+) -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-2.5">
                            <span class="inline-block px-2.5 py-0.5 bg-slate-800 text-white font-black text-[10px] rounded-full uppercase">A los 180 Días</span>
                            <h4 class="font-black text-xs text-slate-900">6 Meses+:</h4>
                            <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                <li>Todo lo anterior activo</li>
                                <li>Vacunación anual completa (Pentavalente + Rabia)</li>
                                <li>Examen de laboratorio (Hemograma o Perfil)</li>
                                <li>Citología de oídos</li>
                            </ul>
                        </div>

                        <!-- 240 Días (8 Meses+) -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-2.5 sm:col-span-2 lg:col-span-1">
                            <span class="inline-block px-2.5 py-0.5 bg-slate-800 text-white font-black text-[10px] rounded-full uppercase">A los 240 Días</span>
                            <h4 class="font-black text-xs text-slate-900">8 Meses+:</h4>
                            <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                <li>Todo lo anterior activo</li>
                                <li>2 Baños y peluquería médica</li>
                                <li>Servicio Funerario con 10% Dcto</li>
                            </ul>
                        </div>

                    </div>
                </div>

                <!-- BLOQUE CARENCIA: PLAN PREMIUM -->
                <div id="carencia-block-premium" class="space-y-4 hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                        
                        <!-- Día 0: Inmediato -->
                        <div class="bg-white p-5 rounded-2xl border border-purple-200 shadow-xs space-y-2.5">
                            <span class="inline-block px-2.5 py-0.5 bg-purple-600 text-white font-black text-[10px] rounded-full uppercase">Día 0 (Inmediato)</span>
                            <h4 class="font-black text-xs text-slate-900">Al Inscribirte:</h4>
                            <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                <li>Kit de Bienvenida Premium</li>
                                <li>1ra Desparasitación interna</li>
                                <li>Consultas virtuales ILIMITADAS (24/7)</li>
                                <li>Historia clínica digital</li>
                                <li>Dctos preferenciales en farmacia</li>
                            </ul>
                        </div>

                        <!-- 30 Días (Mes 1+) -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-2.5">
                            <span class="inline-block px-2.5 py-0.5 bg-slate-800 text-white font-black text-[10px] rounded-full uppercase">A los 30 Días</span>
                            <h4 class="font-black text-xs text-slate-900">Mes 1+:</h4>
                            <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                <li>1ra Consulta presencial especializada</li>
                                <li>Inyectología de estabilización ($20k)</li>
                                <li>1ra Desparasitación externa (Credelio)</li>
                            </ul>
                        </div>

                        <!-- 90 - 180 Días -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-2.5">
                            <span class="inline-block px-2.5 py-0.5 bg-slate-800 text-white font-black text-[10px] rounded-full uppercase">90 - 180 Días</span>
                            <h4 class="font-black text-xs text-slate-900">Diagnóstico Avanzado:</h4>
                            <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                <li>Vacunación anual completa</li>
                                <li>2da Desparasitación externa (Credelio)</li>
                                <li>2 Exámenes de Laboratorio (Hemograma + Bioquímica)</li>
                                <li>1 Ecografía Abdominal completa</li>
                            </ul>
                        </div>

                        <!-- 240 Días (8 Meses+) -->
                        <div class="bg-white p-5 rounded-2xl border border-purple-300 shadow-xs space-y-2.5">
                            <span class="inline-block px-2.5 py-0.5 bg-purple-700 text-white font-black text-[10px] rounded-full uppercase">A los 240 Días</span>
                            <h4 class="font-black text-xs text-slate-900">Cobertura Total:</h4>
                            <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc pl-3 font-medium">
                                <li>Limpieza Dental (Profilaxis) 50% Dcto</li>
                                <li>Baños y estética médica</li>
                                <li><strong>Servicio Funerario 100% Gratuito</strong></li>
                            </ul>
                        </div>

                    </div>
                </div>

                <!-- BANNER DESTACADO DE ACTIVACIÓN INMEDIATA CON PAGO ANUAL -->
                <div class="p-5 sm:p-6 rounded-3xl bg-emerald-500/10 border border-emerald-500/30 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center space-x-3.5 text-left">
                        <span class="text-3xl shrink-0">🚀</span>
                        <div>
                            <h4 class="font-black text-sm text-slate-900">¿Quieres todos los servicios activos desde el DÍA 1?</h4>
                            <p class="text-xs text-slate-600">Elige la modalidad de <strong>Pago Anual Anticipado</strong>: ahorras 10%, no pagas inscripción y <strong>desbloqueas el 100% de los beneficios de inmediato sin esperar días de carencia</strong>.</p>
                        </div>
                    </div>
                    <button type="button" onclick="setBillingCycle('annual'); openEnrollModal(selectedPlan);" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs rounded-full shadow-md shrink-0 whitespace-nowrap">
                        ⭐ Activar Plan Anual sin Carencias
                    </button>
                </div>

            </div>
        </section>

        <!-- 07. ¿CÓMO FUNCIONA TU MEMBRESÍA? (5 PASOS) -->
        <section id="como-funciona" class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                <div class="text-center space-y-3">
                    <div class="inline-flex items-center space-x-2 bg-teal-100 text-teal-800 text-xs font-bold px-3 py-1 rounded-full">
                        <span>⚡ Proceso 100% Digital</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">Así funciona tu membresía en 5 pasos</h2>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto">
                        Todo conectado directamente con el sistema médico de la clínica para una atención rápida y sin trámites.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Paso 1 -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                        <span class="text-2xl font-black text-teal-600 block">01</span>
                        <h4 class="font-black text-sm text-slate-900">Elige tu plan</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Selecciona la modalidad mensual o anual que mejor se adapte a tu peludo.</p>
                    </div>

                    <!-- Paso 2 -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                        <span class="text-2xl font-black text-teal-600 block">02</span>
                        <h4 class="font-black text-sm text-slate-900">Afíliate</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Completa los datos del tutor y tu mascota en menos de 1 minuto.</p>
                    </div>

                    <!-- Paso 3 -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                        <span class="text-2xl font-black text-teal-600 block">03</span>
                        <h4 class="font-black text-sm text-slate-900">Recibe tu carnet</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Tu mascota queda registrada en la base oficial con carnet digital único.</p>
                    </div>

                    <!-- Paso 4 -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                        <span class="text-2xl font-black text-teal-600 block">04</span>
                        <h4 class="font-black text-sm text-slate-900">Usa tus beneficios</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Acude a la clínica y el equipo valida y canjea tus servicios en recepción.</p>
                    </div>

                    <!-- Paso 5 -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                        <span class="text-2xl font-black text-teal-600 block">05</span>
                        <h4 class="font-black text-sm text-slate-900">Consulta saldos</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Conoce tus beneficios disponibles y el historial médico de tu mascota.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 08. CARNET DIGITAL INTERACTIVO (ELEMENTO DE CONVERSIÓN) -->
        <section class="py-16 sm:py-20 bg-white border-t border-slate-100">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <div class="lg:col-span-6 space-y-5">
                    <div class="inline-flex items-center space-x-2 bg-teal-50 border border-teal-200 text-teal-800 text-xs font-bold px-3 py-1 rounded-full">
                        <span>🐾 Tu Mascota en la Era Digital</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                        Tu mascota también tiene su Carnet Digital Oficial
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Con el Carnet Digital de <strong>{{ $tenant->name }}</strong>, consulta el estado de su membresía, historial de vacunas y saldo de consultas disponibles directamente desde tu teléfono.
                    </p>

                    <div class="space-y-2.5 text-xs text-slate-700 font-medium pt-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-teal-600 font-black">✓</span>
                            <span>Código QR único de validación médica en mostrador.</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-teal-600 font-black">✓</span>
                            <span>Apertura de historia clínica y placa con collar grabada.</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-teal-600 font-black">✓</span>
                            <span>Sincronizado en tiempo real con el software de la clínica.</span>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="button" onclick="openEnrollModal('basico')" class="px-7 py-3.5 bg-brand-primary text-white font-black text-xs uppercase tracking-wider rounded-2xl shadow-md hover:opacity-95">
                            🐾 Obtener Carnet Digital para mi Mascota
                        </button>
                    </div>
                </div>

                <div class="lg:col-span-6 flex justify-center">
                    <div class="w-full max-w-sm sm:max-w-md carnet-card rounded-3xl p-6 sm:p-7 text-white shadow-2xl relative overflow-hidden border border-white/20 select-none" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
                        <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-white/10 pointer-events-none"></div>
                        <div class="absolute -left-10 -bottom-10 w-32 h-32 rounded-full bg-white/5 pointer-events-none"></div>

                        <div class="relative z-10 space-y-5">
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

                            <div class="flex items-center justify-between pt-1">
                                <div class="space-y-0.5">
                                    <p class="text-[9px] uppercase tracking-wider text-white/60 font-bold">Paciente</p>
                                    <h3 class="text-2xl sm:text-3xl font-black tracking-tight text-white uppercase">LUCAS</h3>
                                    <p class="text-xs text-teal-100 font-medium">Golden Retriever • Canino</p>
                                </div>
                                <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center text-3xl shadow-inner border border-white/20">
                                    🐕
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 pt-2 bg-black/25 p-3.5 rounded-2xl border border-white/10">
                                <div>
                                    <p class="text-[8px] uppercase tracking-wider text-white/60 font-bold">Membresía</p>
                                    <p class="text-xs font-black text-amber-300">Plan Patitas Premium</p>
                                </div>
                                <div>
                                    <p class="text-[8px] uppercase tracking-wider text-white/60 font-bold">Contrato Digital</p>
                                    <p class="text-xs font-mono font-bold text-white">VP-2026-9482</p>
                                </div>
                            </div>

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
                </div>

            </div>
        </section>

        <!-- 09. TESTIMONIOS & PRUEBA SOCIAL -->
        <section class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
                <div class="text-center space-y-2">
                    <span class="text-xs font-black text-brand-primary uppercase tracking-widest">Opiniones Reales</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900">Lo que dicen las familias en {{ $city }}</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Testimonio 1 -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-3">
                        <div class="text-amber-400 text-xs font-bold">⭐⭐⭐⭐⭐</div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">
                            “Desde que tenemos la membresía llevamos mucho más organizado el cuidado de Max. No tenemos que pensar en cuánto costará la consulta ni las vacunas.”
                        </p>
                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-900">María Camila R.</span>
                            <span class="text-[10px] text-teal-700 font-bold">Tutor de Max 🐕 (Cajicá)</span>
                        </div>
                    </div>

                    <!-- Testimonio 2 -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-3">
                        <div class="text-amber-400 text-xs font-bold">⭐⭐⭐⭐⭐</div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">
                            “Pagué el año completo y el ahorro fue inmediato. Además la atención de las doctoras en el consultorio de Cajicá es impecable y muy cariñosa.”
                        </p>
                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-900">Juan David G.</span>
                            <span class="text-[10px] text-teal-700 font-bold">Tutor de Luna 🐱 (Chía)</span>
                        </div>
                    </div>

                    <!-- Testimonio 3 -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-3">
                        <div class="text-amber-400 text-xs font-bold">⭐⭐⭐⭐⭐</div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">
                            “Tener las consultas virtuales por WhatsApp para dudas rápidas los fines de semana nos ha dado una tranquilidad increíble. Súper recomendado.”
                        </p>
                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-900">Andrea P.</span>
                            <span class="text-[10px] text-teal-700 font-bold">Tutor de Milo 🐶 (Cajicá)</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 10. INSTALACIONES & CONSULTORIO VETERINARIO (FOTOS & VIDEO) -->
        <section id="instalaciones" class="py-16 sm:py-20 bg-white border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                
                <div class="text-center space-y-3">
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

                    <!-- Datos de la Clínica & Galería de Fotos del Consultorio -->
                    <div class="lg:col-span-5 space-y-5">
                        
                        @if(!empty($bannerVideo) && !empty($bannerImage))
                            <div class="rounded-3xl overflow-hidden shadow-md border border-slate-200 aspect-[16/9] relative group">
                                <img src="{{ $bannerImage }}" alt="Instalaciones de {{ $tenant->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-3 py-1 rounded-full text-[10px] font-black text-slate-900 shadow-sm border border-slate-100">
                                    🏥 Instalaciones
                                </div>
                            </div>
                        @elseif(!empty($heroImage))
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

                            <a href="https://wa.me/57{{ $cleanPhone }}?text=Hola,%20quiero%20conocer%20la%20ubicaci%C3%B3n%20y%20agendar%20visita%20en%20{{ urlencode($tenant->name) }}" target="_blank" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-black text-xs rounded-2xl transition flex items-center justify-center gap-2">
                                <span>💬 Cómo Llegar por WhatsApp</span>
                                <span>↗</span>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 11. CONDICIONES CLARAS & TRANSPARENCIA (QUÉ NO INCLUYE) -->
        <section class="py-14 bg-slate-900 text-white border-t border-slate-800">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                <div class="flex items-center space-x-3 text-amber-400 text-xs font-black uppercase tracking-wider">
                    <span>⚖️</span>
                    <span>Condiciones Claras y Transparencia del Servicio</span>
                </div>
                <h3 class="text-xl sm:text-2xl font-black text-white">Antes de afiliarte, queremos que todo esté claro:</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-300 font-normal leading-relaxed">
                    <div class="bg-slate-950/60 p-4 rounded-2xl border border-slate-800 space-y-1.5">
                        <p class="font-bold text-white">✓ Membresía de Cuidado Preventivo:</p>
                        <p>Tu membresía incluye exclusivamente la bolsa de servicios, consultas, vacunas y beneficios expresamente descritos en el plan elegido.</p>
                    </div>
                    <div class="bg-slate-950/60 p-4 rounded-2xl border border-slate-800 space-y-1.5">
                        <p class="font-bold text-white">✓ Servicios Adicionales o Especializados:</p>
                        <p>Procedimientos quirúrgicos mayores, hospitalización de alta complejidad o medicamentos no incluidos se rigen por las tarifas oficiales vigentes de la clínica con descuentos preferenciales para afiliados.</p>
                    </div>
                </div>

                <p class="text-[11px] text-slate-400 pt-1">
                    * Los planes de salud de {{ $tenant->name }} constituyen programas de medicina preventiva veterinaria y no corresponden a pólizas de seguro financiero ni medicina prepagada.
                </p>
            </div>
        </section>

        <!-- 12. PREGUNTAS FRECUENTES (FAQ) -->
        <section id="faq" class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="text-center space-y-2">
                    <span class="text-xs font-black text-brand-primary uppercase tracking-widest">Resolvemos tus inquietudes</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900">Preguntas Frecuentes</h3>
                </div>

                <div class="space-y-3.5">
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                        <button type="button" onclick="toggleFaq(1)" class="w-full p-4 sm:p-5 text-left font-bold text-xs sm:text-sm text-slate-900 flex items-center justify-between gap-2 hover:bg-slate-50 transition">
                            <span>¿Cómo solicito una cita o servicio una vez afiliado?</span>
                            <span id="faq-icon-1" class="text-teal-600 font-black text-base">+</span>
                        </button>
                        <div id="faq-content-1" class="hidden px-4 pb-4 sm:px-5 sm:pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3 font-normal">
                            Solo debes comunicarte a nuestra línea única oficial de WhatsApp <strong>{{ $phone }}</strong>. Nuestro equipo valida tu carnet digital en recepción en segundos y agenda tu cita prioritaria.
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                        <button type="button" onclick="toggleFaq(2)" class="w-full p-4 sm:p-5 text-left font-bold text-xs sm:text-sm text-slate-900 flex items-center justify-between gap-2 hover:bg-slate-50 transition">
                            <span>¿Qué incluye el Kit de Bienvenida?</span>
                            <span id="faq-icon-2" class="text-teal-600 font-black text-base">+</span>
                        </button>
                        <div id="faq-content-2" class="hidden px-4 pb-4 sm:px-5 sm:pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3 font-normal">
                            Incluye la Cédula Digital de tu mascota, Collar con Placa de identificación física grabada, apertura de historia clínica y la primera dosis de desparasitación interna.
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                        <button type="button" onclick="toggleFaq(3)" class="w-full p-4 sm:p-5 text-left font-bold text-xs sm:text-sm text-slate-900 flex items-center justify-between gap-2 hover:bg-slate-50 transition">
                            <span>¿Qué diferencia hay entre pago mensual y pago anual?</span>
                            <span id="faq-icon-3" class="text-teal-600 font-black text-base">+</span>
                        </button>
                        <div id="faq-content-3" class="hidden px-4 pb-4 sm:px-5 sm:pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3 font-normal">
                            En el pago mensual los beneficios se habilitan progresivamente mes a mes. En el <strong>pago anual anticipado</strong> obtienes un 10% de descuento directo ($540.000 COP en plan básico) y todos los servicios se activan <strong>inmediatamente sin periodos de carencia</strong>.
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                        <button type="button" onclick="toggleFaq(4)" class="w-full p-4 sm:p-5 text-left font-bold text-xs sm:text-sm text-slate-900 flex items-center justify-between gap-2 hover:bg-slate-50 transition">
                            <span>¿Puedo afiliar más de una mascota?</span>
                            <span id="faq-icon-4" class="text-teal-600 font-black text-base">+</span>
                        </button>
                        <div id="faq-content-4" class="hidden px-4 pb-4 sm:px-5 sm:pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3 font-normal">
                            ¡Sí! Cada peludo cuenta con su propio carnet digital y su bolsa individual de consultas, vacunas y peluquerías.
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 13. CTA FINAL POTENTE (DUAL) -->
        <section class="py-16 sm:py-20 bg-slate-900 text-white relative overflow-hidden">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 relative z-10">
                <span class="text-3xl">🐾</span>
                <h2 class="text-3xl sm:text-5xl font-black tracking-tight text-white">
                    Empieza a cuidar a tu mascota de forma inteligente
                </h2>
                <p class="text-slate-300 text-sm sm:text-base max-w-xl mx-auto font-normal">
                    Elige el plan que mejor se adapte a sus necesidades y dale el respaldo médico que se merece durante todo el año.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <button type="button" onclick="openEnrollModal('basico')" class="w-full sm:w-auto px-8 py-4 bg-teal-500 hover:bg-teal-400 text-slate-950 font-black text-sm uppercase tracking-wider rounded-full shadow-xl transition-all">
                        🐾 Afiliar a Mi Mascota Ahora
                    </button>
                    <a href="https://wa.me/57{{ $cleanPhone }}?text=Hola,%20tengo%20dudas%20sobre%20los%20Planes%20de%20{{ urlencode($tenant->name) }}" target="_blank" class="w-full sm:w-auto px-8 py-4 bg-slate-800 hover:bg-slate-700 text-white font-bold text-sm rounded-full border border-slate-700 transition-all flex items-center justify-center space-x-2">
                        <span>💬 Hablar con {{ $tenant->name }} por WhatsApp</span>
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- STICKY BOTTOM ACTION BAR PARA CELULARES -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-30 bg-white/95 backdrop-blur-md border-t border-slate-200 p-3 px-4 flex items-center justify-between gap-3 shadow-2xl">
        <div class="min-w-0">
            <p class="text-[10px] text-slate-400 font-black uppercase">Membresía Desde</p>
            <p class="text-xs font-black text-slate-900 truncate">$50.000 COP / mes</p>
        </div>
        <div class="flex items-center space-x-2 shrink-0">
            <a href="https://wa.me/57{{ $cleanPhone }}" target="_blank" class="p-2.5 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-200 text-sm">
                💬
            </a>
            <button type="button" onclick="openEnrollModal('basico')" class="px-4 py-2.5 bg-brand-primary text-white font-black text-xs rounded-xl shadow-xs">
                Afiliar Mascota 🐾
            </button>
        </div>
    </div>

    <!-- 14. FOOTER -->
    <footer id="contacto" class="bg-slate-950 text-slate-400 py-12 text-xs border-t border-slate-800 pb-20 lg:pb-12">
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

    <!-- MODAL DE AUTO-AFILIACIÓN DIGITAL EN VIVO (STEP-BY-STEP) -->
    <div id="enroll-modal" class="fixed inset-0 z-50 modal-backdrop hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative my-auto animate-in fade-in zoom-in-95 duration-200">
            
            <button type="button" onclick="closeEnrollModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-lg font-bold w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
                ✕
            </button>

            <!-- Encabezado Modal -->
            <div class="text-center space-y-1 pb-4 border-b border-slate-100">
                <div class="inline-flex items-center space-x-1.5 bg-teal-50 text-teal-800 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase">
                    <span>🐾 Afiliación Digital</span>
                </div>
                <h3 class="text-xl font-black text-slate-900" id="modal-step-title">1. Datos del Tutor Responsable</h3>
                <p class="text-xs text-slate-500" id="modal-step-subtitle">Ingresa tus datos de contacto para la membresía</p>
            </div>

            <!-- FORMULARIO MULTIPASO -->
            <form id="enroll-form" onsubmit="submitEnrollment(event)" class="pt-4 space-y-4">
                
                <!-- PASO 1: DATOS DEL TUTOR -->
                <div id="step-1-fields" class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nombre y Apellido *</label>
                        <input type="text" id="tutor_name" required placeholder="Ej. María Camila Rodríguez" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">WhatsApp / Teléfono *</label>
                            <input type="tel" id="tutor_phone" required placeholder="Ej. 3508742543" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Cédula / Documento</label>
                            <input type="text" id="tutor_doc" placeholder="Ej. 1020304050" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Correo Electrónico *</label>
                        <input type="email" id="tutor_email" required placeholder="Ej. maria@gmail.com" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                <!-- PASO 2: DATOS DE LA MASCOTA -->
                <div id="step-2-fields" class="space-y-3 hidden">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nombre de la Mascota *</label>
                        <input type="text" id="pet_name" placeholder="Ej. Lucas" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Especie *</label>
                            <select id="pet_species" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="Canino">🐶 Perro (Canino)</option>
                                <option value="Felino">🐱 Gato (Felino)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Edad Aprox. (Años)</label>
                            <input type="number" id="pet_age" min="0" max="25" placeholder="Ej. 2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Raza</label>
                        <input type="text" id="pet_breed" placeholder="Ej. Golden Retriever / Criollo" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                <!-- PASO 3: RESUMEN Y PLAN -->
                <div id="step-3-fields" class="space-y-3 hidden">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500">Plan Seleccionado:</span>
                            <span id="summary-plan-name" class="font-black text-slate-900">Plan Patitas Básico</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500">Modalidad:</span>
                            <span id="summary-cycle" class="font-black text-teal-700">Pago Mensual</span>
                        </div>
                        <div class="flex justify-between items-center text-xs pt-1 border-t border-slate-200">
                            <span class="font-bold text-slate-900">Total a Pagar:</span>
                            <span id="summary-price" class="font-black text-sm text-slate-900">$50.000 COP</span>
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-500 text-center">
                        Al confirmar, se creará el contrato digital de tu mascota en {{ $tenant->name }} y se generará tu Carnet Digital de inmediato.
                    </p>
                </div>

                <!-- PASO 4: ÉXITO Y CARNET GENERADO -->
                <div id="step-success-fields" class="space-y-4 hidden text-center">
                    <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl mx-auto">
                        ✓
                    </div>
                    <h4 class="text-lg font-black text-slate-900">¡Afiliación Completada con Éxito!</h4>
                    <p class="text-xs text-slate-600">
                        El contrato digital <strong id="success-contract-id" class="text-teal-700 font-mono">VP-2026-XXXX</strong> ha sido emitido para <strong id="success-pet-name">TU MASCOTA</strong>.
                    </p>
                    
                    <div class="pt-2 space-y-2">
                        <a id="success-whatsapp-btn" href="#" target="_blank" class="w-full py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs uppercase tracking-wider rounded-2xl shadow-md flex items-center justify-center space-x-2">
                            <span>💬 Notificar a la Clínica por WhatsApp</span>
                            <span>↗</span>
                        </a>
                        <button type="button" onclick="closeEnrollModal()" class="w-full py-2.5 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-200">
                            Cerrar
                        </button>
                    </div>
                </div>

                <!-- BOTONES DE NAVEGACIÓN DEL MODAL -->
                <div id="modal-nav-btns" class="pt-3 flex items-center justify-between gap-3 border-t border-slate-100">
                    <button type="button" id="btn-modal-prev" onclick="prevModalStep()" class="hidden px-4 py-2.5 text-xs font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200">
                        ← Atrás
                    </button>
                    <button type="button" id="btn-modal-next" onclick="nextModalStep()" class="ml-auto px-6 py-2.5 text-xs font-black text-white bg-brand-primary rounded-xl shadow-xs hover:opacity-90">
                        Siguiente Paso →
                    </button>
                    <button type="submit" id="btn-modal-submit" class="hidden ml-auto px-6 py-2.5 text-xs font-black text-white bg-emerald-600 rounded-xl shadow-xs hover:bg-emerald-500">
                        Confirmar y Activar Carnet ✓
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- JAVASCRIPT DE INTERACTIVIDAD & ENROLLMENT MULTIPASO -->
    <script>
        let currentModalStep = 1;
        let selectedPlan = 'basico';
        let currentCycle = 'monthly';

        // Calculadora de Ahorro en tiempo real
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
            document.getElementById('calc-savings-percent').innerText = 'Ahorras un ' + porcentaje + '% en salud veterinaria';
        }

        // Selector Mensual vs Anual
        function setBillingCycle(cycle) {
            currentCycle = cycle;
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

        // Carencias Toggle
        function showCarenciaPlan(plan) {
            const blockBasico = document.getElementById('carencia-block-basico');
            const blockPremium = document.getElementById('carencia-block-premium');
            const btnBasico = document.getElementById('btn-car-basico');
            const btnPremium = document.getElementById('btn-car-premium');

            if (plan === 'premium') {
                blockBasico.classList.add('hidden');
                blockPremium.classList.remove('hidden');
                btnPremium.className = 'px-4 py-2 rounded-xl bg-purple-700 text-white shadow-xs transition-all';
                btnBasico.className = 'px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all';
            } else {
                blockPremium.classList.add('hidden');
                blockBasico.classList.remove('hidden');
                btnBasico.className = 'px-4 py-2 rounded-xl bg-white text-slate-900 shadow-xs transition-all';
                btnPremium.className = 'px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all';
            }
        }

        // MODAL DE AFILIACIÓN
        function openEnrollModal(plan) {
            selectedPlan = plan || 'basico';
            currentModalStep = 1;
            renderModalStep();
            document.getElementById('enroll-modal').classList.remove('hidden');
            document.getElementById('enroll-modal').classList.add('flex');
        }

        function closeEnrollModal() {
            document.getElementById('enroll-modal').classList.add('hidden');
            document.getElementById('enroll-modal').classList.remove('flex');
        }

        function nextModalStep() {
            if (currentModalStep === 1) {
                const name = document.getElementById('tutor_name').value.trim();
                const phone = document.getElementById('tutor_phone').value.trim();
                const email = document.getElementById('tutor_email').value.trim();
                if (!name || !phone || !email) {
                    alert('Por favor completa tu nombre, teléfono y correo electrónico.');
                    return;
                }
            } else if (currentModalStep === 2) {
                const petName = document.getElementById('pet_name').value.trim();
                if (!petName) {
                    alert('Por favor ingresa el nombre de tu mascota.');
                    return;
                }
            }

            currentModalStep++;
            renderModalStep();
        }

        function prevModalStep() {
            if (currentModalStep > 1) {
                currentModalStep--;
                renderModalStep();
            }
        }

        function renderModalStep() {
            const step1 = document.getElementById('step-1-fields');
            const step2 = document.getElementById('step-2-fields');
            const step3 = document.getElementById('step-3-fields');
            const stepSuccess = document.getElementById('step-success-fields');
            const btnPrev = document.getElementById('btn-modal-prev');
            const btnNext = document.getElementById('btn-modal-next');
            const btnSubmit = document.getElementById('btn-modal-submit');
            const modalTitle = document.getElementById('modal-step-title');
            const modalSub = document.getElementById('modal-step-subtitle');
            const navBtns = document.getElementById('modal-nav-btns');

            step1.classList.add('hidden');
            step2.classList.add('hidden');
            step3.classList.add('hidden');
            stepSuccess.classList.add('hidden');
            btnPrev.classList.add('hidden');
            btnNext.classList.add('hidden');
            btnSubmit.classList.add('hidden');
            navBtns.classList.remove('hidden');

            if (currentModalStep === 1) {
                modalTitle.innerText = '1. Datos del Tutor Responsable';
                modalSub.innerText = 'Ingresa tus datos de contacto para la membresía';
                step1.classList.remove('hidden');
                btnNext.classList.remove('hidden');
            } else if (currentModalStep === 2) {
                modalTitle.innerText = '2. Datos de tu Mascota';
                modalSub.innerText = '¿A qué peludo vamos a proteger hoy?';
                step2.classList.remove('hidden');
                btnPrev.classList.remove('hidden');
                btnNext.classList.remove('hidden');
            } else if (currentModalStep === 3) {
                modalTitle.innerText = '3. Resumen de la Membresía';
                modalSub.innerText = 'Verifica la información antes de activar tu carnet';
                step3.classList.remove('hidden');
                btnPrev.classList.remove('hidden');
                btnSubmit.classList.remove('hidden');

                const isPremium = (selectedPlan === 'premium');
                const isAnnual = (currentCycle === 'annual');

                document.getElementById('summary-plan-name').innerText = isPremium ? 'Plan Patitas Premium' : 'Plan Patitas Básico';
                document.getElementById('summary-cycle').innerText = isAnnual ? 'Pago Anual Anticipado (-10%)' : 'Pago Mensual';
                
                let priceText = '$50.000 COP / mes';
                if (isPremium && !isAnnual) priceText = '$80.000 COP / mes';
                if (!isPremium && isAnnual) priceText = '$540.000 COP / año';
                if (isPremium && isAnnual) priceText = '$864.000 COP / año';
                
                document.getElementById('summary-price').innerText = priceText;
            }
        }

        // Envío AJAX del formulario de auto-afiliación
        async function submitEnrollment(event) {
            event.preventDefault();
            const btnSubmit = document.getElementById('btn-modal-submit');
            btnSubmit.disabled = true;
            btnSubmit.innerText = 'Emitiendo carnet...';

            const payload = {
                tutor_name: document.getElementById('tutor_name').value.trim(),
                tutor_phone: document.getElementById('tutor_phone').value.trim(),
                tutor_email: document.getElementById('tutor_email').value.trim(),
                tutor_doc: document.getElementById('tutor_doc').value.trim(),
                pet_name: document.getElementById('pet_name').value.trim(),
                pet_species: document.getElementById('pet_species').value,
                pet_breed: document.getElementById('pet_breed').value.trim(),
                pet_age: document.getElementById('pet_age').value.trim(),
                plan_slug: selectedPlan,
                billing_cycle: currentCycle,
            };

            try {
                const response = await fetch('/v/{{ $tenant->slug }}/afiliar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    document.getElementById('step-1-fields').classList.add('hidden');
                    document.getElementById('step-2-fields').classList.add('hidden');
                    document.getElementById('step-3-fields').classList.add('hidden');
                    document.getElementById('modal-nav-btns').classList.add('hidden');
                    
                    document.getElementById('modal-step-title').innerText = '🎉 ¡Carnet Digital Emitido!';
                    document.getElementById('modal-step-subtitle').innerText = 'Tu membresía ha quedado registrada en la clínica';
                    
                    document.getElementById('success-contract-id').innerText = data.contract_id;
                    document.getElementById('success-pet-name').innerText = data.pet_name;
                    document.getElementById('success-whatsapp-btn').href = data.whatsapp_url;
                    
                    document.getElementById('step-success-fields').classList.remove('hidden');
                } else {
                    alert(data.error || 'Ocurrió un error al procesar tu afiliación. Por favor intenta de nuevo.');
                    btnSubmit.disabled = false;
                    btnSubmit.innerText = 'Confirmar y Activar Carnet ✓';
                }
            } catch (err) {
                console.error(err);
                alert('No se pudo conectar con el servidor. Intenta de nuevo.');
                btnSubmit.disabled = false;
                btnSubmit.innerText = 'Confirmar y Activar Carnet ✓';
            }
        }
    </script>
</body>
</html>
