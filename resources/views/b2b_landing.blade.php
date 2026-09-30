<!DOCTYPE html>
<html lang="es" class="h-full bg-[#090a0c] text-zinc-100 antialiased selection:bg-emerald-500 selection:text-zinc-950 overflow-x-hidden scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AVI-Plan — Plataforma de Planes de Bienestar y Salud para Veterinarias</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .glass { background: rgba(18, 20, 24, 0.78); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.07); }
        .glass-card { background: rgba(22, 25, 30, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.07); }
        /* Gradiente Esmeralda Clínico Puro (Sin tonos azulados ni púrpuras) */
        .gradient-text { 
            background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #6ee7b7 100%); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent; 
        }
        .glow-emerald { box-shadow: 0 0 60px -15px rgba(16, 185, 129, 0.25); }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between overflow-x-hidden bg-[#090a0c] text-zinc-100">

    <!-- 1. HEADER / NAVBAR -->
    <header class="sticky top-0 z-50 glass border-b border-zinc-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 via-emerald-500 to-teal-400 flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-zinc-950 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-black tracking-tight text-white">AVI<span class="text-emerald-400">Plan</span></span>
                    <span class="hidden md:inline-block ml-2 px-2.5 py-0.5 text-[10px] font-extrabold uppercase bg-emerald-500/10 text-emerald-400 rounded-full border border-emerald-500/20">
                        Planes de Bienestar para Veterinarias
                    </span>
                </div>
            </a>
            
            <nav class="hidden lg:flex items-center space-x-7 text-xs sm:text-sm font-semibold text-zinc-300">
                <a href="#como-funciona" class="hover:text-emerald-400 transition-colors">Cómo Funciona</a>
                <a href="#recibes" class="hover:text-emerald-400 transition-colors">Lo que Recibes</a>
                <a href="#experiencia-cliente" class="hover:text-emerald-400 transition-colors">Portal del Cliente</a>
                <a href="#calculadora" class="hover:text-emerald-400 transition-colors">Calculadora</a>
                <a href="#precios" class="hover:text-emerald-400 transition-colors">Precios</a>
                <a href="#faq" class="hover:text-emerald-400 transition-colors">Preguntas</a>
            </nav>

            <div class="flex items-center space-x-3">
                <a href="/admin" class="hidden sm:inline-flex px-3 py-2 text-xs font-bold text-zinc-400 hover:text-white transition-colors">
                    Iniciar Sesión
                </a>
                <button type="button" onclick="openRegisterModal('pro')" class="px-4 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-black text-zinc-950 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-300 hover:to-teal-300 rounded-xl shadow-lg shadow-emerald-500/20 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                    15 Días Gratis 🚀
                </button>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- 2. HERO PRINCIPAL -->
        <section class="relative pt-12 sm:pt-20 pb-16 sm:pb-24 overflow-hidden">
            <!-- Halo esmeralda médico tenue -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[500px] bg-gradient-to-tr from-emerald-500/10 via-emerald-600/5 to-transparent blur-3xl -z-10 rounded-full pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-4xl mx-auto space-y-6">
                    
                    <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/25 text-emerald-400 text-xs font-bold tracking-wide">
                        <span>15 días gratis · Sin tarjeta de crédito</span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white leading-[1.1]">
                        Convierte clientes ocasionales en <span class="gradient-text">clientes recurrentes.</span>
                    </h1>

                    <p class="text-base sm:text-xl text-zinc-300 leading-relaxed max-w-3xl mx-auto font-normal">
                        Crea y vende tus propios planes de bienestar para mascotas, recibe pagos recurrentes y administra afiliados, beneficios y renovaciones desde una plataforma con tu propia marca.
                    </p>

                    <!-- FRASE DE POSICIONAMIENTO WHITE-LABEL -->
                    <div class="pt-1">
                        <p class="text-xs sm:text-sm font-mono font-bold text-emerald-400/90 tracking-wider uppercase">
                            Tu marca. Tus planes. Tus precios. Tus clientes.
                        </p>
                    </div>

                    <!-- CTAs PRINCIPALES -->
                    <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button type="button" onclick="openRegisterModal('pro')" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-emerald-400 text-zinc-950 font-black text-base hover:from-emerald-400 hover:to-emerald-300 shadow-xl shadow-emerald-500/25 transition-all transform hover:-translate-y-1 flex items-center justify-center space-x-2">
                            <span>🚀 Crear mi Clínica Gratis</span>
                        </button>
                        <a href="/v/vet-pet-patitas" target="_blank" class="w-full sm:w-auto px-7 py-4 rounded-2xl glass hover:bg-zinc-800/80 text-zinc-200 font-bold text-sm sm:text-base border border-zinc-700/80 hover:border-emerald-500/50 transition-all flex items-center justify-center space-x-2">
                            <span>👀 Ver Clínica Piloto en Vivo</span>
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- 3. CÓMO FUNCIONA AVI-PLAN (FLUJO VISUAL DE 6 PASOS) -->
        <section id="como-funciona" class="py-16 bg-[#0c0d10] border-y border-zinc-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-400">Flujo Operativo Simple</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Así funciona AVI-Plan</h2>
                    <p class="text-xs sm:text-sm text-zinc-400">Un circuito cerrado diseñado para la velocidad en clínica y recepción.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                    <!-- PASO 01 -->
                    <div class="glass-card p-5 rounded-2xl space-y-2 border border-zinc-800/80 flex flex-col justify-between">
                        <div>
                            <span class="text-2xl font-black font-mono text-emerald-400">01</span>
                            <h3 class="text-sm font-bold text-white mt-1">Crea tus planes</h3>
                        </div>
                        <p class="text-[11px] text-zinc-400 leading-snug">
                            Define tus beneficios: consultas, vacunas, desparasitaciones y fija tu tarifa mensual.
                        </p>
                    </div>

                    <!-- PASO 02 -->
                    <div class="glass-card p-5 rounded-2xl space-y-2 border border-zinc-800/80 flex flex-col justify-between">
                        <div>
                            <span class="text-2xl font-black font-mono text-emerald-300">02</span>
                            <h3 class="text-sm font-bold text-white mt-1">Escaneo en QR</h3>
                        </div>
                        <p class="text-[11px] text-zinc-400 leading-snug">
                            El cliente escanea el afiche oficial en la sala de espera o entra a tu enlace web.
                        </p>
                    </div>

                    <!-- PASO 03 -->
                    <div class="glass-card p-5 rounded-2xl space-y-2 border border-zinc-800/80 flex flex-col justify-between">
                        <div>
                            <span class="text-2xl font-black font-mono text-teal-300">03</span>
                            <h3 class="text-sm font-bold text-white mt-1">Afiliación digital</h3>
                        </div>
                        <p class="text-[11px] text-zinc-400 leading-snug">
                            Registra los datos de su mascota y adquiere su membresía en 2 minutos sin papeles.
                        </p>
                    </div>

                    <!-- PASO 04 -->
                    <div class="glass-card p-5 rounded-2xl space-y-2 border border-zinc-800/80 flex flex-col justify-between">
                        <div>
                            <span class="text-2xl font-black font-mono text-amber-400">04</span>
                            <h3 class="text-sm font-bold text-white mt-1">Carnet digital</h3>
                        </div>
                        <p class="text-[11px] text-zinc-400 leading-snug">
                            Recibe al instante su carnet con código de barras en su celular y WhatsApp.
                        </p>
                    </div>

                    <!-- PASO 05 -->
                    <div class="glass-card p-5 rounded-2xl space-y-2 border border-zinc-800/80 flex flex-col justify-between">
                        <div>
                            <span class="text-2xl font-black font-mono text-emerald-400">05</span>
                            <h3 class="text-sm font-bold text-white mt-1">Canje en caja</h3>
                        </div>
                        <p class="text-[11px] text-zinc-400 leading-snug">
                            La recepcionista digita la cédula o escanea el QR y descuenta cupos en 3 segundos.
                        </p>
                    </div>

                    <!-- PASO 06 -->
                    <div class="glass-card p-5 rounded-2xl space-y-2 border border-zinc-800/80 flex flex-col justify-between">
                        <div>
                            <span class="text-2xl font-black font-mono text-amber-300">06</span>
                            <h3 class="text-sm font-bold text-white mt-1">Renovaciones</h3>
                        </div>
                        <p class="text-[11px] text-zinc-400 leading-snug">
                            El sistema gestiona vencimientos y te ayuda a reactivar planes automáticamente.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. LO QUE TU VETERINARIA RECIBE (LOS 5 ACTIVOS CON IA) -->
        <section id="recibes" class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-2">
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-400">Todo Incluido</span>
                    <h2 class="text-3xl sm:text-5xl font-black text-white">Lo que tu veterinaria recibe en 60 segundos</h2>
                    <p class="text-sm sm:text-base text-zinc-400">Herramientas completas para operar desde el primer día.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- 1. PORTAL WEB -->
                    <div class="glass p-6 rounded-3xl border border-zinc-800/80 hover:border-emerald-500/50 transition-all space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-2xl font-bold">
                            🌐
                        </div>
                        <h3 class="text-lg font-bold text-white">Portal Web Marca Blanca</h3>
                        <p class="text-xs text-zinc-400 leading-relaxed">
                            Tu propia página web personalizada con tu logo, fotos y colores (ej: <code class="text-emerald-400 font-mono">avipetapp.com/v/tu-clinica</code>). Tus clientes consultan planes y se afilian online.
                        </p>
                    </div>

                    <!-- 2. AFICHE QR -->
                    <div class="glass p-6 rounded-3xl border border-zinc-800/80 hover:border-amber-500/50 transition-all space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-2xl font-bold">
                            🖨️
                        </div>
                        <h3 class="text-lg font-bold text-white">Afiche de Mostrador con QR</h3>
                        <p class="text-xs text-zinc-400 leading-relaxed">
                            Generado en tamaño Carta listo para imprimir en 1 clic. Colócalo en recepción para que los clientes en sala de espera se afilien con su celular sin recargar a tu equipo.
                        </p>
                    </div>

                    <!-- 3. CARNET DIGITAL -->
                    <div class="glass p-6 rounded-3xl border border-zinc-800/80 hover:border-emerald-500/50 transition-all space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-300 flex items-center justify-center text-2xl font-bold">
                            🪪
                        </div>
                        <h3 class="text-lg font-bold text-white">Carnet Digital Oficial</h3>
                        <p class="text-xs text-zinc-400 leading-relaxed">
                            Cada mascota recibe un carnet interactivo con código de barras en el celular del tutor. Muestra datos del peludo, vigencia y saldos de beneficios disponibles.
                        </p>
                    </div>

                    <!-- 4. MOSTRADOR DE CANJE -->
                    <div class="glass p-6 rounded-3xl border border-zinc-800/80 hover:border-teal-500/50 transition-all space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-teal-500/10 text-teal-300 flex items-center justify-center text-2xl font-bold">
                            ⚡
                        </div>
                        <h3 class="text-lg font-bold text-white">Mostrador de Canje en Vivo</h3>
                        <p class="text-xs text-zinc-400 leading-relaxed">
                            Búsqueda instantánea por cédula, teléfono o lector QR. Tu recepcionista visualiza de inmediato qué servicios tiene derecho la mascota y descuenta cupos con auditoría.
                        </p>
                    </div>

                    <!-- 5. ASISTENTE DE IA (AVI INTELLIGENCE) -->
                    <div class="glass p-6 rounded-3xl border-2 border-emerald-500/40 bg-emerald-950/15 lg:col-span-2 space-y-3 relative overflow-hidden">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-2xl font-bold">
                                🤖
                            </div>
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-400">Inteligencia Operativa</span>
                                <h3 class="text-lg font-bold text-white">Asistente de IA (AVI Intelligence)</h3>
                            </div>
                        </div>
                        <p class="text-xs text-zinc-300 leading-relaxed">
                            Identifica vencimientos, consulta afiliados y te ayuda a crear acciones de retención automática para tu clínica:
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 pt-1 font-mono text-[11px]">
                            <div class="bg-zinc-900/90 p-2.5 rounded-xl border border-zinc-800 text-zinc-300">
                                🔔 "12 planes vencen en los próximos 7 días."
                            </div>
                            <div class="bg-zinc-900/90 p-2.5 rounded-xl border border-zinc-800 text-zinc-300">
                                🩺 "8 clientes no han usado sus beneficios."
                            </div>
                            <div class="bg-zinc-900/90 p-2.5 rounded-xl border border-zinc-800 text-zinc-300">
                                💉 "5 mascotas tienen vacunas pendientes."
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. EXPERIENCIA DEL CLIENTE (MOCKUP VISUAL DEL CARNET Y PORTAL) -->
        <section id="experiencia-cliente" class="py-20 bg-[#0c0d10] border-y border-zinc-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    
                    <div class="space-y-6">
                        <span class="text-xs font-black uppercase tracking-wider text-emerald-400">El Lado del Paciente</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white leading-tight">
                            Tu cliente también tiene su propio portal
                        </h2>
                        <p class="text-sm sm:text-base text-zinc-300 leading-relaxed">
                            Una experiencia móvil de primer nivel para el tutor de la mascota. Accede a su carnet digital, consulta los beneficios incluidos y conoce con exactitud qué servicios preventivos ya utilizó y cuáles tiene disponibles.
                        </p>

                        <ul class="space-y-3 text-xs sm:text-sm text-zinc-300">
                            <li class="flex items-center space-x-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Cero carnets de papel arrugados o perdidos.</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Transparencia total en saldos y fechas de renovación.</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Mayor sentido de pertenencia y fidelidad con tu clínica.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- MOCKUP VISUAL INTERACTIVO -->
                    <div class="flex justify-center">
                        <div class="w-full max-w-sm bg-[#111317] rounded-3xl p-6 border-2 border-emerald-500/40 shadow-2xl space-y-5">
                            
                            <!-- CABECERA CARNET -->
                            <div class="flex items-center justify-between border-b border-zinc-800 pb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-300 flex items-center justify-center text-2xl font-bold">
                                        🐶
                                    </div>
                                    <div>
                                        <h4 class="text-base font-black text-white">Luna</h4>
                                        <p class="text-[11px] text-zinc-400">Golden Retriever • 2 años</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-black uppercase border border-emerald-500/30">
                                    Activo ✓
                                </span>
                            </div>

                            <!-- DETALLES DEL PLAN -->
                            <div class="space-y-3 text-xs">
                                <div class="flex justify-between items-center bg-zinc-900/80 p-3 rounded-xl border border-zinc-800">
                                    <span class="text-zinc-400 font-medium">Membresía:</span>
                                    <span class="font-bold text-white">Plan Premium Patitas</span>
                                </div>

                                <div class="bg-zinc-900/80 p-3 rounded-xl border border-zinc-800 space-y-1.5">
                                    <div class="flex justify-between text-[11px]">
                                        <span class="text-zinc-400">Próximo beneficio:</span>
                                        <span class="font-bold text-emerald-400">🩺 Consulta preventiva</span>
                                    </div>
                                    <div class="flex justify-between text-[11px]">
                                        <span class="text-zinc-400">Beneficios utilizados:</span>
                                        <span class="font-bold text-white font-mono">2 / 5 cupos</span>
                                    </div>
                                    <div class="flex justify-between text-[11px]">
                                        <span class="text-zinc-400">Próximo vencimiento:</span>
                                        <span class="font-bold text-amber-400">15 Oct 2026</span>
                                    </div>
                                </div>
                            </div>

                            <a href="/v/vet-pet-patitas/carnet/VP-2026-0001" target="_blank" class="block w-full py-2.5 text-center rounded-xl bg-zinc-800 hover:bg-zinc-700 text-emerald-400 font-bold text-xs border border-zinc-700 transition">
                                Ver Carnet Digital en Vivo →
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 6. EVOLUCIÓN: DE REACTIVA A RECURRENTE -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14 space-y-2">
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-400">Modelo de Atención</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">De una veterinaria reactiva a un modelo recurrente</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- SIN PLANES -->
                    <div class="glass-card p-6 sm:p-8 rounded-3xl border border-rose-500/20 bg-rose-950/10 space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center font-bold text-xl">✕</div>
                            <div>
                                <h3 class="text-lg font-bold text-white">Sin planes de salud</h3>
                                <p class="text-xs text-rose-400/80 font-medium">Ingresos dependientes de cada visita puntual</p>
                            </div>
                        </div>
                        <ul class="space-y-3 text-xs sm:text-sm text-zinc-300">
                            <li class="flex items-start space-x-2">
                                <span class="text-rose-400 font-bold">✕</span>
                                <span>El cliente paga únicamente cuando necesita un servicio de urgencia o enfermedad.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-rose-400 font-bold">✕</span>
                                <span>Las visitas preventivas se pierden o se posponen indefinidamente.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-rose-400 font-bold">✕</span>
                                <span>El seguimiento clínico depende de llamadas manuales del equipo.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-rose-400 font-bold">✕</span>
                                <span>La relación con el cliente se corta al terminar la consulta.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CON AVI-PLAN -->
                    <div class="glass-card p-6 sm:p-8 rounded-3xl border-2 border-emerald-500/40 bg-emerald-950/20 space-y-4 shadow-xl shadow-emerald-500/5">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center font-bold text-xl">✓</div>
                            <div>
                                <h3 class="text-lg font-bold text-white">Con AVI-Plan</h3>
                                <p class="text-xs text-emerald-400 font-semibold">Un programa para mantener la relación todo el año</p>
                            </div>
                        </div>
                        <ul class="space-y-3 text-xs sm:text-sm text-zinc-200">
                            <li class="flex items-start space-x-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>El cliente adquiere una membresía con cobertura programada.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Los beneficios prepagados incentivan chequeos y vacunas preventivas.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>La clínica puede comunicar renovaciones y vencimientos oportunamente.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Creas nuevas oportunidades de venta cruzada en cada visita.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. CALCULADORA MRR ESTIMADA (DATOS CREÍBLES) -->
        <section id="calculadora" class="py-20 bg-[#0c0d10] border-y border-zinc-800/80">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-400">Simulador</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">¿Cuánto podría generar tu programa?</h2>
                    <p class="text-xs sm:text-sm text-zinc-400">Ajusta los parámetros para estimar tus ingresos mensuales recurrentes.</p>
                </div>

                <div class="glass p-8 sm:p-10 rounded-3xl border border-zinc-700/80 shadow-2xl space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        
                        <!-- CONTROLES -->
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="text-xs font-bold text-zinc-300 uppercase">Mascotas activas en planes:</label>
                                    <span id="pets-count-display" class="text-2xl font-black text-emerald-400 font-mono">50</span>
                                </div>
                                <input type="range" id="pets-slider" min="10" max="300" step="5" value="50" class="w-full h-2.5 bg-zinc-800 rounded-lg appearance-none cursor-pointer accent-emerald-400">
                                <div class="flex justify-between text-[10px] text-zinc-500 font-bold mt-1">
                                    <span>10 mascotas</span>
                                    <span>150 mascotas</span>
                                    <span>300 mascotas</span>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-zinc-300 uppercase block mb-2">Precio promedio mensual del plan:</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <button type="button" onclick="setPlanPrice(49000)" class="price-btn py-2 px-3 rounded-xl border border-zinc-700 bg-zinc-800/80 text-xs font-bold text-zinc-300 hover:border-emerald-500" data-price="49000">$49.000</button>
                                    <button type="button" onclick="setPlanPrice(65000)" class="price-btn py-2 px-3 rounded-xl border border-emerald-500 bg-emerald-500/20 text-xs font-black text-emerald-300" data-price="65000">$65.000 ⭐</button>
                                    <button type="button" onclick="setPlanPrice(89000)" class="price-btn py-2 px-3 rounded-xl border border-zinc-700 bg-zinc-800/80 text-xs font-bold text-zinc-300 hover:border-emerald-500" data-price="89000">$89.000</button>
                                </div>
                            </div>
                        </div>

                        <!-- RESULTADOS ESTIMADOS -->
                        <div class="bg-gradient-to-br from-[#111317] to-[#090a0c] p-6 rounded-2xl border-2 border-emerald-500/40 space-y-4 text-center">
                            <div class="space-y-1">
                                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-400">Ingreso recurrente mensual estimado</span>
                                <div id="mrr-monthly" class="text-4xl sm:text-5xl font-black text-white font-mono">$3.250.000</div>
                                <span class="text-[11px] text-zinc-400 block pt-1">
                                    Ejemplo calculado según el número de mascotas y precio mensual seleccionados.
                                </span>
                            </div>

                            <hr class="border-zinc-800">

                            <div class="grid grid-cols-2 gap-3 text-left">
                                <div class="bg-zinc-900/90 p-3 rounded-xl border border-zinc-800">
                                    <span class="text-[9px] uppercase font-bold text-zinc-400 block">Facturación Anual</span>
                                    <span id="mrr-annual" class="text-base font-black text-emerald-400 font-mono">$39.000.000</span>
                                </div>
                                <div class="bg-zinc-900/90 p-3 rounded-xl border border-zinc-800">
                                    <span class="text-[9px] uppercase font-bold text-zinc-400 block">Costo AVI-Plan</span>
                                    <span class="text-base font-black text-zinc-300 font-mono">$99.000<span class="text-[10px] font-normal text-zinc-400">/mes</span></span>
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="button" onclick="openRegisterModal('pro')" class="w-full py-3 bg-gradient-to-r from-emerald-500 to-emerald-400 hover:from-emerald-400 hover:to-emerald-300 text-zinc-950 font-black text-xs rounded-xl shadow-lg shadow-emerald-500/20 transition transform hover:scale-[1.02]">
                                    Comenzar mi Programa →
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- 8. PRECIOS TRANSPARENTES -->
        <section id="precios" class="py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-400">Planes Transparentes</span>
                    <h2 class="text-3xl sm:text-5xl font-black text-white">Prueba gratuita de 15 días</h2>
                    <p class="text-sm sm:text-base text-zinc-400">Sin tarjeta de crédito requerida. Explora la plataforma a tu ritmo.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                    
                    <!-- STARTER -->
                    <div class="glass p-8 rounded-3xl flex flex-col justify-between border border-zinc-800/80 hover:border-zinc-700 transition">
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Consultorios</span>
                            <h3 class="text-2xl font-black text-white">Starter</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-4xl sm:text-5xl font-extrabold text-white font-mono">$99.000</span>
                                <span class="text-zinc-400 text-sm">COP / mes</span>
                            </div>
                            <p class="text-xs text-zinc-400 leading-relaxed">
                                Hasta 60 mascotas activas*.
                            </p>
                            <hr class="border-zinc-800">
                            <ul class="space-y-2.5 text-xs text-zinc-300">
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Portal web propio con tu marca</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Afiche de mostrador con QR</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>1 Usuario para recepción</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Mostrador de canje en vivo</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Soporte por WhatsApp</span></li>
                            </ul>
                        </div>
                        <button type="button" onclick="openRegisterModal('starter')" class="mt-8 w-full py-3.5 text-center rounded-xl glass hover:bg-zinc-800 text-white font-bold text-sm border border-zinc-700 hover:border-zinc-500 transition">
                            Elegir Starter
                        </button>
                    </div>

                    <!-- PROFESIONAL (POPULAR) -->
                    <div class="glass p-8 rounded-3xl flex flex-col justify-between border-2 border-emerald-500 shadow-2xl shadow-emerald-500/15 relative transform lg:-translate-y-2">
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-emerald-500 text-zinc-950 font-black text-[11px] uppercase tracking-wider shadow-md">
                            ⭐ MÁS ELEGIDO
                        </div>
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Clínicas en Crecimiento</span>
                            <h3 class="text-2xl font-black text-white">Profesional</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-4xl sm:text-5xl font-extrabold text-emerald-400 font-mono">$229.000</span>
                                <span class="text-zinc-400 text-sm">COP / mes</span>
                            </div>
                            <p class="text-xs text-zinc-300 leading-relaxed">
                                Hasta 250 mascotas activas* + Usuarios ilimitados + AVI Intelligence.
                            </p>
                            <hr class="border-zinc-800">
                            <ul class="space-y-2.5 text-xs text-zinc-200">
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span><strong>Todo lo del plan Starter</strong></span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span><strong>Usuarios ilimitados</strong> para tu equipo</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span><strong>AVI Intelligence:</strong> Detección automática de retención y vencimientos</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Reportes de facturación recurrente</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Soporte prioritario</span></li>
                            </ul>
                        </div>
                        <button type="button" onclick="openRegisterModal('pro')" class="mt-8 w-full py-4 text-center rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-400 hover:from-emerald-400 hover:to-emerald-300 text-zinc-950 font-black text-sm shadow-xl shadow-emerald-500/25 transition transform hover:scale-[1.02]">
                            Comenzar Prueba Gratuita →
                        </button>
                    </div>

                    <!-- ENTERPRISE -->
                    <div class="glass p-8 rounded-3xl flex flex-col justify-between border border-zinc-800/80 hover:border-zinc-700 transition">
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Hospitales y Redes</span>
                            <h3 class="text-2xl font-black text-white">Enterprise</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-4xl sm:text-5xl font-extrabold text-white font-mono">$489.000</span>
                                <span class="text-zinc-400 text-sm">COP / mes</span>
                            </div>
                            <p class="text-xs text-zinc-400 leading-relaxed">Mascotas ilimitadas + Multi-sucursal + Dominio Propio.</p>
                            <hr class="border-zinc-800">
                            <ul class="space-y-2.5 text-xs text-zinc-300">
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span><strong>Mascotas y afiliados ilimitados</strong></span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Múltiples sedes y sucursales conectadas</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Dominio propio personalizado (<code class="text-emerald-400">tuclinica.com</code>)</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Integración WhatsApp</span></li>
                                <li class="flex items-center space-x-2"><span class="text-emerald-400 font-bold">✓</span> <span>Acompañamiento en puesta en marcha</span></li>
                            </ul>
                        </div>
                        <a href="https://wa.me/573508742543?text=Hola%20Robinson,%20me%20interesa%20el%20plan%20Enterprise%20de%20AVI-Plan" target="_blank" class="mt-8 w-full py-3.5 text-center rounded-xl glass hover:bg-zinc-800 text-white font-bold text-sm border border-zinc-700 hover:border-zinc-500 transition">
                            Contactar Asesor
                        </a>
                    </div>
                </div>

                <div class="mt-8 text-center text-xs text-zinc-500">
                    * <strong>Mascota activa:</strong> Mascota que cuenta con un plan o membresía vigente en el mes. Si superas el límite de tu plan, puedes subir de nivel en cualquier momento sin perder datos ni interrumpir a tus afiliados.
                </div>
            </div>
        </section>

        <!-- 9. PREGUNTAS FRECUENTES (FAQ AMPLIADA) -->
        <section id="faq" class="py-16 bg-[#0c0d10] border-t border-zinc-800/80">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <div class="text-center space-y-2">
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-400">Dudas Frecuentes</span>
                    <h2 class="text-3xl font-extrabold text-white">Preguntas Frecuentes</h2>
                </div>

                <div class="space-y-4">
                    <details class="glass p-5 rounded-2xl border border-zinc-800/80 group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-white flex justify-between items-center list-none">
                            <span>¿Tengo que reemplazar mi software actual de historia clínica?</span>
                            <span class="text-emerald-400 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-zinc-400 mt-3 leading-relaxed">
                            <strong>No.</strong> AVI-Plan no busca competir con tu software de historia médica o inventarios (SoftVet, Gesvet, etc.). AVI-Plan es una <strong>plataforma especializada en planes de bienestar, membresías y facturación recurrente</strong>. Convive perfectamente con cualquier sistema que uses hoy.
                        </p>
                    </details>

                    <details class="glass p-5 rounded-2xl border border-zinc-800/80 group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-white flex justify-between items-center list-none">
                            <span>¿AVI-Plan cobra comisión por cada plan vendido?</span>
                            <span class="text-emerald-400 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-zinc-400 mt-3 leading-relaxed">
                            <strong>No.</strong> El 100% del dinero cobrado a tus clientes va directo a tus cuentas o medios de pago. No retenemos tu dinero ni cobramos porcentajes por transacción. Solo pagas la suscripción fija mensual de la plataforma.
                        </p>
                    </details>

                    <details class="glass p-5 rounded-2xl border border-zinc-800/80 group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-white flex justify-between items-center list-none">
                            <span>¿Puedo crear mis propios beneficios y precios?</span>
                            <span class="text-emerald-400 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-zinc-400 mt-3 leading-relaxed">
                            <strong>Sí, con total libertad.</strong> Puedes definir el nombre de tus planes, qué servicios incluye cada uno (número de consultas, vacunas, desparasitaciones, baños o profilaxis) y el precio que desees cobrar.
                        </p>
                    </details>

                    <details class="glass p-5 rounded-2xl border border-zinc-800/80 group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-white flex justify-between items-center list-none">
                            <span>¿Cómo pagan las suscripciones los clientes?</span>
                            <span class="text-emerald-400 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-zinc-400 mt-3 leading-relaxed">
                            Puedes configurar tus cuentas habituales: Nequi, Daviplata, transferencia Bancolombia, o enlazar botones de pago digitales como Bold o Wompi.
                        </p>
                    </details>

                    <details class="glass p-5 rounded-2xl border border-zinc-800/80 group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-white flex justify-between items-center list-none">
                            <span>¿Puedo utilizar mi propio dominio?</span>
                            <span class="text-emerald-400 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-zinc-400 mt-3 leading-relaxed">
                            Por defecto tienes un subdominio seguro (ej: <code class="text-emerald-400 font-mono">avipetapp.com/v/tu-clinica</code>). En el plan Enterprise, puedes conectar directamente tu propio dominio o subdominio corporativo (ej: <code class="text-emerald-400 font-mono">salud.tuclinica.com</code>).
                        </p>
                    </details>

                    <details class="glass p-5 rounded-2xl border border-zinc-800/80 group cursor-pointer">
                        <summary class="font-bold text-sm sm:text-base text-white flex justify-between items-center list-none">
                            <span>¿Qué ocurre cuando terminan los 15 días gratis?</span>
                            <span class="text-emerald-400 font-bold text-lg group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-zinc-400 mt-3 leading-relaxed">
                            No solicitamos tarjeta de crédito para iniciar. Antes de finalizar el periodo te consultaremos si deseas continuar con el plan Starter o Profesional. Si decides no continuar, tu cuenta se pausa sin ningún cargo ni penalidad.
                        </p>
                    </details>
                </div>
            </div>
        </section>

        <!-- 10. CTA FINAL -->
        <section class="py-20 relative overflow-hidden">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="glass p-8 sm:p-14 rounded-3xl border-2 border-emerald-500/30 text-center space-y-6 relative overflow-hidden glow-emerald">
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                        Crea el programa de salud de tu veterinaria hoy mismo
                    </h2>
                    <p class="text-sm sm:text-lg text-zinc-300 max-w-2xl mx-auto font-normal">
                        Tu marca. Tus planes. Tus precios. Tus clientes.
                    </p>
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button type="button" onclick="openRegisterModal('pro')" class="w-full sm:w-auto px-9 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-emerald-400 text-zinc-950 font-black text-base hover:from-emerald-400 hover:to-emerald-300 shadow-xl shadow-emerald-500/25 transition transform hover:-translate-y-0.5">
                            Comenzar prueba gratuita →
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER B2B -->
    <footer class="border-t border-zinc-800/80 py-10 bg-[#090a0c] text-zinc-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <span class="font-extrabold text-white">AVI<span class="text-emerald-400">Plan</span></span>
                <span>— Plataforma de Planes de Bienestar para Veterinarias.</span>
            </div>
            <div class="flex space-x-6 font-semibold">
                <a href="/admin" class="hover:text-emerald-400 transition-colors">Acceso Mostrador</a>
                <a href="/v/vet-pet-patitas" class="hover:text-emerald-400 transition-colors">Clínica Piloto</a>
                <a href="https://wa.me/573508742543" target="_blank" class="hover:text-emerald-400 transition-colors">Contacto WhatsApp</a>
            </div>
        </div>
    </footer>

    <!-- MODAL DE REGISTRO EXPRESS B2B EN 60 SEGUNDOS -->
    <div id="register-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-md p-4 hidden transition-opacity opacity-0 pointer-events-none">
        <div class="relative w-full max-w-lg bg-[#111317] border border-zinc-700/80 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 text-zinc-100 transform scale-95 transition-transform">
            
            <button type="button" onclick="closeRegisterModal()" class="absolute top-4 right-4 text-zinc-400 hover:text-white p-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="space-y-1">
                <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black uppercase">
                    <span>Prueba Gratuita de 15 Días</span>
                </div>
                <h3 class="text-2xl font-black text-white">Crea tu Clínica Veterinaria</h3>
                <p class="text-xs text-zinc-400">Empieza a configurar tus planes y tu afiche en 60 segundos.</p>
            </div>

            <!-- FORMULARIO AJAX -->
            <form id="clinic-onboarding-form" onsubmit="submitOnboarding(event)" class="space-y-4">
                @csrf
                <input type="hidden" name="saas_plan_tier" id="form-tier" value="pro">

                <div>
                    <label class="block text-xs font-bold text-zinc-300 uppercase mb-1">Nombre de tu Veterinaria <span class="text-emerald-400">*</span></label>
                    <input type="text" name="clinic_name" id="clinic-name-input" required placeholder="Ej. Veterinaria San Roque" oninput="updateSlugPreview(this.value)" class="w-full bg-zinc-900 border border-zinc-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-400 transition placeholder:text-zinc-600">
                    <p class="text-[10px] text-zinc-400 mt-1 font-mono">
                        Tu web será: <span id="slug-preview" class="text-emerald-400 font-bold">avipetapp.com/v/tu-clinica</span>
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-zinc-300 uppercase mb-1">Ciudad <span class="text-emerald-400">*</span></label>
                        <input type="text" name="city" required placeholder="Ej. Bogotá / Medellín" class="w-full bg-zinc-900 border border-zinc-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-400 transition placeholder:text-zinc-600">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-zinc-300 uppercase mb-1">WhatsApp de Contacto <span class="text-emerald-400">*</span></label>
                        <input type="tel" name="phone" required placeholder="Ej. 3101234567" class="w-full bg-zinc-900 border border-zinc-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-400 transition placeholder:text-zinc-600">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-300 uppercase mb-1">Correo Electrónico (Tu usuario) <span class="text-emerald-400">*</span></label>
                    <input type="email" name="email" required placeholder="doctor@tuclinica.com" class="w-full bg-zinc-900 border border-zinc-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-400 transition placeholder:text-zinc-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-300 uppercase mb-1">Contraseña <span class="text-emerald-400">*</span></label>
                    <input type="password" name="password" required minlength="6" placeholder="Mínimo 6 caracteres" class="w-full bg-zinc-900 border border-zinc-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-400 transition placeholder:text-zinc-600">
                </div>

                <div id="form-error-alert" class="hidden p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs font-medium"></div>

                <button type="submit" id="submit-btn" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-400 hover:from-emerald-400 hover:to-emerald-300 text-zinc-950 font-black text-sm shadow-xl shadow-emerald-500/20 transition transform active:scale-95 flex items-center justify-center space-x-2">
                    <span id="btn-text">🚀 Activar mi Clínica Gratis</span>
                    <span id="btn-spinner" class="hidden animate-spin rounded-full h-4 w-4 border-2 border-zinc-950 border-t-transparent"></span>
                </button>

                <p class="text-[10px] text-center text-zinc-500">
                    Sin tarjeta de crédito requerida. Acceso inmediato.
                </p>
            </form>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
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

                btnText.innerText = '¡Listo! Entrando a tu panel...';
                window.location.href = data.redirect_url;

            } catch (err) {
                errorAlert.innerText = err.message;
                errorAlert.classList.remove('hidden');
                submitBtn.disabled = false;
                btnText.innerText = '🚀 Activar mi Clínica Gratis';
                btnSpinner.classList.add('hidden');
            }
        }

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
                    btn.className = 'price-btn py-2 px-3 rounded-xl border border-zinc-700 bg-zinc-800/80 text-xs font-bold text-zinc-300 hover:border-emerald-500';
                }
            });
            calculateMRR();
        }

        calculateMRR();
    </script>
</body>
</html>
