<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-900 text-slate-100 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVI-Plan — Planes de Salud y Bienestar para Mascotas</title>
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
                    <span class="text-xl font-extrabold tracking-tight text-white">AVI<span class="text-emerald-400">Plan</span></span>
                    <span class="hidden sm:inline-block ml-2 px-2 py-0.5 text-xs font-semibold bg-emerald-500/10 text-emerald-400 rounded-full border border-emerald-500/20">SaaS Multi-tenant</span>
                </div>
            </div>
            
            <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-slate-300">
                <a href="#planes" class="hover:text-emerald-400 transition-colors">Planes</a>
                <a href="#asistente-ia" class="hover:text-emerald-400 transition-colors">Asistente IA</a>
                <a href="#beneficios" class="hover:text-emerald-400 transition-colors">Beneficios</a>
                <a href="#mostrador" class="hover:text-emerald-400 transition-colors">Recepción en Mostrador</a>
            </nav>

            <div class="flex items-center space-x-4">
                <a href="/admin" class="px-4 py-2 text-sm font-semibold text-slate-200 hover:text-white bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 transition-all flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    <span>Panel Recepción</span>
                </a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <main class="flex-grow">
        <section class="relative pt-16 pb-24 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto space-y-6">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold tracking-wide uppercase">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Planes de Bienestar y Salud Prepaga</span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white leading-tight">
                        Cuidado veterinario sin sorpresas para tu <span class="gradient-text">mejor amigo</span>
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-400 leading-relaxed">
                        Suscripciones de salud con consultas ilimitadas, vacunas, desparasitación y validación instantánea por código en mostrador.
                    </p>

                    <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="#asistente-ia" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-bold text-base hover:from-emerald-400 hover:to-teal-400 shadow-lg shadow-emerald-500/25 transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span>Recomendar Plan con IA</span>
                        </a>
                        <a href="/admin/counter-redeem" class="w-full sm:w-auto px-8 py-4 rounded-2xl glass hover:bg-slate-800 text-slate-200 font-bold text-base border border-slate-700 transition-all flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Validar en Mostrador (Recepción)</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ASISTENTE IA DE RECOMENDACIÓN -->
        <section id="asistente-ia" class="py-16 bg-slate-950/60 border-y border-slate-800/80">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-3 mb-10">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Motor Inteligente FastAPI</span>
                    <h2 class="text-3xl font-extrabold text-white">Asistente IA de Recomendación de Salud</h2>
                    <p class="text-slate-400 text-sm max-w-xl mx-auto">Ingresa el perfil de tu mascota y nuestro microservicio de IA determinará el plan con mayor ahorro y cobertura ideal.</p>
                </div>

                <div class="glass rounded-3xl p-6 sm:p-10 shadow-2xl">
                    <form id="ai-plan-form" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Especie</label>
                            <select id="species" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:border-emerald-500">
                                <option value="canino">🐶 Perro (Canino)</option>
                                <option value="felino">🐱 Gato (Felino)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Edad (Años)</label>
                            <input type="number" id="age" value="3" min="0" max="25" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Peso (kg)</label>
                            <input type="number" id="weight" value="12.5" step="0.5" min="1" max="90" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Estilo de Vida</label>
                            <select id="lifestyle" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:border-emerald-500">
                                <option value="outdoor">Parque / Muy Activo</option>
                                <option value="indoor">Hogar / Departamento</option>
                                <option value="senior">Senior / Reposo</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2 lg:col-span-4 pt-2">
                            <button type="button" onclick="analyzePlan()" class="w-full py-4 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-base transition-all shadow-lg shadow-emerald-500/20 flex items-center justify-center space-x-2">
                                <span id="btn-text">⚡ Analizar Mascota y Recomendar Plan</span>
                                <span id="btn-loading" class="hidden">Analizando con IA en FastAPI...</span>
                            </button>
                        </div>
                    </form>

                    <!-- RESULTADO IA -->
                    <div id="ai-result" class="hidden mt-8 p-6 rounded-2xl bg-emerald-950/40 border border-emerald-500/30 text-slate-200">
                        <div class="flex items-start space-x-4">
                            <div class="p-3 bg-emerald-500/20 rounded-xl text-emerald-400 font-bold text-2xl">🏆</div>
                            <div class="space-y-2">
                                <h3 class="text-lg font-bold text-emerald-400" id="result-title">Plan Recomendado: Pro Bienestar Canino</h3>
                                <p class="text-sm text-slate-300" id="result-reason">Tu mascota se beneficiará de cobertura completa de vacunas anuales, desparasitación trimestral y consultas preventivas continuas.</p>
                                <div class="pt-2 flex items-center space-x-4 text-xs font-semibold text-emerald-300">
                                    <span>✓ Ahorro Estimado Anual: 35%</span>
                                    <span>✓ Prioridad en Citas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- PLANES GRID -->
        <section id="planes" class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-3 mb-14">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Planes de Suscripción</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Coberturas diseñadas para cada etapa</h2>
                    <p class="text-slate-400 text-sm max-w-xl mx-auto">Sin copagos ocultos ni letras pequeñas. Paga mensualmente y redime en clínica al instante.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- PLAN ESENCIAL -->
                    <div class="glass rounded-3xl p-8 flex flex-col justify-between hover:border-slate-600 transition-all">
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Básico Preventivo</span>
                            <h3 class="text-2xl font-bold text-white">Plan Esencial</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-4xl font-extrabold text-white">$49.000</span>
                                <span class="text-slate-400 text-sm">/mes</span>
                            </div>
                            <p class="text-sm text-slate-400">Ideal para mascotas jóvenes que requieren control preventivo básico.</p>
                            
                            <hr class="border-slate-800">
                            
                            <ul class="space-y-3 text-sm text-slate-300">
                                <li class="flex items-center space-x-3"><span class="text-emerald-400">✓</span><span>1 Consulta médica mensual gratis</span></li>
                                <li class="flex items-center space-x-3"><span class="text-emerald-400">✓</span><span>Vacunación anual completa</span></li>
                                <li class="flex items-center space-x-3"><span class="text-emerald-400">✓</span><span>Desparasitación trimestral</span></li>
                                <li class="flex items-center space-x-3"><span class="text-slate-500">✕</span><span class="text-slate-500">Profilaxis dental</span></li>
                            </ul>
                        </div>
                        <a href="/admin" class="mt-8 w-full py-3 text-center rounded-xl glass hover:bg-slate-800 text-white font-bold text-sm border border-slate-700 transition-all">
                            Suscribir en Clínica
                        </a>
                    </div>

                    <!-- PLAN PRO BIENESTAR (DESTACADO) -->
                    <div class="relative glass rounded-3xl p-8 flex flex-col justify-between border-2 border-emerald-500 shadow-2xl shadow-emerald-500/10">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-extrabold text-xs tracking-wider uppercase shadow-md">
                            ⭐ Más Popular
                        </div>
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Cuidado Total</span>
                            <h3 class="text-2xl font-bold text-white">Plan Pro Bienestar</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-4xl font-extrabold text-emerald-400">$89.000</span>
                                <span class="text-slate-400 text-sm">/mes</span>
                            </div>
                            <p class="text-sm text-slate-400">Protección completa contra emergencias, higiene y control preventivo.</p>
                            
                            <hr class="border-slate-800">
                            
                            <ul class="space-y-3 text-sm text-slate-300">
                                <li class="flex items-center space-x-3"><span class="text-emerald-400">✓</span><span>Consultas generales ilimitadas</span></li>
                                <li class="flex items-center space-x-3"><span class="text-emerald-400">✓</span><span>Vacunas + Refuerzos + Desparasitación</span></li>
                                <li class="flex items-center space-x-3"><span class="text-emerald-400">✓</span><span>1 Limpieza dental ultrasónica anual</span></li>
                                <li class="flex items-center space-x-3"><span class="text-emerald-400">✓</span><span>15% descuento en cirugías</span></li>
                            </ul>
                        </div>
                        <a href="/admin" class="mt-8 w-full py-3 text-center rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-sm transition-all shadow-lg shadow-emerald-500/25">
                            Suscribir en Clínica
                        </a>
                    </div>

                    <!-- PLAN SENIOR GOLD -->
                    <div class="glass rounded-3xl p-8 flex flex-col justify-between hover:border-slate-600 transition-all">
                        <div class="space-y-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Integral Avanzado</span>
                            <h3 class="text-2xl font-bold text-white">Plan Gold Senior</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-4xl font-extrabold text-white">$149.000</span>
                                <span class="text-slate-400 text-sm">/mes</span>
                            </div>
                            <p class="text-sm text-slate-400">Para mascotas adultas o senior con requerimientos diagnósticos.</p>
                            
                            <hr class="border-slate-800">
                            
                            <ul class="space-y-3 text-sm text-slate-300">
                                <li class="flex items-center space-x-3"><span class="text-emerald-400">✓</span><span>Consultas y urgencias 24/7 gratis</span></li>
                                <li class="flex items-center space-x-3"><span class="text-emerald-400">✓</span><span>Perfil bioquímico y hemograma anual</span></li>
                                <li class="flex items-center space-x-3"><span class="text-emerald-400">✓</span><span>Ecografía abdominal preventiva</span></li>
                                <li class="flex items-center space-x-3"><span class="text-emerald-400">✓</span><span>25% descuento en hospitalización</span></li>
                            </ul>
                        </div>
                        <a href="/admin" class="mt-8 w-full py-3 text-center rounded-xl glass hover:bg-slate-800 text-white font-bold text-sm border border-slate-700 transition-all">
                            Suscribir en Clínica
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-slate-800 py-10 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-slate-500 text-xs gap-4">
            <p>© 2026 NODIA SaaS Platform. Impulsando la salud y bienestar veterinario en Colombia.</p>
            <div class="flex space-x-6">
                <a href="/admin" class="hover:text-emerald-400 transition-colors">Acceso Operador</a>
                <a href="/admin/counter-redeem" class="hover:text-emerald-400 transition-colors">Mostrador</a>
                <a href="/api/health" class="hover:text-emerald-400 transition-colors">API Health</a>
            </div>
        </div>
    </footer>

    <script>
        function analyzePlan() {
            const species = document.getElementById('species').value;
            const age = parseInt(document.getElementById('age').value);
            const weight = parseFloat(document.getElementById('weight').value);
            const lifestyle = document.getElementById('lifestyle').value;
            
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');
            const resultBox = document.getElementById('ai-result');
            const resultTitle = document.getElementById('result-title');
            const resultReason = document.getElementById('result-reason');

            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');

            setTimeout(() => {
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
                resultBox.classList.remove('hidden');

                if (age >= 7) {
                    resultTitle.innerText = "Plan Recomendado: Gold Senior (" + (species === 'canino' ? 'Perro' : 'Gato') + " Adulto Mayor)";
                    resultReason.innerText = "Debido a su edad (" + age + " años), es fundamental contar con exámenes de laboratorio preventivos (hemograma y perfil bioquímico) y consultas geriátricas ilimitadas.";
                } else if (age <= 1) {
                    resultTitle.innerText = "Plan Recomendado: Plan Cachorro / Gatito Primer Año";
                    resultReason.innerText = "En su etapa de crecimiento, el esquema de vacunación múltiple y desparasitación mensual es la máxima prioridad para garantizar su desarrollo saludable.";
                } else {
                    resultTitle.innerText = "Plan Recomendado: Pro Bienestar " + (lifestyle === 'outdoor' ? 'Activo' : 'Hogar');
                    resultReason.innerText = "Ideal para su peso (" + weight + " kg) y nivel de actividad. Incluye consultas médicas continuas, profilaxis dental ultrasónica y cobertura preventiva anual.";
                }
            }, 600);
        }
    </script>
</body>
</html>
