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

    $adParam = $order['utm_content'] ?? $order['ad_name'] ?? $order['ad'] ?? '';
    $adsetParam = $order['utm_term'] ?? $order['adset_name'] ?? $order['adset'] ?? '';
    $campParam = $order['utm_campaign'] ?? $order['campaign_name'] ?? '';
    $srcParam = $order['utm_source'] ?? '';
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

            <!-- ORIGIN ATTRIBUTION -->
            <div class="pt-2 mt-2 border-t border-slate-800 flex flex-wrap items-center gap-1.5 text-[11px]">
                @if($adParam)
                    <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-2 py-0.5 rounded-md font-bold">
                        🎯 Anuncio: <strong>{{ $adParam }}</strong>
                    </span>
                @elseif($srcParam)
                    <span class="bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 px-2 py-0.5 rounded-md font-bold">
                        📢 Fuente: <strong>{{ $srcParam }}</strong>
                    </span>
                @else
                    <span class="bg-slate-800 text-slate-400 px-2 py-0.5 rounded-md font-semibold">
                        🌐 Tráfico Meta Ads / Directo
                    </span>
                @endif
                @if($adsetParam)
                    <span class="bg-indigo-500/20 text-indigo-200 px-2 py-0.5 rounded-md font-medium">
                        📂 {{ $adsetParam }}
                    </span>
                @endif
                @if($campParam)
                    <span class="text-slate-400 font-medium">
                        • {{ $campParam }}
                    </span>
                @endif
            </div>
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
