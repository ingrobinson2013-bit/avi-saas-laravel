<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Panel de Pedidos y Carritos Abandonados — AVIPET BioLab®</title>
    @if($authorized)
    <meta http-equiv="refresh" content="20">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 font-sans antialiased">
    @if(!$authorized)
        <div class="min-h-screen flex items-center justify-center p-4">
            <form method="GET" action="/biolab/pedidos" class="w-full max-w-sm bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl space-y-4 text-center">
                <div class="mx-auto h-14 w-14 rounded-2xl bg-indigo-600/20 border border-indigo-500/40 flex items-center justify-center text-2xl">
                    🔬
                </div>
                <div>
                    <h1 class="text-lg font-black text-white">Centro de Pedidos AVIPET BioLab®</h1>
                    <p class="text-xs text-slate-400 mt-1">Ingresa el PIN de acceso para ver pedidos y recuperar carritos abandonados</p>
                </div>
                <input
                    type="password"
                    name="pin"
                    placeholder="PIN (ej: 2026)"
                    required
                    autofocus
                    class="w-full rounded-xl bg-slate-950 border border-slate-700 px-4 py-3 text-center text-base font-bold text-white focus:outline-none focus:border-emerald-500"
                >
                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-sm shadow-lg transition cursor-pointer"
                >
                    🔓 Entrar al Panel en Vivo
                </button>
            </form>
        </div>
    @else
        @php
            $totalRevenue = collect($orders)->sum(fn($o) => (int) ($o['total_cop'] ?? 0));
            $bundleLabels = [
                '1_bolsa' => '1 Bolsa (250g) — $69.900 COP',
                '2_bolsas' => 'Pack Dúo 2 Bolsas (500g) — $124.900 COP',
                '3_bolsas' => 'Tratamiento 3 Bolsas (750g) — $169.900 COP',
            ];
        @endphp

        <header class="bg-gradient-to-r from-[#1E1446] via-[#2D1B69] to-slate-900 border-b border-indigo-500/30 sticky top-0 z-30">
            <div class="max-w-6xl mx-auto px-4 py-3.5 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🔬</span>
                    <div>
                        <h1 class="text-base sm:text-lg font-black text-white leading-tight">
                            AVIPET BioLab® — Monitor de Pedidos y Carritos en Vivo
                        </h1>
                        <p class="text-xs text-indigo-200">
                            Se actualiza automáticamente cada 20 segundos • Última lectura: {{ now()->timezone('America/Bogota')->format('h:i:s A') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a
                        href="/biolab/pedidos?pin=2026"
                        class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs transition"
                    >
                        🔄 Actualizar ahora
                    </a>
                    <a
                        href="/dermo-gut-superboost"
                        target="_blank"
                        class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs transition"
                    >
                        ↗ Ver Página de Producto
                    </a>
                </div>
            </div>
        </header>

        <main class="max-w-6xl mx-auto px-4 py-6 space-y-8">
            <!-- KPI SUMMARY -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="bg-slate-900 border border-cyan-500/40 rounded-2xl p-4">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-cyan-300">
                        👀 Visitantes Medidos (Mapa de Calor)
                    </span>
                    <div class="text-3xl font-black text-white mt-1 flex items-baseline gap-2">
                        <span>{{ $heatmap['total_sessions'] ?? 0 }}</span>
                        <span class="text-xs font-bold text-emerald-400">
                            ({{ $heatmap['active_now'] ?? 0 }} últimos 10 min)
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        Scroll promedio en la página: <strong class="text-cyan-300">{{ $heatmap['avg_scroll_pct'] ?? 0 }}%</strong>
                    </p>
                </div>

                <div class="bg-slate-900 border border-amber-500/40 rounded-2xl p-4">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-amber-400">
                        🔥 Carritos por Recuperar (Con WhatsApp)
                    </span>
                    <div class="text-3xl font-black text-white mt-1">
                        {{ count($leads) }}
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        Clientes que escribieron su celular en el formulario pero no terminaron la dirección.
                    </p>
                </div>

                <div class="bg-slate-900 border border-emerald-500/40 rounded-2xl p-4">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-400">
                        ✅ Pedidos Confirmados Contraentrega
                    </span>
                    <div class="text-3xl font-black text-white mt-1">
                        {{ count($orders) }}
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        Órdenes completas con dirección listas para despachar.
                    </p>
                </div>

                <div class="bg-slate-900 border border-indigo-500/40 rounded-2xl p-4">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-indigo-300">
                        💰 Valor Total en Pedidos Confirmados
                    </span>
                    <div class="text-3xl font-black text-emerald-400 mt-1">
                        ${{ number_format($totalRevenue, 0, ',', '.') }} COP
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        Recaudo contraentrega al entregar en casa.
                    </p>
                </div>
            </div>

            <!-- HEATMAP SECTION: SCROLL RETENTION + CLICKS + MODAL FUNNEL -->
            @php
                $totalSess = max(1, (int) ($heatmap['total_sessions'] ?? 0));
                $secData = $heatmap['sections'] ?? [];
                $clkData = $heatmap['clicks'] ?? [];
                $sectionLabels = [
                    'hero_gallery' => '1. 📸 Galería Principal y Promesa Arriba (Hero)',
                    'plan_selector' => '2. 📦 Selector de Planes (1, 2 y 3 Bolsas + Botón Comprar)',
                    'demo_gif' => '3. 🎬 GIF Demostrativo en Vivo (3 Pasos de Uso)',
                    'problem_agitation' => '4. 🚨 Historia del Problema (Por qué se rasca / lame las patas)',
                    'formula_ingredients' => '5. 🔬 Doble Matriz Bio-Activa e Ingredientes',
                    'dosage_calculator' => '6. ⚖️ Calculadora Interactiva de Dosis según Peso',
                    'reviews_social' => '7. ⭐ Reseñas y Casos Reales Verificados en Colombia',
                    'faq_guarantee' => '8. 🛡️ Preguntas Frecuentes (FAQ) y Garantía',
                ];
                $clickLabels = [
                    'thumb_gallery' => '🖼️ Tocaron las 4 miniaturas de fotos de la galería',
                    'pkg_1_bolsa' => '📦 Seleccionaron Plan 1 Bolsa ($69.900)',
                    'pkg_2_bolsas' => '🔥 Seleccionaron Plan 2 Bolsas ($124.900)',
                    'pkg_3_bolsas' => '🏆 Seleccionaron Plan 3 Bolsas ($169.900)',
                    'cta_open_modal' => '🚚 Tocaron Botón "PEDIR CONTRAENTREGA" (Abrieron Popup)',
                ];
                $modalSteps = [
                    'cta_open_modal' => 'Paso 1: Abrieron el Popup de Pedido Contraentrega',
                    'modal_focus_phone' => 'Paso 2: Tocaron la casilla de 📱 WhatsApp / Celular',
                    'modal_focus_name' => 'Paso 3: Tocaron la casilla de 👤 Nombre y Apellido',
                    'modal_focus_dept_city' => 'Paso 4: Seleccionaron 📍 Departamento / Ciudad',
                    'modal_focus_address' => 'Paso 5: Tocaron la casilla de 🏠 Dirección Exacta',
                    'modal_submit_attempt' => 'Paso 6A: Tocaron "✅ CONFIRMAR PEDIDO"',
                    'modal_click_whatsapp' => 'Paso 6B: Tocaron "💬 Pedir directo por WhatsApp en 1 clic"',
                ];
            @endphp
            <section class="bg-slate-900 border border-slate-800 rounded-3xl p-5 space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-800 pb-3">
                    <div>
                        <h2 class="text-lg sm:text-xl font-black text-cyan-300 flex items-center gap-2">
                            <span>🌡️ Mapa de Calor en Vivo — ¿Dónde están y qué tocan los visitantes?</span>
                        </h2>
                        <p class="text-xs text-slate-400">
                            Mide en tiempo real hasta qué sección bajan los usuarios y en qué botones o casillas del formulario se quedan.
                        </p>
                    </div>
                    <span class="text-xs font-bold bg-cyan-500/15 text-cyan-300 border border-cyan-500/30 px-3 py-1 rounded-full">
                        🔥 Rojo = Muy Caliente • 🟠 Naranja = Tibio • 🔵 Azul = Frío
                    </span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- LEFT: SECTION SCROLL HEATMAP -->
                    <div class="space-y-3">
                        <h3 class="text-sm font-black uppercase tracking-wider text-white">
                            📜 1. Mapa de Calor de Lectura (Scroll por Sección de la Página)
                        </h3>
                        <div class="space-y-2.5">
                            @foreach($sectionLabels as $secKey => $secTitle)
                                @php
                                    $count = (int) ($secData[$secKey] ?? 0);
                                    $pct = ($heatmap['total_sessions'] ?? 0) > 0 ? min(100, round(($count / $totalSess) * 100)) : 0;
                                    $barColor = $pct >= 70
                                        ? 'from-rose-600 via-orange-500 to-amber-400'
                                        : ($pct >= 40 ? 'from-amber-500 to-yellow-400' : 'from-cyan-600 to-blue-500');
                                @endphp
                                <div class="bg-slate-950/80 border border-slate-800 rounded-xl p-2.5 space-y-1.5">
                                    <div class="flex items-center justify-between text-xs font-bold">
                                        <span class="text-slate-200">{{ $secTitle }}</span>
                                        <span class="text-amber-300 font-black">{{ $count }} visit. ({{ $pct }}%)</span>
                                    </div>
                                    <div class="w-full h-2.5 bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r {{ $barColor }} rounded-full" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- RIGHT: CLICKS & CHECKOUT MODAL FUNNEL HEATMAP -->
                    <div class="space-y-5">
                        <div class="space-y-3">
                            <h3 class="text-sm font-black uppercase tracking-wider text-white">
                                👆 2. Zonas con Más Clics en la Página
                            </h3>
                            <div class="space-y-2">
                                @foreach($clickLabels as $clkKey => $clkTitle)
                                    @php
                                        $cCount = (int) ($clkData[$clkKey] ?? 0);
                                        $cPct = ($heatmap['total_sessions'] ?? 0) > 0 ? min(100, round(($cCount / $totalSess) * 100)) : 0;
                                    @endphp
                                    <div class="bg-slate-950/80 border border-slate-800 rounded-xl px-3 py-2 flex items-center justify-between text-xs">
                                        <span class="font-semibold text-slate-300">{{ $clkTitle }}</span>
                                        <span class="font-black text-emerald-400">{{ $cCount }} personas ({{ $cPct }}%)</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h3 class="text-sm font-black uppercase tracking-wider text-amber-300">
                                🛒 3. Radiografía Dentro del Formulario Contraentrega (¿Dónde se salen?)
                            </h3>
                            <div class="space-y-2">
                                @foreach($modalSteps as $mKey => $mTitle)
                                    @php
                                        $mCount = (int) ($clkData[$mKey] ?? 0);
                                    @endphp
                                    <div class="bg-slate-950/80 border border-amber-500/20 rounded-xl px-3 py-2 flex items-center justify-between text-xs">
                                        <span class="font-semibold text-slate-200">{{ $mTitle }}</span>
                                        <span class="font-black text-amber-400">{{ $mCount }} usuarios</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SECTION 1: ABANDONED CHECKOUTS / LEADS TO RECOVER -->
            <section class="space-y-3">
                <div class="flex items-center justify-between gap-2">
                    <div>
                        <h2 class="text-lg sm:text-xl font-black text-amber-400 flex items-center gap-2">
                            <span>🔥 Carritos Abandonados / Pagos Iniciados ({{ count($leads) }})</span>
                        </h2>
                        <p class="text-xs text-slate-400">
                            Apenas un visitante escribe los 10 dígitos de su celular en el formulario, aparece aquí automáticamente para que lo contactes en 1 clic si se sale.
                        </p>
                    </div>
                </div>

                @if(count($leads) === 0)
                    <div class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 text-center text-slate-400 text-sm">
                        Aún no hay carritos abandonados con número de celular registrado. En cuanto un visitante digite su celular en el formulario de compra, aparecerá aquí al instante.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($leads as $lead)
                            @php
                                $phone = $lead['customer_phone'] ?? '';
                                $name = !empty($lead['customer_name']) ? $lead['customer_name'] : 'Dueño(a) de mascota';
                                $bundleId = $lead['bundle_id'] ?? '1_bolsa';
                                $bundleText = $bundleLabels[$bundleId] ?? $bundleId;
                                $cityText = trim(($lead['city'] ?? '') . (!empty($lead['department']) ? ' (' . $lead['department'] . ')' : ''));
                                $createdAt = !empty($lead['created_at'])
                                    ? \Carbon\Carbon::parse($lead['created_at'])->timezone('America/Bogota')->format('d/m/Y h:i A')
                                    : 'Hace un momento';
                                $recoveryMsg = "Hola" . (!empty($lead['customer_name']) ? " *{$lead['customer_name']}*" : "") . " 🐾 Te escribimos de *AVIPET BioLab®*.\n\n"
                                    . "Vimos que estabas pidiendo tu *DERMO & GUT SUPERBOOST®* ({$bundleText}) con *Envío Gratis + Pago Contraentrega*, pero faltó confirmar tu dirección de entrega.\n\n"
                                    . "¿Me regalas por aquí tu *Ciudad y Dirección* para dejarte agendado el despacho hoy mismo y enviarte los *2 Bonos Gratis (Guía PDF + Comunidad con Médica Veterinaria)*? 🚚🩺";
                                $waUrl = "https://wa.me/57{$phone}?text=" . rawurlencode($recoveryMsg);
                            @endphp
                            <div class="bg-slate-900 border-2 border-amber-500/40 rounded-2xl p-4 flex flex-col justify-between gap-4 shadow-lg">
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="bg-amber-500/20 text-amber-300 border border-amber-500/30 text-[11px] font-black px-2.5 py-0.5 rounded-full">
                                            ⏳ CARRITO INICIADO • POR CONFIRMAR
                                        </span>
                                        <span class="text-xs text-slate-400 font-semibold">
                                            🕒 {{ $createdAt }}
                                        </span>
                                    </div>
                                    <div class="text-base font-black text-white">
                                        👤 {{ $name }} — <span class="text-emerald-400">📱 {{ $phone }}</span>
                                    </div>
                                    <div class="text-xs text-slate-300 space-y-1 bg-slate-950/80 p-3 rounded-xl border border-slate-800">
                                        <div>📦 <strong>Plan seleccionado:</strong> {{ $bundleText }}</div>
                                        @if($cityText)
                                            <div>📍 <strong>Ciudad / Depto:</strong> {{ $cityText }}</div>
                                        @endif
                                        @if(!empty($lead['address']))
                                            <div>🏠 <strong>Dirección parcial:</strong> {{ $lead['address'] }}</div>
                                        @endif
                                    </div>
                                </div>

                                <a
                                    href="{{ $waUrl }}"
                                    target="_blank"
                                    rel="noreferrer"
                                    class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-amber-500 to-emerald-600 hover:from-amber-400 hover:to-emerald-500 text-slate-950 font-black text-xs sm:text-sm text-center shadow-lg transition flex items-center justify-center gap-2"
                                >
                                    <span>📲 RECUPERAR PEDIDO POR WHATSAPP (1 CLIC) →</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- SECTION 2: CONFIRMED ORDERS -->
            <section class="space-y-3">
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-emerald-400 flex items-center gap-2">
                        <span>✅ Pedidos Contraentrega Confirmados ({{ count($orders) }})</span>
                    </h2>
                    <p class="text-xs text-slate-400">
                        Clientes que completaron todo el formulario de compra contraentrega.
                    </p>
                </div>

                @if(count($orders) === 0)
                    <div class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 text-center text-slate-400 text-sm">
                        Todavía no hay órdenes completadas al 100%. Apenas entre el primer pedido confirmado lo verás aquí con todos los datos de envío.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($orders as $order)
                            @php
                                $orderCode = $order['order_code'] ?? 'BIO-000';
                                $phone = $order['customer_phone'] ?? '';
                                $name = $order['customer_name'] ?? 'Cliente';
                                $bundleTitle = $order['bundle_title'] ?? '1 Bolsa Dermo & Gut Superboost';
                                $formattedTotal = $order['formatted_total'] ?? '$69.900 COP';
                                $createdAt = !empty($order['created_at'])
                                    ? \Carbon\Carbon::parse($order['created_at'])->timezone('America/Bogota')->format('d/m/Y h:i A')
                                    : '';
                                $confirmMsg = "Hola *{$name}* 🐾 ¡Gracias por tu pedido en *AVIPET BioLab®*!\n\n"
                                    . "✅ *Orden confirmada:* {$orderCode}\n"
                                    . "📦 *Producto:* {$bundleTitle}\n"
                                    . "💰 *Total a pagar al recibir en casa:* {$formattedTotal} (Envío Gratis)\n"
                                    . "📍 *Dirección:* " . ($order['address'] ?? '') . ", " . ($order['city'] ?? '') . " (" . ($order['department'] ?? '') . ")\n\n"
                                    . "🎁 *AQUÍ TIENES TU BONO VIP GRATIS (Guía Clínica de Nutrición Hipoalergénica en PDF):*\n"
                                    . "https://biolab.avipetapp.com/guias/guia-nutricion-clinica-hipoalergenica-avipet-biolab.pdf\n\n"
                                    . "Por favor confírmanos con un *SÍ* para despachar tu paquete hoy mismo. 🚚";
                                $waConfirmUrl = "https://wa.me/57{$phone}?text=" . rawurlencode($confirmMsg);
                            @endphp
                            <div class="bg-slate-900 border-2 border-emerald-500/40 rounded-2xl p-4 flex flex-col justify-between gap-4 shadow-lg">
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-black px-2.5 py-0.5 rounded-full">
                                            ✅ ORDEN #{{ $orderCode }}
                                        </span>
                                        <span class="text-xs text-slate-400 font-semibold">
                                            🕒 {{ $createdAt }}
                                        </span>
                                    </div>
                                    <div class="text-base font-black text-white">
                                        👤 {{ $name }} — <span class="text-emerald-400">📱 {{ $phone }}</span>
                                    </div>
                                    <div class="text-xs text-slate-300 space-y-1 bg-slate-950/80 p-3 rounded-xl border border-slate-800">
                                        <div>📦 <strong>Kit:</strong> {{ $bundleTitle }}</div>
                                        <div>💰 <strong>Cobrar en casa:</strong> <span class="text-emerald-400 font-black">{{ $formattedTotal }}</span></div>
                                        <div>📍 <strong>Ciudad:</strong> {{ $order['city'] ?? '' }} ({{ $order['department'] ?? '' }})</div>
                                        <div>🏠 <strong>Dirección:</strong> {{ $order['address'] ?? '' }} {{ !empty($order['neighborhood']) ? '— ' . $order['neighborhood'] : '' }}</div>
                                        <div>🐾 <strong>Mascota:</strong> {{ $order['pet_type'] ?? 'Perro' }}</div>
                                    </div>
                                </div>

                                <a
                                    href="{{ $waConfirmUrl }}"
                                    target="_blank"
                                    rel="noreferrer"
                                    class="w-full py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs sm:text-sm text-center shadow-lg transition flex items-center justify-center gap-2"
                                >
                                    <span>📲 CONFIRMAR DESPACHO Y ENVIAR GUÍA PDF POR WHATSAPP →</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </main>
    @endif
</body>
</html>
