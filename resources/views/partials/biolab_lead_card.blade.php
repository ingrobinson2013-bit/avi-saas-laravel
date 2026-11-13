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

    $adParam = $lead['utm_content'] ?? $lead['ad_name'] ?? $lead['ad'] ?? '';
    $adsetParam = $lead['utm_term'] ?? $lead['adset_name'] ?? $lead['adset'] ?? '';
    $campParam = $lead['utm_campaign'] ?? $lead['campaign_name'] ?? '';
    $srcParam = $lead['utm_source'] ?? '';
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
        href="{{ $waUrl }}"
        target="_blank"
        rel="noreferrer"
        class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-amber-500 to-emerald-600 hover:from-amber-400 hover:to-emerald-500 text-slate-950 font-black text-xs sm:text-sm text-center shadow-lg transition flex items-center justify-center gap-2"
    >
        <span>📲 RECUPERAR PEDIDO POR WHATSAPP (1 CLIC) →</span>
    </a>
</div>
