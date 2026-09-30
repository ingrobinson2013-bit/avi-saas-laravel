<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950 text-slate-100 antialiased selection:bg-emerald-500 selection:text-slate-950 overflow-x-hidden scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AVI-Plan — La Plataforma SaaS de Membresías y Salud Recurrente para Veterinarias</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .glass { background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .glass-card { background: rgba(30, 41, 59, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .gradient-text { background: linear-gradient(135deg, #10b981 0%, #38bdf8 50%, #818cf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .glow-emerald { box-shadow: 0 0 60px -15px rgba(16, 185, 129, 0.35); }
        .glow-cyan { box-shadow: 0 0 60px -15px rgba(56, 189, 248, 0.35); }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between overflow-x-hidden bg-slate-950 text-slate-100">

    <!-- NAVBAR B2B -->
    <header class="sticky top-0 z-50 glass border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-400 to-sky-400 flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-slate-950 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-black tracking-tight text-white">AVI<span class="text-emerald-400">Plan</span></span>
                    <span class="hidden sm:inline-block ml-2 px-2 py-0.5 text-[10px] font-extrabold uppercase bg-emerald-500/10 text-emerald-400 rounded-full border border-emerald-500/20">SaaS Veterinario</span>
                </div>
            </a>
            
            <nav class="hidden lg:flex items-center space-x-8 text-xs sm:text-sm font-semibold text-slate-300">
                <a href="#como-funciona" class="hover:text-emerald-400 transition-colors">Cómo Funciona</a>
                <a href="#pilares" class="hover:text-emerald-400 transition-colors">Lo que te Entregamos</a>
                <a href="#calculadora" class="hover:text-emerald-400 transition-colors">Calculadora MRR</a>
                <a href="#precios" class="hover:text-emerald-400 transition-colors">Precios</a>
                <a href="#faq" class="hover:text-emerald-400 transition-colors">Preguntas</a>
            </nav>

            <div class="flex items-center space-x-3">
                <a href="/admin" class="hidden sm:inline-flex px-3 py-2 text-xs font-bold text-slate-300 hover:text-white transition-colors">
                    Iniciar Sesión
                </a>
                <button type="button" onclick="openRegisterModal('pro')" class="px-4 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-black text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-300 hover:to-teal-300 rounded-xl shadow-lg shadow-emerald-500/20 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                    15 Días Gratis 🚀
                </button>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- 1. HERO B2B DE ALTA CONVERSIÓN -->
        <section class="relative pt-12 sm:pt-20 pb-20 sm:pb-28 overflow-hidden">
            <!-- Gradiente de fondo difuso -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[500px] bg-gradient-to-tr from-emerald-500/15 via-teal-500/10 to-transparent blur-3xl -z-10 rounded-full pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-4xl mx-auto space-y-6">
                    
                    <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-black tracking-wide uppercase shadow-sm">
                        <span>✨ 15 Días de Prueba Gratis • Sin Tarjeta de Crédito • Cancela cuando quieras</span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white leading-[1.1]">
                        Convierte tu Veterinaria en un <span class="gradient-text">Motor de Ingresos Recurrentes</span> con Planes de Salud
                    </h1>

                    <p class="text-base sm:text-xl text-slate-300 leading-relaxed max-w-3xl mx-auto font-normal">
                        Deja de esperar a que las mascotas se enfermen para poder facturar. Entrega a tus clientes <strong class="text-white font-semibold">membresías mensuales prepagadas</strong> con carnet digital, cobra automáticamente y valida cupos en tu mostrador en 3 segundos con tu propia marca.
                    </p>

                    <!-- CTAs PRINCIPALES -->
                    <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button type="button" onclick="openRegisterModal('pro')" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-400 via-teal-400 to-emerald-400 text-slate-950 font-black text-base hover:from-emerald-300 hover:to-teal-300 shadow-xl shadow-emerald-500/30 transition-all transform hover:-translate-y-1 flex items-center justify-center space-x-2">
                            <span>🚀 Crear mi Clínica Gratis en 60s</span>
                            <span class="text-xs bg-slate-950/20 px-2 py-0.5 rounded-full font-bold">15 días gratis</span>
                        </button>
                        <a href="/v/vet-pet-patitas" target="_blank" class="w-full sm:w-auto px-7 py-4 rounded-2xl glass hover:bg-slate-800 text-slate-200 font-bold text-sm sm:text-base border border-slate-700 hover:border-slate-500 transition-all flex items-center justify-center space-x-2">
                            <span>👀 Ver Clínica Piloto en Vivo (Patitas)</span>
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>

                    <!-- SOCIAL PROOF / TRUST PILLS -->
                    <div class="pt-6 flex flex-wrap items-center justify-center gap-4 text-xs font-semibold text-slate-400">
                        <div class="flex items-center space-x-1.5 bg-slate-900/80 px-3 py-1.5 rounded-full border border-slate-800">
                            <span class="text-emerald-400">✓</span>
                            <span>Tu Propio Portal con tu Logo y Colores</span>
                        </div>
                        <div class="flex items-center space-x-1.5 bg-slate-900/80 px-3 py-1.5 rounded-full border border-slate-800">
                            <span class="text-emerald-400">✓</span>
                            <span>Afiche de Mostrador con QR para Imprimir</span>
                        </div>
                        <div class="flex items-center space-x-1.5 bg-slate-900/80 px-3 py-1.5 rounded-full border border-slate-800">
                            <span class="text-emerald-400">✓</span>
                            <span>Validación Rápida por Cédula o QR en Recepción</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. COMPARATIVA: VETERINARIA TRADICIONAL VS CON AVI-PLAN -->
        <section id="como-funciona" class="py-16 bg-slate-900/40 border-y border-slate-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-400">Evolución de Negocio</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-1">¿Por qué las mejores veterinarias cambiaron al modelo de suscripción?</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- MODELO TRADICIONAL -->
                    <div class="glass-card p-6 sm:p-8 rounded-3xl border border-rose-500/20 bg-rose-950/10 space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center font-bold text-xl">✕</div>
                            <div>
                                <h3 class="text-lg font-bold text-white">Veterinaria Tradicional (Reactiva)</h3>
                                <p class="text-xs text-rose-400/80 font-medium">Facturación impredecible y fuga de clientes</p>
                            </div>
                        </div>
                        <ul class="space-y-3 text-xs sm:text-sm text-slate-300">
                            <li class="flex items-start space-x-2">
                                <span class="text-rose-400 font-bold">✕</span>
                                <span>Los clientes solo visitan la clínica cuando la mascota ya está grave o enferma.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-rose-400 font-bold">✕</span>
                                <span>Discusiones en recepción por el valor imprevisto de consultas y vacunas.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-rose-400 font-bold">✕</span>
                                <span>El 65% de los tutores olvidan las fechas de vacunación y desparasitación.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-rose-400 font-bold">✕</span>
                                <span>Si llueve o hay puente festivo, los ingresos caen a cero.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- MODELO CON AVI-PLAN -->
                    <div class="glass-card p-6 sm:p-8 rounded-3xl border-2 border-emerald-500/40 bg-emerald-950/20 space-y-4 shadow-xl shadow-emerald-500/5">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center font-bold text-xl">✓</div>
                            <div>
                                <h3 class="text-lg font-bold text-white">Tu Clínica con AVI-Plan (Proactiva)</h3>
                                <p class="text-xs text-emerald-400 font-semibold">Ingreso fijo garantizado el día 1 de cada mes</p>
                            </div>
                        </div>
                        <ul class="space-y-3 text-xs sm:text-sm text-slate-200">
                            <li class="flex items-start space-x-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span><strong>Facturación mensual predecible (MRR):</strong> Cientos de tutores pagan su cuota mes a mes.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span><strong>Clientes que visitan 3 veces más al año:</strong> Aprovechan sus chequeos y baños preventivos.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span><strong>Fidelización blindada:</strong> El tutor nunca se va a otra veterinaria porque aquí tiene su plan activo.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span><strong>Ventas cruzadas automáticas:</strong> Al venir a canjear, compran snacks, medicamentos y accesorios.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. LOS 4 PILARES QUE TE ENTREGAMOS -->
        <section id="pilares" class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-2">
                    <span class="text-xs font-black uppercase tracking-wider text-teal-400">Solución Todo en Uno</span>
                    <h2 class="text-3xl sm:text-5xl font-black text-white">Lo que tu veterinaria recibe en 60 segundos</h2>
                    <p class="text-sm sm:text-base text-slate-400">Sin programar, sin diseñadores y sin contratos complicados.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- PILAR 1 -->
                    <div class="glass p-6 rounded-3xl border border-slate-800 hover:border-emerald-500/50 transition-all flex flex-col justify-between space-y-4 group">
                        <div class="space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                                🌐
                            </div>
                            <h3 class="text-lg font-bold text-white">Portal Web Marca Blanca</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Tu propia página web con tu nombre, logo, fotos y colores (ej: <code class="text-emerald-400">avipetapp.com/v/tu-clinica</code>). Tus clientes eligen su plan y se afilian desde su celular en 2 minutos.
                            </p>
                        </div>
                        <span class="text-[11px] font-bold text-emerald-400">Personalizable 100% →</span>
                    </div>

                    <!-- PILAR 2 -->
                    <div class="glass p-6 rounded-3xl border border-slate-800 hover:border-teal-500/50 transition-all flex flex-col justify-between space-y-4 group">
                        <div class="space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-teal-500/10 text-teal-400 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                                🖨️
                            </div>
                            <h3 class="text-lg font-bold text-white">Afiche de Mostrador con QR</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Generado automáticamente en tamaño Carta/A4 de alta definición. Lo imprimes con 1 clic y lo colocas en tu recepción para captar clientes en sala de espera sin esfuerzo.
                            </p>
                        </div>
                        <span class="text-[11px] font-bold text-teal-400">Listo para Imprimir →</span>
                    </div>

                    <!-- PILAR 3 -->
                    <div class="glass p-6 rounded-3xl border border-slate-800 hover:border-sky-500/50 transition-all flex flex-col justify-between space-y-4 group">
                        <div class="space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-sky-500/10 text-sky-400 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                                ⚡
                            </div>
                            <h3 class="text-lg font-bold text-white">Mostrador de Canje en Vivo</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Tu recepcionista digita la cédula o escanea el QR del carnet y ve al instante qué vacunas o consultas tiene disponibles. Descuenta cupos en 1 segundo con auditoría total.
                            </p>
                        </div>
                        <span class="text-[11px] font-bold text-sky-400">Cero Fricción en Caja →</span>
                    </div>

                    <!-- PILAR 4 -->
                    <div class="glass p-6 rounded-3xl border border-slate-800 hover:border-purple-500/50 transition-all flex flex-col justify-between space-y-4 group">
                        <div class="space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-400 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                                🪪
                            </div>
                            <h3 class="text-lg font-bold text-white">Carnet Digital Oficial</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Cada mascota recibe un carnet digital con código de barras y QR en el WhatsApp del dueño. Elimina el desorden de carnets de papel perdidos y eleva el prestigio de tu clínica.
                            </p>
                        </div>
                        <span class="text-[11px] font-bold text-purple-400">En el celular del tutor →</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. CALCULADORA INTERACTIVA DE MRR & ROI -->
        <section id="calculadora" class="py-20 bg-slate-900/60 border-y border-slate-800">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-400">Simulador Financiero</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Calcula cuánto facturará tu veterinaria</h2>
                    <p class="text-xs sm:text-sm text-slate-400">Mueve los valores para proyectar tus ingresos mensuales fijos.</p>
                </div>

                <div class="glass p-8 sm:p-10 rounded-3xl border border-slate-700/80 shadow-2xl space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        
                        <!-- CONTROLES -->
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="text-xs font-bold text-slate-300 uppercase">Mascotas activas en planes:</label>
                                    <span id="pets-count-display" class="text-2xl font-black text-emerald-400 font-mono">50</span>
                                </div>
                                <input type="range" id="pets-slider" min="10" max="300" step="5" value="50" class="w-full h-2.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-400">
                                <div class="flex justify-between text-[10px] text-slate-500 font-bold mt-1">
                                    <span>10 mascotas</span>
                                    <span>150 mascotas</span>
                                    <span>300 mascotas</span>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-slate-300 uppercase block mb-2">Precio promedio de tu plan mensual:</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <button type="button" onclick="setPlanPrice(49000)" class="price-btn py-2 px-3 rounded-xl border border-slate-700 bg-slate-800/80 text-xs font-bold text-slate-300 hover:border-emerald-500 focus:border-emerald-500 focus:bg-emerald-500/10 focus:text-emerald-300 active" data-price="49000">$49.000</button>
                                    <button type="button" onclick="setPlanPrice(65000)" class="price-btn py-2 px-3 rounded-xl border border-emerald-500 bg-emerald-500/20 text-xs font-black text-emerald-300" data-price="65000">$65.000 ⭐</button>
                                    <button type="button" onclick="setPlanPrice(89000)" class="price-btn py-2 px-3 rounded-xl border border-slate-700 bg-slate-800/80 text-xs font-bold text-slate-300 hover:border-emerald-500 focus:border-emerald-500 focus:bg-emerald-500/10 focus:text-emerald-300" data-price="89000">$89.000</button>
                                </div>
                            </div>

                            <p class="text-[11px] text-slate-400 leading-tight">
                                💡 <em>Dato real: Una veterinaria con 1 solo consultorio afilia entre 30 y 60 mascotas durante sus primeros 45 días usando el afiche de mostrador.</em>
                            </p>
                        </div>

                        <!-- RESULTADOS PROYECTADOS -->
                        <div class="bg-gradient-to-br from-slate-900 to-slate-950 p-6 rounded-2xl border-2 border-emerald-500/40 space-y-5 text-center relative overflow-hidden">
                            <div class="space-y-1">
                                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-400">Ingreso Recurrente Mensual (MRR)</span>
                                <div id="mrr-monthly" class="text-4xl sm:text-5xl font-black text-white font-mono">$3.250.000</div>
                                <span class="text-xs text-slate-400">COP / cada mes garantizados</span>
                            </div>

                            <hr class="border-slate-800">

                            <div class="grid grid-cols-2 gap-3 text-left">
                                <div class="bg-slate-900/90 p-3 rounded-xl border border-slate-800">
                                    <span class="text-[9px] uppercase font-bold text-slate-400 block">Facturación Anual</span>
                                    <span id="mrr-annual" class="text-lg font-black text-teal-300 font-mono">$39.000.000</span>
                                </div>
                                <div class="bg-slate-900/90 p-3 rounded-xl border border-slate-800">
                                    <span class="text-[9px] uppercase font-bold text-slate-400 block">Costo AVI-Plan</span>
                                    <span class="text-lg font-black text-slate-300 font-mono">$99.000<span class="text-[10px] font-normal text-slate-400">/mes</span></span>
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="button" onclick="openRegisterModal('pro')" class="w-full py-3.5 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-300 hover:to-teal-300 text-slate-950 font-black text-sm rounded-xl shadow-lg shadow-emerald-500/20 transition-all transform hover:scale-[1.02]">
                                    Comenzar a Facturar Esto (15 Días Gratis) →
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- 5. PRECIOS TRANSPARENTES -->
        <section id="precios" class="py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-400">Planes Simples y Sin Sorpresas</span>
                    <h2 class="text-3xl sm:text-5xl font-black text-white">Comienza con 15 días gratis</h2>
                    <p class="text-sm sm:text-base text-slate-400">Sin cobros adelantados. Si el software no te genera ingresos en 15 días, no pagas un solo peso.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                    
                    <!-- STARTER -->
                    <div class="glass p-8 rounded-3xl flex flex-col justify-between border border-slate-800 hover:border-slate-700 transition">
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Consultorios & Veterinarios</span>
                            <h3 class="text-2xl font-black text-white">Starter</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-4xl sm:text-5xl font-extrabold text-white font-mono">$99.000</span>
                                <span class="text-slate-400 text-sm">COP / mes</span>
                            </div>
                            <p class="text-xs text-slate-400 leading-relaxed">Hasta 60 mascotas activas en planes de salud.</p>
                            <hr class="border-slate-800">
                            <ul class="space-y-2.5 text-xs text-slate-300">
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Portal web propio con tu marca</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Afiche de mostrador con QR oficial</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>1 Usuario para recepción</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Mostrador de canje en vivo</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Soporte estándar por WhatsApp</span></li>
                            </ul>
                        </div>
                        <button type="button" onclick="openRegisterModal('starter')" class="mt-8 w-full py-3.5 text-center rounded-xl glass hover:bg-slate-800 text-white font-bold text-sm border border-slate-700 hover:border-slate-500 transition">
                            Probar Starter (15 Días)
                        </button>
                    </div>

                    <!-- PROFESIONAL (POPULAR) -->
                    <div class="glass p-8 rounded-3xl flex flex-col justify-between border-2 border-emerald-500 shadow-2xl shadow-emerald-500/15 relative transform lg:-translate-y-2">
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-emerald-500 text-slate-950 font-black text-[11px] uppercase tracking-wider shadow-md">
                            ⭐ MÁS ELEGIDO POR CLÍNICAS
                        </div>
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Clínicas en Crecimiento</span>
                            <h3 class="text-2xl font-black text-white">Profesional</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-4xl sm:text-5xl font-extrabold text-emerald-400 font-mono">$229.000</span>
                                <span class="text-slate-400 text-sm">COP / mes</span>
                            </div>
                            <p class="text-xs text-slate-300 leading-relaxed">Hasta 250 mascotas + Usuarios ilimitados + Asistente IA.</p>
                            <hr class="border-slate-800">
                            <ul class="space-y-2.5 text-xs text-slate-200">
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span><strong>Todo lo del plan Starter</strong></span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span><strong>Usuarios ilimitados</strong> (doctores + recepción)</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Asistente IA de Retención & Vencimientos</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Métricas de facturación recurrente en vivo</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Soporte VIP prioritario NODIA</span></li>
                            </ul>
                        </div>
                        <button type="button" onclick="openRegisterModal('pro')" class="mt-8 w-full py-4 text-center rounded-xl bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-300 hover:to-teal-300 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 transition transform hover:scale-[1.02]">
                            Comenzar 15 Días Gratis →
                        </button>
                    </div>

                    <!-- ENTERPRISE -->
                    <div class="glass p-8 rounded-3xl flex flex-col justify-between border border-slate-800 hover:border-slate-700 transition">
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Hospitales y Redes Multi-Sede</span>
                            <h3 class="text-2xl font-black text-white">Enterprise</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-4xl sm:text-5xl font-extrabold text-white font-mono">$489.000</span>
                                <span class="text-slate-400 text-sm">COP / mes</span>
                            </div>
                            <p class="text-xs text-slate-400 leading-relaxed">Mascotas ilimitadas + Multi-sucursal + Dominio Propio.</p>
                            <hr class="border-slate-800">
                            <ul class="space-y-2.5 text-xs text-slate-300">
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span><strong>Mascotas y afiliados ilimitados</strong></span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Múltiples sedes y sucursales conectadas</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Dominio propio personalizado (<code class="text-teal-400">tuclinica.com</code>)</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Integración WhatsApp Bot n8n para avisos</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Gerente de cuenta y capacitación a tu equipo</span></li>
                            </ul>
                        </div>
                        <a href="https://wa.me/573508742543?text=Hola%20Robinson,%20me%20interesa%20el%20plan%20Enterprise%20para%20mi%20red%20de%20veterinarias" target="_blank" class="mt-8 w-full py-3.5 text-center rounded-xl glass hover:bg-slate-800 text-white font-bold text-sm border border-slate-700 hover:border-slate-500 transition">
                            Contactar Asesor Enterprise
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. PREGUNTAS FRECUENTES (FAQ) -->
        <section id="faq" class="py-16 bg-slate-900/40 border-t border-slate-800">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <div class="text-center space-y-2">
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-400">Dudas Frecuentes</span>
                    <h2 class="text-3xl font-extrabold text-white">Todo lo que necesitas saber antes de empezar</h2>
                </div>

                <div class="space-y-4">
                    <details class="glass p-5 rounded-2xl border border-slate-800 group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-white flex justify-between items-center list-none">
                            <span>¿Tengo que reemplazar mi software actual de historia clínica?</span>
                            <span class="text-emerald-400 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-400 mt-3 leading-relaxed">
                            <strong>No.</strong> AVI-Plan no busca competir con tu software de historia médica o inventarios (SoftVet, Gesvet, etc.). AVI-Plan es un <strong>motor especializado de membresías y facturación recurrente</strong>. Convive perfectamente con cualquier sistema que uses hoy.
                        </p>
                    </details>

                    <details class="glass p-5 rounded-2xl border border-slate-800 group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-white flex justify-between items-center list-none">
                            <span>¿Cómo cobran las suscripciones mis clientes?</span>
                            <summary-icon class="text-emerald-400 font-bold text-lg group-open:rotate-45 transition-transform">+</summary-icon>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-400 mt-3 leading-relaxed">
                            El dinero va <strong>100% directo a tus cuentas</strong>. Puedes configurar tu Nequi, Daviplata, transferencia Bancolombia o links de cobro Bold/Wompi. AVI-Plan no retiene tu dinero ni te cobra comisión por transacción.
                        </p>
                    </details>

                    <details class="glass p-5 rounded-2xl border border-slate-800 group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-white flex justify-between items-center list-none">
                            <span>¿Qué pasa cuando terminen los 15 días gratis?</span>
                            <summary-icon class="text-emerald-400 font-bold text-lg group-open:rotate-45 transition-transform">+</summary-icon>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-400 mt-3 leading-relaxed">
                            No te pedimos tarjeta de crédito para iniciar la prueba. Al día 13 te avisaremos para que elijas tu plan (desde $99.000/mes). Si decides no continuar, tu cuenta simplemente se pausa sin penalidades ni cobros sorpresa.
                        </p>
                    </details>

                    <details class="glass p-5 rounded-2xl border border-slate-800 group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-white flex justify-between items-center list-none">
                            <span>¿Cuánto tiempo tardo en tener mi clínica lista para afiliar pacientes?</span>
                            <summary-icon class="text-emerald-400 font-bold text-lg group-open:rotate-45 transition-transform">+</summary-icon>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-400 mt-3 leading-relaxed">
                            <strong>Menos de 60 segundos.</strong> En cuanto completas el formulario de registro, el sistema te crea automáticamente tus 2 planes recomendados, tu enlace web público y tu afiche oficial con código QR listo para imprimir en recepción.
                        </p>
                    </details>
                </div>
            </div>
        </section>

        <!-- 7. BANNER FINAL CTA -->
        <section class="py-20 relative overflow-hidden">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="glass p-8 sm:p-14 rounded-3xl border-2 border-emerald-500/30 text-center space-y-6 relative overflow-hidden glow-emerald">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-black uppercase">
                        <span>🚀 Comienza hoy mismo</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                        Haz que tu veterinaria facture ingresos fijos todos los meses
                    </h2>
                    <p class="text-sm sm:text-lg text-slate-300 max-w-2xl mx-auto font-normal">
                        Únete a la nueva generación de clínicas veterinarias con planes de salud y carnet digital. Tu prueba de 15 días gratis está lista.
                    </p>
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button type="button" onclick="openRegisterModal('pro')" class="w-full sm:w-auto px-9 py-4 rounded-2xl bg-gradient-to-r from-emerald-400 to-teal-400 text-slate-950 font-black text-base hover:from-emerald-300 hover:to-teal-300 shadow-xl shadow-emerald-500/30 transition transform hover:-translate-y-0.5">
                            Crear mi Clínica Gratis en 60s →
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER B2B -->
    <footer class="border-t border-slate-800 py-10 bg-slate-950 text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <span class="font-extrabold text-white">AVI<span class="text-emerald-400">Plan</span></span>
                <span>— Plataforma SaaS Marca Blanca de Salud y Membresías Veterinarias.</span>
            </div>
            <div class="flex space-x-6 font-semibold">
                <a href="/admin" class="hover:text-emerald-400 transition-colors">Acceso Mostrador</a>
                <a href="/v/vet-pet-patitas" class="hover:text-emerald-400 transition-colors">Clínica Piloto en Vivo</a>
                <a href="https://wa.me/573508742543" target="_blank" class="hover:text-emerald-400 transition-colors">Soporte WhatsApp</a>
            </div>
        </div>
    </footer>

    <!-- MODAL DE REGISTRO EXPRESS B2B EN 60 SEGUNDOS -->
    <div id="register-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4 hidden transition-opacity opacity-0 pointer-events-none">
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-700/80 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 text-slate-100 transform scale-95 transition-transform">
            
            <!-- BOTÓN CERRAR -->
            <button type="button" onclick="closeRegisterModal()" class="absolute top-4 right-4 text-slate-400 hover:text-white p-2 rounded-xl bg-slate-800 hover:bg-slate-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="space-y-1">
                <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black uppercase">
                    <span>✨ Registro Express en 60 Segundos</span>
                </div>
                <h3 class="text-2xl font-black text-white">Crea tu Clínica Veterinaria</h3>
                <p class="text-xs text-slate-400">Disfruta de <strong class="text-emerald-400">15 días de prueba gratis</strong> con funciones Pro activadas.</p>
            </div>

            <!-- FORMULARIO AJAX -->
            <form id="clinic-onboarding-form" onsubmit="submitOnboarding(event)" class="space-y-4">
                @csrf
                <input type="hidden" name="saas_plan_tier" id="form-tier" value="pro">

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nombre de tu Veterinaria o Clínica <span class="text-emerald-400">*</span></label>
                    <input type="text" name="clinic_name" id="clinic-name-input" required placeholder="Ej. Veterinaria San Roque" oninput="updateSlugPreview(this.value)" class="w-full bg-slate-800/90 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-400 transition placeholder:text-slate-500">
                    <p class="text-[10px] text-slate-400 mt-1 font-mono">
                        Tu web será: <span id="slug-preview" class="text-emerald-400 font-bold">avipetapp.com/v/tu-clinica</span>
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Ciudad <span class="text-emerald-400">*</span></label>
                        <input type="text" name="city" required placeholder="Ej. Bogotá / Medellín" class="w-full bg-slate-800/90 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-400 transition placeholder:text-slate-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">WhatsApp de Contacto <span class="text-emerald-400">*</span></label>
                        <input type="tel" name="phone" required placeholder="Ej. 3101234567" class="w-full bg-slate-800/90 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-400 transition placeholder:text-slate-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Correo Electrónico (Tu usuario) <span class="text-emerald-400">*</span></label>
                    <input type="email" name="email" required placeholder="doctor@tuclinica.com" class="w-full bg-slate-800/90 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-400 transition placeholder:text-slate-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Contraseña de Acceso <span class="text-emerald-400">*</span></label>
                    <input type="password" name="password" required minlength="6" placeholder="Mínimo 6 caracteres" class="w-full bg-slate-800/90 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-400 transition placeholder:text-slate-500">
                </div>

                <div id="form-error-alert" class="hidden p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs font-medium"></div>

                <button type="submit" id="submit-btn" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-300 hover:to-teal-300 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 transition transform active:scale-95 flex items-center justify-center space-x-2">
                    <span id="btn-text">🚀 Activar mi Clínica Gratis (15 Días)</span>
                    <span id="btn-spinner" class="hidden animate-spin rounded-full h-4 w-4 border-2 border-slate-950 border-t-transparent"></span>
                </button>

                <p class="text-[10px] text-center text-slate-500">
                    Al registrarte aceptas los términos del servicio. No se requiere tarjeta de crédito.
                </p>
            </form>
        </div>
    </div>

    <!-- SCRIPTS DE INTERACCIÓN, CALCULADORA Y ONBOARDING -->
    <script>
        // --- 1. MODAL REGISTRO ---
        function openRegisterModal(tier = 'pro') {
            document.getElementById('form-tier').value = tier;
            const modal = document.getElementById('register-modal');
            modal.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
            setTimeout(() => document.getElementById('clinic-name-input').focus(), 150);
        }

        function closeRegisterModal() {
            const modal = document.getElementById('register-modal');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.querySelector('div').classList.remove('scale-100');
            modal.querySelector('div').classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 200);
        }

        function updateSlugPreview(name) {
            const clean = name.toLowerCase()
                .trim()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]/g, '-')
                .replace(/-+/g, '-');
            const preview = clean || 'tu-clinica';
            document.getElementById('slug-preview').innerText = `avipetapp.com/v/${preview}`;
        }

        // --- 2. SUBMIT ONBOARDING AJAX ---
        async function submitOnboarding(event) {
            event.preventDefault();
            const form = event.target;
            const errorAlert = document.getElementById('form-error-alert');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnSpinner = document.getElementById('btn-spinner');

            errorAlert.classList.add('hidden');
            submitBtn.disabled = true;
            btnText.innerText = 'Creando tu plataforma y afiche...';
            btnSpinner.classList.remove('hidden');

            const formData = new FormData(form);

            try {
                const response = await fetch('/registro-clinica', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    let errorMsg = data.message || 'Error al procesar el registro.';
                    if (data.errors) {
                        const firstError = Object.values(data.errors)[0];
                        if (Array.isArray(firstError)) errorMsg = firstError[0];
                    }
                    throw new Error(errorMsg);
                }

                // Éxito: redireccionar a la consola de la clínica
                btnText.innerText = '¡Listo! Entrando a tu panel...';
                window.location.href = data.redirect_url;

            } catch (err) {
                errorAlert.innerText = err.message;
                errorAlert.classList.remove('hidden');
                submitBtn.disabled = false;
                btnText.innerText = '🚀 Activar mi Clínica Gratis (15 Días)';
                btnSpinner.classList.add('hidden');
            }
        }

        // --- 3. CALCULADORA MRR & ROI ---
        let currentPlanPrice = 65000;
        const petsSlider = document.getElementById('pets-slider');
        const petsCountDisplay = document.getElementById('pets-count-display');
        const mrrMonthly = document.getElementById('mrr-monthly');
        const mrrAnnual = document.getElementById('mrr-annual');

        function formatCOP(num) {
            return '$' + num.toLocaleString('es-CO');
        }

        function calculateMRR() {
            const count = parseInt(petsSlider.value);
            petsCountDisplay.innerText = count;

            const monthly = count * currentPlanPrice;
            const annual = monthly * 12;

            mrrMonthly.innerText = formatCOP(monthly);
            mrrAnnual.innerText = formatCOP(annual);
        }

        petsSlider.addEventListener('input', calculateMRR);

        function setPlanPrice(price) {
            currentPlanPrice = price;
            document.querySelectorAll('.price-btn').forEach(btn => {
                const p = parseInt(btn.getAttribute('data-price'));
                if (p === price) {
                    btn.className = 'price-btn py-2 px-3 rounded-xl border border-emerald-500 bg-emerald-500/20 text-xs font-black text-emerald-300';
                } else {
                    btn.className = 'price-btn py-2 px-3 rounded-xl border border-slate-700 bg-slate-800/80 text-xs font-bold text-slate-300 hover:border-emerald-500';
                }
            });
            calculateMRR();
        }

        // Calcular inicial
        calculateMRR();
    </script>
</body>
</html>
