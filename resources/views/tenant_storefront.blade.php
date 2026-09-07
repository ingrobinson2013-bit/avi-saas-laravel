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
        $paymentNequi = $tenant->branding['payment_nequi'] ?? $phone;
        $paymentBank = $tenant->branding['payment_bank_info'] ?? 'Bancolombia Ahorros # 123-456789-01 (Titular: ' . $tenant->name . ')';
        $paymentBoldLink = $tenant->branding['payment_bold_link'] ?? null;
        $paymentInstructions = $tenant->branding['payment_instructions'] ?? 'Una vez realizado el pago, confirma por WhatsApp con tu número de carnet.';

        // Textos del Hero personalizables
        $heroTitle = $tenant->branding['hero_title'] ?? 'El cuidado de tu mascota, todo el año.';
        $heroSubtitle = $tenant->branding['hero_subtitle'] ?? 'Accede a consultas, vacunas, controles incluidos y precios preferenciales en ' . $city . ' con la membresía de salud preventiva de ' . $tenant->name . '.';
        $heroPriceBadge = $tenant->branding['hero_price_badge'] ?? 'Desde $50.000/mes';

        // Toggles de Bloques y Secciones Activas
        $showHowItWorks = $tenant->branding['section_how_it_works'] ?? true;
        $showPlans = $tenant->branding['section_plans'] ?? true;
        $showCalculator = $tenant->branding['section_calculator'] ?? true;
        $showCarnetFeature = $tenant->branding['section_carnet_feature'] ?? true;
        $showComparison = $tenant->branding['section_comparison'] ?? true;
        $showCarencias = $tenant->branding['section_carencias'] ?? true;
        $showFacilities = $tenant->branding['section_facilities'] ?? true;
        $showTestimonials = $tenant->branding['section_testimonials'] ?? true;
        $showFaq = $tenant->branding['section_faq'] ?? true;
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
                @if($showHowItWorks)
                    <a href="#como-funciona" class="hover:text-brand-primary transition-colors">¿Cómo Funciona?</a>
                @endif
                @if($showPlans)
                    <a href="#planes" class="hover:text-brand-primary transition-colors">Planes</a>
                @endif
                @if($showCalculator)
                    <a href="#calculadora" class="hover:text-brand-primary transition-colors flex items-center space-x-1">
                        <span>🧮 Calculadora</span>
                        <span class="bg-amber-100 text-amber-800 text-[10px] font-extrabold px-1.5 py-0.5 rounded-full">Ahorro</span>
                    </a>
                @endif
                @if($showCarnetFeature)
                    <a href="#carnet-digital" class="hover:text-brand-primary transition-colors">Carnet Digital</a>
                @endif
                @if($showComparison)
                    <a href="#comparador" class="hover:text-brand-primary transition-colors">Comparar</a>
                @endif
                @if($showFacilities)
                    <a href="#instalaciones" class="hover:text-brand-primary transition-colors">Instalaciones</a>
                @endif
                @if($showFaq)
                    <a href="#faq" class="hover:text-brand-primary transition-colors">Preguntas</a>
                @endif
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
        <!-- 01. HERO POTENTE CON PROPUESTA DE VALOR DIRECTA (PRIORIDAD 1) -->
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
                            <span class="text-xs font-black text-slate-800 uppercase tracking-wider">{{ $heroPriceBadge }}</span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.12]">
                            {{ $heroTitle }}
                        </h1>

                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl font-normal">
                            {{ $heroSubtitle }}
                        </p>

                        <!-- ELEMENTOS DE CONFIANZA RÁPIDA (TRUST BADGES) -->
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 pt-1 text-xs font-bold text-slate-700">
                            <div class="flex items-center space-x-1.5 bg-white/80 backdrop-blur-xs px-3 py-1.5 rounded-xl border border-slate-200 shadow-xs">
                                <span>🐾</span>
                                <span>+450 mascotas protegidas</span>
                            </div>
                            <div class="flex items-center space-x-1.5 bg-white/80 backdrop-blur-xs px-3 py-1.5 rounded-xl border border-slate-200 shadow-xs">
                                <span>📍</span>
                                <span>Sede en {{ $city }}</span>
                            </div>
                            <div class="flex items-center space-x-1.5 bg-white/80 backdrop-blur-xs px-3 py-1.5 rounded-xl border border-slate-200 shadow-xs">
                                <span class="text-amber-400">⭐⭐⭐⭐⭐</span>
                                <span>Atención médica profesional</span>
                            </div>
                        </div>

                        <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5">
                            <a href="#planes" class="px-7 py-4 rounded-full bg-brand-primary text-white font-extrabold text-sm shadow-lg hover:opacity-90 transition-all flex items-center justify-center space-x-2 text-center">
                                <span>Ver Planes de Salud</span>
                                <span>›</span>
                            </a>
                            <button type="button" onclick="openEnrollModal('basico')" class="px-6 py-4 rounded-full bg-white hover:bg-slate-50 text-slate-800 font-extrabold text-sm border border-slate-200 shadow-xs transition-all flex items-center justify-center space-x-2 text-center">
                                <span>🐾 Afiliar a Mi Mascota</span>
                            </button>
                        </div>
                    </div>

                    <!-- COLUMNA DERECHA: FOTO PRINCIPAL + BADGE EN VIVO -->
                    <div class="lg:col-span-5 relative mt-4 lg:mt-0 space-y-4">
                        <div class="mx-auto max-w-sm sm:max-w-md space-y-4">
                            
                            <!-- TARJETA VISUAL DE LA CLÍNICA / FOTO HERO COMPLETA -->
                            <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-white relative group flex flex-col">
                                <div class="w-full relative overflow-hidden flex items-center justify-center bg-slate-50">
                                    <img src="{{ $heroImage }}" alt="Pacientes de {{ $tenant->name }}" class="w-full h-auto max-h-[480px] object-cover sm:object-contain group-hover:scale-102 transition-transform duration-500" loading="lazy">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/20 via-transparent to-transparent pointer-events-none"></div>
                                </div>
                                
                                <div class="p-3.5 bg-white border-t border-slate-100 flex items-center justify-between gap-2 z-10 shadow-xs">
                                    <div class="flex items-center space-x-2.5 min-w-0">
                                        <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-black text-sm shrink-0">
                                            🩺
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-black text-slate-900 truncate">Membresía Digital Activa</p>
                                            <p class="text-[10px] text-teal-700 font-bold truncate">Validación por Chip & QR</p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="openEnrollModal('basico')" class="px-3.5 py-1.5 bg-brand-primary text-white font-black text-xs rounded-xl shadow-xs shrink-0 hover:opacity-90 transition-all">
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

        <!-- 02. ¿CÓMO FUNCIONA? (4 PASOS LIMPIOS - PRIORIDAD 2) -->
        @if($showHowItWorks)
        <section id="como-funciona" class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-3 mb-12">
                    <div class="inline-flex items-center space-x-2 bg-teal-100 text-teal-800 text-xs font-black px-3.5 py-1 rounded-full">
                        <span>⚡ Simple, Rápido y 100% Digital</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">¿Cómo funciona tu membresía?</h2>
                    <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto">
                        Cuidar a tu mascota en <strong>{{ $tenant->name }}</strong> es fácil, transparente y sin complicaciones en 4 pasos:
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Paso 1 -->
                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-xs relative group hover:border-teal-400 hover:shadow-md transition-all">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center font-black text-lg mb-4 group-hover:scale-110 transition-transform">
                            01
                        </div>
                        <h3 class="text-base font-black text-slate-900 mb-2">Elige tu plan</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Selecciona el plan mensual o anual que mejor se adapte a la edad y necesidades de salud de tu peludo.
                        </p>
                    </div>

                    <!-- Paso 2 -->
                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-xs relative group hover:border-teal-400 hover:shadow-md transition-all">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center font-black text-lg mb-4 group-hover:scale-110 transition-transform">
                            02
                        </div>
                        <h3 class="text-base font-black text-slate-900 mb-2">Registra a tu mascota</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Ingresa sus datos en el formulario digital en menos de 2 minutos sin papeleos ni filas.
                        </p>
                    </div>

                    <!-- Paso 3 -->
                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-xs relative group hover:border-teal-400 hover:shadow-md transition-all">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center font-black text-lg mb-4 group-hover:scale-110 transition-transform">
                            03
                        </div>
                        <h3 class="text-base font-black text-slate-900 mb-2">Disfruta tus beneficios</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Agenda tus consultas, vacunas y procedimientos directamente en la sede de {{ $city }}.
                        </p>
                    </div>

                    <!-- Paso 4 -->
                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-xs relative group hover:border-teal-400 hover:shadow-md transition-all">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center font-black text-lg mb-4 group-hover:scale-110 transition-transform">
                            04
                        </div>
                        <h3 class="text-base font-black text-slate-900 mb-2">Todo desde tu celular</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Consulta tu carnet inteligente, historial de servicios y código QR médico en tiempo real sin descargar apps.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- 03. PLANES DE MEMBRESÍA (PLANES MÁS ARRIBA - PRIORIDAD 3) -->
        @if($showPlans)
        <section id="planes" class="py-16 sm:py-20 bg-white border-t border-slate-200">
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
                        <div class="bg-slate-100 p-1.5 rounded-2xl inline-flex items-center gap-1 border border-slate-200 shadow-inner">
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
                                        <p class="text-xs text-slate-500 font-medium">Prevención integral y controles médicos</p>
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
        @endif

        <!-- 04. SIMULADOR DE AHORRO ANUAL INTERACTIVO (PRIORIDAD 3) -->
        @if($showCalculator)
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
        @endif

        <!-- 05. CARNET DIGITAL PROTAGONISTA: "TODO EL CUIDADO EN UN SOLO LUGAR" (PRIORIDAD 4) -->
        @if($showCarnetFeature)
        <section id="carnet-digital" class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <div class="lg:col-span-6 space-y-6">
                    <div class="inline-flex items-center space-x-2 bg-teal-100 text-teal-800 text-xs font-bold px-3.5 py-1 rounded-full">
                        <span>📱 Todo el Cuidado en un Solo Lugar</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                        Tu mascota tiene su Carnet Digital Inteligente
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        Olvida los carnets de papel que se pierden o deterioran. Con el sistema de <strong>{{ $tenant->name }}</strong>, tienes control total de la salud y beneficios de tu peludo desde cualquier smartphone:
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-1">
                        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs space-y-1">
                            <span class="text-lg">🪪</span>
                            <h4 class="text-xs font-black text-slate-900">Carnet Digital Activo</h4>
                            <p class="text-[11px] text-slate-500 leading-tight">Validación médica oficial con chip y número de contrato único.</p>
                        </div>
                        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs space-y-1">
                            <span class="text-lg">🔍</span>
                            <h4 class="text-xs font-black text-slate-900">Código QR de Validación</h4>
                            <p class="text-[11px] text-slate-500 leading-tight">Canjea tus consultas y vacunas en recepción en menos de 5 segundos.</p>
                        </div>
                        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs space-y-1">
                            <span class="text-lg">📦</span>
                            <h4 class="text-xs font-black text-slate-900">Bolsa de Beneficios en Vivo</h4>
                            <p class="text-[11px] text-slate-500 leading-tight">Consulta cuántas consultas, vacunas y baños te quedan disponibles.</p>
                        </div>
                        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs space-y-1">
                            <span class="text-lg">🛡️</span>
                            <h4 class="text-xs font-black text-slate-900">Historial Clínico Seguro</h4>
                            <p class="text-[11px] text-slate-500 leading-tight">Todo sincronizado con el software médico de {{ $tenant->name }}.</p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="button" onclick="openEnrollModal('basico')" class="px-7 py-3.5 bg-brand-primary text-white font-black text-xs uppercase tracking-wider rounded-2xl shadow-md hover:opacity-95 transition-all">
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
                                        <div class="h-8 px-2 py-0.5 bg-white rounded-xl shadow-md border border-white/80 flex items-center justify-center shrink-0">
                                            <img src="{{ $logoUrl }}" alt="Logo" class="h-full w-auto max-h-6 object-contain">
                                        </div>
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
                                    <span>Validación médica en recepción</span>
                                </div>
                                <span class="font-mono text-[9px] text-white/60">🔐 Verificado</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        @endif

        <!-- 06. TABLA COMPARADORA DE PLANES -->
        @if($showComparison)
        <section id="comparador" class="py-16 sm:py-20 bg-white border-t border-slate-100">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <div class="text-center space-y-2">
                    <span class="text-xs font-black text-brand-primary uppercase tracking-widest">Decide en segundos</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900">¿Cuál es el mejor plan para tu mascota?</h3>
                    <p class="sm:hidden text-[11px] text-slate-400 font-bold">↔ Desliza hacia los lados para comparar</p>
                </div>

                <div class="overflow-x-auto rounded-3xl border border-slate-200 shadow-xs -mx-2 sm:mx-0">
                    <table class="w-full min-w-[500px] text-left border-collapse text-xs sm:text-sm">
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
        @endif

        <!-- 07. CRONOGRAMA DE ACTIVACIÓN DE SERVICIOS (PERIODOS DE CARENCIA) -->
        @if($showCarencias)
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
                        En la modalidad de pago mensual, los servicios preventivos se activan por etapas para garantizar la sostenibilidad del plan de salud.
                    </p>

                    <!-- Selector de Plan en Carencias -->
                    <div class="pt-3 flex items-center justify-center">
                        <div class="bg-slate-200/70 p-1.5 rounded-2xl inline-flex items-center gap-1 shadow-inner text-xs font-bold">
                            <button type="button" onclick="showCarenciaPlan('basico')" id="btn-car-basico" class="px-4 py-2 rounded-xl bg-white text-slate-900 shadow-xs transition-all">
                                🛡️ Plan Básico
                            </button>
                            <button type="button" onclick="showCarenciaPlan('premium')" id="btn-car-premium" class="px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all">
                                💎 Plan Premium
                            </button>
                        </div>
                    </div>
                </div>

                <!-- BLOQUE CARENCIA: PLAN BÁSICO -->
                <div id="carencia-block-basico" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Día 0: Inmediato -->
                    <div class="bg-white p-5 rounded-3xl border-2 border-emerald-500 shadow-sm space-y-3 relative overflow-hidden">
                        <div class="absolute top-0 right-0 bg-emerald-500 text-white text-[9px] font-black px-2.5 py-0.5 rounded-bl-xl uppercase">
                            Día 0 (Inmediato)
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-base">
                            ⚡
                        </div>
                        <h4 class="font-black text-sm text-slate-900">Activación Inmediata</h4>
                        <ul class="text-xs text-slate-600 space-y-1.5 font-medium">
                            <li>✓ Kit de Bienvenida (Placa + Collar)</li>
                            <li>✓ Carnet Digital Oficial</li>
                            <li>✓ Consultas Virtuales ILIMITADAS</li>
                            <li>✓ 1ª Desparasitación Interna</li>
                        </ul>
                    </div>

                    <!-- 30 Días (Mes 1+) -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-3 relative">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-black text-base">
                            🩺
                        </div>
                        <h4 class="font-black text-sm text-slate-900">A partir del Mes 1</h4>
                        <ul class="text-xs text-slate-600 space-y-1.5 font-medium">
                            <li>✓ Consultas Presenciales Generales</li>
                            <li>✓ 1er Baño & Peluquería Médica</li>
                        </ul>
                    </div>

                    <!-- 90 Días (3 Meses+) -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-3 relative">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center font-black text-base">
                            💉
                        </div>
                        <h4 class="font-black text-sm text-slate-900">A partir del Mes 3</h4>
                        <ul class="text-xs text-slate-600 space-y-1.5 font-medium">
                            <li>✓ Vacunación Anual Completa</li>
                            <li>✓ 2ª Desparasitación Interna</li>
                        </ul>
                    </div>

                    <!-- 180 Días (6 Meses+) -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-3 relative">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-black text-base">
                            🧪
                        </div>
                        <h4 class="font-black text-sm text-slate-900">A partir del Mes 6</h4>
                        <ul class="text-xs text-slate-600 space-y-1.5 font-medium">
                            <li>✓ 1 Examen de Laboratorio Completo</li>
                            <li>✓ Desparasitación Externa (Credelio)</li>
                            <li>✓ 2º Baño & Peluquería</li>
                        </ul>
                    </div>

                </div>

                <!-- BLOQUE CARENCIA: PLAN PREMIUM -->
                <div id="carencia-block-premium" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Día 0: Inmediato -->
                    <div class="bg-white p-5 rounded-3xl border-2 border-purple-600 shadow-sm space-y-3 relative overflow-hidden">
                        <div class="absolute top-0 right-0 bg-purple-600 text-white text-[9px] font-black px-2.5 py-0.5 rounded-bl-xl uppercase">
                            Día 0 (Inmediato)
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center font-black text-base">
                            💎
                        </div>
                        <h4 class="font-black text-sm text-slate-900">Activación Inmediata</h4>
                        <ul class="text-xs text-slate-600 space-y-1.5 font-medium">
                            <li>✓ Kit de Bienvenida (Placa + Collar)</li>
                            <li>✓ Carnet Digital Oficial</li>
                            <li>✓ Consultas Virtuales ILIMITADAS</li>
                            <li>✓ 1ª Desparasitación Interna</li>
                        </ul>
                    </div>

                    <!-- 30 Días (Mes 1+) -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-3 relative">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-black text-base">
                            🩺
                        </div>
                        <h4 class="font-black text-sm text-slate-900">A partir del Mes 1</h4>
                        <ul class="text-xs text-slate-600 space-y-1.5 font-medium">
                            <li>✓ Consultas Presenciales</li>
                            <li>✓ 1er Baño & Peluquería</li>
                            <li>✓ 1er Examen de Laboratorio</li>
                        </ul>
                    </div>

                    <!-- 90 - 180 Días -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-3 relative">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-base">
                            🔬
                        </div>
                        <h4 class="font-black text-sm text-slate-900">Mes 3 al Mes 6</h4>
                        <ul class="text-xs text-slate-600 space-y-1.5 font-medium">
                            <li>✓ Vacunación Completa + Rabia</li>
                            <li>✓ 1 Ecografía Abdominal Completa</li>
                            <li>✓ 2ª Desparasitación Externa</li>
                        </ul>
                    </div>

                    <!-- 240 Días (8 Meses+) -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-3 relative">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center font-black text-base">
                            🦷
                        </div>
                        <h4 class="font-black text-sm text-slate-900">A partir del Mes 8</h4>
                        <ul class="text-xs text-slate-600 space-y-1.5 font-medium">
                            <li>✓ Profilaxis Dental (50% Dcto)</li>
                            <li>✓ Servicio Funerario Gratuito</li>
                            <li>✓ 2º Examen de Laboratorio</li>
                        </ul>
                    </div>

                </div>

                <!-- BANNER DESTACADO DE ACTIVACIÓN INMEDIATA CON PAGO ANUAL -->
                <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="space-y-1.5 text-center sm:text-left">
                        <div class="inline-flex items-center space-x-2 bg-white/20 px-3 py-0.5 rounded-full text-xs font-black uppercase tracking-wider">
                            <span>🚀 Bypass de Carencias</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black">¿Quieres usar TODOS los servicios desde el Día 1?</h3>
                        <p class="text-xs sm:text-sm text-emerald-100 max-w-xl font-medium">
                            Con el <strong>Pago Anual Anticipado</strong> eliminas todos los periodos de carencia y recibes un 10% de descuento directo en tu membresía.
                        </p>
                    </div>
                    <button type="button" onclick="setBillingCycle('annual'); location.href='#planes';" class="px-6 py-3.5 bg-white text-emerald-900 hover:bg-emerald-50 font-black text-xs uppercase tracking-wider rounded-2xl shadow-md shrink-0 transition-all">
                        ⭐ Ver Beneficio Anual
                    </button>
                </div>

            </div>
        </section>
        @endif

        <!-- 08. INSTALACIONES & CONSULTORIO VETERINARIO (FOTOS & VIDEO 9:16) -->
        @if($showFacilities)
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

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center max-w-5xl mx-auto">
                    
                    @if(!empty($bannerVideo))
                        <!-- 1. HISTORIA / REEL EN FORMATO VERTICAL 9:16 REAL -->
                        <div class="lg:col-span-5 flex justify-center">
                            <div class="w-full max-w-[320px] sm:max-w-[340px] aspect-[9/16] rounded-[36px] overflow-hidden shadow-2xl border-[6px] border-slate-950 bg-black relative group flex flex-col justify-between">
                                
                                <!-- Top Story Bar -->
                                <div class="absolute top-0 inset-x-0 p-3.5 z-20 bg-gradient-to-b from-black/80 via-black/40 to-transparent flex items-center justify-between text-white text-xs">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-7 h-7 rounded-full bg-teal-500 border-2 border-white flex items-center justify-center text-xs shadow-xs">
                                            🐾
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-extrabold text-[11px] leading-tight truncate">{{ $tenant->name }}</p>
                                            <p class="text-[9px] text-teal-300 font-bold flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-ping"></span>
                                                <span>Video en Vivo</span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Botón de Audio Interactivo (Estilo Instagram Story) -->
                                    <button type="button" id="btn-sound-toggle" onclick="toggleStorySound(event)" class="bg-black/60 hover:bg-black/80 backdrop-blur-md px-2.5 py-1 rounded-full text-[10px] font-bold flex items-center space-x-1.5 text-white border border-white/20 transition-all cursor-pointer shadow-md">
                                        <span id="sound-icon">🔇</span>
                                        <span id="sound-label">Activar Audio</span>
                                    </button>
                                </div>

                                <!-- Video Vertical Full 9:16 -->
                                <video id="story-video-player" class="w-full h-full object-cover cursor-pointer" autoplay muted loop playsinline poster="{{ $bannerImage }}" onclick="toggleStorySound(event)">
                                    <source src="{{ $bannerVideo }}" type="video/mp4">
                                    Tu navegador no soporta video.
                                </video>

                                <!-- Bottom Location Pill -->
                                <div class="absolute bottom-3 inset-x-3 bg-slate-950/85 backdrop-blur-md p-2.5 rounded-2xl text-white flex items-center justify-between text-xs border border-white/10 z-20 pointer-events-none">
                                    <div class="flex items-center space-x-1.5 min-w-0">
                                        <span class="text-sm shrink-0">📍</span>
                                        <span class="font-bold text-[10px] truncate">{{ $city }}</span>
                                    </div>
                                    <span class="text-[9px] text-emerald-400 font-black bg-emerald-950/80 px-2 py-0.5 rounded-full uppercase tracking-wider shrink-0">Abierto L-S</span>
                                </div>
                            </div>
                        </div>

                        <!-- 2. DATOS DE LA CLÍNICA & FOTO DE INSTALACIONES -->
                        <div class="lg:col-span-7 space-y-5">
                            @if(!empty($bannerImage))
                                <div class="rounded-3xl overflow-hidden shadow-md border border-slate-200 aspect-[16/9] relative group">
                                    <img src="{{ $bannerImage }}" alt="Instalaciones de {{ $tenant->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                    <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-3 py-1 rounded-full text-[10px] font-black text-slate-900 shadow-sm border border-slate-100">
                                        🏥 Sede Presencial
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

                                <a href="https://wa.me/57{{ $cleanPhone }}?text=Hola,%20quiero%20conocer%20la%20ubicaci%C3%B3n%20y%20agendar%20visita%20en%20{{ urlencode($tenant->name) }}" target="_blank" class="w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-black text-xs rounded-2xl transition flex items-center justify-center gap-2 shadow-sm">
                                    <span>💬 Cómo Llegar por WhatsApp</span>
                                    <span>↗</span>
                                </a>
                            </div>
                        </div>

                    @else
                        <!-- FALLBACK CUANDO NO HAY VIDEO: COVER FOTO HORIZONTAL -->
                        <div class="lg:col-span-7 rounded-3xl overflow-hidden shadow-xl border border-slate-200 bg-slate-900 relative aspect-video flex items-center justify-center group">
                            @if(!empty($bannerImage))
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

                                <a href="https://wa.me/57{{ $cleanPhone }}?text=Hola,%20quiero%20conocer%20la%20ubicaci%C3%B3n%20y%20agendar%20visita%20en%20{{ urlencode($tenant->name) }}" target="_blank" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-black text-xs rounded-2xl transition flex items-center justify-center gap-2">
                                    <span>💬 Cómo Llegar por WhatsApp</span>
                                    <span>↗</span>
                                </a>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </section>
        @endif

        <!-- 09. TESTIMONIOS & PRUEBA SOCIAL -->
        @if($showTestimonials)
        <section class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
                <div class="text-center space-y-2">
                    <span class="text-xs font-black text-brand-primary uppercase tracking-widest">Opiniones Reales</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900">Lo que dicen las familias en {{ $city }}</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Testimonio 1 -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-3">
                        <div class="text-amber-400 text-sm">⭐⭐⭐⭐⭐</div>
                        <p class="text-xs text-slate-600 italic leading-relaxed">
                            "Tener el plan de salud me da una tranquilidad inmensa. Mi perrita Luna ya tuvo su vacuna y su chequeo sin pagar nada extra en recepción."
                        </p>
                        <div class="pt-2 flex items-center space-x-2.5 border-t border-slate-100">
                            <div class="w-8 h-8 rounded-full bg-teal-100 text-teal-800 font-bold flex items-center justify-center text-xs">
                                MC
                            </div>
                            <div class="text-[11px]">
                                <span class="font-bold text-slate-900">María Camila R.</span>
                                <span class="block text-slate-400">Mamá de Luna (Poodle)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonio 2 -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-3">
                        <div class="text-amber-400 text-sm">⭐⭐⭐⭐⭐</div>
                        <p class="text-xs text-slate-600 italic leading-relaxed">
                            "El carnet digital con QR es una maravilla. Llego a la veterinaria, lo escanean y ya saben qué vacunas y controles le corresponden a Milo."
                        </p>
                        <div class="pt-2 flex items-center space-x-2.5 border-t border-slate-100">
                            <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-800 font-bold flex items-center justify-center text-xs">
                                JG
                            </div>
                            <div class="text-[11px]">
                                <span class="font-bold text-slate-900">Juan David G.</span>
                                <span class="block text-slate-400">Papá de Milo (Bulldog)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonio 3 -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-3">
                        <div class="text-amber-400 text-sm">⭐⭐⭐⭐⭐</div>
                        <p class="text-xs text-slate-600 italic leading-relaxed">
                            "Pagué el año completo y me ahorré un montón de plata. La atención del equipo en {{ $tenant->name }} siempre es de 10 sobre 10."
                        </p>
                        <div class="pt-2 flex items-center space-x-2.5 border-t border-slate-100">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-xs">
                                AP
                            </div>
                            <div class="text-[11px]">
                                <span class="font-bold text-slate-900">Andrea P.</span>
                                <span class="block text-slate-400">Mamá de Rocky & Nina</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- 10. CONDICIONES CLARAS & TRANSPARENCIA (QUÉ NO INCLUYE) -->
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

        <!-- 11. PREGUNTAS FRECUENTES (FAQ) -->
        @if($showFaq)
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
        @endif

        <!-- 12. CTA FINAL POTENTE (DUAL) -->
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
            <p class="text-[10px] text-slate-400 font-black uppercase">Membresía</p>
            <p class="text-xs font-black text-slate-900 truncate">{{ $heroPriceBadge }}</p>
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

    <!-- 13. FOOTER 100% WHITE LABEL -->
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
            © {{ date('Y') }} {{ $tenant->name }}. Todos los derechos reservados. Sistema Integral de Membresías y Salud Preventiva.
        </div>
    </footer>

    <!-- MODAL DE AUTO-AFILIACIÓN DIGITAL EN VIVO (STEP-BY-STEP) -->
    <div id="enroll-modal" class="fixed inset-0 z-50 modal-backdrop hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-lg w-full p-5 sm:p-8 shadow-2xl border border-slate-200 relative my-auto max-h-[92vh] overflow-y-auto animate-in fade-in zoom-in-95 duration-200">
            
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
                        <input type="email" id="tutor_email" required placeholder="Ej. camila@gmail.com" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                <!-- PASO 2: DATOS DE LA MASCOTA -->
                <div id="step-2-fields" class="space-y-3 hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nombre de la Mascota *</label>
                            <input type="text" id="pet_name" placeholder="Ej. Lucas" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Especie *</label>
                            <select id="pet_species" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="canino">🐶 Canino (Perro)</option>
                                <option value="felino">🐱 Felino (Gato)</option>
                            </select>
                        </div>
                    </div>

                    <!-- FOTO DE LA MASCOTA -->
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-2xl">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">📸 Foto de tu Mascota (Para su Carnet Oficial)</label>
                        <div class="flex items-center space-x-3">
                            <div id="pet-photo-preview-box" class="w-14 h-14 rounded-2xl bg-white border-2 border-dashed border-teal-400/60 flex items-center justify-center text-xl text-teal-600 overflow-hidden shrink-0 shadow-xs relative">
                                <img id="pet-photo-preview" class="w-full h-full object-cover hidden" alt="Foto">
                                <span id="pet-photo-placeholder">📷</span>
                            </div>
                            <div class="space-y-1 min-w-0">
                                <input type="file" id="pet_photo_input" accept="image/*" onchange="previewPetPhoto(event)" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-teal-50 file:text-teal-800 hover:file:bg-teal-100 cursor-pointer">
                                <p class="text-[10px] text-slate-400 truncate">PNG, JPG o foto directa desde tu celular.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Raza</label>
                            <input type="text" id="pet_breed" placeholder="Ej. Golden Retriever / Criollo" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Edad Aproximada</label>
                            <input type="text" id="pet_age" placeholder="Ej. 2 años" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                </div>

                <!-- PASO 3: RESUMEN Y MEDIO DE PAGO -->
                <div id="step-3-fields" class="space-y-3.5 hidden">
                    <!-- RESUMEN DEL PLAN -->
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 space-y-1">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500">Plan Seleccionado:</span>
                            <span id="summary-plan-name" class="font-black text-slate-900">Plan Patitas Básico</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500">Frecuencia:</span>
                            <span id="summary-cycle" class="font-bold text-teal-700">Mensual</span>
                        </div>
                        <div class="flex justify-between items-center text-xs border-t border-slate-200 pt-1.5 mt-1.5">
                            <span class="font-black text-slate-900">Valor a Pagar:</span>
                            <span id="summary-price" class="font-black text-emerald-600 text-sm">$50.000 COP</span>
                        </div>
                    </div>

                    <!-- SELECTOR DE MEDIO DE PAGO INTERACTIVO -->
                    <div>
                        <label class="block text-xs font-black text-slate-900 mb-2">Selecciona tu Medio de Pago Directo:</label>
                        <input type="hidden" id="payment_method" value="nequi">
                        
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div onclick="selectPaymentMethod('nequi')" class="payment-card-opt p-2.5 rounded-xl border-2 border-teal-500 bg-teal-50/50 cursor-pointer text-center space-y-0.5 hover:bg-teal-50 transition-all">
                                <span class="block text-base">📱</span>
                                <span class="block text-slate-900 font-extrabold">Nequi / Daviplata</span>
                                <span class="block text-[10px] text-teal-700 font-bold">Transferencia Directa</span>
                            </div>

                            <div onclick="selectPaymentMethod('bold')" class="payment-card-opt p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer text-center space-y-0.5 hover:bg-slate-50 transition-all">
                                <span class="block text-base">💳</span>
                                <span class="block text-slate-900 font-extrabold">Bold / PSE</span>
                                <span class="block text-[10px] text-purple-700 font-bold">Tarjetas y PSE</span>
                            </div>

                            <div onclick="selectPaymentMethod('bank')" class="payment-card-opt p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer text-center space-y-0.5 hover:bg-slate-50 transition-all">
                                <span class="block text-base">🏦</span>
                                <span class="block text-slate-900 font-extrabold">Bancolombia</span>
                                <span class="block text-[10px] text-slate-500 font-bold">Cuenta Clínica</span>
                            </div>

                            <div onclick="selectPaymentMethod('cash')" class="payment-card-opt p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer text-center space-y-0.5 hover:bg-slate-50 transition-all">
                                <span class="block text-base">💵</span>
                                <span class="block text-slate-900 font-extrabold">En Recepción</span>
                                <span class="block text-[10px] text-slate-500 font-bold">Efectivo / Datáfono</span>
                            </div>
                        </div>
                    </div>

                    <!-- DETALLES DE PAGO DINÁMICOS SEGÚN SELECCIÓN -->
                    <!-- 1. NEQUI / DAVIPLATA -->
                    <div id="pay-detail-nequi" class="p-3 bg-emerald-50 border border-emerald-200 rounded-2xl space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-emerald-950">📲 Número Nequi / Daviplata Oficial:</span>
                            <button type="button" onclick="copyText('{{ $paymentNequi }}', this)" class="text-[10px] font-black bg-emerald-600 text-white px-2 py-0.5 rounded-md hover:bg-emerald-700">
                                Copiar
                            </button>
                        </div>
                        <p class="text-base font-black text-emerald-900 font-mono tracking-wider">{{ $paymentNequi }}</p>
                        <p class="text-[11px] text-emerald-800">
                            Transfiere desde tu app de Nequi o Daviplata a este número de la clínica.
                        </p>
                    </div>

                    <!-- 2. BOLD / TARJETA -->
                    <div id="pay-detail-bold" class="hidden p-3 bg-purple-50 border border-purple-200 rounded-2xl space-y-2">
                        <span class="text-xs font-bold text-purple-950">💳 Pago Seguro con Bold (Tarjetas & PSE)</span>
                        <p class="text-[11px] text-purple-800 leading-relaxed">
                            Al confirmar tu afiliación serás redirigido al portal oficial de Bold de <strong>{{ $tenant->name }}</strong> para pagar con tarjeta de crédito, débito o PSE.
                        </p>
                    </div>

                    <!-- 3. BANCOLOMBIA / TRANSFERENCIA BANCARIA -->
                    <div id="pay-detail-bank" class="hidden p-3 bg-slate-100 border border-slate-200 rounded-2xl space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-900">🏦 Cuenta Bancaria Oficial:</span>
                            <button type="button" onclick="copyText('{{ $paymentBank }}', this)" class="text-[10px] font-black bg-slate-700 text-white px-2 py-0.5 rounded-md hover:bg-slate-800">
                                Copiar
                            </button>
                        </div>
                        <p class="text-xs font-bold text-slate-800 leading-relaxed font-mono">{{ $paymentBank }}</p>
                    </div>

                    <!-- 4. EN RECEPCIÓN -->
                    <div id="pay-detail-cash" class="hidden p-3 bg-amber-50 border border-amber-200 rounded-2xl space-y-1">
                        <span class="text-xs font-bold text-amber-950">💵 Pago Directo en Sede</span>
                        <p class="text-[11px] text-amber-800 leading-relaxed">
                            Puedes cancelar en efectivo o datáfono directamente en nuestro consultorio en <strong>{{ $address }}, {{ $city }}</strong> al momento de tu primera visita.
                        </p>
                    </div>

                    <!-- INSTRUCCIÓN DE CONFIRMACIÓN -->
                    @if(!empty($paymentInstructions))
                        <div class="text-[11px] text-slate-600 bg-amber-50/80 border border-amber-200 p-2.5 rounded-xl flex items-start space-x-1.5">
                            <span class="text-amber-700 font-bold shrink-0">ℹ️</span>
                            <span>{{ $paymentInstructions }}</span>
                        </div>
                    @endif
                </div>

                <!-- PASO 4: ÉXITO Y CARNET GENERADO -->
                <div id="step-success-fields" class="space-y-4 hidden text-center">
                    <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl mx-auto shadow-inner">
                        ✓
                    </div>
                    <div>
                        <h4 class="text-lg font-black text-slate-900">¡Afiliación Completada con Éxito!</h4>
                        <p class="text-xs text-slate-600 mt-1">
                            El contrato digital <strong id="success-contract-id" class="text-teal-700 font-mono font-black">VP-2026-XXXX</strong> ha sido emitido para <strong id="success-pet-name">TU MASCOTA</strong>.
                        </p>
                    </div>

                    <!-- BOTÓN BOLD DINÁMICO SI FUE SELECCIONADO Y TIENE LINK -->
                    <div id="success-bold-container" class="hidden pt-1">
                        <a id="success-bold-btn" href="#" target="_blank" class="w-full py-3 bg-purple-700 hover:bg-purple-800 text-white font-black text-xs uppercase tracking-wider rounded-2xl shadow-md flex items-center justify-center space-x-2 transition-all">
                            <span>💳 Pagar Ahora con Bold / PSE</span>
                            <span>↗</span>
                        </a>
                    </div>
                    
                    <div class="pt-1 space-y-2">
                        <a id="success-carnet-btn" href="#" target="_blank" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-black text-xs uppercase tracking-wider rounded-2xl shadow-md flex items-center justify-center space-x-2 transition-all">
                            <span>🪪 Ver y Descargar Carnet Digital (PDF)</span>
                            <span>↗</span>
                        </a>
                        <a id="success-whatsapp-btn" href="#" target="_blank" class="w-full py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs uppercase tracking-wider rounded-2xl shadow-md flex items-center justify-center space-x-2 transition-all">
                            <span>💬 Enviar Comprobante / Notificar a la Clínica</span>
                            <span>↗</span>
                        </a>
                        <button type="button" onclick="closeEnrollModal()" class="w-full py-2.5 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-200 transition-all">
                            Cerrar
                        </button>
                    </div>
                </div>

                <!-- BOTONES DE NAVEGACIÓN DEL MODAL -->
                <div id="modal-nav-btns" class="pt-3 flex items-center justify-between gap-3 border-t border-slate-100">
                    <button type="button" id="btn-modal-prev" onclick="prevModalStep()" class="hidden px-4 py-2.5 text-xs font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-all">
                        ← Atrás
                    </button>
                    <button type="button" id="btn-modal-next" onclick="nextModalStep()" class="ml-auto px-6 py-2.5 text-xs font-black text-white bg-brand-primary rounded-xl shadow-xs hover:opacity-90 transition-all">
                        Siguiente Paso →
                    </button>
                    <button type="submit" id="btn-modal-submit" class="hidden ml-auto px-6 py-2.5 text-xs font-black text-white bg-emerald-600 rounded-xl shadow-xs hover:bg-emerald-500 transition-all">
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
        let currentPaymentMethod = 'nequi';
        let petPhotoBase64 = null;

        function previewPetPhoto(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                petPhotoBase64 = e.target.result;
                const img = document.getElementById('pet-photo-preview');
                const placeholder = document.getElementById('pet-photo-placeholder');
                img.src = petPhotoBase64;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        // Copiar texto al portapapeles con feedback
        function copyText(text, btnElement) {
            navigator.clipboard.writeText(text).then(() => {
                const original = btnElement.innerText;
                btnElement.innerText = '¡Copiado! ✓';
                setTimeout(() => {
                    btnElement.innerText = original;
                }, 2000);
            }).catch(err => {
                prompt('Copia este valor:', text);
            });
        }

        // Selección visual e interactiva de método de pago
        function selectPaymentMethod(method) {
            currentPaymentMethod = method;
            document.getElementById('payment_method').value = method;

            const nequiBox = document.getElementById('pay-detail-nequi');
            const boldBox = document.getElementById('pay-detail-bold');
            const bankBox = document.getElementById('pay-detail-bank');
            const cashBox = document.getElementById('pay-detail-cash');

            nequiBox.classList.add('hidden');
            boldBox.classList.add('hidden');
            bankBox.classList.add('hidden');
            cashBox.classList.add('hidden');

            if (method === 'nequi') nequiBox.classList.remove('hidden');
            if (method === 'bold') boldBox.classList.remove('hidden');
            if (method === 'bank') bankBox.classList.remove('hidden');
            if (method === 'cash') cashBox.classList.remove('hidden');

            document.querySelectorAll('.payment-card-opt').forEach(el => {
                el.classList.remove('border-teal-500', 'border-2', 'bg-teal-50/50');
                el.classList.add('border-slate-200', 'bg-white');
            });
            event.currentTarget.classList.remove('border-slate-200', 'bg-white');
            event.currentTarget.classList.add('border-teal-500', 'border-2', 'bg-teal-50/50');
        }

        // Calculadora de Ahorro en tiempo real
        function calculateSavings() {
            const consultas = parseInt(document.getElementById('calc-consultas').value) || 3;
            const baths = parseInt(document.getElementById('calc-baths').value) || 2;

            document.getElementById('calc-consultas-val').innerText = consultas + (consultas === 1 ? ' consulta' : ' consultas');
            document.getElementById('calc-baths-val').innerText = baths + (baths === 1 ? ' baño' : ' baños');

            const valorConsultasPart = consultas * 65000;
            const valorBanosPart = baths * 45000;
            const valorPrevPart = 450000;
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
                modalTitle.innerText = '3. Resumen y Medio de Pago';
                modalSub.innerText = 'Verifica la información y medio de pago directo a la clínica';
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
                pet_photo_base64: petPhotoBase64,
                plan_slug: selectedPlan,
                billing_cycle: currentCycle,
                payment_method: document.getElementById('payment_method').value,
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
                    document.getElementById('modal-step-subtitle').innerText = 'Tu membresía ha quedado registrada en {{ $tenant->name }}';
                    
                    document.getElementById('success-contract-id').innerText = data.contract_id;
                    document.getElementById('success-pet-name').innerText = data.pet_name;
                    document.getElementById('success-carnet-btn').href = data.carnet_url;
                    document.getElementById('success-whatsapp-btn').href = data.whatsapp_url;

                    // Si eligió Bold y existe link, mostrar botón de pago directo Bold
                    const boldContainer = document.getElementById('success-bold-container');
                    const boldBtn = document.getElementById('success-bold-btn');
                    if (data.bold_payment_url && (data.payment_method === 'bold' || data.payment_method === 'card_pse' || data.payment_method === 'card')) {
                        boldBtn.href = data.bold_payment_url;
                        boldContainer.classList.remove('hidden');
                    } else {
                        boldContainer.classList.add('hidden');
                    }
                    
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

        // Control de Audio para el Story Video
        function toggleStorySound(event) {
            if (event) event.stopPropagation();
            const video = document.getElementById('story-video-player');
            const icon = document.getElementById('sound-icon');
            const label = document.getElementById('sound-label');
            const btn = document.getElementById('btn-sound-toggle');

            if (video) {
                if (video.muted) {
                    video.muted = false;
                    if (icon) icon.innerText = '🔊';
                    if (label) label.innerText = 'Audio Activado';
                    if (btn) btn.classList.add('bg-teal-600/80', 'border-teal-300');
                } else {
                    video.muted = true;
                    if (icon) icon.innerText = '🔇';
                    if (label) label.innerText = 'Activar Audio';
                    if (btn) btn.classList.remove('bg-teal-600/80', 'border-teal-300');
                }
            }
        }
    </script>
</body>
</html>
