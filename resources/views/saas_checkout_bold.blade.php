<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-900 text-slate-100 antialiased selection:bg-indigo-500 selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activar Suscripción AVI-Plan — {{ $tenant->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bold Official Checkout SDK -->
    <script type="text/javascript" src="https://checkout.bold.co/library/boldPaymentButton.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .glow-box {
            box-shadow: 0 0 50px -10px rgba(99, 102, 241, 0.25);
        }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between bg-slate-950 text-slate-100 py-10 px-4 sm:px-6">

    <div class="max-w-xl mx-auto w-full space-y-8 my-auto">
        
        <!-- HEADER DE MARCA SAAS -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-bold uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>Pasarela de Pago Oficial Segura</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                Activa tu Suscripción AVI-Plan
            </h1>
            <p class="text-sm text-slate-400">
                Clínica: <strong class="text-white">{{ $tenant->name }}</strong>
            </p>
        </div>

        <!-- TARJETA PRINCIPAL DE LIQUIDACIÓN Y PAGO -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-2xl glow-box relative overflow-hidden">
            
            <!-- DETALLES DEL PLAN SAAS -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Plan Seleccionado</span>
                        <h3 class="text-xl font-black text-white mt-0.5">
                            @if($tier === 'starter') Plan Starter (Hasta 60 mascotas)
                            @elseif($tier === 'enterprise') Plan Enterprise (Ilimitado + Sedes)
                            @elseif($tier === 'pay_per_pet') Modalidad por Mascota Activa
                            @else Plan Profesional (Hasta 250 mascotas)
                            @endif
                        </h3>
                    </div>
                    <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-xs font-black rounded-full uppercase">
                        SaaS 30 Días
                    </span>
                </div>

                <!-- VALOR A PAGAR -->
                <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-medium">Total mensual a liquidar:</span>
                        <div class="text-3xl sm:text-4xl font-black text-white font-mono mt-0.5">
                            ${{ number_format($amount, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">COP</span>
                        </div>
                    </div>
                    <div class="text-right text-xs text-slate-400">
                        <span class="text-emerald-400 font-bold">✓ Sin permanencia</span><br>
                        <span>✓ Factura y recibo digital</span>
                    </div>
                </div>

                <!-- BENEFICIOS DEL SOFTWARE -->
                <div class="space-y-2 text-xs text-slate-300">
                    <div class="flex items-center space-x-2">
                        <span class="text-indigo-400 font-bold">✓</span>
                        <span>Plataforma web activa de afiliación de tutores y mascotas.</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-indigo-400 font-bold">✓</span>
                        <span>Terminal de canje con lector QR en mostrador en tiempo real.</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-indigo-400 font-bold">✓</span>
                        <span>Carnets digitales interactivos para clientes vía WhatsApp.</span>
                    </div>
                </div>
            </div>

            <!-- BOTÓN OFICIAL DE BOLD (PSE / TARJETAS / BOTÓN BANCOLOMBIA / NEQUI) -->
            <div class="pt-4 border-t border-slate-800 space-y-4">
                <div class="text-center space-y-1">
                    <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">
                        Elige tu medio de pago con Bold:
                    </span>
                    <p class="text-[11px] text-slate-500">
                        PSE (Todos los bancos), Tarjeta Crédito/Débito, Botón Bancolombia y Nequi
                    </p>
                </div>

                <!-- CONTAINER DEL BOTÓN BOLD -->
                <div class="flex justify-center items-center py-2">
                    <script 
                        data-bold-button="DARK"
                        data-api-key="{{ $identityKey }}"
                        data-order-id="{{ $orderId }}"
                        data-amount="{{ (int) round($amount) }}"
                        data-currency="COP"
                        data-integrity-signature="{{ $integritySignature }}"
                        data-description="Mensualidad SaaS AVI-Plan - {{ $tenant->name }}"
                        data-redirection-url="{{ $redirectUrl }}"
                        data-webhook-url="{{ $webhookUrl }}"
                        data-payer-email="{{ $payerEmail }}"
                        data-payer-name="{{ $payerName }}"
                        data-payer-phone="{{ $payerPhone }}"
                    ></script>
                </div>

                <div class="flex items-center justify-center space-x-4 pt-2 text-[11px] text-slate-500">
                    <span class="flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>Cifrado SSL 256 bits</span>
                    </span>
                    <span>•</span>
                    <span>Procesado por <strong>Bold.co</strong></span>
                    <span>•</span>
                    <span>Activación Inmediata</span>
                </div>
            </div>

            <!-- OPCIÓN MANUAL: TRANSFERENCIA DIRECTA -->
            <div class="bg-slate-950/60 p-4 rounded-2xl border border-slate-800/80 text-xs text-slate-400 space-y-2">
                <div class="flex justify-between items-center text-slate-300 font-bold">
                    <span>¿Prefieres transferir directamente a Bancolombia / Nequi?</span>
                    <span class="text-indigo-400">Opción Directa</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-mono text-slate-300 pt-1">
                    <div class="bg-slate-900 p-2 rounded-xl border border-slate-800">
                        <span class="text-slate-500 block text-[10px]">Bancolombia Ahorros:</span>
                        <strong># 123-456789-01</strong>
                    </div>
                    <div class="bg-slate-900 p-2 rounded-xl border border-slate-800">
                        <span class="text-slate-500 block text-[10px]">Nequi / Daviplata:</span>
                        <strong>3508742543</strong>
                    </div>
                </div>
                <p class="text-[10px] text-slate-500 pt-1">
                    Titular: Robinson Naranjo / NODIA. Envía tu comprobante al WhatsApp para activación inmediata.
                </p>
            </div>

            <!-- REGRESAR AL PANEL -->
            <div class="text-center pt-2">
                <a href="/admin/{{ $tenant->slug }}" class="text-xs text-slate-500 hover:text-slate-300 transition underline">
                    ← Regresar al Panel de {{ $tenant->name }}
                </a>
            </div>

        </div>

        <p class="text-center text-xs text-slate-600">
            AVI-Plan by AviPetApp & NODIA · Todos los derechos reservados.
        </p>

    </div>

</body>
</html>
