<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950 text-slate-100 antialiased selection:bg-teal-500 selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Carnet Digital Oficial — {{ $subscription->pet->name }} | {{ $tenant->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    
    @php
        $primaryColor = $tenant->branding['primary_color'] ?? '#0D9488';
        $secondaryColor = $tenant->branding['secondary_color'] ?? '#0B1120';
        $logoUrl = $tenant->branding['logo_url'] ?? null;
        $city = $tenant->branding['city'] ?? 'Cajicá, Cundinamarca';
        $address = $tenant->branding['address'] ?? 'Calle 7 # 4-73 Este';
        $phone = $tenant->branding['phone'] ?? '3508742543';
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        
        $pet = $subscription->pet;
        $customer = $pet->customer;
        $plan = $subscription->plan;
        
        // Clean plan name without duplicate "Plan"
        $planName = $plan->name;
        if (str_starts_with(strtolower($planName), 'plan plan')) {
            $planName = preg_replace('/^plan\s+plan\s+/i', 'Plan ', $planName);
        }
        
        $isCanino = in_array(strtolower($pet->species ?? ''), ['canino', 'perro', 'dog']);
        $contractId = $subscription->gateway_subscription_id ?? ('VP-2026-' . str_pad($subscription->id, 4, '0', STR_PAD_LEFT));
        $expirationDate = $subscription->current_period_end ? $subscription->current_period_end->format('d/m/Y') : now()->addYear()->format('d/m/Y');
        $qrData = url('/v/' . $tenant->slug . '/carnet/' . $contractId);
    @endphp

    <style>
        :root {
            --brand-primary: {{ $primaryColor }};
            --brand-secondary: {{ $secondaryColor }};
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        
        .bg-brand-primary { background-color: var(--brand-primary); }
        .bg-brand-secondary { background-color: var(--brand-secondary); }
        .text-brand-primary { color: var(--brand-primary); }
        .border-brand-primary { border-color: var(--brand-primary); }

        /* Estilo Tarjeta Digital Apple Wallet / Luxury Card */
        .wallet-card {
            background: linear-gradient(135deg, {{ $primaryColor }}ee 0%, #041d2d 55%, {{ $secondaryColor }} 100%);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(255, 255, 255, 0.15) inset;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }
        .wallet-card::before {
            content: '';
            position: absolute;
            top: 0; left: -50%; width: 200%; height: 100%;
            background: linear-gradient(
                60deg,
                rgba(255, 255, 255, 0) 20%,
                rgba(255, 255, 255, 0.08) 35%,
                rgba(255, 255, 255, 0.18) 50%,
                rgba(255, 255, 255, 0.08) 65%,
                rgba(255, 255, 255, 0) 80%
            );
            transform: translateX(-100%);
            transition: transform 0.8s ease;
            pointer-events: none;
        }
        .wallet-card:hover::before {
            transform: translateX(100%);
        }
        .wallet-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 30px 60px -12px rgba(13, 148, 136, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.3) inset;
        }

        .chip-metallic {
            background: linear-gradient(135deg, #fce089 0%, #dfac40 50%, #c9932b 100%);
            box-shadow: inset 0 1px 1px rgba(255,255,255,0.6), 0 2px 4px rgba(0,0,0,0.4);
            border: 1px solid #b88320;
        }

        @media print {
            body { 
                background: white !important; 
                color: black !important; 
                padding: 0 !important;
            }
            .no-print { display: none !important; }
            .print-certificate {
                background: white !important;
                color: #0f172a !important;
                border: 2px solid #cbd5e1 !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 24px !important;
                border-radius: 16px !important;
            }
            .print-certificate * {
                color: #0f172a !important;
            }
            .wallet-card {
                background: linear-gradient(135deg, #0f766e 0%, #0f172a 100%) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                box-shadow: none !important;
            }
            .wallet-card * {
                color: white !important;
            }
        }
    </style>
</head>
<body class="min-h-full py-6 sm:py-10 px-3 sm:px-6 lg:px-8 flex flex-col justify-between bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">

    <!-- CONTENEDOR PRINCIPAL 100% CENTRADO -->
    <div class="max-w-4xl w-full mx-auto space-y-6 sm:space-y-8">
        
        <!-- 1. BARRA SUPERIOR DE ACCIONES (NO PRINT) -->
        <header class="no-print bg-slate-900/90 backdrop-blur-md p-3.5 sm:p-4 rounded-3xl border border-slate-800 shadow-xl flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center space-x-3 min-w-0">
                <a href="/v/{{ $tenant->slug }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 shrink-0 border border-slate-700">
                    <span>←</span>
                    <span class="truncate">Volver a {{ $tenant->name }}</span>
                </a>
                <span class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 rounded-full text-xs font-black">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Membresía Activa 2026</span>
                </span>
            </div>

            <div class="flex items-center space-x-2 shrink-0">
                <button type="button" onclick="copyShareLink(this)" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs rounded-xl border border-slate-700 transition flex items-center space-x-1.5">
                    <span>🔗</span>
                    <span class="hidden sm:inline">Copiar Link</span>
                </button>
                <button type="button" onclick="window.print()" class="px-4 py-2 bg-teal-500 hover:bg-teal-400 text-slate-950 font-black text-xs rounded-xl shadow-md transition flex items-center space-x-1.5">
                    <span>🖨️</span>
                    <span>Descargar PDF</span>
                </button>
                <a href="https://wa.me/57{{ $cleanPhone }}?text={{ urlencode('Hola ' . $tenant->name . ', este es el Carnet Digital de ' . $pet->name . ' (Contrato ' . $contractId . '). Deseo agendar un servicio.') }}" target="_blank" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center space-x-1.5">
                    <span>💬</span>
                    <span class="hidden sm:inline">WhatsApp</span>
                </a>
            </div>
        </header>

        <!-- 2. DOCUMENTO / CERTIFICADO OFICIAL -->
        <main class="print-certificate bg-slate-900/90 backdrop-blur-xl p-5 sm:p-8 lg:p-10 rounded-3xl border border-slate-800 shadow-2xl space-y-8 text-white">
            
            <!-- ENCABEZADO DE LA CLÍNICA -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-800 pb-6">
                <div class="flex items-center space-x-3.5 min-w-0">
                    @if(!empty($logoUrl))
                        <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="h-14 sm:h-16 w-auto max-h-16 object-contain rounded-2xl p-1 bg-white/10 backdrop-blur-md border border-white/20 shadow-md shrink-0">
                    @else
                        <div class="w-14 h-14 rounded-2xl bg-brand-primary text-white flex items-center justify-center text-3xl font-black shadow-lg shrink-0">
                            🐾
                        </div>
                    @endif
                    <div class="min-w-0">
                        <div class="flex items-center space-x-2">
                            <h1 class="text-base sm:text-xl font-black text-white leading-tight truncate">{{ $tenant->name }}</h1>
                            <span class="text-emerald-400 text-xs shrink-0" title="Clínica Verificada">✓</span>
                        </div>
                        <p class="text-xs text-slate-400 font-medium truncate">📍 {{ $address }}, {{ $city }}</p>
                        <p class="text-xs text-teal-300 font-bold">Línea de Atención: {{ $phone }}</p>
                    </div>
                </div>

                <div class="text-left sm:text-right bg-slate-950/60 p-3 rounded-2xl border border-slate-800 sm:bg-transparent sm:p-0 sm:border-0 shrink-0">
                    <span class="inline-flex items-center space-x-1 px-3 py-1 bg-teal-500/10 border border-teal-500/30 text-teal-300 text-[11px] font-black rounded-full uppercase tracking-wider">
                        <span>🛡️</span>
                        <span>Certificado Digital Oficial</span>
                    </span>
                    <div class="mt-1.5 flex items-center sm:justify-end space-x-1.5">
                        <span class="text-[11px] text-slate-400 font-mono">CONTRATO:</span>
                        <span class="font-mono font-black text-sm text-teal-400 bg-slate-800/80 px-2 py-0.5 rounded-lg border border-slate-700 select-all">{{ $contractId }}</span>
                    </div>
                </div>
            </div>

            <!-- 3. MOCKUP DE CARNET DIGITAL 3D (APPLE WALLET / LUXURY FINTECH STYLE) -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black text-teal-400 uppercase tracking-widest flex items-center space-x-1.5">
                        <span>💳</span>
                        <span>Credencial Digital de Afiliación</span>
                    </span>
                    <span class="text-[11px] text-slate-400 font-medium hidden sm:inline">Válido en sede física y urgencias</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- FRONTAL DEL CARNET (ANVERSO) -->
                    <div class="wallet-card rounded-3xl p-6 text-white select-none flex flex-col justify-between min-h-[220px] aspect-[1.6/1]">
                        
                        <!-- Top Bar Card -->
                        <div class="flex items-center justify-between border-b border-white/15 pb-3">
                            <div class="flex items-center space-x-2.5 min-w-0">
                                @if(!empty($logoUrl))
                                    <img src="{{ $logoUrl }}" alt="Logo" class="h-6 w-6 object-contain bg-white/20 backdrop-blur-md rounded-lg p-0.5 shrink-0">
                                @else
                                    <span class="text-xl">🐾</span>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-[9px] font-black uppercase tracking-widest text-teal-200 truncate">{{ $tenant->name }}</p>
                                    <p class="text-[11px] font-black text-white leading-tight">Membresía de Salud</p>
                                </div>
                            </div>

                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 bg-emerald-400/20 text-emerald-300 border border-emerald-300/30 text-[9px] font-black rounded-full uppercase tracking-wider shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>ACTIVO</span>
                            </span>
                        </div>

                        <!-- Paciente & Avatar -->
                        <div class="flex items-center justify-between py-3">
                            <div class="space-y-0.5 min-w-0">
                                <p class="text-[9px] uppercase tracking-wider text-white/60 font-bold">Paciente</p>
                                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white uppercase truncate">{{ $pet->name }}</h2>
                                <p class="text-xs text-teal-100 font-medium truncate">{{ $pet->breed ?: 'Mestizo' }} • {{ $pet->species ?: 'Canino' }}</p>
                            </div>
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center text-3xl sm:text-4xl shadow-inner border border-white/20 shrink-0">
                                {{ $isCanino ? '🐕' : '🐱' }}
                            </div>
                        </div>

                        <!-- Chip, Plan & Contrato -->
                        <div class="grid grid-cols-12 gap-2 bg-slate-950/40 backdrop-blur-md p-2.5 rounded-2xl border border-white/10 text-[10px] items-center">
                            <div class="col-span-2 flex items-center justify-center">
                                <div class="chip-metallic w-7 h-5 rounded-md flex items-center justify-center text-[7px] font-black text-slate-900 shadow-xs">
                                    CHIP
                                </div>
                            </div>
                            <div class="col-span-5 min-w-0 pl-1">
                                <p class="text-[7px] uppercase tracking-wider text-white/60 font-bold">Plan</p>
                                <p class="font-black text-amber-300 truncate">{{ $planName }}</p>
                            </div>
                            <div class="col-span-5 text-right min-w-0">
                                <p class="text-[7px] uppercase tracking-wider text-white/60 font-bold">Contrato Digital</p>
                                <p class="font-mono font-bold text-white text-[11px] truncate">{{ $contractId }}</p>
                            </div>
                        </div>

                    </div>

                    <!-- REVERSO DEL CARNET (QR & TUTOR) -->
                    <div class="rounded-3xl p-6 bg-slate-950 text-white shadow-xl relative overflow-hidden border border-slate-800 select-none flex flex-col justify-between min-h-[220px] aspect-[1.6/1]">
                        
                        <!-- Header Reverso -->
                        <div class="flex items-center justify-between border-b border-slate-800 pb-2.5">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Validación de Afiliado</p>
                            <span class="text-[9px] text-emerald-400 font-mono font-bold flex items-center gap-1">
                                <span>🔒</span>
                                <span>Firma Digital Segura</span>
                            </span>
                        </div>

                        <!-- Datos del Tutor & QR -->
                        <div class="grid grid-cols-12 gap-3 items-center py-2">
                            <div class="col-span-7 space-y-1.5 text-xs min-w-0">
                                <div>
                                    <p class="text-[8px] uppercase tracking-wider text-slate-400 font-bold">Tutor Titular</p>
                                    <p class="font-black text-white truncate text-xs sm:text-sm">{{ $customer->name }}</p>
                                </div>
                                <div>
                                    <p class="text-[8px] uppercase tracking-wider text-slate-400 font-bold">WhatsApp / Teléfono</p>
                                    <p class="font-bold text-emerald-400 truncate">{{ $customer->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-[8px] uppercase tracking-wider text-slate-400 font-bold">Vigencia Oficial</p>
                                    <p class="font-medium text-slate-300 text-[11px]">Hasta {{ $expirationDate }}</p>
                                </div>
                            </div>

                            <div class="col-span-5 flex flex-col items-center justify-center">
                                <div class="bg-white p-1.5 rounded-2xl shadow-lg border border-slate-300">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ urlencode($qrData) }}" alt="Código QR del Carnet" class="w-16 h-16 sm:w-18 sm:h-18 object-contain">
                                </div>
                                <span class="text-[8px] text-slate-400 font-mono mt-1 text-center font-bold">Escanear en Sede</span>
                            </div>
                        </div>

                        <!-- Footer Reverso -->
                        <div class="text-[9px] text-slate-400 border-t border-slate-800 pt-2 flex justify-between items-center">
                            <span class="truncate">Presenta esta credencial en recepción</span>
                            <span class="text-teal-400 font-bold shrink-0">Tel: {{ $phone }}</span>
                        </div>

                    </div>

                </div>
            </div>

            <!-- 4. FICHA RESUMEN DE AFILIACIÓN (PACIENTE & TUTOR) -->
            <div class="bg-slate-950/60 p-5 sm:p-6 rounded-3xl border border-slate-800 space-y-4">
                <h3 class="font-black text-xs sm:text-sm text-teal-400 uppercase tracking-wider flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-teal-400"></span>
                    <span>1. Resumen de Afiliación y Datos de Contacto</span>
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                    <div class="space-y-0.5">
                        <span class="text-slate-400 block font-bold text-[10px] uppercase">Paciente</span>
                        <strong class="text-white text-sm uppercase block truncate">{{ $pet->name }}</strong>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-slate-400 block font-bold text-[10px] uppercase">Especie & Raza</span>
                        <strong class="text-slate-200 block truncate">{{ $pet->species ?: 'Canino' }} • {{ $pet->breed ?: 'Mestizo' }}</strong>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-slate-400 block font-bold text-[10px] uppercase">Tutor Responsable</span>
                        <strong class="text-white block truncate">{{ $customer->name }}</strong>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-slate-400 block font-bold text-[10px] uppercase">WhatsApp</span>
                        <strong class="text-emerald-400 block truncate font-mono">{{ $customer->phone }}</strong>
                    </div>
                </div>
            </div>

            <!-- 5. BOLSA DE BENEFICIOS MÉDICOS (METERS & BADGES) -->
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border-b border-slate-800 pb-3">
                    <h3 class="font-black text-xs sm:text-sm text-emerald-400 uppercase tracking-wider flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span>2. Bolsa de Beneficios Médicos ({{ $planName }})</span>
                    </h3>
                    <span class="text-xs text-slate-400 font-medium">Periodo de Cobertura 2026</span>
                </div>

                <!-- CARDS DE BENEFICIOS CON PROGRESO VISUAL -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
                    
                    @php
                        $balances = $subscription->benefitBalances;
                    @endphp

                    @if($balances && $balances->count() > 0)
                        @foreach($balances as $bal)
                            @php
                                $total = $bal->total_granted ?? 1;
                                $used = $bal->used_count ?? 0;
                                $remaining = $bal->remaining_count ?? ($total - $used);
                                $isUnlimited = ($total >= 999);
                                $pct = $isUnlimited ? 100 : round(($remaining / max(1, $total)) * 100);
                            @endphp
                            <div class="bg-slate-950/70 p-4 rounded-2xl border border-slate-800 hover:border-slate-700 transition space-y-2.5">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="font-bold text-xs text-white truncate">{{ $bal->benefitDefinition->name ?? 'Servicio Veterinario' }}</p>
                                        <p class="text-[10px] text-slate-400">
                                            @if($isUnlimited)
                                                Acceso Ilimitado L-D
                                            @else
                                                {{ $used }} de {{ $total }} consumidos
                                            @endif
                                        </p>
                                    </div>
                                    <span class="px-2 py-0.5 text-[10px] font-black rounded-full shrink-0 {{ $remaining > 0 ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-slate-800 text-slate-400' }}">
                                        {{ $isUnlimited ? 'ILIMITADO' : ($remaining . ' disp.') }}
                                    </span>
                                </div>

                                <!-- Progress Bar -->
                                <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                                    <div class="bg-gradient-to-r from-teal-500 to-emerald-400 h-full rounded-full transition-all" style="width: {{ $pct }}%;"></div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- FALLBACK ESTÁNDAR PLAN PATITAS -->
                        <div class="bg-slate-950/70 p-4 rounded-2xl border border-slate-800 space-y-2.5">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-bold text-xs text-white">🩺 Consultas Presenciales</p>
                                    <p class="text-[10px] text-slate-400">0 de 3 consumidas</p>
                                </div>
                                <span class="px-2 py-0.5 text-[10px] font-black rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">3 disp.</span>
                            </div>
                            <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-emerald-400 h-full rounded-full" style="width: 100%;"></div>
                            </div>
                        </div>

                        <div class="bg-slate-950/70 p-4 rounded-2xl border border-slate-800 space-y-2.5">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-bold text-xs text-white">💬 Consultas Virtuales</p>
                                    <p class="text-[10px] text-slate-400">Lunes a Domingo</p>
                                </div>
                                <span class="px-2 py-0.5 text-[10px] font-black rounded-full bg-teal-500/20 text-teal-400 border border-teal-500/30">ILIMITADO</span>
                            </div>
                            <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-teal-400 h-full rounded-full" style="width: 100%;"></div>
                            </div>
                        </div>

                        <div class="bg-slate-950/70 p-4 rounded-2xl border border-slate-800 space-y-2.5">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-bold text-xs text-white">💉 Vacunación Anual</p>
                                    <p class="text-[10px] text-slate-400">Pentavalente + Rabia</p>
                                </div>
                                <span class="px-2 py-0.5 text-[10px] font-black rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">1 disp.</span>
                            </div>
                            <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-emerald-400 h-full rounded-full" style="width: 100%;"></div>
                            </div>
                        </div>

                        <div class="bg-slate-950/70 p-4 rounded-2xl border border-slate-800 space-y-2.5">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-bold text-xs text-white">💊 Desparasitaciones Internas</p>
                                    <p class="text-[10px] text-slate-400">3 dosis al año</p>
                                </div>
                                <span class="px-2 py-0.5 text-[10px] font-black rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">3 disp.</span>
                            </div>
                            <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-emerald-400 h-full rounded-full" style="width: 100%;"></div>
                            </div>
                        </div>

                        <div class="bg-slate-950/70 p-4 rounded-2xl border border-slate-800 space-y-2.5">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-bold text-xs text-white">🛡️ Desparasitación Externa</p>
                                    <p class="text-[10px] text-slate-400">Credelio / Pipeta</p>
                                </div>
                                <span class="px-2 py-0.5 text-[10px] font-black rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">2 disp.</span>
                            </div>
                            <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-emerald-400 h-full rounded-full" style="width: 100%;"></div>
                            </div>
                        </div>

                        <div class="bg-slate-950/70 p-4 rounded-2xl border border-slate-800 space-y-2.5">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-bold text-xs text-white">🧪 Examen de Laboratorio</p>
                                    <p class="text-[10px] text-slate-400">Hemograma completo</p>
                                </div>
                                <span class="px-2 py-0.5 text-[10px] font-black rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">1 disp.</span>
                            </div>
                            <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-emerald-400 h-full rounded-full" style="width: 100%;"></div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <!-- 6. POLÍTICA DE VALIDACIÓN Y FIRMA DIGITAL -->
            <div class="pt-6 border-t border-slate-800 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-400">
                <div class="space-y-1">
                    <p class="font-bold text-white flex items-center space-x-1.5">
                        <span>🏥</span>
                        <span>Validación en Clínica</span>
                    </p>
                    <p class="text-[11px] leading-relaxed">
                        Este carnet digital es válido exclusivamente en las instalaciones oficiales de <strong>{{ $tenant->name }}</strong>. Los servicios se debitan y registran al momento de la consulta.
                    </p>
                </div>
                <div class="text-left sm:text-right space-y-1">
                    <p class="font-bold text-white flex items-center sm:justify-end space-x-1.5">
                        <span>🔐</span>
                        <span>Firma y Certificación Digital</span>
                    </p>
                    <p class="font-mono text-[10px] text-slate-400 select-all">
                        HASH: {{ strtoupper(substr(hash('sha256', $contractId . $tenant->id), 0, 16)) }} • {{ now()->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>

        </main>

        <!-- 7. PIE DE PÁGINA (NO PRINT) -->
        <footer class="no-print text-center text-xs text-slate-500 pb-8 space-y-1">
            <p>© {{ date('Y') }} {{ $tenant->name }}. Sistema Integral de Membresías y Salud Preventiva.</p>
        </footer>

    </div>

    <!-- JAVASCRIPT DE COPIADO Y COMPARTIR -->
    <script>
        function copyShareLink(btn) {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                const original = btn.innerHTML;
                btn.innerHTML = '<span>✓</span><span>¡Copiado!</span>';
                btn.classList.add('bg-emerald-700', 'text-white');
                setTimeout(() => {
                    btn.innerHTML = original;
                    btn.classList.remove('bg-emerald-700', 'text-white');
                }, 2000);
            }).catch(() => {
                prompt('Copia el link de tu carnet:', url);
            });
        }
    </script>
</body>
</html>
