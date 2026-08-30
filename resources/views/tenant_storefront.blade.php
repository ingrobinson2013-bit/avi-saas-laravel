<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-900 text-slate-100 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name }} — Planes de Salud y Bienestar para Mascotas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .gradient-text { background: linear-gradient(135deg, {{ $tenant->branding['primary_color'] ?? '#10b981' }} 0%, #38bdf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between selection:bg-emerald-500 selection:text-slate-950">

    <!-- NAVBAR CLINICA -->
    <header class="sticky top-0 z-50 glass border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-6 h-6 text-slate-950 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-white">{{ $tenant->name }}</span>
                    <span class="hidden sm:inline-block ml-2 px-2 py-0.5 text-xs font-semibold bg-emerald-500/10 text-emerald-400 rounded-full border border-emerald-500/20">{{ $tenant->branding['city'] ?? 'Cajicá' }}</span>
                </div>
            </div>
            
            <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-slate-300">
                <a href="#planes" class="hover:text-emerald-400 transition-colors">Planes de Salud</a>
                <a href="#asistente-ia" class="hover:text-emerald-400 transition-colors">Calculadora IA</a>
                <a href="#contacto" class="hover:text-emerald-400 transition-colors">Contacto</a>
            </nav>

            <div class="flex items-center space-x-3">
                <a href="/admin" class="px-4 py-2 text-sm font-semibold text-slate-200 hover:text-white bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 transition-all flex items-center space-x-2">
                    <span>Acceso Recepción</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- HERO -->
        <section class="relative pt-16 pb-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center max-w-3xl mx-auto space-y-6">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold tracking-wide uppercase">
                    <span>{{ $tenant->name }} — Salud y Bienestar</span>
                </div>

                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white leading-tight">
                    Planes de salud prepagada para tu <span class="gradient-text">mascota</span>
                </h1>

                <p class="text-lg text-slate-400 leading-relaxed">
                    Consultas veterinarias, vacunación, desparasitaciones y descuentos especiales con atención presencial en <strong class="text-slate-200">{{ $tenant->branding['city'] ?? 'Cajicá' }}</strong>.
                </p>

                <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#planes" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-base shadow-lg shadow-emerald-500/25 transition-all">
                        Ver Planes Disponibles
                    </a>
                    @if(isset($tenant->branding['phone']))
                    <a href="https://wa.me/57{{ $tenant->branding['phone'] }}?text=Hola,%20deseo%20afiliarme%20a%20un%20plan%20de%20salud" target="_blank" class="w-full sm:w-auto px-8 py-4 rounded-2xl glass hover:bg-slate-800 text-emerald-400 font-bold text-base border border-emerald-500/30 transition-all">
                        WhatsApp: {{ $tenant->branding['phone'] }}
                    </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- LISTADO DINAMICO DE PLANES DE LA CLINICA -->
        <section id="planes" class="py-16 bg-slate-950/60 border-y border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-3 mb-14">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Nuestra Oferta de Planes</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Planes Oficiales de {{ $tenant->name }}</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    @forelse($plans as $plan)
                    <div class="glass rounded-3xl p-8 flex flex-col justify-between border border-slate-700 hover:border-emerald-500/50 transition-all">
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Plan de Suscripción</span>
                            <h3 class="text-2xl font-bold text-white">{{ $plan->name }}</h3>
                            <div class="flex items-baseline space-x-2">
                                <span class="text-4xl font-extrabold text-white">${{ number_format($plan->price_cop, 0, ',', '.') }}</span>
                                <span class="text-slate-400 text-sm">COP / {{ $plan->billing_interval === 'monthly' ? 'mes' : 'año' }}</span>
                            </div>
                            <p class="text-sm text-slate-300">{{ $plan->description }}</p>
                            
                            <hr class="border-slate-800">
                            
                            <p class="text-xs font-bold text-slate-400 uppercase">Beneficios incluidos:</p>
                            <ul class="space-y-2 text-sm text-slate-300">
                                @foreach($plan->planBenefits as $pb)
                                <li class="flex items-center space-x-2">
                                    <span class="text-emerald-400 font-bold">✓</span>
                                    <span>{{ $pb->benefitDefinition->name }} (x{{ $pb->quantity >= 999 ? 'Ilimitado' : $pb->quantity }})</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @if(isset($tenant->branding['phone']))
                        <a href="https://wa.me/57{{ $tenant->branding['phone'] }}?text=Hola,%20deseo%20afiliarme%20al%20{{ urlencode($plan->name) }}" target="_blank" class="mt-8 w-full py-4 text-center rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-sm shadow-md block">
                            Afiliarme por WhatsApp
                        </a>
                        @endif
                    </div>
                    @empty
                    <p class="text-slate-400 text-center col-span-2">No hay planes registrados para esta veterinaria aún.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer id="contacto" class="border-t border-slate-800 py-10 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-slate-500 text-xs gap-4">
            <div>
                <p class="font-bold text-slate-300">{{ $tenant->name }}</p>
                <p>{{ $tenant->branding['address'] ?? '' }} — {{ $tenant->branding['city'] ?? '' }}</p>
            </div>
            <div class="flex space-x-6">
                <a href="/" class="hover:text-emerald-400 transition-colors">Plataforma AVI-Plan</a>
                <a href="/admin" class="hover:text-emerald-400 transition-colors">Acceso Recepción</a>
            </div>
        </div>
    </footer>
</body>
</html>
