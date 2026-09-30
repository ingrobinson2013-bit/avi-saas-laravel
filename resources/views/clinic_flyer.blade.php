<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-900 text-slate-900 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afiche Oficial de Mostrador — {{ $tenant->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-primary: {{ $primaryColor }};
            --brand-secondary: {{ $secondaryColor }};
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        @media screen {
            .flyer-canvas {
                max-width: 820px;
                min-height: 1160px;
                margin: 24px auto;
                box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1);
            }
        }

        @media print {
            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .flyer-canvas {
                box-shadow: none !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                min-height: 100% !important;
                border: none !important;
                border-radius: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            @page {
                size: letter portrait;
                margin: 0.5cm;
            }
        }
    </style>
</head>
<body class="min-h-full py-4 sm:py-8 px-2 sm:px-4 flex flex-col items-center justify-start">

    <!-- BARRA FLOTANTE DE ACCIONES (NO SE IMPRIME) -->
    <aside class="no-print w-full max-w-[820px] mb-4 bg-slate-800/90 backdrop-blur-md p-3 sm:p-4 rounded-2xl border border-slate-700 flex flex-wrap items-center justify-between gap-3 text-white shadow-xl">
        <div class="flex items-center space-x-2">
            <span class="text-xl">🖨️</span>
            <div>
                <p class="font-extrabold text-sm leading-tight">Material POP para Mostrador / Sala de Espera</p>
                <p class="text-[11px] text-slate-300">Imprime en tamaño Carta o colócalo en un marco acrílico en recepción.</p>
            </div>
        </div>

        <div class="flex items-center space-x-2">
            <a href="/v/{{ $tenant->slug }}/admin" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-xl text-xs font-bold transition">
                ← Volver al Panel
            </a>
            <button type="button" onclick="window.print()" class="px-5 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs rounded-xl shadow-lg transition flex items-center space-x-1.5 transform hover:scale-105">
                <span>🖨️ Mandar a Imprimir / Guardar PDF</span>
            </button>
        </div>
    </aside>

    <!-- AFICHE TAMAÑO CARTA DE ALTA DEFINICIÓN -->
    <main class="flyer-canvas w-full bg-white rounded-3xl p-8 sm:p-10 flex flex-col justify-between border border-slate-200 relative overflow-hidden">
        
        <!-- DECORACIÓN SUPERIOR DE MARCA -->
        <div class="absolute top-0 left-0 right-0 h-3 bg-gradient-to-r" style="background: linear-gradient(90deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);"></div>

        <!-- 1. ENCABEZADO DE LA CLÍNICA -->
        <header class="flex items-center justify-between border-b-2 border-slate-100 pb-5">
            <div class="flex items-center space-x-4 min-w-0">
                @if(!empty($logoUrl))
                    <div class="h-16 w-auto max-w-[180px] flex items-center justify-center">
                        <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="h-full w-auto object-contain">
                    </div>
                @else
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-3xl font-black text-white shadow-md" style="background-color: {{ $primaryColor }};">
                        🐾
                    </div>
                @endif
                <div>
                    <h1 class="text-xl font-black text-slate-900 tracking-tight leading-tight uppercase">{{ $tenant->name }}</h1>
                    <p class="text-xs text-slate-700 font-bold">📍 {{ $address }} • {{ $city }}</p>
                    <p class="text-xs font-extrabold" style="color: {{ $primaryColor }};">Línea de Atención: {{ $phone }}</p>
                </div>
            </div>

            <div class="text-right shrink-0">
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 text-slate-900 font-black text-[11px] rounded-full uppercase tracking-wider border border-amber-300 shadow-sm" style="background-color: #fef3c7;">
                    <span>⭐</span>
                    <span>Salud Prepagada 2026</span>
                </span>
                <p class="text-[10px] text-slate-700 mt-1 font-bold">Membresía Digital Oficial</p>
            </div>
        </header>

        <!-- 2. TITULAR MAGNÉTICO DE CONVERSIÓN -->
        <section class="text-center py-4 space-y-2">
            <span class="text-xs font-black uppercase tracking-widest text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full">
                ¡Protege a tu mascota y ahorra hasta un 40%!
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                Afílialo a nuestro <span style="color: {{ $primaryColor }};">Plan de Salud & Carnet Digital</span>
            </h2>
            <p class="text-xs sm:text-sm text-slate-700 max-w-xl mx-auto font-medium">
                Dile adiós a las cuentas imprevistas. Con nuestras membresías tienes consultas, vacunas, desparasitaciones y descuentos cubiertos todo el año.
            </p>
        </section>

        <!-- 3. CUADRO COMPARATIVO DE LOS DOS PLANES -->
        <section class="grid grid-cols-2 gap-4 py-2">
            
            <!-- PLAN BÁSICO -->
            <div class="rounded-2xl p-4 sm:p-5 border-2 border-slate-200 bg-slate-50/70 flex flex-col justify-between space-y-3">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black uppercase tracking-wider text-slate-700">Prevención Total</span>
                        <span class="text-base">🛡️</span>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 leading-tight">Plan Patitas Básico</h3>
                    
                    <div class="bg-white p-2.5 rounded-xl border border-slate-200">
                        <div class="flex items-baseline space-x-1">
                            <span class="text-2xl font-black text-slate-900">$50.000</span>
                            <span class="text-[10px] font-bold text-slate-700">COP / mes</span>
                        </div>
                        <p class="text-[9px] text-slate-700 leading-tight mt-0.5">
                            Mes 1: <strong>$100.000</strong> (incluye inscripción única). A partir del 2do mes: <strong>$50.000</strong>.
                        </p>
                    </div>

                    <div class="space-y-1.5 text-[11px] text-slate-800 font-medium pt-1">
                        <p class="flex items-start space-x-1.5"><strong class="text-emerald-700">✓</strong> <span><strong>3 Consultas Presenciales</strong> al año</span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-emerald-700">✓</strong> <span><strong>Vacunación Anual Completa</strong> (1 dosis)</span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-emerald-700">✓</strong> <span><strong>Inyectología de Estabilización</strong> ($20k)</span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-emerald-700">✓</strong> <span><strong>1 Examen Básico Laboratorio</strong> 100%</span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-emerald-700">✓</strong> <span><strong>3 Desparasitaciones Internas</strong> al año</span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-emerald-700">✓</strong> <span><strong>2 Antipulgas / Pipetas</strong> al año</span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-emerald-700">✓</strong> <span><strong>Baño y Peluquería</strong> incluidos</span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-emerald-700">✓</strong> <span><strong>Consultas Virtuales Ilimitadas</strong></span></p>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-200 text-[10px] text-slate-700">
                    🏷️ <strong>20% Dcto:</strong> Profilaxis Dental • <strong>10% Dcto:</strong> Medicamentos
                </div>
            </div>

            <!-- PLAN PREMIUM -->
            <div class="rounded-2xl p-4 sm:p-5 border-2 border-purple-500 bg-purple-50/40 flex flex-col justify-between space-y-3 relative shadow-xs">
                <span class="absolute -top-2.5 right-4 bg-purple-700 text-white text-[9px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    RECOMENDADO ★
                </span>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black uppercase tracking-wider text-purple-900">Máxima Cobertura</span>
                        <span class="text-base">💎</span>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 leading-tight">Plan Patitas Premium</h3>
                    
                    <div class="bg-white p-2.5 rounded-xl border border-purple-200">
                        <div class="flex items-baseline space-x-1">
                            <span class="text-2xl font-black text-purple-900">$80.000</span>
                            <span class="text-[10px] font-bold text-slate-700">COP / mes</span>
                        </div>
                        <p class="text-[9px] text-slate-700 leading-tight mt-0.5">
                            Mes 1: <strong>$150.000</strong> (incluye inscripción única). A partir del 2do mes: <strong>$80.000</strong>.
                        </p>
                    </div>

                    <div class="space-y-1.5 text-[11px] text-slate-800 font-medium pt-1">
                        <p class="flex items-start space-x-1.5"><strong class="text-purple-700">✓</strong> <span><strong>3 Consultas Presenciales</strong> al año</span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-purple-700">✓</strong> <span><strong>Vacunación Anual Completa</strong></span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-purple-700">✓</strong> <span><strong>Laboratorio Completo 100%:</strong> Hemograma, ALT, BUN, Creatinina, Coprológico</span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-purple-700">✓</strong> <span><strong>Desparasitación Externa:</strong> Credelio/Pipeta</span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-purple-700">✓</strong> <span><strong>Chequeos Preventivos Trimestrales</strong></span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-purple-700">✓</strong> <span><strong>Kit de Bienvenida:</strong> Cédula + Collar Placa</span></p>
                        <p class="flex items-start space-x-1.5"><strong class="text-purple-700">★</strong> <span class="text-purple-950 font-bold"><strong>Servicio Funerario 100% Gratuito</strong></span></p>
                    </div>
                </div>

                <div class="pt-2 border-t border-purple-200 text-[10px] text-slate-700">
                    🏷️ <strong>20% Dcto:</strong> Certificado de Vuelo • <strong>10% Dcto:</strong> Hospitalización
                </div>
            </div>

        </section>

        <!-- 4. BLOQUE CENTRAL DE ESCANEO DE QR (CALL TO ACTION GIGANTE) -->
        <section class="my-2 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-2xl p-5 text-white flex items-center justify-between gap-6 shadow-xl">
            <div class="space-y-2 flex-1">
                <span class="inline-flex items-center space-x-1 text-[10px] font-black uppercase tracking-wider text-teal-300 bg-teal-900/60 px-2.5 py-0.5 rounded-full border border-teal-500/30">
                    <span>⚡</span>
                    <span>Afiliación Digital en 2 Minutos</span>
                </span>
                <h3 class="text-xl sm:text-2xl font-black text-white leading-tight">
                    Escanea aquí con la cámara de tu celular
                </h3>
                <p class="text-xs text-slate-300 leading-relaxed font-normal">
                    1. Abre tu cámara y apunta al código QR.<br>
                    2. Elige tu plan y registra los datos de tu peludo.<br>
                    3. ¡Listo! Recibes su <strong>Carnet Digital Oficial</strong> en tu WhatsApp al instante.
                </p>
                <div class="pt-1">
                    <p class="text-[11px] font-mono text-teal-300 font-bold truncate">🌐 {{ $enrollmentUrl }}</p>
                </div>
            </div>

            <!-- CÓDIGO QR GIGANTE DE ALTA DEFINICIÓN -->
            <div class="shrink-0 flex flex-col items-center bg-white p-2.5 rounded-2xl shadow-2xl border-2 border-white">
                <img src="{{ $qrCodeUrl }}" alt="Código QR para afiliarse" class="w-36 h-36 sm:w-40 sm:h-40 object-contain">
                <span class="text-[9px] font-black uppercase tracking-wider text-slate-900 mt-1">¡ESCANÉAME! 🐾</span>
            </div>
        </section>

        <!-- 5. PIE DE PÁGINA DEL AFICHE -->
        <footer class="pt-3 border-t-2 border-slate-100 flex items-center justify-between text-xs text-slate-700">
            <div>
                <p class="font-extrabold text-slate-900">{{ $tenant->name }}</p>
                <p class="text-[10px]">{{ $address }}, {{ $city }}.</p>
            </div>
            <div class="text-right">
                <p class="font-black text-emerald-800 text-sm">WhatsApp: {{ $phone }}</p>
                <p class="text-[9px] text-slate-700 font-mono">Powered by AVI SaaS Platform</p>
            </div>
        </footer>

    </main>

</body>
</html>
