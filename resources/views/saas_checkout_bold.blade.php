<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50 text-slate-900 antialiased selection:bg-blue-600 selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activar Suscripción AviPetApp — {{ $tenant->name }}</title>
    <link rel="icon" type="image/svg+xml" href="/brand/favicons/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/brand/favicons/favicon-32.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bold Official Checkout SDK -->
    <script type="text/javascript" src="https://checkout.bold.co/library/boldPaymentButton.js"></script>

    <style>
        body { font-family: 'Inter', Arial, sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .hero-bg {
            background: radial-gradient(circle at 50% -20%, rgba(109, 40, 217, 0.06) 0%, rgba(244, 247, 252, 0.95) 70%);
        }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between bg-[#F4F7FC] text-[#15213B] hero-bg">

    <!-- 1. TOP NAVBAR CLARA Y MODERNA (Logo Horizontal Oficial AviPetApp) -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200 sticky top-0 z-30 shadow-xs">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3">
                <img src="/brand/svg/avipetapp-horizontal-fondo-claro.svg" alt="AviPetApp" class="h-8 w-auto min-w-[140px] object-contain">
                <span class="text-[10px] font-bold uppercase bg-[#6D28D9]/10 text-[#6D28D9] px-2.5 py-0.5 rounded-md border border-[#6D28D9]/20">
                    Checkout Seguro
                </span>
            </a>

            <div class="flex items-center space-x-3 text-xs font-semibold">
                <div class="hidden sm:flex items-center space-x-1.5 text-[#0F9F9A] bg-[#0F9F9A]/10 border border-[#0F9F9A]/25 px-3 py-1 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-[#0F9F9A] animate-ping"></span>
                    <span>Cifrado SSL 256 bits · Bold.co</span>
                </div>
                <a href="/admin/{{ $tenant->slug }}" class="text-[#5C6B85] hover:text-[#15213B] font-bold hover:underline transition">
                    ← Volver a la Clínica
                </a>
            </div>
        </div>
    </header>

    <!-- 2. CONTENIDO PRINCIPAL: 2 COLUMNAS CLARAS (ESTILO STRIPE / FINTECH MODERNO) -->
    <main class="flex-grow py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- COLUMNA IZQUIERDA: RESUMEN DE LA CLÍNICA Y BENEFICIOS INCLUIDOS -->
            <div class="lg:col-span-6 space-y-6">
                
                <div class="space-y-2">
                    <div class="inline-flex items-center space-x-2 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full text-blue-800 text-xs font-bold uppercase tracking-wider shadow-xs">
                        <span>🏥 Suscripción SaaS para Clínicas</span>
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                        Activa tu plataforma oficial de salud y bienestar
                    </h1>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Clínica: <strong class="text-slate-900">{{ $tenant->name }}</strong>
                    </p>
                </div>

                <!-- SELECTOR INTERACTIVO DE PLANES SAAS -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-blue-700">Cambiar o Seleccionar Plan</span>
                            <h2 class="text-lg font-black text-slate-900 mt-0.5">Elige el plan que necesita tu clínica:</h2>
                        </div>
                        <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
                            Sin permanencia
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        @foreach($plans as $planKey => $p)
                            @php $isSelected = ($tier === $planKey); @endphp
                            <a 
                                href="/admin/{{ $tenant->slug }}/renovar-saas?tier={{ $planKey }}"
                                class="relative p-4 rounded-2xl border-2 transition-all flex flex-col justify-between text-left {{ $isSelected ? 'border-blue-600 bg-blue-50/60 shadow-xs ring-2 ring-blue-500/20' : 'border-slate-200 bg-slate-50/50 hover:border-slate-300 hover:bg-white' }}"
                            >
                                @if($isSelected)
                                    <div class="absolute top-3 right-3 w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-black shadow-xs">
                                        ✓
                                    </div>
                                @endif

                                <div>
                                    <div class="flex items-center space-x-1.5">
                                        <span class="text-sm font-black text-slate-900">{{ $p['name'] }}</span>
                                        <span class="text-[9px] font-extrabold px-2 py-0.5 rounded-full {{ $planKey === 'pro' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-slate-200/80 text-slate-700' }}">
                                            {{ $p['badge'] }}
                                        </span>
                                    </div>
                                    <div class="text-xs font-black text-blue-700 mt-1.5 font-mono">
                                        {{ $p['price_label'] }}
                                    </div>
                                    <div class="text-[11px] font-semibold text-slate-600 mt-0.5">
                                        {{ $p['limit'] }}
                                    </div>
                                    <div class="text-[10.5px] text-slate-500 mt-1 leading-snug">
                                        {{ $p['desc'] }}
                                    </div>
                                </div>

                                <div class="mt-3 pt-2.5 border-t border-slate-200/70 text-[10.5px] font-bold {{ $isSelected ? 'text-blue-700 flex items-center space-x-1' : 'text-slate-400 group-hover:text-slate-600' }}">
                                    @if($isSelected)
                                        <span>● Seleccionado para pagar</span>
                                    @else
                                        <span>Cambiar a este plan →</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- RESUMEN DEL PLAN SELECCIONADO -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Plan Seleccionado</span>
                            <h3 class="text-lg sm:text-xl font-black text-slate-900 mt-0.5">
                                @if($tier === 'starter') Plan Starter (Hasta 60 mascotas)
                                @elseif($tier === 'enterprise') Plan Enterprise (Ilimitado + Sedes)
                                @elseif($tier === 'pay_per_pet') Modalidad por Mascota Activa
                                @else Plan Profesional (Hasta 250 mascotas)
                                @endif
                            </h3>
                        </div>
                        <span class="px-3 py-1 bg-blue-50 text-blue-800 border border-blue-200 text-xs font-black rounded-full uppercase">
                            SaaS 30 Días
                        </span>
                    </div>

                    <hr class="border-slate-100">

                    <p class="text-xs font-bold text-slate-900 uppercase tracking-wider">Tu suscripción incluye todo el ecosistema:</p>

                    <div class="space-y-3 text-xs text-slate-700 font-medium">
                        <div class="flex items-start space-x-2.5">
                            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                            <span><strong>Página Web Oficial de Afiliación:</strong> Portal B2C con tu propia marca para que tus tutores se afilien digitalmente sin filas.</span>
                        </div>
                        <div class="flex items-start space-x-2.5">
                            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                            <span><strong>Terminal de Canje Rápido en Mostrador:</strong> POS médico interactivo con lector de código QR para redimir consultas y vacunas en 3 segundos.</span>
                        </div>
                        <div class="flex items-start space-x-2.5">
                            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                            <span><strong>Carnet Digital Interactivo:</strong> Los tutores consultan su saldo de beneficios en vivo desde su celular sin descargar aplicaciones.</span>
                        </div>
                        <div class="flex items-start space-x-2.5">
                            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                            <span><strong>Afiche Oficial para Sala de Espera:</strong> Diseño listo para imprimir con código QR para captura masiva de pacientes.</span>
                        </div>
                        <div class="flex items-start space-x-2.5">
                            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                            <span><strong>Soporte Prioritario & Acompañamiento:</strong> Asesoría directa por WhatsApp con el equipo de AviPetApp y NODIA.</span>
                        </div>
                    </div>
                </div>

                <!-- BADGES DE TRANQUILIDAD -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs font-semibold text-slate-600">
                    <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-xs flex items-center space-x-2">
                        <span class="text-base">🛡️</span>
                        <span>Sin cláusula de permanencia</span>
                    </div>
                    <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-xs flex items-center space-x-2">
                        <span class="text-base">⚡</span>
                        <span>Activación inmediata al pagar</span>
                    </div>
                </div>

            </div>

            <!-- COLUMNA DERECHA: CAJA DE PAGO CON BOLD CHECKOUT -->
            <div class="lg:col-span-6 space-y-6">
                
                <div class="bg-white rounded-3xl border-2 border-blue-500/80 p-6 sm:p-8 shadow-xl space-y-6 relative overflow-hidden">
                    
                    <div class="border-b border-slate-100 pb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Resumen de Liquidación</span>
                        <div class="flex items-baseline justify-between mt-1">
                            <div class="text-3xl sm:text-4xl font-black text-slate-900 font-mono">
                                ${{ number_format($amount, 0, ',', '.') }}
                            </div>
                            <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-200">
                                COP / Mes
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            Facturación recurrente mensual · Cero comisiones por transacción.
                        </p>
                    </div>

                    <!-- MEDIOS DE PAGO HABILITADOS EN BOLD -->
                    <div class="space-y-3">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">
                            Medios de pago disponibles con Bold:
                        </span>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-center text-[11px] font-bold text-slate-700">
                            <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200 shadow-2xs flex flex-col items-center justify-center space-y-0.5">
                                <span class="text-base">🏦</span>
                                <span>PSE</span>
                            </div>
                            <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200 shadow-2xs flex flex-col items-center justify-center space-y-0.5">
                                <span class="text-base">📱</span>
                                <span>Nequi</span>
                            </div>
                            <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200 shadow-2xs flex flex-col items-center justify-center space-y-0.5">
                                <span class="text-base">🟢</span>
                                <span>Bancolombia</span>
                            </div>
                            <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200 shadow-2xs flex flex-col items-center justify-center space-y-0.5">
                                <span class="text-base">💳</span>
                                <span>Tarjetas</span>
                            </div>
                        </div>
                    </div>

                    <!-- MEDIOS DE PAGO Y BOTÓN DE ACCIÓN -->
                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        @if($hasValidBoldKey)
                            <p class="text-xs font-semibold text-slate-600 text-center">
                                Haz clic en el botón a continuación para abrir la pasarela segura:
                            </p>

                            <!-- CONTENEDOR DEL BOTÓN OFICIAL BOLD SDK -->
                            <div class="flex justify-center items-center py-2">
                                <script 
                                    src="https://checkout.bold.co/library/boldPaymentButton.js"
                                    data-bold-button="DARK"
                                    data-api-key="{{ $identityKey }}"
                                    data-order-id="{{ $orderId }}"
                                    data-amount="{{ (int) round($amount) }}"
                                    data-currency="COP"
                                    data-integrity-signature="{{ $integritySignature }}"
                                    data-description="Mensualidad SaaS AviPetApp - {{ $tenant->name }}"
                                    data-redirection-url="{{ $redirectUrl }}"
                                    data-webhook-url="{{ $webhookUrl }}"
                                    data-payer-email="{{ $payerEmail }}"
                                    data-payer-name="{{ $payerName }}"
                                    data-payer-phone="{{ $payerPhone }}"
                                ></script>
                            </div>
                        @elseif($boldDirectLink)
                            <!-- LINK DE COBRO DIRECTO BOLD (SMART LINK) -->
                            <div class="space-y-3 text-center">
                                <a 
                                    href="{{ $boldDirectLink }}" 
                                    target="_blank" 
                                    class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-red-600 via-rose-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-extrabold text-sm sm:text-base shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2.5"
                                >
                                    <span>💳 Pagar ${{ number_format($amount, 0, ',', '.') }} con Bold</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                                <p class="text-[11px] text-slate-500">
                                    Acepta Tarjetas de Crédito, Débito, PSE, Nequi y Daviplata.
                                </p>
                            </div>
                        @else
                            <!-- PAGO DIRECTO / TRANSFERENCIA INMEDIATA + WHATSAPP -->
                            <div class="space-y-4 text-left">
                                <div class="p-4 rounded-2xl bg-blue-50/70 border border-blue-200/80 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-blue-900 uppercase">Transferencia Inmediata</span>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-200/80 text-blue-900">0% Comisión</span>
                                    </div>
                                    <div class="space-y-1.5 text-xs text-slate-700">
                                        <div class="flex justify-between items-center py-1 border-b border-blue-200/50">
                                            <span class="text-slate-500 font-medium">Bancolombia Ahorros:</span>
                                            <strong class="font-mono text-slate-900 select-all">123-456789-01</strong>
                                        </div>
                                        <div class="flex justify-between items-center py-1 border-b border-blue-200/50">
                                            <span class="text-slate-500 font-medium">Nequi / Daviplata:</span>
                                            <strong class="font-mono text-slate-900 select-all">323 581 3942</strong>
                                        </div>
                                        <div class="flex justify-between items-center pt-1">
                                            <span class="text-slate-500 font-medium">Titular:</span>
                                            <span class="font-bold text-slate-900">AviPetApp SaaS Colombia</span>
                                        </div>
                                    </div>
                                </div>

                                <a 
                                    href="https://wa.me/573235813942?text={{ urlencode('Hola Robinson, adjunto comprobante de pago de la suscripción SaaS AviPetApp (' . $tenant->name . ') por valor de $' . number_format($amount, 0, ',', '.') . ' COP. ID de orden: ' . $orderId) }}"
                                    target="_blank"
                                    class="w-full py-4 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs sm:text-sm shadow-lg shadow-emerald-600/25 transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2 text-center"
                                >
                                    <span>📲 Enviar Comprobante por WhatsApp</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>

                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-[10.5px] text-slate-500 space-y-1">
                                    <p class="font-bold text-slate-700">⚙️ ¿Tienes tu propio Link o Llaves de Bold?</p>
                                    <p>Pega tu <strong>Link de Pago Bold</strong> en Ajustes de la clínica o configura tus llaves API en el archivo <code class="bg-white px-1 rounded border">.env</code> para habilitar el botón automático sin error BTN-000.</p>
                                </div>
                            </div>
                        @endif

                        <!-- TRUST & SEGURIDAD -->
                        <div class="pt-2 flex flex-wrap items-center justify-center gap-3 text-[11px] text-slate-500 font-medium">
                            <div class="flex items-center space-x-1">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Transacción Cifrada</span>
                            </div>
                            <span>•</span>
                            <span>Procesado por <strong>Bold Colombia</strong></span>
                            <span>•</span>
                            <span>Activación 24/7</span>
                        </div>
                    </div>

                </div>

                <!-- SOPORTE WHATSAPP DIRECTO SI TIENE DUDAS -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200 text-xs text-slate-600 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span>💬</span>
                        <span>¿Tienes alguna duda con tu facturación?</span>
                    </div>
                    <a href="https://wa.me/573235813942?text=Hola%20Robinson,%20tengo%20una%20duda%20sobre%20el%20pago%20SaaS%20de%20{{ urlencode($tenant->name) }}" target="_blank" class="text-blue-600 font-bold hover:underline">
                        Hablar con Asesor →
                    </a>
                </div>

            </div>

        </div>
    </main>

    <!-- 3. FOOTER SENCILLO -->
    <footer class="border-t border-slate-200 py-6 bg-white text-center text-xs text-[#5C6B85]">
        <p>© {{ date('Y') }} AviPetApp · Software con IA para veterinarias · Facturación y Recaudo Seguro.</p>
    </footer>

</body>
</html>
