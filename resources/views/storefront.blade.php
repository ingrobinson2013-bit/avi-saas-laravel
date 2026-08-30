<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-900 text-slate-100 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patitas Felices — Planes de Salud y Bienestar Veterinario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .gradient-text { background: linear-gradient(135deg, #34d399 0%, #38bdf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between selection:bg-emerald-500 selection:text-slate-950">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 glass border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-6 h-6 text-slate-950 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-white">Patitas <span class="text-emerald-400">Felices</span></span>
                    <span class="hidden sm:inline-block ml-2 px-2 py-0.5 text-xs font-semibold bg-emerald-500/10 text-emerald-400 rounded-full border border-emerald-500/20">Planes de Salud Prepaga</span>
                </div>
            </div>
            
            <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-slate-300">
                <a href="#planes" class="hover:text-emerald-400 transition-colors">Nuestros Planes</a>
                <a href="#asistente-ia" class="hover:text-emerald-400 transition-colors">Asistente IA</a>
                <a href="#beneficios" class="hover:text-emerald-400 transition-colors">Línea de Atención</a>
            </nav>

            <div class="flex items-center space-x-3">
                <a href="/admin" class="px-4 py-2 text-sm font-semibold text-slate-200 hover:text-white bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 transition-all flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    <span>Panel Veterinaria</span>
                </a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <main class="flex-grow">
        <section class="relative pt-16 pb-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto space-y-6">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold tracking-wide uppercase">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Planes de Bienestar y Salud Integral para Mascotas</span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white leading-tight">
                        Cuidado veterinario completo para tu <span class="gradient-text">mejor amigo</span>
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-400 leading-relaxed">
                        Afíliate a nuestros planes mensuales con Kit de bienvenida, consultas presenciales y virtuales ilimitadas, vacunas anuales, desparasitaciones y descuentos especiales.
                    </p>

                    <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="#planes" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-bold text-base hover:from-emerald-400 hover:to-teal-400 shadow-lg shadow-emerald-500/25 transition-all flex items-center justify-center space-x-2">
                            <span>Ver Planes y Afiliarme</span>
                        </a>
                        <a href="https://wa.me/573508742543?text=Hola,%20deseo%20información%20sobre%20los%20Planes%20de%20Salud%20Patitas%20Felices" target="_blank" class="w-full sm:w-auto px-8 py-4 rounded-2xl glass hover:bg-slate-800 text-emerald-400 font-bold text-base border border-emerald-500/30 transition-all flex items-center justify-center space-x-2">
                            <span>WhatsApp: 350 874 2543</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ASISTENTE IA DE RECOMENDACIÓN -->
        <section id="asistente-ia" class="py-14 bg-slate-950/60 border-y border-slate-800/80">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-3 mb-8">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Calculadora Inteligente</span>
                    <h2 class="text-3xl font-extrabold text-white">¿Cuál plan se adapta mejor a tu peludito?</h2>
                    <p class="text-slate-400 text-sm max-w-xl mx-auto">Selecciona los datos de tu mascota para calcular la cobertura ideal.</p>
                </div>

                <div class="glass rounded-3xl p-6 sm:p-8 shadow-2xl">
                    <form id="ai-plan-form" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Especie</label>
                            <select id="species" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:border-emerald-500">
                                <option value="canino">🐶 Perro</option>
                                <option value="felino">🐱 Gato</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Tamaño / Raza</label>
                            <select id="size" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:border-emerald-500">
                                <option value="small">Pequeña / Mediana</option>
                                <option value="large">Grande / Gigante</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Edad (Años)</label>
                            <input type="number" id="age" value="2" min="0" max="25" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Modalidad de Pago</label>
                            <select id="payment_mode" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:border-emerald-500">
                                <option value="monthly">Mensual (con carencias)</option>
                                <option value="yearly">Anual (10% Dcto + Sin Carencias)</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2 lg:col-span-4 pt-2">
                            <button type="button" onclick="analyzePlan()" class="w-full py-4 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-base transition-all shadow-lg shadow-emerald-500/20">
                                ✨ Calcular Recomendación de Plan
                            </button>
                        </div>
                    </form>

                    <!-- RESULTADO IA -->
                    <div id="ai-result" class="hidden mt-6 p-6 rounded-2xl bg-emerald-950/40 border border-emerald-500/30 text-slate-200">
                        <div class="flex items-start space-x-4">
                            <div class="p-3 bg-emerald-500/20 rounded-xl text-emerald-400 font-bold text-2xl">🐾</div>
                            <div class="space-y-2">
                                <h3 class="text-lg font-bold text-emerald-400" id="result-title">Recomendación</h3>
                                <p class="text-sm text-slate-300" id="result-reason"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- PLANES OFICIALES PATITAS FELICES -->
        <section id="planes" class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-3 mb-14">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Nuestra Oferta</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Planes Oficiales Patitas Felices</h2>
                    <p class="text-slate-400 text-sm max-w-xl mx-auto">Selecciona el plan que mejor se adapte a tu mascota. Paga mensual o aprovecha 10% de descuento en el pago anual con activación inmediata.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    <!-- PLAN BASICO -->
                    <div class="glass rounded-3xl p-8 flex flex-col justify-between border border-slate-700 hover:border-emerald-500/50 transition-all">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Plan Esencial Preventivo</span>
                                <span class="px-2.5 py-0.5 text-xs font-bold bg-slate-800 text-slate-300 rounded-full">Afiliación $50.000</span>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Plan Patitas Básico</h3>
                            <div class="flex items-baseline space-x-2">
                                <span class="text-4xl font-extrabold text-white">$50.000</span>
                                <span class="text-slate-400 text-sm">/mes (a partir del 2do mes)</span>
                            </div>
                            <p class="text-xs text-emerald-400 font-semibold">O paga el año completo con 10% de descuento: $540.000 COP (Sin carencias)</p>
                            
                            <hr class="border-slate-800">
                            
                            <div class="space-y-3 text-sm text-slate-300">
                                <p class="text-xs font-bold text-slate-400 uppercase">⚡ Beneficios Inmediatos al Pagar:</p>
                                <ul class="space-y-2 pl-2">
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Kit Bienvenida: Cédula + Collar Placa + Carnet Digital</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>1ra Desparasitación + Control inicial</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Consultas Virtuales Gratuitas e Ilimitadas (L-D)</span></li>
                                </ul>

                                <p class="text-xs font-bold text-slate-400 uppercase pt-2">📅 Coberturas Durante el Año:</p>
                                <ul class="space-y-2 pl-2">
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>3 Consultas Veterinarias Presenciales</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Inyectología de estabilización en consulta</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>1 Vacunación Anual Completa (Pentavalente/Triple + Rabia)</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>1 Examen de Laboratorio 100% (CH, ALT, BUN, CREA)</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>2 Citologías de Oídos al año</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Desparasitación interna cada 4 meses (3 al año)</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Antipulgas externo cada 6 meses (2 al año)</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Baño y Peluquería (1 Grande o 2 Pequeñas/Medianas)</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Descuentos: 10% Hospitalización, 20% Profilaxis, 10% Medicamentos</span></li>
                                </ul>
                            </div>
                        </div>
                        <a href="https://wa.me/573508742543?text=Hola,%20deseo%20afiliarme%20al%20Plan%20Patitas%20Básico" target="_blank" class="mt-8 w-full py-4 text-center rounded-2xl glass hover:bg-slate-800 text-white font-bold text-sm border border-slate-700 transition-all block">
                            Afiliarme al Plan Básico
                        </a>
                    </div>

                    <!-- PLAN PREMIUM -->
                    <div class="relative glass rounded-3xl p-8 flex flex-col justify-between border-2 border-emerald-500 shadow-2xl shadow-emerald-500/10">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-extrabold text-xs tracking-wider uppercase shadow-md">
                            ⭐ Cobertura Total Plus
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Plan Integral Premium</span>
                                <span class="px-2.5 py-0.5 text-xs font-bold bg-emerald-500/20 text-emerald-400 rounded-full">1er Mes $150.000</span>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Plan Patitas Premium</h3>
                            <div class="flex items-baseline space-x-2">
                                <span class="text-4xl font-extrabold text-emerald-400">$80.000</span>
                                <span class="text-slate-400 text-sm">/mes (a partir del 2do mes)</span>
                            </div>
                            <p class="text-xs text-emerald-400 font-semibold">O paga el año completo con 10% de descuento: $902.400 COP (Sin carencias)</p>
                            
                            <hr class="border-slate-800">
                            
                            <div class="space-y-3 text-sm text-slate-300">
                                <p class="text-xs font-bold text-slate-400 uppercase">⚡ Beneficios Inmediatos al Pagar:</p>
                                <ul class="space-y-2 pl-2">
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Kit Bienvenida: Cédula + Collar Placa + Carnet Digital</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Control inicial para creación de historia clínica</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Consultas Virtuales Gratuitas e Ilimitadas (L-D)</span></li>
                                </ul>

                                <p class="text-xs font-bold text-slate-400 uppercase pt-2">📅 Coberturas Durante el Año:</p>
                                <ul class="space-y-2 pl-2">
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>3 Consultas Veterinarias Presenciales</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Chequeos de control y prevención cada 3 meses</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Inyectología de estabilización en consulta incluida</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>1 Vacunación Anual Completa (Pentavalente/Triple + Rabia)</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Desparasitación externa semestral (Credelio o Pipeta)</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>100% Exámenes de Laboratorio: Coprológico/Orina y Hemograma/Perfil Bioquímico</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>20% Descuento en Certificado Médico Nacional de Vuelo</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>Servicio Funerario Gratuito 100% Incluido (a partir de 8 meses)</span></li>
                                    <li class="flex items-center space-x-2"><span class="text-emerald-400">✓</span><span>10% Dcto en Hospitalización, Procedimientos e Imagenología</span></li>
                                </ul>
                            </div>
                        </div>
                        <a href="https://wa.me/573508742543?text=Hola,%20deseo%20afiliarme%20al%20Plan%20Patitas%20Premium" target="_blank" class="mt-8 w-full py-4 text-center rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-sm transition-all shadow-lg shadow-emerald-500/25 block">
                            Afiliarme al Plan Premium
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-slate-800 py-10 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-slate-500 text-xs gap-4">
            <p>© 2026 Clínica Veterinaria Patitas Felices — Línea Única de Atención: <span class="text-emerald-400 font-bold">350 874 2543</span></p>
            <div class="flex space-x-6">
                <a href="/admin" class="hover:text-emerald-400 transition-colors">Panel Operador</a>
                <a href="/admin/counter-redeem" class="hover:text-emerald-400 transition-colors">Mostrador de Recepción</a>
                <a href="/super-admin" class="hover:text-emerald-400 transition-colors">SaaS Admin</a>
            </div>
        </div>
    </footer>

    <script>
        function analyzePlan() {
            const species = document.getElementById('species').value;
            const size = document.getElementById('size').value;
            const age = parseInt(document.getElementById('age').value);
            const payment = document.getElementById('payment_mode').value;
            
            const resultBox = document.getElementById('ai-result');
            const resultTitle = document.getElementById('result-title');
            const resultReason = document.getElementById('result-reason');

            resultBox.classList.remove('hidden');

            if (age >= 5 || payment === 'yearly') {
                resultTitle.innerText = "⭐ Plan Recomendado: Plan Patitas Premium (" + (payment === 'yearly' ? 'Modalidad Anual' : 'Cuidado Avanzado') + ")";
                resultReason.innerText = "Para " + (species === 'canino' ? 'tu perro' : 'tu gato') + ", el Plan Premium ofrece exámenes de laboratorio al 100%, desparasitación externa con Credelio/pipeta, vacunación completa y servicio funerario incluido." + (payment === 'yearly' ? " Con el pago anual de $902.400 COP ahorras 10% y activas todos los beneficios de inmediato sin meses de carencia." : "");
            } else {
                resultTitle.innerText = "🐾 Plan Recomendado: Plan Patitas Básico";
                resultReason.innerText = "Excelente para mantenimiento preventivo joven. Incluye Kit de bienvenida, 3 consultas presenciales, vacunas anuales, desparasitación cada 4 meses y " + (size === 'large' ? '1 baño para razas grandes.' : '2 baños al año para razas pequeñas/medianas.') + (payment === 'yearly' ? " En pago anual te cuesta $540.000 COP sin periodos de espera." : " Afiliación inicial $50.000 y mensualidades de $50.000 COP.");
            }
        }
    </script>
</body>
</html>
