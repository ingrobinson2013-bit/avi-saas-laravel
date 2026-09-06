<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-100 text-slate-900 antialiased selection:bg-teal-500 selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet Digital — {{ $subscription->pet->name }} ({{ $tenant->name }})</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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
        $isCanino = in_array(strtolower($pet->species), ['canino', 'perro', 'dog']);
    @endphp

    <style>
        :root {
            --brand-primary: {{ $primaryColor }};
            --brand-secondary: {{ $secondaryColor }};
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-brand-primary { background-color: var(--brand-primary); }
        .bg-brand-secondary { background-color: var(--brand-secondary); }
        .text-brand-primary { color: var(--brand-primary); }
        .border-brand-primary { border-color: var(--brand-primary); }

        @media print {
            body { background: white !important; }
            .no-print { display: none !important; }
            .print-container { box-shadow: none !important; border: none !important; max-width: 100% !important; padding: 0 !important; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body class="min-h-full py-6 sm:py-10 px-4 sm:px-6">

    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- BARRA SUPERIOR DE ACCIONES (NO IMPRIMIR) -->
        <div class="no-print bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center space-x-3">
                <a href="/v/{{ $tenant->slug }}" class="text-xs font-bold text-slate-500 hover:text-slate-900 transition flex items-center space-x-1">
                    <span>← Volver a</span>
                    <strong class="text-slate-900">{{ $tenant->name }}</strong>
                </a>
                <span class="text-slate-300">|</span>
                <span class="text-xs font-black text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full">
                    ● Membresía Activa 2026
                </span>
            </div>

            <div class="flex items-center space-x-2">
                <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-black text-xs rounded-xl shadow-xs transition flex items-center space-x-1.5">
                    <span>🖨️ Imprimir / Guardar PDF</span>
                </button>
                <a href="https://wa.me/57{{ $cleanPhone }}?text={{ urlencode('Hola ' . $tenant->name . ', este es el carnet digital de ' . $pet->name . ' (Contrato ' . $subscription->gateway_subscription_id . '). Quiero agendar una cita.') }}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs rounded-xl shadow-xs transition flex items-center space-x-1.5">
                    <span>💬 WhatsApp</span>
                </a>
            </div>
        </div>

        <!-- DOCUMENTO PRINCIPAL (CERTIFICADO & CARNET) -->
        <div class="print-container bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-xl space-y-8">
            
            <!-- ENCABEZADO OFICIAL DE LA CLÍNICA -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                <div class="flex items-center space-x-3.5">
                    @if(!empty($logoUrl))
                        <img src="{{ $logoUrl }}" alt="{{ $tenant->name }}" class="h-14 w-auto max-h-14 object-contain rounded-xl shadow-xs">
                    @else
                        <div class="w-12 h-12 rounded-2xl bg-brand-primary text-white flex items-center justify-center text-2xl font-black shadow-md">
                            🐾
                        </div>
                    @endif
                    <div>
                        <h1 class="text-lg sm:text-xl font-black text-slate-900 leading-tight">{{ $tenant->name }}</h1>
                        <p class="text-xs text-slate-500 font-medium">📍 {{ $address }}, {{ $city }} • Tel: {{ $phone }}</p>
                    </div>
                </div>

                <div class="text-left sm:text-right">
                    <span class="inline-block px-3 py-1 bg-teal-50 border border-teal-200 text-teal-800 text-xs font-black rounded-full uppercase tracking-wider">
                        Certificado Oficial de Afiliación
                    </span>
                    <p class="text-xs font-mono font-bold text-slate-400 mt-1">ID: {{ $subscription->gateway_subscription_id }}</p>
                </div>
            </div>

            <!-- CARNET DIGITAL (TAMAÑO TARJETA DE POCKET) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- FRONTAL DEL CARNET -->
                <div class="rounded-3xl p-6 text-white shadow-lg relative overflow-hidden border border-white/20 select-none flex flex-col justify-between aspect-[1.6/1]" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
                    <div class="absolute -right-10 -top-10 w-36 h-36 rounded-full bg-white/10 pointer-events-none"></div>

                    <div class="flex items-center justify-between border-b border-white/15 pb-2.5">
                        <div class="flex items-center space-x-2">
                            <span class="text-lg">🐾</span>
                            <div>
                                <p class="text-[9px] font-black uppercase tracking-widest text-teal-200 truncate max-w-[160px]">{{ $tenant->name }}</p>
                                <p class="text-[11px] font-black text-white">Carnet de Salud Preventiva</p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 bg-emerald-400/20 text-emerald-300 border border-emerald-300/30 text-[8px] font-black rounded-full uppercase tracking-wider">
                            ● ACTIVO
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div class="space-y-0.5">
                            <p class="text-[8px] uppercase tracking-wider text-white/60 font-bold">Paciente</p>
                            <h2 class="text-2xl font-black tracking-tight text-white uppercase">{{ $pet->name }}</h2>
                            <p class="text-xs text-teal-100 font-medium">{{ $pet->breed ?: 'Mestizo' }} • {{ $pet->species }}</p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center text-3xl shadow-inner border border-white/20">
                            {{ $isCanino ? '🐕' : '🐱' }}
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 bg-black/25 p-2.5 rounded-xl border border-white/10 text-[10px]">
                        <div>
                            <p class="text-[7px] uppercase tracking-wider text-white/60 font-bold">Plan</p>
                            <p class="font-black text-amber-300 truncate">{{ $plan->name }}</p>
                        </div>
                        <div>
                            <p class="text-[7px] uppercase tracking-wider text-white/60 font-bold">Contrato</p>
                            <p class="font-mono font-bold text-white">{{ $subscription->gateway_subscription_id }}</p>
                        </div>
                    </div>
                </div>

                <!-- REVERSO DEL CARNET / CÓDIGO QR Y VALIDACIÓN -->
                <div class="rounded-3xl p-6 bg-slate-900 text-white shadow-lg relative overflow-hidden border border-slate-800 select-none flex flex-col justify-between aspect-[1.6/1]">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-2.5">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Información del Tutor</p>
                        <span class="text-[9px] text-teal-400 font-mono font-bold">AVI-SaaS</span>
                    </div>

                    <div class="grid grid-cols-12 gap-3 items-center py-2">
                        <div class="col-span-8 space-y-1 text-xs">
                            <div>
                                <p class="text-[8px] uppercase tracking-wider text-slate-400 font-bold">Tutor Responsable:</p>
                                <p class="font-black text-white truncate">{{ $customer->name }}</p>
                            </div>
                            <div>
                                <p class="text-[8px] uppercase tracking-wider text-slate-400 font-bold">WhatsApp / Teléfono:</p>
                                <p class="font-bold text-emerald-400">{{ $customer->phone }}</p>
                            </div>
                            <div>
                                <p class="text-[8px] uppercase tracking-wider text-slate-400 font-bold">Vigencia:</p>
                                <p class="font-medium text-slate-300 text-[11px]">Hasta {{ $subscription->current_period_end ? $subscription->current_period_end->format('d/m/Y') : '12 Meses' }}</p>
                            </div>
                        </div>

                        <div class="col-span-4 flex flex-col items-center justify-center">
                            <!-- QR Code Dinámico -->
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode(url('/v/' . $tenant->slug . '/carnet/' . $subscription->gateway_subscription_id)) }}" alt="QR Carnet" class="w-16 h-16 rounded-xl bg-white p-1 shadow-md">
                            <span class="text-[8px] text-slate-400 font-mono mt-1">Escanear</span>
                        </div>
                    </div>

                    <div class="text-[9px] text-slate-400 border-t border-slate-800 pt-2 flex justify-between items-center">
                        <span>Presenta este carnet al solicitar tu servicio</span>
                        <span class="text-teal-400 font-bold">Atención: {{ $phone }}</span>
                    </div>
                </div>

            </div>

            <!-- FICHA DE DETALLES DEL PACIENTE & TUTOR -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-4">
                <h3 class="font-black text-sm text-slate-900 uppercase tracking-wider flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span>
                    <span>1. Datos del Paciente y Titular</span>
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block font-bold">Nombre Mascota:</span>
                        <strong class="text-slate-900 text-sm uppercase">{{ $pet->name }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-bold">Especie & Raza:</span>
                        <strong class="text-slate-900">{{ $pet->species }} • {{ $pet->breed ?: 'Mestizo' }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-bold">Tutor / Propietario:</span>
                        <strong class="text-slate-900">{{ $customer->name }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-bold">Teléfono de Contacto:</span>
                        <strong class="text-slate-900">{{ $customer->phone }}</strong>
                    </div>
                </div>
            </div>

            <!-- BOLSA DE BENEFICIOS ANUALES & ESTADO DE USO -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-black text-sm text-slate-900 uppercase tracking-wider flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span>2. Bolsa de Beneficios Médicos (Plan {{ $plan->name }})</span>
                    </h3>
                    <span class="text-xs text-slate-500 font-medium">Periodo 2026</span>
                </div>

                <div class="overflow-x-auto rounded-2xl border border-slate-200">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-900 border-b border-slate-200">
                                <th class="p-3 font-black">Servicio / Beneficio</th>
                                <th class="p-3 font-black text-center">Cupo Total</th>
                                <th class="p-3 font-black text-center">Utilizados</th>
                                <th class="p-3 font-black text-center text-teal-700">Disponibles</th>
                                <th class="p-3 font-black text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            @forelse($subscription->benefitBalances as $balance)
                                <tr>
                                    <td class="p-3 font-bold text-slate-900">
                                        {{ $balance->benefitDefinition->name ?? 'Servicio Veterinario' }}
                                    </td>
                                    <td class="p-3 text-center font-bold">{{ $balance->total_granted }}</td>
                                    <td class="p-3 text-center text-slate-500">{{ $balance->used_count }}</td>
                                    <td class="p-3 text-center font-black text-emerald-600 bg-emerald-50/50">
                                        {{ $balance->remaining_count }}
                                    </td>
                                    <td class="p-3 text-center">
                                        @if($balance->remaining_count > 0)
                                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-black rounded-full">
                                                Disponible ✓
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-full">
                                                Completado
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-3 font-bold text-slate-900">🩺 Consultas Médicas Presenciales</td>
                                    <td class="p-3 text-center font-bold">3</td>
                                    <td class="p-3 text-center text-slate-500">0</td>
                                    <td class="p-3 text-center font-black text-emerald-600">3</td>
                                    <td class="p-3 text-center"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-black rounded-full">Disponible ✓</span></td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-bold text-slate-900">💉 Vacunación Anual (Pentavalente + Rabia)</td>
                                    <td class="p-3 text-center font-bold">1</td>
                                    <td class="p-3 text-center text-slate-500">0</td>
                                    <td class="p-3 text-center font-black text-emerald-600">1</td>
                                    <td class="p-3 text-center"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-black rounded-full">Disponible ✓</span></td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-bold text-slate-900">💊 Desparasitaciones Internas</td>
                                    <td class="p-3 text-center font-bold">3</td>
                                    <td class="p-3 text-center text-slate-500">0</td>
                                    <td class="p-3 text-center font-black text-emerald-600">3</td>
                                    <td class="p-3 text-center"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-black rounded-full">Disponible ✓</span></td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-bold text-slate-900">🛡️ Desparasitación Externa (Credelio)</td>
                                    <td class="p-3 text-center font-bold">1</td>
                                    <td class="p-3 text-center text-slate-500">0</td>
                                    <td class="p-3 text-center font-black text-emerald-600">1</td>
                                    <td class="p-3 text-center"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-black rounded-full">Disponible ✓</span></td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-bold text-slate-900">🧪 Examen de Laboratorio</td>
                                    <td class="p-3 text-center font-bold">1</td>
                                    <td class="p-3 text-center text-slate-500">0</td>
                                    <td class="p-3 text-center font-black text-emerald-600">1</td>
                                    <td class="p-3 text-center"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-black rounded-full">Disponible ✓</span></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FIRMA & VALIDACIÓN -->
            <div class="pt-6 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-slate-500">
                <div class="space-y-1">
                    <p class="font-bold text-slate-900">🏥 Validación en Clínica:</p>
                    <p>Este documento es válido únicamente para el paciente registrado en la sede de <strong>{{ $tenant->name }}</strong>. Los servicios se debitan al momento de su atención.</p>
                </div>
                <div class="text-left sm:text-right space-y-1">
                    <p class="font-bold text-slate-900">Certificación Digital:</p>
                    <p class="font-mono text-[11px] text-slate-400">EMITIDO POR AVI-SAAS • {{ now()->format('d/m/Y H:i') }}</p>
                </div>
            </div>

        </div>

        <!-- PIE DE PÁGINA (NO IMPRIMIR) -->
        <div class="no-print text-center text-xs text-slate-400 pt-4">
            Plataforma de Membresías Médicas desarrollada con tecnología AVI-SaaS para {{ $tenant->name }}.
        </div>

    </div>

</body>
</html>
