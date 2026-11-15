<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#059669">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="BioLab Pedidos">
    <link rel="manifest" href="/biolab/manifest.webmanifest">
    <link rel="apple-touch-icon" href="/brand/favicons/favicon-180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/brand/favicons/favicon-192.png">
    <title>Panel de Pedidos y Carritos Abandonados — AVIPET BioLab®</title>
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
            $todayRevenue = collect($todayOrders)->sum(fn($o) => (int) ($o['total_cop'] ?? 0));
            $allRevenue = collect($allOrders)->sum(fn($o) => (int) ($o['total_cop'] ?? 0));
            $bundleLabels = [
                '1_bolsa' => '1 Bolsa (250g) — $69.900 COP',
                '2_bolsas' => 'Pack Dúo 2 Bolsas (500g) — $124.900 COP',
                '3_bolsas' => 'Tratamiento 3 Bolsas (750g) — $169.900 COP',
            ];
            $sectionsMap = [
                'hero_gallery' => '1. 📸 Galería Principal y Promesa Arriba (Hero)',
                'plan_selector' => '2. 📦 Selector de Planes (1, 2 y 3 Bolsas + Botón Comprar)',
                'demo_gif' => '3. 🎬 GIF Demostrativo en Vivo (3 Pasos de Uso)',
                'problem_agitation' => '4. 🚨 Historia del Problema (Por qué se rasca / lame las patas)',
                'formula_ingredients' => '5. 🔬 Doble Matriz Bio-Activa e Ingredientes',
                'dosage_calculator' => '6. ⚖️ Calculadora Interactiva de Dosis según Peso',
                'reviews_social' => '7. ⭐ Reseñas y Casos Reales Verificados en Colombia',
                'faq_guarantee' => '8. 🛡️ Preguntas Frecuentes (FAQ) y Garantía',
            ];
            $clicksMap = [
                'thumb_gallery' => '🖼️ Tocaron las 4 miniaturas de fotos de la galería',
                'pkg_1_bolsa' => '📦 Seleccionaron Plan 1 Bolsa ($69.900)',
                'pkg_2_bolsas' => '🔥 Seleccionaron Plan 2 Bolsas ($124.900)',
                'pkg_3_bolsas' => '🏆 Seleccionaron Plan 3 Bolsas ($169.900)',
                'cta_open_modal' => '🚚 Tocaron Botón "PEDIR CONTRAENTREGA" (Abrieron Popup)',
            ];
            $modalFunnelMap = [
                'cta_open_modal' => 'Paso 1: Abrieron el Popup de Pedido Contraentrega',
                'modal_focus_phone' => 'Paso 2: Tocaron la casilla de 📱 WhatsApp / Celular',
                'modal_focus_name' => 'Paso 3: Tocaron la casilla de 👤 Nombre y Apellido',
                'modal_focus_dept_city' => 'Paso 4: Seleccionaron 📍 Departamento / Ciudad',
                'modal_focus_address' => 'Paso 5: Tocaron la casilla de 🏠 Dirección Exacta',
                'modal_submit_attempt' => 'Paso 6A: Tocaron "✅ CONFIRMAR PEDIDO"',
                'modal_click_whatsapp' => 'Paso 6B: Tocaron "💬 Pedir directo por WhatsApp en 1 clic"',
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
                            Se actualiza automáticamente cada 25 segundos • Última lectura: {{ now()->timezone('America/Bogota')->format('h:i:s A') }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <button
                        id="pwa-install-btn"
                        type="button"
                        onclick="installPwaApp()"
                        class="hidden px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-black text-xs transition shadow-lg shadow-indigo-900/30"
                    >
                        📲 Instalar App
                    </button>
                    <button
                        id="push-enable-btn"
                        type="button"
                        onclick="enableBiolabPush()"
                        class="px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition shadow-lg shadow-amber-900/30"
                    >
                        🔔 Activar Alertas
                    </button>
                    <button
                        id="push-test-btn"
                        type="button"
                        onclick="sendTestBiolabPush()"
                        class="px-3 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs transition"
                        title="Enviar notificación de prueba"
                    >
                        ⚡ Probar
                    </button>
                    <a
                        href="/biolab/pedidos?pin=2026"
                        class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs transition"
                    >
                        🔄 Actualizar
                    </a>
                    <a
                        href="/dermo-gut-superboost"
                        target="_blank"
                        class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs transition"
                    >
                        ↗ Ver Producto
                    </a>
                </div>
            </div>
            <div id="pwa-status-banner" class="hidden max-w-7xl mx-auto px-4 pb-3">
                <div class="px-3.5 py-2 rounded-xl bg-slate-800/90 border border-white/10 text-xs text-slate-200 flex items-center justify-between gap-2">
                    <span id="pwa-status-text"></span>
                    <button type="button" onclick="document.getElementById('pwa-status-banner').classList.add('hidden')" class="text-slate-400 hover:text-white font-bold">✕</button>
                </div>
            </div>
        </header>

        <main class="max-w-6xl mx-auto px-4 py-6 space-y-6">
            <!-- TAB CONTROLLER (HOY vs HISTÓRICO) -->
            <div class="flex flex-wrap items-center justify-between gap-3 bg-slate-900/90 border border-slate-800 p-2.5 rounded-2xl shadow-lg">
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        onclick="switchTab('today')"
                        id="tab-btn-today"
                        class="px-4 py-2.5 rounded-xl font-black text-xs sm:text-sm transition flex items-center gap-2 bg-emerald-600 text-white shadow-lg cursor-pointer"
                    >
                        <span>📅 Hoy ({{ $todayDate }} — Últimas 24h)</span>
                        <span class="bg-emerald-950/70 text-emerald-200 text-xs px-2 py-0.5 rounded-full font-bold">
                            {{ count($todayOrders) }} pedidos
                        </span>
                    </button>
                    <button
                        type="button"
                        onclick="switchTab('all')"
                        id="tab-btn-all"
                        class="px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition flex items-center gap-2 bg-slate-800 text-slate-300 hover:text-white cursor-pointer"
                    >
                        <span>🌐 Histórico Total</span>
                        <span class="bg-slate-700 text-slate-200 text-xs px-2 py-0.5 rounded-full font-bold">
                            {{ count($allOrders) }} pedidos
                        </span>
                    </button>
                </div>
                <div class="text-xs text-slate-400 font-semibold px-2">
                    <span id="tab-indicator-text">Mostrando métricas y pedidos de las últimas 24 horas</span>
                </div>
            </div>

            <!-- VIEW: TODAY (DEFAULT) -->
            <div id="view-today" class="space-y-6">
                <!-- KPI SUMMARY TODAY -->
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div class="bg-slate-900 border border-cyan-500/40 rounded-2xl p-4">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-cyan-300">
                            👀 Visitantes Medidos Hoy
                        </span>
                        <div class="text-3xl font-black text-white mt-1 flex items-baseline gap-2">
                            <span>{{ $todayHeatmap['total_sessions'] ?? 0 }}</span>
                            <span class="text-xs font-bold text-emerald-400">
                                ({{ $todayHeatmap['active_now'] ?? 0 }} activos)
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">
                            Scroll promedio hoy: <strong class="text-cyan-300">{{ $todayHeatmap['avg_scroll_pct'] ?? 0 }}%</strong>
                        </p>
                    </div>

                    <div class="bg-slate-900 border border-amber-500/40 rounded-2xl p-4">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-amber-400">
                            🔥 Carritos de Hoy (Con WhatsApp)
                        </span>
                        <div class="text-3xl font-black text-white mt-1">
                            {{ count($todayLeads) }}
                        </div>
                        <p class="text-xs text-slate-400 mt-1">
                            Clientes que entraron hoy y dejaron su celular.
                        </p>
                    </div>

                    <div class="bg-slate-900 border border-emerald-500/40 rounded-2xl p-4">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-400">
                            ✅ Pedidos Confirmados Hoy
                        </span>
                        <div class="text-3xl font-black text-white mt-1">
                            {{ count($todayOrders) }}
                        </div>
                        <p class="text-xs text-slate-400 mt-1">
                            Órdenes completas listas para despachar.
                        </p>
                    </div>

                    <div class="bg-slate-900 border border-indigo-500/40 rounded-2xl p-4">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-indigo-300">
                            💰 Recaudo Contraentrega Hoy
                        </span>
                        <div class="text-3xl font-black text-emerald-400 mt-1">
                            ${{ number_format($todayRevenue, 0, ',', '.') }} COP
                        </div>
                        <p class="text-xs text-slate-400 mt-1">
                            Total a cobrar al entregar en casa.
                        </p>
                    </div>
                </div>

                <!-- HEATMAP TODAY -->
                <section class="bg-slate-900 border border-slate-800 rounded-3xl p-5 space-y-6">
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-800 pb-3">
                        <div>
                            <h2 class="text-lg sm:text-xl font-black text-cyan-300 flex items-center gap-2">
                                <span>🌡️ Mapa de Calor de HOY ({{ $todayDate }})</span>
                            </h2>
                            <p class="text-xs text-slate-400">
                                Mide hasta qué sección bajaron las visitas de hoy y en qué casillas interactuaron.
                            </p>
                        </div>
                        <span class="text-xs font-bold bg-cyan-500/15 text-cyan-300 border border-cyan-500/30 px-3 py-1 rounded-full">
                            🔥 Sesiones hoy: {{ $todayHeatmap['total_sessions'] ?? 0 }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <h3 class="text-sm font-black uppercase tracking-wider text-white">
                                📜 1. Scroll por Sección (Hoy)
                            </h3>
                            <div class="space-y-2.5">
                                @php
                                    $todayTot = max(1, $todayHeatmap['total_sessions'] ?? 1);
                                @endphp
                                @foreach($sectionsMap as $secKey => $secTitle)
                                    @php
                                        $cnt = $todayHeatmap['sections'][$secKey] ?? 0;
                                        $pct = round(($cnt / $todayTot) * 100);
                                    @endphp
                                    <div class="bg-slate-950/80 border border-slate-800 rounded-xl p-2.5 space-y-1.5">
                                        <div class="flex items-center justify-between text-xs font-bold">
                                            <span class="text-slate-200">{{ $secTitle }}</span>
                                            <span class="text-amber-300 font-black">{{ $cnt }} visit. ({{ $pct }}%)</span>
                                        </div>
                                        <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-emerald-500 to-cyan-400 rounded-full" style="width: {{ $pct }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-sm font-black uppercase tracking-wider text-amber-300">
                                🛒 2. Embudo Dentro del Formulario (Hoy)
                            </h3>
                            <div class="space-y-2">
                                @foreach($modalFunnelMap as $fKey => $fTitle)
                                    @php
                                        $fCnt = $todayHeatmap['clicks'][$fKey] ?? 0;
                                    @endphp
                                    <div class="bg-slate-950/80 border border-amber-500/20 rounded-xl px-3 py-2 flex items-center justify-between text-xs">
                                        <span class="font-semibold text-slate-200">{{ $fTitle }}</span>
                                        <span class="font-black text-amber-400">{{ $fCnt }} usuarios</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION 1: TODAY LEADS -->
                <section class="space-y-3">
                    <h2 class="text-lg font-black text-amber-400 flex items-center gap-2">
                        <span>🔥 Carritos Abandonados de Hoy ({{ count($todayLeads) }})</span>
                    </h2>
                    @if(count($todayLeads) === 0)
                        <div class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 text-center text-slate-400 text-sm">
                            No hay carritos abandonados sin cerrar hoy. ¡Todos los que iniciaron completaron su compra o no han dejado números pendientes!
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($todayLeads as $lead)
                                @include('partials.biolab_lead_card', ['lead' => $lead, 'bundleLabels' => $bundleLabels])
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- SECTION 2: TODAY ORDERS -->
                <section class="space-y-3">
                    <h2 class="text-lg font-black text-emerald-400 flex items-center gap-2">
                        <span>✅ Pedidos Confirmados de Hoy ({{ count($todayOrders) }})</span>
                    </h2>
                    @if(count($todayOrders) === 0)
                        <div class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 text-center text-slate-400 text-sm">
                            Aún no se registran pedidos completados hoy. En cuanto entre uno se verá aquí en vivo.
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($todayOrders as $order)
                                @include('partials.biolab_order_card', ['order' => $order])
                            @endforeach
                        </div>
                    @endif
                </section>
            </div>

            <!-- VIEW: ALL-TIME (HIDDEN BY DEFAULT) -->
            <div id="view-all" class="space-y-6 hidden">
                <!-- KPI SUMMARY ALL -->
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div class="bg-slate-900 border border-cyan-500/40 rounded-2xl p-4">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-cyan-300">
                            👀 Visitantes Medidos (Total Histórico)
                        </span>
                        <div class="text-3xl font-black text-white mt-1 flex items-baseline gap-2">
                            <span>{{ $allHeatmap['total_sessions'] ?? 0 }}</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">
                            Scroll promedio histórico: <strong class="text-cyan-300">{{ $allHeatmap['avg_scroll_pct'] ?? 0 }}%</strong>
                        </p>
                    </div>

                    <div class="bg-slate-900 border border-amber-500/40 rounded-2xl p-4">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-amber-400">
                            🔥 Carritos Totales (Con WhatsApp)
                        </span>
                        <div class="text-3xl font-black text-white mt-1">
                            {{ count($allLeads) }}
                        </div>
                    </div>

                    <div class="bg-slate-900 border border-emerald-500/40 rounded-2xl p-4">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-400">
                            ✅ Pedidos Confirmados Totales
                        </span>
                        <div class="text-3xl font-black text-white mt-1">
                            {{ count($allOrders) }}
                        </div>
                    </div>

                    <div class="bg-slate-900 border border-indigo-500/40 rounded-2xl p-4">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-indigo-300">
                            💰 Recaudo Contraentrega Total
                        </span>
                        <div class="text-3xl font-black text-emerald-400 mt-1">
                            ${{ number_format($allRevenue, 0, ',', '.') }} COP
                        </div>
                    </div>
                </div>

                <!-- HEATMAP ALL -->
                <section class="bg-slate-900 border border-slate-800 rounded-3xl p-5 space-y-6">
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-800 pb-3">
                        <h2 class="text-lg sm:text-xl font-black text-cyan-300 flex items-center gap-2">
                            <span>🌡️ Mapa de Calor Histórico Acumulado</span>
                        </h2>
                        <span class="text-xs font-bold bg-cyan-500/15 text-cyan-300 border border-cyan-500/30 px-3 py-1 rounded-full">
                            Total sesiones: {{ $allHeatmap['total_sessions'] ?? 0 }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <h3 class="text-sm font-black uppercase tracking-wider text-white">
                                📜 Scroll por Sección (Histórico)
                            </h3>
                            <div class="space-y-2.5">
                                @php
                                    $allTot = max(1, $allHeatmap['total_sessions'] ?? 1);
                                @endphp
                                @foreach($sectionsMap as $secKey => $secTitle)
                                    @php
                                        $cnt = $allHeatmap['sections'][$secKey] ?? 0;
                                        $pct = round(($cnt / $allTot) * 100);
                                    @endphp
                                    <div class="bg-slate-950/80 border border-slate-800 rounded-xl p-2.5 space-y-1.5">
                                        <div class="flex items-center justify-between text-xs font-bold">
                                            <span class="text-slate-200">{{ $secTitle }}</span>
                                            <span class="text-amber-300 font-black">{{ $cnt }} visit. ({{ $pct }}%)</span>
                                        </div>
                                        <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-rose-600 via-orange-500 to-amber-400 rounded-full" style="width: {{ $pct }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-sm font-black uppercase tracking-wider text-amber-300">
                                🛒 Embudo Dentro del Formulario (Histórico)
                            </h3>
                            <div class="space-y-2">
                                @foreach($modalFunnelMap as $fKey => $fTitle)
                                    @php
                                        $fCnt = $allHeatmap['clicks'][$fKey] ?? 0;
                                    @endphp
                                    <div class="bg-slate-950/80 border border-amber-500/20 rounded-xl px-3 py-2 flex items-center justify-between text-xs">
                                        <span class="font-semibold text-slate-200">{{ $fTitle }}</span>
                                        <span class="font-black text-amber-400">{{ $fCnt }} usuarios</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION: ALL LEADS -->
                <section class="space-y-3">
                    <h2 class="text-lg font-black text-amber-400 flex items-center gap-2">
                        <span>🔥 Todos los Carritos Abandonados ({{ count($allLeads) }})</span>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($allLeads as $lead)
                            @include('partials.biolab_lead_card', ['lead' => $lead, 'bundleLabels' => $bundleLabels])
                        @endforeach
                    </div>
                </section>

                <!-- SECTION: ALL ORDERS -->
                <section class="space-y-3">
                    <h2 class="text-lg font-black text-emerald-400 flex items-center gap-2">
                        <span>✅ Todos los Pedidos Confirmados ({{ count($allOrders) }})</span>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($allOrders as $order)
                            @include('partials.biolab_order_card', ['order' => $order])
                        @endforeach
                    </div>
                </section>
            </div>
        </main>

        <script>
            function switchTab(mode) {
                const todayView = document.getElementById('view-today');
                const allView = document.getElementById('view-all');
                const btnToday = document.getElementById('tab-btn-today');
                const btnAll = document.getElementById('tab-btn-all');
                const indicator = document.getElementById('tab-indicator-text');

                if (mode === 'today') {
                    todayView.classList.remove('hidden');
                    allView.classList.add('hidden');
                    btnToday.className = 'px-4 py-2.5 rounded-xl font-black text-xs sm:text-sm transition flex items-center gap-2 bg-emerald-600 text-white shadow-lg cursor-pointer';
                    btnAll.className = 'px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition flex items-center gap-2 bg-slate-800 text-slate-300 hover:text-white cursor-pointer';
                    indicator.textContent = 'Mostrando métricas y pedidos de las últimas 24 horas';
                    localStorage.setItem('biolab_panel_tab', 'today');
                } else {
                    todayView.classList.add('hidden');
                    allView.classList.remove('hidden');
                    btnAll.className = 'px-4 py-2.5 rounded-xl font-black text-xs sm:text-sm transition flex items-center gap-2 bg-emerald-600 text-white shadow-lg cursor-pointer';
                    btnToday.className = 'px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition flex items-center gap-2 bg-slate-800 text-slate-300 hover:text-white cursor-pointer';
                    indicator.textContent = 'Mostrando histórico acumulado completo de todas las campañas';
                    localStorage.setItem('biolab_panel_tab', 'all');
                }
            }

            const BIOTAB_VAPID_KEY = @json($vapidPublicKey ?? '');
            const BIOLAB_PIN = '2026';
            let deferredInstallPrompt = null;
            let swRegistration = null;

            let knownOrderCount = {{ count($allOrders) }};
            let knownTopOrderCode = @json($allOrders[0]['order_code'] ?? '');
            let knownLeadCount = {{ count($allLeads) }};
            let knownTopLeadKey = @json(($allLeads[0]['customer_phone'] ?? '') . '|' . ($allLeads[0]['created_at'] ?? ''));

            function showPwaBanner(msg) {
                const banner = document.getElementById('pwa-status-banner');
                const text = document.getElementById('pwa-status-text');
                if (banner && text) {
                    text.textContent = msg;
                    banner.classList.remove('hidden');
                }
            }

            function playAlertChime() {
                // Sonido clásico "Cha-Ching" estilo caja registradora Shopify
                try {
                    const AudioCtx = window.AudioContext || window.webkitAudioContext;
                    if (!AudioCtx) return;
                    const ctx = new AudioCtx();
                    if (ctx.state === 'suspended') {
                        ctx.resume();
                    }
                    const now = ctx.currentTime;

                    // 1. "Cha-" (deslizamiento metálico de caja + moneda)
                    const bufferSize = Math.floor(ctx.sampleRate * 0.08);
                    const noiseBuffer = ctx.createBuffer(1, bufferSize, ctx.sampleRate);
                    const output = noiseBuffer.getChannelData(0);
                    for (let i = 0; i < bufferSize; i++) {
                        output[i] = (Math.random() * 2 - 1) * Math.exp(-i / (bufferSize * 0.35));
                    }
                    const noise = ctx.createBufferSource();
                    noise.buffer = noiseBuffer;
                    const filter = ctx.createBiquadFilter();
                    filter.type = 'bandpass';
                    filter.frequency.setValueAtTime(3400, now);
                    filter.Q.value = 2.2;
                    const noiseGain = ctx.createGain();
                    noiseGain.gain.setValueAtTime(0.28, now);
                    noiseGain.gain.exponentialRampToValueAtTime(0.001, now + 0.08);
                    noise.connect(filter);
                    filter.connect(noiseGain);
                    noiseGain.connect(ctx.destination);
                    noise.start(now);

                    // Pre-toque metálico corto (B5 -> E6)
                    const coin = ctx.createOscillator();
                    const coinGain = ctx.createGain();
                    coin.type = 'triangle';
                    coin.frequency.setValueAtTime(987.77, now);
                    coin.frequency.exponentialRampToValueAtTime(1318.51, now + 0.06);
                    coinGain.gain.setValueAtTime(0.16, now);
                    coinGain.gain.exponentialRampToValueAtTime(0.001, now + 0.09);
                    coin.connect(coinGain);
                    coinGain.connect(ctx.destination);
                    coin.start(now);
                    coin.stop(now + 0.095);

                    // 2. "-CHING!" (campana brillante de caja registradora)
                    const bellStart = now + 0.105;
                    const partials = [
                        { freq: 1318.51, gain: 0.24, dur: 0.85 }, // E6 fundamental
                        { freq: 1975.53, gain: 0.14, dur: 0.75 }, // B6 quinta brillante
                        { freq: 2637.02, gain: 0.16, dur: 0.65 }, // E7 octava
                        { freq: 3322.44, gain: 0.09, dur: 0.50 }, // G#7 brillo metálico
                        { freq: 4186.01, gain: 0.05, dur: 0.35 }, // C8 shimmer
                    ];
                    partials.forEach((p) => {
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(p.freq, bellStart);
                        gain.gain.setValueAtTime(0.001, bellStart);
                        gain.gain.exponentialRampToValueAtTime(p.gain, bellStart + 0.012);
                        gain.gain.exponentialRampToValueAtTime(0.0008, bellStart + p.dur);
                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        osc.start(bellStart);
                        osc.stop(bellStart + p.dur + 0.02);
                    });
                } catch (e) {}
                if (navigator.vibrate) {
                    navigator.vibrate([120, 60, 220]);
                }
            }

            function urlBase64ToUint8Array(base64String) {
                const padding = '='.repeat((4 - base64String.length % 4) % 4);
                const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
                const rawData = window.atob(base64);
                const outputArray = new Uint8Array(rawData.length);
                for (let i = 0; i < rawData.length; ++i) {
                    outputArray[i] = rawData.charCodeAt(i);
                }
                return outputArray;
            }

            function updatePushButtonUI(active) {
                const btn = document.getElementById('push-enable-btn');
                if (!btn) return;
                if (active) {
                    btn.textContent = '✅ Alertas Activas';
                    btn.className = 'px-3.5 py-2 rounded-xl bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 font-black text-xs transition';
                } else {
                    btn.textContent = '🔔 Activar Alertas';
                    btn.className = 'px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition shadow-lg shadow-amber-900/30';
                }
            }

            async function syncPushSubscription(reg) {
                if (!reg || !reg.pushManager || !BIOTAB_VAPID_KEY) return false;
                let sub = await reg.pushManager.getSubscription();
                if (!sub) {
                    sub = await reg.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: urlBase64ToUint8Array(BIOTAB_VAPID_KEY),
                    });
                }
                const res = await fetch('/biolab/push/subscribe', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ pin: BIOLAB_PIN, subscription: sub.toJSON() }),
                });
                return res.ok;
            }

            async function enableBiolabPush() {
                playAlertChime();
                const isIos = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
                const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;

                if (isIos && !isStandalone) {
                    showPwaBanner('📱 En iPhone: toca el botón Compartir (cuadro con flecha ↑) → "Agregar a inicio", abre la app desde tu pantalla y luego toca "🔔 Activar Alertas".');
                    return;
                }

                if (!('Notification' in window) || !('serviceWorker' in navigator) || !('PushManager' in window)) {
                    showPwaBanner('⚠️ Este navegador no soporta Push en segundo plano. Mantén el panel abierto para recibir alertas con sonido cada 15s.');
                    return;
                }

                try {
                    const permission = await Notification.requestPermission();
                    if (permission !== 'granted') {
                        showPwaBanner('🔕 Permiso de notificaciones denegado. Actívalo en Ajustes del navegador/sitio para recibir alertas.');
                        updatePushButtonUI(false);
                        return;
                    }
                    const reg = swRegistration || await navigator.serviceWorker.ready;
                    const ok = await syncPushSubscription(reg);
                    updatePushButtonUI(ok);
                    if (ok) {
                        showPwaBanner('✅ ¡Alertas Push activadas! Recibirás notificación por cada pedido y carrito abandonado incluso con la app cerrada.');
                    } else {
                        showPwaBanner('⚠️ No se pudo registrar el dispositivo en el servidor. Intenta recargar.');
                    }
                } catch (err) {
                    showPwaBanner('⚠️ Error activando alertas: ' + (err && err.message ? err.message : 'desconocido'));
                }
            }

            async function sendTestBiolabPush() {
                playAlertChime();
                try {
                    const res = await fetch('/biolab/push/test', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                        body: JSON.stringify({ pin: BIOLAB_PIN }),
                    });
                    const data = await res.json();
                    if (data.ok && data.result && data.result.sent > 0) {
                        showPwaBanner('⚡ Notificación de prueba enviada a ' + data.result.sent + ' dispositivo(s).');
                    } else {
                        showPwaBanner('⚠️ Aún no hay dispositivos suscritos. Toca primero "🔔 Activar Alertas".');
                    }
                } catch (e) {
                    showPwaBanner('⚠️ Error enviando prueba.');
                }
            }

            async function installPwaApp() {
                if (deferredInstallPrompt) {
                    deferredInstallPrompt.prompt();
                    await deferredInstallPrompt.userChoice;
                    deferredInstallPrompt = null;
                    document.getElementById('pwa-install-btn')?.classList.add('hidden');
                } else {
                    showPwaBanner('📲 En Android Chrome: menú ⋮ → "Instalar aplicación". En iPhone Safari: Compartir ↑ → "Agregar a inicio".');
                }
            }

            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredInstallPrompt = e;
                document.getElementById('pwa-install-btn')?.classList.remove('hidden');
            });

            async function pollBiolabUpdates() {
                try {
                    const res = await fetch('/biolab/pedidos?pin=' + BIOLAB_PIN + '&format=json', { cache: 'no-store' });
                    if (!res.ok) return;
                    const data = await res.json();
                    const newOrderCount = data.total_orders ?? knownOrderCount;
                    const newTopOrderCode = (data.orders && data.orders[0] && data.orders[0].order_code) ? data.orders[0].order_code : '';
                    const newLeadCount = data.total_abandoned_checkouts ?? knownLeadCount;
                    const topLead = (data.abandoned_checkouts && data.abandoned_checkouts[0]) ? data.abandoned_checkouts[0] : null;
                    const newTopLeadKey = topLead ? ((topLead.customer_phone || '') + '|' + (topLead.created_at || '')) : '';

                    const hasNewOrder = newOrderCount > knownOrderCount || (newTopOrderCode && newTopOrderCode !== knownTopOrderCode);
                    const hasNewLead = newLeadCount > knownLeadCount || (newTopLeadKey && newTopLeadKey !== knownTopLeadKey);

                    if (hasNewOrder || hasNewLead) {
                        playAlertChime();
                        setTimeout(() => window.location.reload(), 900);
                    }
                } catch (e) {}
            }

            // Restore last active tab & initialize PWA Service Worker on load
            document.addEventListener('DOMContentLoaded', async function() {
                const saved = localStorage.getItem('biolab_panel_tab');
                if (saved === 'all') {
                    switchTab('all');
                }

                const isIos = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
                const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
                if (isIos && !isStandalone) {
                    document.getElementById('pwa-install-btn')?.classList.remove('hidden');
                }

                if ('serviceWorker' in navigator) {
                    try {
                        swRegistration = await navigator.serviceWorker.register('/biolab-sw.js', { scope: '/biolab/' });
                        if ('Notification' in window && Notification.permission === 'granted') {
                            const ok = await syncPushSubscription(swRegistration);
                            updatePushButtonUI(ok);
                        }
                    } catch (e) {}
                }

                setInterval(pollBiolabUpdates, 15000);
            });
        </script>
    @endif
</body>
</html>
