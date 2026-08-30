<!DOCTYPE html>
<html lang="es" class="h-full bg-white text-slate-900 antialiased selection:bg-emerald-500 selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name }} — Cuidado preventivo inteligente para tu mascota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @php
        $primaryColor = $tenant->branding['primary_color'] ?? '#059669';
        $secondaryColor = $tenant->branding['secondary_color'] ?? '#034433';
        $logoUrl = $tenant->branding['logo_url'] ?? null;
        $heroImage = $tenant->branding['hero_image_url'] ?? 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?w=700&auto=format&fit=crop&q=80';
        $bannerImage = $tenant->branding['banner_image_url'] ?? 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=1000';
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
<body class="min-h-full flex flex-col justify-between bg-white">

    <!-- 1. TOP BAR PERSONALIZADA CON COLOR SECUNDARIO -->
    <div class="bg-brand-secondary text-white text-xs font-semibold py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center space-x-2 text-emerald-100">
                <span>🐾</span>
                <span>Cuida a tu mascota todo el año • Con planes flexibles de salud prepagada</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}" target="_blank" class="flex items-center space-x-1.5 hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4 fill-current text-emerald-400" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                    </svg>
                    <span>WhatsApp</span>
                    <span class="text-white font-bold">{{ $tenant->branding['phone'] ?? '350 874 2543' }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. NAVBAR CON LOGO DINÁMICO DE LA CLÍNICA -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                @if(!empty($logoUrl))
                    <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="h-11 w-auto max-w-[150px] object-contain rounded-xl">
                @else
                    <div class="w-10 h-10 rounded-full bg-brand-primary flex items-center justify-center text-white shadow-md">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                @endif
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">{{ $tenant->name }}</span>
                    <span class="hidden sm:inline-block ml-2 px-2 py-0.5 text-xs font-semibold rounded-full" style="background-color: {{ $primaryColor }}15; color: {{ $primaryColor }};">{{ $tenant->branding['city'] ?? 'Cajicá' }}</span>
                </div>
            </div>

            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
                <a href="#planes" class="text-brand-primary font-bold border-b-2 border-brand-primary pb-1">Planes</a>
                <a href="#beneficios" class="hover:text-brand-primary transition-colors">Beneficios</a>
                <a href="#como-funciona" class="hover:text-brand-primary transition-colors">Preguntas</a>
                <a href="#contacto" class="hover:text-brand-primary transition-colors">Contacto</a>
            </nav>

            <div class="flex items-center space-x-3">
                <a href="/v/{{ $tenant->slug }}/admin" class="px-4 py-2 text-sm font-bold text-slate-700 hover:text-slate-900 border border-slate-200 rounded-full hover:bg-slate-50 transition-all">
                    Panel Veterinaria
                </a>
                <a href="#planes" class="px-5 py-2 text-sm font-bold text-white bg-brand-primary hover:opacity-90 rounded-full shadow-md transition-all">
                    Ver planes
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- 3. HERO SECTION CON FOTO DINÁMICA -->
        <section class="hero-gradient relative pt-12 pb-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center space-x-3 bg-white px-3 py-1.5 rounded-full shadow-sm border border-slate-100">
                            <div class="flex -space-x-2 overflow-hidden">
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" alt=""/>
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt=""/>
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt=""/>
                            </div>
                            <div class="flex items-center space-x-1 text-amber-400 text-xs">
                                <span>★★★★★</span>
                            </div>
                            <span class="text-xs font-bold text-slate-600">+450 mascotas protegidas este mes</span>
                        </div>

                        <h1 class="text-4xl sm:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.1]">
                            Cuidado preventivo <span class="text-brand-primary">inteligente</span> para tu mascota
                        </h1>

                        <p class="text-lg text-slate-600 leading-relaxed max-w-xl font-normal">
                            Planes de salud diseñados por veterinarios para garantizar bienestar, ahorro y tranquilidad en <strong class="text-slate-800">{{ $tenant->branding['city'] ?? 'Cajicá' }}</strong>.
                        </p>

                        <div class="space-y-2.5 text-sm font-semibold text-slate-700">
                            <div class="flex items-center space-x-2.5">
                                <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-extrabold" style="background-color: {{ $primaryColor }}20; color: {{ $primaryColor }};">✓</span>
                                <span>Ahorra hasta 35% en servicios</span>
                            </div>
                            <div class="flex items-center space-x-2.5">
                                <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-extrabold" style="background-color: {{ $primaryColor }}20; color: {{ $primaryColor }};">✓</span>
                                <span>Atención prioritaria en clínica</span>
                            </div>
                            <div class="flex items-center space-x-2.5">
                                <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-extrabold" style="background-color: {{ $primaryColor }}20; color: {{ $primaryColor }};">✓</span>
                                <span>Recordatorios y seguimiento personalizado</span>
                            </div>
                        </div>

                        <div class="pt-3 flex flex-wrap items-center gap-4">
                            <a href="#planes" class="px-7 py-3.5 rounded-full bg-brand-primary text-white font-bold text-sm shadow-lg hover:opacity-90 transition-all flex items-center space-x-2">
                                <span>Explorar planes</span>
                                <span>›</span>
                            </a>
                            <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}?text=Hola,%20deseo%20agendar%20una%20cita%20veterinaria%20en%20{{ urlencode($tenant->name) }}" target="_blank" class="px-6 py-3.5 rounded-full bg-white hover:bg-slate-50 text-slate-800 font-bold text-sm border border-slate-200 shadow-sm transition-all flex items-center space-x-2">
                                <span>📅 Agendar cita</span>
                            </a>
                        </div>

                        <div class="pt-4 flex flex-wrap items-center gap-6 text-xs text-slate-500 font-medium">
                            <span class="flex items-center space-x-1.5"><span>🔒</span> <span>Seguridad de datos</span></span>
                            <span class="flex items-center space-x-1.5"><span>💳</span> <span>Pagos seguros</span></span>
                            <span class="flex items-center space-x-1.5"><span>🛡️</span> <span>Cancelación flexible</span></span>
                        </div>
                    </div>

                    <!-- FOTO DERECHA HERO (CONFIGURADA DESDE EL PANEL) -->
                    <div class="lg:col-span-5 relative">
                        <div class="relative mx-auto max-w-md">
                            <img class="w-full h-auto object-cover rounded-3xl shadow-lg border border-slate-100" src="{{ $heroImage }}" alt="{{ $tenant->name }}"/>
                            
                            <div class="absolute -bottom-6 -left-6 sm:-left-8 bg-white p-4 sm:p-5 rounded-2xl shadow-2xl border border-slate-100 max-w-[270px] space-y-3">
                                <div class="flex items-center space-x-3">
                                    <img class="w-11 h-11 rounded-full object-cover border-2 border-brand-primary" src="https://images.unsplash.com/photo-1552053831-71594a27632d?w=150" alt="Max Golden"/>
                                    <div>
                                        <div class="flex items-center space-x-1.5">
                                            <h4 class="font-extrabold text-sm text-slate-900">Max</h4>
                                            <span class="px-1.5 py-0.2 text-[10px] font-bold rounded-full" style="background-color: {{ $primaryColor }}20; color: {{ $primaryColor }};">● Activo</span>
                                        </div>
                                        <p class="text-[11px] text-slate-500">Golden Retriever • 3 años</p>
                                        <p class="text-[10px] text-brand-primary font-bold">Plan Activo 💎</p>
                                    </div>
                                </div>

                                <div class="bg-slate-50 p-2.5 rounded-xl text-xs space-y-1">
                                    <div class="flex justify-between text-slate-500 text-[10px]">
                                        <span>Próximo servicio</span>
                                        <span class="font-bold text-slate-700">En 12 días</span>
                                    </div>
                                    <p class="font-bold text-slate-800 text-xs">Desparasitación</p>
                                </div>

                                <div class="flex items-center justify-between pt-1 border-t border-slate-100 text-xs">
                                    <div>
                                        <span class="text-[10px] text-slate-400">Ahorro acumulado</span>
                                        <p class="font-extrabold text-brand-primary text-sm">$180.000 <span class="text-[10px] font-normal text-slate-500">COP</span></p>
                                    </div>
                                    <div class="text-brand-primary text-lg">📊</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 4. PLANES DINÁMICOS CON COLORES DE MARCA -->
        <section id="planes" class="py-20 bg-[#fbfcfd] border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center space-y-2 mb-16">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Elige el plan ideal para tu mascota</h2>
                    <p class="text-slate-500 text-sm">Planes oficiales de {{ $tenant->name }}</p>
                </div>

                <div class="grid grid-cols-1 {{ count($plans) === 2 ? 'md:grid-cols-2 max-w-4xl' : 'md:grid-cols-3 max-w-6xl' }} gap-8 mx-auto items-stretch">
                    
                    @forelse($plans as $index => $plan)
                    @php
                        $isFeatured = ($index === 1) || str_contains(strtolower($plan->name), 'premium') || str_contains(strtolower($plan->name), 'plus');
                    @endphp

                    <div class="bg-white rounded-3xl p-8 {{ $isFeatured ? 'border-2 border-brand-primary shadow-xl relative' : 'border border-slate-200 shadow-sm hover:shadow-md' }} flex flex-col justify-between transition-all">
                        
                        @if($isFeatured)
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 bg-brand-secondary text-white font-bold text-[11px] rounded-full shadow-md">
                            Más elegido
                        </div>
                        @endif

                        <div class="space-y-5">
                            <div class="flex items-center space-x-3 {{ $isFeatured ? 'pt-2' : '' }}">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl font-bold" style="background-color: {{ $primaryColor }}15; color: {{ $primaryColor }};">
                                    🐾
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900">{{ $plan->name }}</h3>
                                    <p class="text-xs text-slate-400">{{ $plan->description ? Str::limit($plan->description, 45) : 'Plan de bienestar para mascotas' }}</p>
                                </div>
                            </div>

                            <div class="flex items-baseline space-x-1 pt-2">
                                <span class="text-4xl font-extrabold text-slate-900">${{ number_format($plan->price_cop, 0, ',', '.') }}</span>
                                <span class="text-slate-400 text-xs font-semibold">COP / {{ $plan->billing_interval === 'monthly' ? 'mes' : 'año' }}</span>
                            </div>
                            
                            @if(!empty($plan->description))
                            <p class="text-xs text-slate-600 font-medium">{{ $plan->description }}</p>
                            @endif

                            <hr class="border-slate-100">

                            <p class="text-xs font-bold text-slate-400 uppercase">Beneficios incluidos:</p>
                            <ul class="space-y-3 text-xs font-medium text-slate-600">
                                @forelse($plan->planBenefits as $pb)
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-brand-primary font-bold">✓</span>
                                    <span>{{ $pb->benefitDefinition->name }} (x{{ $pb->quantity >= 999 ? 'Ilimitado' : $pb->quantity }})</span>
                                </li>
                                @empty
                                <li class="flex items-center space-x-2.5 text-slate-400">
                                    <span>• Cobertura médica y preventiva incluida</span>
                                </li>
                                @endforelse
                            </ul>
                        </div>

                        <a href="https://wa.me/57{{ $tenant->branding['phone'] ?? '3508742543' }}?text=Hola,%20deseo%20afiliarme%20al%20{{ urlencode($plan->name) }}%20en%20{{ urlencode($tenant->name) }}" target="_blank" class="mt-8 w-full py-3.5 text-center rounded-full {{ $isFeatured ? 'bg-brand-primary hover:opacity-90 text-white shadow-md' : 'bg-white hover:bg-slate-50 text-slate-800 border border-slate-300' }} font-bold text-xs transition-all block">
                            Elegir plan
                        </a>
                    </div>
                    @empty
                    <div class="col-span-2 text-center py-12 text-slate-400">
                        <p>No hay planes configurados para esta clínica todavía.</p>
                    </div>
                    @endforelse

                </div>

                <p class="text-center text-[11px] text-slate-400 mt-8">* Aplica condiciones y periodos de carencia según reglamento de {{ $tenant->name }}.</p>
            </div>
        </section>

        <!-- 5. FEATURES HIGHLIGHTS -->
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

        <!-- 6. SECCIÓN "ASÍ DE FÁCIL" CON FOTO BANNER DINÁMICA -->
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
                                    <p class="text-xs text-slate-500">Compara y selecciona la cobertura adecuada.</p>
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
                                    <p class="text-xs text-slate-500">Nos encargamos del resto en cada visita a la clínica.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-7">
                        <div class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-100">
                            <img class="w-full h-80 object-cover" src="{{ $bannerImage }}" alt="{{ $tenant->name }}"/>
                            <div class="absolute inset-0 bg-slate-900/20 flex items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-white/90 text-brand-primary flex items-center justify-center text-2xl shadow-xl transform hover:scale-105 transition-all">
                                    ▶
                                </div>
                            </div>
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

        <!-- 8. BANNER WHATSAPP CON GRADIENTE DE MARCA -->
        <section class="py-10 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-3xl p-8 sm:p-10 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
                    <div class="flex items-center space-x-5 z-10">
                        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-3xl flex-shrink-0">
                            💬
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold">¿Tienes dudas? Escríbenos por WhatsApp</h3>
                            <p class="text-emerald-100 text-sm">Te ayudamos a elegir el plan perfecto para tu peludo 🐶🐱</p>
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
                        <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="h-8 w-auto object-contain">
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
                    <li><a href="#como-funciona" class="hover:text-brand-primary">Preguntas frecuentes</a></li>
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
                <span>Política de datos</span>
            </div>
        </div>
    </footer>

</body>
</html>
