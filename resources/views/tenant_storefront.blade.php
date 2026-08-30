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
        .hero-gradient { background: radial-gradient(circle at 80% 20%, {{ $primaryColor }}20 0%, #f0fdfa30 40%, rgba(255, 255, 255, 0) 70%); }
        .bg-brand-primary { background-color: var(--brand-primary); }
        .bg-brand-secondary { background-color: var(--brand-secondary); }
        .text-brand-primary { color: var(--brand-primary); }
        .border-brand-primary { border-color: var(--brand-primary); }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between bg-white overflow-x-hidden">

    <!-- 1. TOP BAR -->
    <div class="bg-brand-secondary text-white text-xs font-semibold py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-1.5 sm:gap-2 text-center sm:text-left">
            <div class="flex items-center space-x-2 text-sky-100 text-[11px] sm:text-xs">
                <span>🐾</span>
                <span>Planes de salud prepagada y bienestar integral</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}" target="_blank" class="flex items-center space-x-1.5 hover:opacity-90 transition-opacity text-[11px] sm:text-xs">
                    <svg class="w-3.5 h-3.5 fill-current text-sky-400" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                    </svg>
                    <span>Línea Única:</span>
                    <span class="text-white font-bold">{{ $tenant->branding['phone'] ?? '350 874 2543' }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. NAVBAR -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between">
            <div class="flex items-center space-x-2.5 sm:space-x-3">
                @if(!empty($logoUrl))
                    <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="h-9 sm:h-12 max-h-14 w-auto object-contain rounded-lg shadow-sm" loading="lazy">
                @else
                    <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-brand-primary flex items-center justify-center text-white text-lg sm:text-xl shadow-md">
                        🐾
                    </div>
                @endif
                <div>
                    <span class="text-base sm:text-xl font-extrabold tracking-tight text-slate-900 truncate block max-w-[170px] sm:max-w-none">{{ $tenant->name }}</span>
                    <span class="hidden sm:inline-block ml-2 px-2.5 py-0.5 text-xs font-semibold rounded-full" style="background-color: {{ $primaryColor }}15; color: {{ $primaryColor }};">{{ $tenant->branding['city'] ?? 'Cajicá' }}</span>
                </div>
            </div>

            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
                <a href="#planes" class="text-brand-primary font-bold border-b-2 border-brand-primary pb-1">Planes</a>
                <a href="#beneficios" class="hover:text-brand-primary transition-colors">Beneficios</a>
                <a href="#como-funciona" class="hover:text-brand-primary transition-colors">Video & Proceso</a>
                <a href="#contacto" class="hover:text-brand-primary transition-colors">Contacto</a>
            </nav>

            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="/v/{{ $tenant->slug }}/admin" class="hidden sm:inline-block px-3.5 sm:px-4 py-2 text-xs sm:text-sm font-bold text-slate-700 hover:text-slate-900 border border-slate-200 rounded-full hover:bg-slate-50 transition-all">
                    Panel
                </a>
                <a href="#planes" class="px-4 sm:px-5 py-2 text-xs sm:text-sm font-bold text-white bg-brand-primary hover:opacity-90 rounded-full shadow-md transition-all whitespace-nowrap">
                    Ver planes
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- 3. HERO -->
        <section class="hero-gradient relative pt-8 sm:pt-12 pb-16 sm:pb-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
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
                            Cuidado preventivo <span class="text-brand-primary">inteligente</span> para tu mascota
                        </h1>

                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl font-normal">
                            Planes de salud diseñados por veterinarios para garantizar bienestar, ahorro continuo y atención inmediata en <strong class="text-slate-800">{{ $tenant->name }}</strong>.
                        </p>

                        <div class="space-y-2.5 text-xs sm:text-sm font-semibold text-slate-700">
                            <div class="flex items-center space-x-2.5">
                                <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-extrabold shrink-0" style="background-color: {{ $primaryColor }}20; color: {{ $primaryColor }};">✓</span>
                                <span>Ahorra hasta 35% en servicios veterinarios anuales</span>
                            </div>
                            <div class="flex items-center space-x-2.5">
                                <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-extrabold shrink-0" style="background-color: {{ $primaryColor }}20; color: {{ $primaryColor }};">✓</span>
                                <span>Atención prioritaria y kit de bienvenida</span>
                            </div>
                            <div class="flex items-center space-x-2.5">
                                <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-extrabold shrink-0" style="background-color: {{ $primaryColor }}20; color: {{ $primaryColor }};">✓</span>
                                <span>Recordatorios automáticos de vacunas y desparasitación</span>
                            </div>
                        </div>

                        <div class="pt-2 flex flex-wrap items-center gap-3 sm:gap-4">
                            <a href="#planes" class="px-6 sm:px-7 py-3 sm:py-3.5 rounded-full bg-brand-primary text-white font-bold text-xs sm:text-sm shadow-lg hover:opacity-90 transition-all flex items-center space-x-2">
                                <span>Explorar planes</span>
                                <span>›</span>
                            </a>
                            <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}?text=Hola,%20deseo%20agendar%20una%20cita%20veterinaria%20en%20{{ urlencode($tenant->name) }}" target="_blank" class="px-5 sm:px-6 py-3 sm:py-3.5 rounded-full bg-white hover:bg-slate-50 text-slate-800 font-bold text-xs sm:text-sm border border-slate-200 shadow-sm transition-all flex items-center space-x-2">
                                <span>📅 Agendar cita</span>
                            </a>
                        </div>
                    </div>

                    <!-- FOTO DERECHA HERO -->
                    <div class="lg:col-span-5 relative mt-4 lg:mt-0">
                        <div class="relative mx-auto max-w-sm sm:max-w-md">
                            <img class="w-full h-auto object-cover rounded-3xl shadow-xl border border-slate-100" src="{{ $heroImage }}" alt="{{ $tenant->name }}" loading="lazy"/>
                            
                            <div class="absolute -bottom-4 left-2 sm:-left-6 sm:-bottom-6 bg-white p-3.5 sm:p-5 rounded-2xl shadow-2xl border border-slate-100 max-w-[240px] sm:max-w-[270px] space-y-2.5 sm:space-y-3">
                                <div class="flex items-center space-x-2.5 sm:space-x-3">
                                    <img class="w-9 h-9 sm:w-11 sm:h-11 rounded-full object-cover border-2 border-brand-primary shrink-0" src="https://images.unsplash.com/photo-1552053831-71594a27632d?w=150" alt="Max Golden"/>
                                    <div>
                                        <div class="flex items-center space-x-1.5">
                                            <h4 class="font-extrabold text-xs sm:text-sm text-slate-900">Max</h4>
                                            <span class="px-1.5 py-0.2 text-[9px] sm:text-[10px] font-bold rounded-full" style="background-color: {{ $primaryColor }}20; color: {{ $primaryColor }};">● Activo</span>
                                        </div>
                                        <p class="text-[10px] sm:text-[11px] text-slate-500">Golden Retriever • 3 años</p>
                                        <p class="text-[9px] sm:text-[10px] text-brand-primary font-bold">Plan Activo 💎</p>
                                    </div>
                                </div>

                                <div class="bg-slate-50 p-2 sm:p-2.5 rounded-xl text-xs space-y-1">
                                    <div class="flex justify-between text-slate-500 text-[9px] sm:text-[10px]">
                                        <span>Próximo servicio</span>
                                        <span class="font-bold text-slate-700">En 12 días</span>
                                    </div>
                                    <p class="font-bold text-slate-800 text-xs">Desparasitación</p>
                                </div>

                                <div class="flex items-center justify-between pt-1 border-t border-slate-100 text-xs">
                                    <div>
                                        <span class="text-[9px] sm:text-[10px] text-slate-400">Ahorro acumulado</span>
                                        <p class="font-extrabold text-brand-primary text-xs sm:text-sm">$180.000 <span class="text-[9px] sm:text-[10px] font-normal text-slate-500">COP</span></p>
                                    </div>
                                    <div class="text-brand-primary text-base sm:text-lg">📊</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 4. PLANES DINÁMICOS CON COLORES DE MARCA Y LÍNEA DE TIEMPO -->
        <section id="planes" class="py-12 sm:py-20 bg-[#fbfcfd] border-t border-slate-100 overflow-hidden">
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
                            <button type="button" onclick="setBillingCycle('monthly')" id="btn-cycle-monthly" class="flex-1 sm:flex-initial px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-xl font-bold text-xs transition-all bg-white text-slate-900 shadow-sm text-center">
                                📅 Pago Mensual
                            </button>
                            <button type="button" onclick="setBillingCycle('annual')" id="btn-cycle-annual" class="flex-1 sm:flex-initial px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-xl font-bold text-xs transition-all text-slate-600 hover:text-slate-900 flex items-center justify-center space-x-1.5 text-center">
                                <span>⭐ Pago Anual</span>
                                <span class="bg-emerald-600 text-white text-[9px] sm:text-[10px] font-black px-1.5 sm:px-2 py-0.5 rounded-full uppercase tracking-wider">-10%</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 max-w-5xl gap-6 sm:gap-8 mx-auto items-stretch">
                    
                    <!-- 1. PLAN PATITAS BÁSICO -->
                    <div id="plan-card-basico" onclick="selectPlanCard('basico')" class="plan-card cursor-pointer bg-white rounded-3xl p-5 sm:p-8 border-2 border-brand-primary ring-2 ring-brand-primary/20 shadow-md flex flex-col justify-between transition-all relative">
                        <div class="space-y-5 sm:space-y-6">
                            <!-- Encabezado del Plan -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl font-bold shrink-0 shadow-sm" style="background-color: {{ $primaryColor }}15; color: {{ $primaryColor }};">
                                        🛡️
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-extrabold text-slate-900">Plan Patitas Básico</h3>
                                        <p class="text-xs text-slate-500 font-medium">Prevención integral y medicina prepagada</p>
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
                        <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}?text=Hola,%20deseo%20activar%20mi%20Plan%20en%20modalidad%20ANUAL%20sin%20carencias" target="_blank" class="w-full sm:w-auto text-center px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-sm whitespace-nowrap transition-all flex items-center justify-center">
                            Activar Plan Anual ⭐
                        </a>
                    </div>
                </div>

                <script>
                    function setBillingCycle(cycle) {
                        const monthlyBlocks = document.querySelectorAll('.monthly-price-block');
                        const annualBlocks = document.querySelectorAll('.annual-price-block');
                        const btnMonthly = document.getElementById('btn-cycle-monthly');
                        const btnAnnual = document.getElementById('btn-cycle-annual');

                        if (cycle === 'annual') {
                            monthlyBlocks.forEach(b => b.classList.add('hidden'));
                            annualBlocks.forEach(b => b.classList.remove('hidden'));
                            btnAnnual.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                            btnAnnual.classList.remove('text-slate-600');
                            btnMonthly.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                            btnMonthly.classList.add('text-slate-600');
                        } else {
                            annualBlocks.forEach(b => b.classList.add('hidden'));
                            monthlyBlocks.forEach(b => b.classList.remove('hidden'));
                            btnMonthly.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                            btnMonthly.classList.remove('text-slate-600');
                            btnAnnual.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                            btnAnnual.classList.add('text-slate-600');
                        }
                    }

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

                        if (planType === 'premium') {
                            // Tarjetas superiores
                            cardBasico.classList.remove('border-2', 'border-brand-primary', 'ring-2', 'ring-brand-primary/20', 'shadow-md');
                            cardBasico.classList.add('border-slate-200');
                            badgeBasico.classList.add('hidden');

                            cardPremium.classList.add('border-2', 'border-brand-primary', 'ring-2', 'ring-brand-primary/20', 'shadow-md');
                            cardPremium.classList.remove('border-slate-200');
                            badgePremium.classList.remove('hidden');

                            // Timeline inferior
                            blockBasico.classList.add('hidden');
                            blockPremium.classList.remove('hidden');
                            btnPremium.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                            btnPremium.classList.remove('text-slate-600');
                            btnBasico.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                            btnBasico.classList.add('text-slate-600');
                            if (titlePlan) titlePlan.textContent = 'Plan Patitas Premium';
                        } else {
                            // Tarjetas superiores
                            cardPremium.classList.remove('border-2', 'border-brand-primary', 'ring-2', 'ring-brand-primary/20', 'shadow-md');
                            cardPremium.classList.add('border-slate-200');
                            badgePremium.classList.add('hidden');

                            cardBasico.classList.add('border-2', 'border-brand-primary', 'ring-2', 'ring-brand-primary/20', 'shadow-md');
                            cardBasico.classList.remove('border-slate-200');
                            badgeBasico.classList.remove('hidden');

                            // Timeline inferior
                            blockPremium.classList.add('hidden');
                            blockBasico.classList.remove('hidden');
                            btnBasico.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                            btnBasico.classList.remove('text-slate-600');
                            btnPremium.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                            btnPremium.classList.add('text-slate-600');
                            if (titlePlan) titlePlan.textContent = 'Plan Patitas Básico';
                        }
                    }

                    function jumpToCarencias(planType) {
                        selectPlanCard(planType);
                        const carenciasEl = document.getElementById('carencias-section');
                        if (carenciasEl) {
                            carenciasEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }
                </script>

                <p class="text-center text-[11px] text-slate-400 mt-8 font-medium">
                    * El proceso para solicitar los beneficios una vez activos será siempre a través de nuestra línea única de atención <strong>{{ $tenant->branding['phone'] ?? '350 874 2543' }}</strong>. Los servicios descritos están incluidos en el plan; la entrega o suministro de estos puede generar un valor adicional según condiciones particulares.
                </p>
            </div>
        </section>

        <!-- 5. FEATURES -->
        <section id="beneficios" class="py-16 bg-white border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-xl flex-shrink-0" style="background-color: {{ $primaryColor }}15; color: {{ $primaryColor }};">
                            🪄
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-slate-900">IA que recomienda lo mejor para tu mascota</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Sugerencias inteligentes según su edad, raza y hábitos.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-xl flex-shrink-0" style="background-color: {{ $primaryColor }}15; color: {{ $primaryColor }};">
                            📱
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-slate-900">Controla todo desde tu celular</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Historial, citas, beneficios y recordatorios de vacunas.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-xl flex-shrink-0" style="background-color: {{ $primaryColor }}15; color: {{ $primaryColor }};">
                            ❤️
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-slate-900">Atención cercana y humana</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Nuestro equipo veterinario siempre disponible para ti.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-xl flex-shrink-0" style="background-color: {{ $primaryColor }}15; color: {{ $primaryColor }};">
                            💰
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-slate-900">Ahorra sin sacrificar la calidad</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Más beneficios, prevención continua y mejor precio.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 6. SECCIÓN "ASÍ DE FÁCIL" CON VIDEO OPTIMIZADO O FOTO BANNER -->
        <section id="como-funciona" class="py-16 bg-[#fbfcfd] border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <div class="lg:col-span-5 space-y-6">
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Así de <span class="text-brand-primary underline" style="text-decoration-color: {{ $primaryColor }}80;">fácil</span></h2>

                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-8 h-8 rounded-full bg-brand-secondary text-white font-extrabold flex items-center justify-center text-xs flex-shrink-0">
                                    1
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-900">Elige tu plan</h4>
                                    <p class="text-xs text-slate-500">Compara y selecciona la cobertura adecuada para tu peludo.</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-8 h-8 rounded-full bg-brand-secondary text-white font-extrabold flex items-center justify-center text-xs flex-shrink-0">
                                    2
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-900">Registra a tu mascota</h4>
                                    <p class="text-xs text-slate-500">Datos rápidos, carnet digital y kit de bienvenida.</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-8 h-8 rounded-full bg-brand-secondary text-white font-extrabold flex items-center justify-center text-xs flex-shrink-0">
                                    3
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-900">Disfruta los beneficios</h4>
                                    <p class="text-xs text-slate-500">Atención médica, vacunas y descuentos en cada visita.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-7">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-100 bg-slate-900">
                            @if(!empty($bannerVideo))
                                <video class="w-full h-80 object-cover" poster="{{ $bannerImage }}" preload="metadata" controls playsinline>
                                    <source src="{{ $bannerVideo }}" type="video/mp4">
                                    Tu navegador no soporta la reproducción de video.
                                </video>
                            @else
                                <img class="w-full h-80 object-cover" src="{{ $bannerImage }}" alt="{{ $tenant->name }}" loading="lazy"/>
                                <div class="absolute inset-0 bg-slate-900/20 flex items-center justify-center pointer-events-none">
                                    <div class="w-16 h-16 rounded-full bg-white/90 text-brand-primary flex items-center justify-center text-2xl shadow-xl">
                                        ▶
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 7. TESTIMONIOS -->
        <section class="py-16 bg-white border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-2xl font-extrabold text-slate-900">Lo que dicen nuestros clientes</h3>
                    <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}" target="_blank" class="text-xs font-bold text-brand-primary hover:opacity-90 flex items-center space-x-1">
                        <span>Ver más opiniones</span>
                        <span>→</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-3">
                        <div class="text-amber-400 text-xs">★★★★★</div>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">"Desde que tengo a Max en el plan Plus, hemos ahorrado y su salud ha mejorado muchísimo."</p>
                        <div class="flex items-center space-x-3 pt-2">
                            <img class="w-8 h-8 rounded-full object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" alt="Andrea"/>
                            <span class="text-xs font-bold text-slate-800">Andrea M. (Tutor de Max)</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-3">
                        <div class="text-amber-400 text-xs">★★★★★</div>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">"Los recordatorios y la atención en el mostrador me han salvado la vida. ¡Ya no se me olvida nada!"</p>
                        <div class="flex items-center space-x-3 pt-2">
                            <img class="w-8 h-8 rounded-full object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt="Camilo"/>
                            <span class="text-xs font-bold text-slate-800">Camilo R. (Tutor de Luna)</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-3">
                        <div class="text-amber-400 text-xs">★★★★★</div>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">"Excelente atención en {{ $tenant->branding['city'] ?? 'Cajicá' }} y beneficios reales. 100% recomendados."</p>
                        <div class="flex items-center space-x-3 pt-2">
                            <img class="w-8 h-8 rounded-full object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="Laura"/>
                            <span class="text-xs font-bold text-slate-800">Laura G. (Tutora de Toby)</span>
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
                        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-3xl flex-shrink-0">
                            💬
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold">¿Tienes dudas? Escríbenos por WhatsApp</h3>
                            <p class="text-sky-100 text-sm">Te ayudamos a elegir el plan perfecto para tu peludo 🐶🐱</p>
                        </div>
                    </div>
                    
                    <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}?text=Hola,%20tengo%20dudas%20sobre%20los%20Planes%20de%20{{ urlencode($tenant->name) }}" target="_blank" class="z-10 px-8 py-4 bg-white text-slate-900 hover:bg-slate-50 font-extrabold text-sm rounded-full shadow-lg transition-all flex items-center space-x-2 flex-shrink-0">
                        <span>💬 Chatear ahora</span>
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- 9. FOOTER -->
    <footer id="contacto" class="bg-[#f8fafc] border-t border-slate-200 py-14 text-slate-600 text-xs">
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
                    <li><a href="#beneficios" class="hover:text-brand-primary">Beneficios</a></li>
                    <li><a href="#como-funciona" class="hover:text-brand-primary">Video & Proceso</a></li>
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

</body>
</html>
