<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Panel de Pedidos y Carritos Abandonados — AVIPET BioLab®</title>
    @if($authorized)
    <meta http-equiv="refresh" content="25">
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

            // Restore last active tab on load
            document.addEventListener('DOMContentLoaded', function() {
                const saved = localStorage.getItem('biolab_panel_tab');
                if (saved === 'all') {
                    switchTab('all');
                }
            });
        </script>
    @endif
</body>
</html>
