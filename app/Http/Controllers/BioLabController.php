<?php

namespace App\Http\Controllers;

use App\Services\WebPushService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BioLabController extends Controller
{
    /**
     * Renderiza la Tienda Oficial General (Flagship Storefront) en https://biolab.avipetapp.com
     */
    public function storeHome(Request $request)
    {
        return Inertia::render('BioLab/StoreHome', [
            'whatsappNumber' => '573235813942',
            'isSubdomain' => str_starts_with(strtolower($request->getHost()), 'biolab.'),
        ]);
    }

    /**
     * Renderiza la Product Page de alta conversión para AVIPET BioLab® — Dermo & Gut Superboost
     * en https://biolab.avipetapp.com/dermo-gut-superboost
     */
    public function show(Request $request)
    {
        return Inertia::render('BioLab/DermoGutSuperboost', [
            'whatsappNumber' => '573235813942',
            'canonicalUrl' => 'https://biolab.avipetapp.com/dermo-gut-superboost',
            'mainDomainUrl' => 'https://avipetapp.com/biolab/dermo-gut-superboost',
            'isSubdomain' => str_starts_with(strtolower($request->getHost()), 'biolab.'),
        ]);
    }

    /**
     * Registra un pedido Contraentrega (Pago en Casa) de AVIPET BioLab®
     * Incluye Escudo Anti-Bot de 5 Capas (Honeypot, Tiempo Mínimo, Lock Atómico, RateLimiter por IP/Teléfono y Validación Celular Colombia)
     */
    public function storeOrder(Request $request)
    {
        // CAPA 1: Honeypot Anti-Bot (campo oculto que los humanos nunca llenan)
        if ($request->filled('website_url')) {
            Log::warning('🤖 [Anti-Bot BioLab] Honeypot activado desde IP: ' . $request->ip());
            return response()->json([
                'success' => false,
                'message' => 'Solicitud bloqueada por el filtro de seguridad anti-bots.',
            ], 422);
        }

        // CAPA 2: Verificación de tiempo humano mínimo de llenado usando reloj consistente del cliente
        $elapsedMs = (int) $request->input('elapsed_ms', 5000);
        if ($elapsedMs > 0 && $elapsedMs < 1200) {
            Log::warning("🤖 [Anti-Bot BioLab] Envío demasiado rápido ({$elapsedMs}ms) desde IP: " . $request->ip());
            return response()->json([
                'success' => false,
                'message' => 'Por favor verifica tus datos antes de enviar el pedido.',
            ], 429);
        }

        $validated = $request->validate([
            'bundle_id' => 'required|string|in:1_bolsa,2_bolsas,3_bolsas',
            'customer_name' => 'required|string|min:2|max:120',
            'customer_phone' => 'required|string|max:40',
            'customer_email' => 'nullable|email|max:120',
            'department' => 'required|string|max:80',
            'city' => 'required|string|min:2|max:80',
            'address' => 'required|string|min:3|max:255',
            'neighborhood' => 'nullable|string|max:120',
            'pet_type' => 'nullable|string|max:40',
            'pet_name' => 'nullable|string|max:80',
            'pet_weight' => 'nullable|string|max:60',
            'payment_method' => 'nullable|string|max:60',
            'order_bump' => 'nullable|boolean',
            'notes' => 'nullable|string|max:500',
        ]);

        // CAPA 3: Validación estricta de número celular colombiano (10 dígitos iniciando en 3, sin dígitos repetidos falsos)
        $cleanPhone = preg_replace('/\D+/', '', $validated['customer_phone']);
        if (str_starts_with($cleanPhone, '57') && strlen($cleanPhone) === 12) {
            $cleanPhone = substr($cleanPhone, 2);
        }
        if (!preg_match('/^3\d{9}$/', $cleanPhone) || preg_match('/^3(\d)\1{8}$/', $cleanPhone)) {
            return response()->json([
                'success' => false,
                'message' => 'Por favor ingresa un número de celular / WhatsApp válido en Colombia (10 dígitos, ej: 300 123 4567).',
            ], 422);
        }

        $ip = $request->ip() ?: 'unknown';

        // CAPA 4: Candado Atómico (evita doble clic simultáneo o ráfagas paralelas de bots en el mismo segundo)
        $lockKey = 'biolab_cod_mutex_' . md5($ip . '_' . $cleanPhone);
        if (!Cache::add($lockKey, true, now()->addSeconds(12))) {
            return response()->json([
                'success' => false,
                'message' => 'Tu pedido ya se está procesando en este momento. Por favor espera unos segundos.',
            ], 429);
        }

        // CAPA 5: Protección contra pedidos duplicados por Teléfono o IP (Cooldown de 15 minutos por teléfono y máx 2 por hora por IP)
        $phoneCooldownKey = 'biolab_cod_phone_' . $cleanPhone;
        $ipRateKey = 'biolab_cod_ip_' . md5($ip);

        if (Cache::has($phoneCooldownKey)) {
            $prevCode = Cache::get($phoneCooldownKey);
            return response()->json([
                'success' => false,
                'message' => "🔒 Ya registramos tu pedido (#{$prevCode}) hace unos minutos. Nuestro equipo ya lo está alistando para despacho.",
            ], 429);
        }

        if (RateLimiter::tooManyAttempts($ipRateKey, 2)) {
            Log::warning("🛡️ [Anti-Bot BioLab] Rate limit por IP excedido ({$ip})");
            return response()->json([
                'success' => false,
                'message' => '🔒 Ya recibimos tu pedido desde esta conexión. Si deseas modificar tu orden, escríbenos directamente por WhatsApp.',
            ], 429);
        }

        RateLimiter::hit($ipRateKey, 3600); // ventana de 1 hora

        $bundles = [
            '1_bolsa' => [
                'title' => '1 Bolsa Dermo & Gut Superboost (250g)',
                'bags' => 1,
                'grams' => '250g',
                'price' => 69900,
                'formatted_price' => '$69.900 COP',
                'savings' => '$17.800 COP',
            ],
            '2_bolsas' => [
                'title' => 'Oferta Dúo Clínico — 2 Bolsas (500g)',
                'bags' => 2,
                'grams' => '500g',
                'price' => 124900,
                'formatted_price' => '$124.900 COP',
                'savings' => '$50.500 COP ($62.450 c/u)',
            ],
            '3_bolsas' => [
                'title' => 'Tratamiento Completo 90 Días — 3 Bolsas (750g)',
                'bags' => 3,
                'grams' => '750g',
                'price' => 169900,
                'formatted_price' => '$169.900 COP',
                'savings' => '$93.200 COP ($56.633 c/u)',
            ],
        ];

        $selectedBundle = $bundles[$validated['bundle_id']] ?? $bundles['2_bolsas'];
        $orderCode = 'BIO-' . now()->format('ym') . '-' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
        $hasOrderBump = (bool) ($validated['order_bump'] ?? true);

        // Registrar el bloqueo de 15 minutos para este celular para impedir duplicados
        Cache::put($phoneCooldownKey, $orderCode, now()->addMinutes(15));

        $orderPayload = [
            'order_code' => $orderCode,
            'created_at' => now()->toIso8601String(),
            'product' => 'AVIPET BioLab® — Dermo & Gut Superboost',
            'bundle_id' => $validated['bundle_id'],
            'bundle_title' => $selectedBundle['title'],
            'total_cop' => $selectedBundle['price'],
            'formatted_total' => $selectedBundle['formatted_price'],
            'order_bump' => $hasOrderBump,
            'order_bump_vip_guide' => $hasOrderBump,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $cleanPhone,
            'customer_email' => $validated['customer_email'] ?? null,
            'department' => $validated['department'],
            'city' => $validated['city'],
            'address' => $validated['address'],
            'neighborhood' => $validated['neighborhood'] ?? null,
            'pet_type' => $validated['pet_type'] ?? 'Perro / Gato',
            'pet_name' => $validated['pet_name'] ?? null,
            'pet_weight' => $validated['pet_weight'] ?? null,
            'payment_method' => $validated['payment_method'] ?? 'Contraentrega (Efectivo / Transferencia al recibir)',
            'notes' => $validated['notes'] ?? null,
            'ip' => $ip,
            'host' => $request->getHost(),
            'utm_source' => $request->input('utm_source'),
            'utm_medium' => $request->input('utm_medium'),
            'utm_campaign' => $request->input('utm_campaign') ?: $request->input('campaign_name'),
            'utm_content' => $request->input('utm_content') ?: ($request->input('ad_name') ?: $request->input('ad')),
            'utm_term' => $request->input('utm_term') ?: ($request->input('adset_name') ?: $request->input('adset')),
            'fbclid' => $request->input('fbclid'),
        ];

        // 1. Guardar en registro persistente JSON, Cache y Log del sistema (y limpiar de carritos abandonados si estaba allí)
        try {
            $existingOrders = Cache::get('biolab_orders_cache', []);
            if (empty($existingOrders) && Storage::disk('local')->exists('biolab_orders.json')) {
                $existingOrders = json_decode(Storage::disk('local')->get('biolab_orders.json'), true) ?? [];
            }
            array_unshift($existingOrders, $orderPayload);
            Storage::disk('local')->put('biolab_orders.json', json_encode($existingOrders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            Cache::forever('biolab_orders_cache', $existingOrders);

            // Si este celular estaba en carritos abandonados, removerlo porque ya compró
            $leads = Cache::get('biolab_leads_cache', []);
            if (empty($leads) && Storage::disk('local')->exists('biolab_leads.json')) {
                $leads = json_decode(Storage::disk('local')->get('biolab_leads.json'), true) ?? [];
            }
            if (!empty($leads)) {
                $leads = array_values(array_filter($leads, fn($l) => ($l['customer_phone'] ?? '') !== $cleanPhone));
                Storage::disk('local')->put('biolab_leads.json', json_encode($leads, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                Cache::forever('biolab_leads_cache', $leads);
            }
        } catch (\Throwable $e) {
            Log::warning('No se pudo escribir biolab_orders.json: ' . $e->getMessage());
        }

        Log::info("📦 [AVIPET BioLab] Nuevo Pedido Contraentrega {$orderCode}", $orderPayload);

        // 1.5 Notificación Push PWA en segundo plano a dispositivos suscritos
        try {
            $pushBody = "{$orderPayload['customer_name']} • {$orderPayload['formatted_total']} ({$orderPayload['city']}) — {$orderPayload['bundle_title']}";
            WebPushService::sendToAll([
                'title' => "🛒 ¡Nuevo Pedido {$orderCode}!",
                'body' => $pushBody,
                'url' => '/biolab/pedidos?pin=2026',
                'tag' => 'biolab-order-' . $orderCode,
                'icon' => '/brand/favicons/favicon-192.png',
                'requireInteraction' => true,
            ]);
        } catch (\Throwable $e) {
            Log::warning('WebPush storeOrder error: ' . $e->getMessage());
        }

        // 1.6 Meta Conversions API (CAPI) — respaldo server-side con event_id = order_code
        $this->sendMetaCapiPurchase($request, $orderPayload, (int) ($selectedBundle['bags'] ?? 1));

        $guidePdfUrl = 'https://biolab.avipetapp.com/guias/guia-nutricion-clinica-hipoalergenica-avipet-biolab.pdf';

        // 2. Notificar por correo al equipo de despachos
        try {
            $notifyEmails = array_filter(array_map('trim', explode(',', env('ADMIN_NOTIFY_EMAILS', 'contacto@avipetapp.com'))));
            if (!empty($notifyEmails)) {
                $customerDigits = '57' . $cleanPhone;
                $adminToCustomerWaText = "Hola *{$orderPayload['customer_name']}* 🐾 ¡Gracias por tu pedido en *AVIPET BioLab®*!\n\n"
                    . "✅ *Orden confirmada:* {$orderCode}\n"
                    . "📦 *Producto:* {$selectedBundle['title']}\n"
                    . "💰 *Total a pagar al recibir en casa:* {$selectedBundle['formatted_price']} (Envío Gratis)\n"
                    . "📍 *Dirección:* {$orderPayload['address']}, {$orderPayload['city']} ({$orderPayload['department']})\n\n"
                    . "🎁 *AQUÍ TIENES TU BONO VIP GRATIS (Guía Clínica de Nutrición Hipoalergénica en PDF):*\n"
                    . "{$guidePdfUrl}\n\n"
                    . "Por favor confírmanos con un *SÍ* para despachar tu paquete con prioridad hoy mismo. 🚚";
                $adminToCustomerWaUrl = "https://wa.me/{$customerDigits}?text=" . rawurlencode($adminToCustomerWaText);

                $mailBody = "🔬 NUEVO PEDIDO CONTRAENTREGA — AVIPET BioLab®\n"
                    . "================================================\n"
                    . "Código de Pedido: {$orderCode}\n"
                    . "Producto: AVIPET BioLab® — Dermo & Gut Superboost\n"
                    . "Presentación: {$selectedBundle['title']}\n"
                    . "Bono Guía PDF + Despacho Prioritario: " . ($hasOrderBump ? 'SÍ INCLUIDO (GRATIS)' : 'No seleccionado') . "\n"
                    . "Total a Cobrar en Casa: {$selectedBundle['formatted_price']} (Envío Gratis)\n"
                    . "Método al Recibir: {$orderPayload['payment_method']}\n\n"
                    . "👤 DATOS DE ENTREGA:\n"
                    . "• Cliente: {$orderPayload['customer_name']}\n"
                    . "• WhatsApp / Tel: {$orderPayload['customer_phone']}\n"
                    . "• Ciudad / Depto: {$orderPayload['city']} ({$orderPayload['department']})\n"
                    . "• Dirección: {$orderPayload['address']}" . ($orderPayload['neighborhood'] ? " — Barrio/Apto: {$orderPayload['neighborhood']}" : "") . "\n\n"
                    . "🐾 DATOS DEL PELUDO:\n"
                    . "• Especie: {$orderPayload['pet_type']}\n"
                    . "• Nombre: " . ($orderPayload['pet_name'] ?: 'No indicado') . "\n"
                    . "• Peso: " . ($orderPayload['pet_weight'] ?: 'No indicado') . "\n"
                    . "• Notas: " . ($orderPayload['notes'] ?: 'Ninguna') . "\n\n"
                    . "📲 ENVIAR CONFIRMACIÓN + GUÍA PDF AL WHATSAPP DEL CLIENTE (1 CLIC):\n"
                    . "{$adminToCustomerWaUrl}\n\n"
                    . "📄 URL Directa de la Guía PDF:\n"
                    . "{$guidePdfUrl}\n";

                Mail::raw($mailBody, function ($message) use ($notifyEmails, $orderCode, $selectedBundle, $orderPayload) {
                    $message->to($notifyEmails)
                        ->subject("🛒 Nuevo Pedido Contraentrega {$orderCode} ({$selectedBundle['formatted_price']}) - {$orderPayload['city']}");
                });
            }
        } catch (\Throwable $e) {
            Log::warning('Error enviando correo de pedido BioLab: ' . $e->getMessage());
        }

        // 3. Construir URL de confirmación rápida para WhatsApp
        $waMessage = "Hola *AVIPET BioLab®* 🔬🐾\n"
            . "Acabo de registrar mi pedido con *Pago Contraentrega + Envío Gratis*:\n\n"
            . "🧾 *Orden:* {$orderCode}\n"
            . "📦 *Kit elegido:* {$selectedBundle['title']}\n"
            . "💰 *Total a pagar al recibir:* {$selectedBundle['formatted_price']}\n\n"
            . "📍 *Datos de despacho:*\n"
            . "• *Nombre:* {$orderPayload['customer_name']}\n"
            . "• *Celular:* {$orderPayload['customer_phone']}\n"
            . "• *Ciudad:* {$orderPayload['city']}, {$orderPayload['department']}\n"
            . "• *Dirección:* {$orderPayload['address']}" . ($orderPayload['neighborhood'] ? " ({$orderPayload['neighborhood']})" : "") . "\n"
            . "• *Mascota:* {$orderPayload['pet_type']}" . ($orderPayload['pet_name'] ? " ({$orderPayload['pet_name']})" : "") . ($orderPayload['pet_weight'] ? " - {$orderPayload['pet_weight']}" : "") . "\n\n"
            . "🩺 ¡Quedo atento(a) a mi ingreso a la Comunidad VIP con la Médica Veterinaria, mi Guía Clínica en PDF y la guía de despacho!";

        $whatsappUrl = 'https://wa.me/573235813942?text=' . rawurlencode($waMessage);

        return response()->json([
            'success' => true,
            'order_code' => $orderCode,
            'order' => $orderPayload,
            'whatsapp_url' => $whatsappUrl,
            'guide_pdf_url' => '/guias/guia-nutricion-clinica-hipoalergenica-avipet-biolab.pdf',
        ]);
    }

    /**
     * Captura automática de carrito iniciado (cuando el usuario escribe su WhatsApp en el modal)
     * para recuperar el pedido si cierra la ventana antes de terminar la dirección
     */
    public function captureLead(Request $request)
    {
        $rawPhone = (string) $request->input('customer_phone', '');
        $cleanPhone = preg_replace('/\D+/', '', $rawPhone);
        if (str_starts_with($cleanPhone, '57') && strlen($cleanPhone) === 12) {
            $cleanPhone = substr($cleanPhone, 2);
        }

        if (!preg_match('/^3\d{9}$/', $cleanPhone)) {
            return response()->json(['saved' => false]);
        }

        $leadPayload = [
            'created_at' => now()->toIso8601String(),
            'customer_phone' => $cleanPhone,
            'customer_name' => trim((string) $request->input('customer_name', '')),
            'bundle_id' => (string) $request->input('bundle_id', '1_bolsa'),
            'department' => trim((string) $request->input('department', '')),
            'city' => trim((string) $request->input('city', '')),
            'address' => trim((string) $request->input('address', '')),
            'utm_source' => $request->input('utm_source'),
            'utm_medium' => $request->input('utm_medium'),
            'utm_campaign' => $request->input('utm_campaign') ?: $request->input('campaign_name'),
            'utm_content' => $request->input('utm_content') ?: ($request->input('ad_name') ?: $request->input('ad')),
            'utm_term' => $request->input('utm_term') ?: ($request->input('adset_name') ?: $request->input('adset')),
            'fbclid' => $request->input('fbclid'),
            'whatsapp_recovery_url' => 'https://wa.me/57' . $cleanPhone . '?text=' . rawurlencode(
                "Hola 🐾 Vimos que estabas pidiendo tu *DERMO & GUT SUPERBOOST®* de *AVIPET BioLab®* con Envío Gratis y Pago Contraentrega. ¿Te ayudo por aquí a confirmar tu dirección de entrega?"
            ),
        ];

        try {
            $leads = Cache::get('biolab_leads_cache', []);
            if (empty($leads) && Storage::disk('local')->exists('biolab_leads.json')) {
                $leads = json_decode(Storage::disk('local')->get('biolab_leads.json'), true) ?? [];
            }
            // Actualizar si ya existe el mismo teléfono o insertar al inicio
            $leads = array_values(array_filter($leads, fn($l) => ($l['customer_phone'] ?? '') !== $cleanPhone));
            array_unshift($leads, $leadPayload);
            $leads = array_slice($leads, 0, 200);
            Storage::disk('local')->put('biolab_leads.json', json_encode($leads, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            Cache::forever('biolab_leads_cache', $leads);

            // Notificar máximo 1 vez cada 10 minutos por celular para no hacer spam mientras escribe
            if (Cache::add("biolab_lead_pushed_{$cleanPhone}", true, now()->addMinutes(10))) {
                $leadName = $leadPayload['customer_name'] !== '' ? $leadPayload['customer_name'] : 'Cliente sin nombre';
                $leadCity = $leadPayload['city'] !== '' ? " ({$leadPayload['city']})" : '';
                WebPushService::sendToAll([
                    'title' => '⚠️ Carrito Abandonado — AVIPET BioLab',
                    'body' => "{$leadName}{$leadCity} • Cel: {$cleanPhone}. ¡Toca para recuperar por WhatsApp!",
                    'url' => '/biolab/pedidos?pin=2026',
                    'tag' => 'biolab-lead-' . $cleanPhone,
                    'icon' => '/brand/favicons/favicon-192.png',
                    'requireInteraction' => true,
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning('No se pudo guardar lead BioLab: ' . $e->getMessage());
        }

        return response()->json(['saved' => true]);
    }

    /**
     * Telemetría ultraligera de Mapa de Calor (Scroll por sección, Clics y Embudo del Modal)
     */
    public function trackTelemetry(Request $request)
    {
        $sessionId = substr(preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $request->input('session_id', '')), 0, 64);
        if (empty($sessionId)) {
            return response()->json(['ok' => false]);
        }

        $maxScroll = max(0, min(100, (int) $request->input('max_scroll_pct', 0)));
        $sections = array_values(array_unique(array_filter((array) $request->input('sections', []), 'is_string')));
        $clicks = array_values(array_unique(array_filter((array) $request->input('clicks', []), 'is_string')));

        try {
            $sessions = Cache::get('biolab_telemetry_sessions', []);
            if (empty($sessions) && Storage::disk('local')->exists('biolab_telemetry.json')) {
                $sessions = json_decode(Storage::disk('local')->get('biolab_telemetry.json'), true) ?? [];
            }

            $existing = $sessions[$sessionId] ?? [
                'first_seen' => now()->toIso8601String(),
                'max_scroll_pct' => 0,
                'sections' => ['hero_gallery'],
                'clicks' => [],
            ];

            $existing['last_seen'] = now()->toIso8601String();
            $existing['max_scroll_pct'] = max((int) ($existing['max_scroll_pct'] ?? 0), $maxScroll);
            $existing['sections'] = array_values(array_unique(array_merge($existing['sections'] ?? [], $sections, ['hero_gallery'])));
            $existing['clicks'] = array_values(array_unique(array_merge($existing['clicks'] ?? [], $clicks)));
            $attr = (array) $request->input('attribution', []);
            if (!empty($attr)) {
                $existing['attribution'] = array_merge($existing['attribution'] ?? [], $attr);
            }

            $sessions[$sessionId] = $existing;
            if (count($sessions) > 500) {
                $sessions = array_slice($sessions, -500, 500, true);
            }

            Cache::forever('biolab_telemetry_sessions', $sessions);
            Storage::disk('local')->put('biolab_telemetry.json', json_encode($sessions));
        } catch (\Throwable $e) {
            // ignore telemetry errors
        }

        return response()->json(['ok' => true]);
    }

    /**
     * Panel visual en vivo de pedidos registrados, carritos iniciados y mapa de calor (protegido por PIN)
     */
    public function listOrders(Request $request)
    {
        $authorized = $request->query('pin') === '2026';

        $orders = [];
        $leads = [];
        $heatmap = [
            'total_sessions' => 0,
            'active_now' => 0,
            'avg_scroll_pct' => 0,
            'sections' => [],
            'clicks' => [],
            'modal_funnel' => [],
        ];

        if ($authorized) {
            $orders = Cache::get('biolab_orders_cache', []);
            $leads = Cache::get('biolab_leads_cache', []);
            $sessions = Cache::get('biolab_telemetry_sessions', []);
            try {
                if (empty($orders) && Storage::disk('local')->exists('biolab_orders.json')) {
                    $orders = json_decode(Storage::disk('local')->get('biolab_orders.json'), true) ?? [];
                }
                if (empty($leads) && Storage::disk('local')->exists('biolab_leads.json')) {
                    $leads = json_decode(Storage::disk('local')->get('biolab_leads.json'), true) ?? [];
                }
                if (empty($sessions) && Storage::disk('local')->exists('biolab_telemetry.json')) {
                    $sessions = json_decode(Storage::disk('local')->get('biolab_telemetry.json'), true) ?? [];
                }
            } catch (\Throwable $e) {
                // ignore
            }

            $bogotaNow = now('America/Bogota');
            $todayStartTs = $bogotaNow->copy()->startOfDay()->timestamp;
            $tenMinsAgo = now()->subMinutes(10)->timestamp;

            $aggregateHeatmap = function (array $sessionsList) use ($tenMinsAgo) {
                $totalSessions = count($sessionsList);
                $activeNow = 0;
                $scrollSum = 0;
                $sectionCounts = [
                    'hero_gallery' => 0,
                    'plan_selector' => 0,
                    'demo_gif' => 0,
                    'problem_agitation' => 0,
                    'formula_ingredients' => 0,
                    'dosage_calculator' => 0,
                    'reviews_social' => 0,
                    'faq_guarantee' => 0,
                ];
                $clickCounts = [
                    'thumb_gallery' => 0,
                    'pkg_1_bolsa' => 0,
                    'pkg_2_bolsas' => 0,
                    'pkg_3_bolsas' => 0,
                    'cta_open_modal' => 0,
                    'modal_focus_phone' => 0,
                    'modal_focus_name' => 0,
                    'modal_focus_dept_city' => 0,
                    'modal_focus_address' => 0,
                    'modal_click_whatsapp' => 0,
                    'modal_submit_attempt' => 0,
                ];

                foreach ($sessionsList as $s) {
                    $scrollSum += (int) ($s['max_scroll_pct'] ?? 0);
                    if (!empty($s['last_seen']) && strtotime($s['last_seen']) >= $tenMinsAgo) {
                        $activeNow++;
                    }
                    foreach (($s['sections'] ?? []) as $sec) {
                        if (isset($sectionCounts[$sec])) {
                            $sectionCounts[$sec]++;
                        }
                    }
                    foreach (($s['clicks'] ?? []) as $clk) {
                        if (isset($clickCounts[$clk])) {
                            $clickCounts[$clk]++;
                        }
                    }
                }

                return [
                    'total_sessions' => $totalSessions,
                    'active_now' => $activeNow,
                    'avg_scroll_pct' => $totalSessions > 0 ? round($scrollSum / $totalSessions) : 0,
                    'sections' => $sectionCounts,
                    'clicks' => $clickCounts,
                ];
            };

            $todaySessions = array_filter($sessions, function($s) use ($todayStartTs) {
                $seen = !empty($s['last_seen']) ? strtotime($s['last_seen']) : (!empty($s['first_seen']) ? strtotime($s['first_seen']) : 0);
                return $seen >= $todayStartTs;
            });

            $todayOrders = array_values(array_filter($orders, function($o) use ($todayStartTs) {
                return !empty($o['created_at']) && strtotime($o['created_at']) >= $todayStartTs;
            }));

            $todayLeads = array_values(array_filter($leads, function($l) use ($todayStartTs) {
                return !empty($l['created_at']) && strtotime($l['created_at']) >= $todayStartTs;
            }));

            $allHeatmap = $aggregateHeatmap($sessions);
            $todayHeatmap = $aggregateHeatmap($todaySessions);
            $heatmap = $todayHeatmap; // default
        }

        if ($request->query('format') === 'json') {
            if (!$authorized) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return response()->json([
                'today_orders' => count($todayOrders ?? []),
                'total_orders' => count($orders),
                'orders' => $orders,
                'today_abandoned_checkouts' => count($todayLeads ?? []),
                'total_abandoned_checkouts' => count($leads),
                'abandoned_checkouts' => $leads,
                'today_heatmap' => $todayHeatmap ?? [],
                'all_heatmap' => $allHeatmap ?? [],
            ]);
        }

        $vapidPublicKey = null;
        if ($authorized) {
            try {
                $vapidPublicKey = WebPushService::getVapidKeys()['publicKey'] ?? null;
            } catch (\Throwable $e) {
                Log::warning('VAPID key init error: ' . $e->getMessage());
            }
        }

        return view('biolab_orders_panel', [
            'authorized' => $authorized,
            'todayOrders' => $todayOrders ?? [],
            'allOrders' => $orders,
            'todayLeads' => $todayLeads ?? [],
            'allLeads' => $leads,
            'todayHeatmap' => $todayHeatmap ?? [],
            'allHeatmap' => $allHeatmap ?? [],
            'todayDate' => isset($bogotaNow) ? $bogotaNow->format('d/m/Y') : now()->format('d/m/Y'),
            'vapidPublicKey' => $vapidPublicKey,
        ]);
    }

    /**
     * Web App Manifest para instalar el Panel de Pedidos BioLab como PWA móvil
     */
    public function manifest()
    {
        return response()->json([
            'id' => '/biolab/pedidos?pin=2026',
            'name' => 'AVIPET BioLab® Pedidos',
            'short_name' => 'BioLab Pedidos',
            'description' => 'Panel de pedidos contraentrega y carritos abandonados en tiempo real.',
            'start_url' => '/biolab/pedidos?pin=2026',
            'scope' => '/biolab/',
            'display' => 'standalone',
            'orientation' => 'portrait',
            'background_color' => '#020617',
            'theme_color' => '#059669',
            'icons' => [
                [
                    'src' => '/brand/favicons/favicon-192.png',
                    'sizes' => '192x192',
                    'type' => 'image/png',
                    'purpose' => 'any maskable',
                ],
                [
                    'src' => '/brand/favicons/favicon-512.png',
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'any maskable',
                ],
            ],
        ], 200, [
            'Content-Type' => 'application/manifest+json; charset=utf-8',
        ]);
    }

    /**
     * Guarda la suscripción Web Push (VAPID) de un celular/navegador autorizado
     */
    public function subscribePush(Request $request)
    {
        if ((string) $request->input('pin', '') !== '2026') {
            return response()->json(['ok' => false, 'error' => 'PIN inválido'], 401);
        }

        $subscription = $request->input('subscription');
        if (!is_array($subscription) || empty($subscription['endpoint']) || empty($subscription['keys']['p256dh']) || empty($subscription['keys']['auth'])) {
            return response()->json(['ok' => false, 'error' => 'Suscripción inválida'], 422);
        }

        $subscription['user_agent'] = substr((string) $request->userAgent(), 0, 180);
        WebPushService::saveSubscription($subscription);

        return response()->json(['ok' => true]);
    }

    /**
     * Envía una notificación push de prueba a todos los dispositivos suscritos
     */
    public function testPush(Request $request)
    {
        if ((string) $request->input('pin', '') !== '2026') {
            return response()->json(['ok' => false, 'error' => 'PIN inválido'], 401);
        }

        $result = WebPushService::sendToAll([
            'title' => '🔔 Prueba AVIPET BioLab®',
            'body' => '¡Listo! Recibirás alertas así por cada pedido y carrito abandonado.',
            'url' => '/biolab/pedidos?pin=2026',
            'tag' => 'biolab-test-' . time(),
            'icon' => '/brand/favicons/favicon-192.png',
            'requireInteraction' => false,
        ]);

        return response()->json(['ok' => true, 'result' => $result]);
    }

    /**
     * Envía el evento Purchase a Meta Conversions API (CAPI) con deduplicación por order_code
     */
    private function sendMetaCapiPurchase(Request $request, array $orderPayload, int $numItems = 1): void
    {
        $pixelId = config('services.meta.pixel_id');
        $capiToken = config('services.meta.capi_token');
        if (empty($pixelId) || empty($capiToken)) {
            return;
        }

        try {
            $realIp = $request->header('CF-Connecting-IP')
                ?: trim(explode(',', (string) $request->header('X-Forwarded-For'))[0])
                ?: $request->ip();

            $fbc = $request->input('fbc') ?: $request->cookie('_fbc');
            if (empty($fbc) && !empty($orderPayload['fbclid'])) {
                $fbc = 'fb.1.' . (int) (microtime(true) * 1000) . '.' . $orderPayload['fbclid'];
            }
            $fbp = $request->input('fbp') ?: $request->cookie('_fbp');

            $normalizeHash = fn (?string $val) => $val !== null && trim($val) !== ''
                ? hash('sha256', mb_strtolower(trim($val), 'UTF-8'))
                : null;

            $firstName = trim(explode(' ', (string) ($orderPayload['customer_name'] ?? ''))[0] ?? '');
            $phoneDigits = '57' . preg_replace('/\D+/', '', (string) ($orderPayload['customer_phone'] ?? ''));

            $userData = array_filter([
                'ph' => [$normalizeHash($phoneDigits)],
                'fn' => $firstName !== '' ? [$normalizeHash($firstName)] : null,
                'ct' => $normalizeHash($orderPayload['city'] ?? null) ? [$normalizeHash($orderPayload['city'])] : null,
                'st' => $normalizeHash($orderPayload['department'] ?? null) ? [$normalizeHash($orderPayload['department'])] : null,
                'country' => [hash('sha256', 'co')],
                'client_ip_address' => $realIp ?: null,
                'client_user_agent' => $request->userAgent() ?: null,
                'fbc' => $fbc ?: null,
                'fbp' => $fbp ?: null,
            ], fn ($v) => $v !== null);

            $eventData = [
                'event_name' => 'Purchase',
                'event_time' => time(),
                'event_id' => $orderPayload['order_code'],
                'action_source' => 'website',
                'event_source_url' => 'https://biolab.avipetapp.com/dermo-gut-superboost',
                'user_data' => $userData,
                'custom_data' => [
                    'currency' => 'COP',
                    'value' => (float) ($orderPayload['total_cop'] ?? 69900),
                    'order_id' => $orderPayload['order_code'],
                    'content_ids' => [$orderPayload['bundle_id'] ?? '1_bolsa'],
                    'content_type' => 'product',
                    'num_items' => max(1, $numItems),
                ],
            ];

            $body = ['data' => [$eventData]];
            $testCode = config('services.meta.test_event_code');
            if (!empty($testCode)) {
                $body['test_event_code'] = $testCode;
            }

            $client = new \GuzzleHttp\Client(['timeout' => 5.0]);
            $res = $client->post("https://graph.facebook.com/v21.0/{$pixelId}/events?access_token=" . urlencode($capiToken), [
                'json' => $body,
            ]);
            Cache::forever('biolab_last_capi_result', [
                'at' => now()->toIso8601String(),
                'order_code' => $orderPayload['order_code'] ?? null,
                'status' => $res->getStatusCode(),
                'body' => json_decode((string) $res->getBody(), true),
            ]);
        } catch (\Throwable $e) {
            Cache::forever('biolab_last_capi_result', [
                'at' => now()->toIso8601String(),
                'order_code' => $orderPayload['order_code'] ?? null,
                'error' => $e->getMessage(),
            ]);
            Log::warning('Meta CAPI Purchase error: ' . $e->getMessage());
        }
    }

    /**
     * Diagnóstico de configuración y último envío a Meta CAPI
     */
    public function capiStatus(Request $request)
    {
        if ((string) $request->query('pin', '') !== '2026') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = (string) config('services.meta.capi_token', '');
        return response()->json([
            'pixel_id' => config('services.meta.pixel_id'),
            'has_capi_token' => $token !== '',
            'token_prefix' => $token !== '' ? substr($token, 0, 8) . '...' : null,
            'last_capi_result' => Cache::get('biolab_last_capi_result'),
        ]);
    }

    /**
     * Envía un evento de prueba Purchase a Meta CAPI (requiere test_event_code de Meta "Probar eventos")
     */
    public function testCapi(Request $request)
    {
        if ((string) $request->input('pin', '') !== '2026') {
            return response()->json(['ok' => false, 'error' => 'PIN inválido'], 401);
        }

        $pixelId = config('services.meta.pixel_id');
        $capiToken = config('services.meta.capi_token');
        if (empty($pixelId) || empty($capiToken)) {
            return response()->json(['ok' => false, 'error' => 'Falta META_CAPI_ACCESS_TOKEN en Easypanel'], 422);
        }

        $testCode = trim((string) $request->input('test_event_code', ''));
        $body = [
            'data' => [[
                'event_name' => 'Purchase',
                'event_time' => time(),
                'event_id' => 'TEST-' . time(),
                'action_source' => 'website',
                'event_source_url' => 'https://biolab.avipetapp.com/dermo-gut-superboost',
                'user_data' => [
                    'ph' => [hash('sha256', '573001234567')],
                    'country' => [hash('sha256', 'co')],
                    'client_ip_address' => $request->header('CF-Connecting-IP') ?: $request->ip(),
                    'client_user_agent' => $request->userAgent() ?: 'Mozilla/5.0',
                ],
                'custom_data' => [
                    'currency' => 'COP',
                    'value' => 69900,
                    'order_id' => 'TEST-' . time(),
                    'content_ids' => ['1_bolsa'],
                    'content_type' => 'product',
                    'num_items' => 1,
                ],
            ]],
        ];
        if ($testCode !== '') {
            $body['test_event_code'] = $testCode;
        }

        try {
            $client = new \GuzzleHttp\Client(['timeout' => 8.0, 'http_errors' => false]);
            $res = $client->post("https://graph.facebook.com/v21.0/{$pixelId}/events?access_token=" . urlencode($capiToken), [
                'json' => $body,
            ]);
            return response()->json([
                'ok' => $res->getStatusCode() >= 200 && $res->getStatusCode() < 300,
                'status' => $res->getStatusCode(),
                'meta_response' => json_decode((string) $res->getBody(), true),
            ]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Reenvía una orden existente (por order_code) a Meta Conversions API (CAPI)
     */
    public function resendOrderCapi(Request $request)
    {
        if ((string) $request->input('pin', '') !== '2026') {
            return response()->json(['ok' => false, 'error' => 'PIN inválido'], 401);
        }

        $orderCode = trim((string) $request->input('order_code', ''));
        if ($orderCode === '') {
            return response()->json(['ok' => false, 'error' => 'Falta order_code'], 422);
        }

        $pixelId = config('services.meta.pixel_id');
        $capiToken = config('services.meta.capi_token');
        if (empty($pixelId) || empty($capiToken)) {
            return response()->json(['ok' => false, 'error' => 'Falta META_CAPI_ACCESS_TOKEN'], 422);
        }

        $orders = Cache::get('biolab_orders_cache', []);
        if (empty($orders) && Storage::disk('local')->exists('biolab_orders.json')) {
            $orders = json_decode(Storage::disk('local')->get('biolab_orders.json'), true) ?? [];
        }

        $order = null;
        foreach ($orders as $o) {
            if (($o['order_code'] ?? '') === $orderCode) {
                $order = $o;
                break;
            }
        }

        if (!$order) {
            return response()->json(['ok' => false, 'error' => 'Orden no encontrada'], 404);
        }

        $normalizeHash = fn (?string $val) => $val !== null && trim($val) !== ''
            ? hash('sha256', mb_strtolower(trim($val), 'UTF-8'))
            : null;

        $eventTs = !empty($order['created_at']) ? strtotime($order['created_at']) : time();
        if (!$eventTs || (time() - $eventTs) > 6 * 86400) {
            $eventTs = time();
        }

        $fbc = !empty($order['fbclid']) ? ('fb.1.' . ($eventTs * 1000) . '.' . $order['fbclid']) : null;
        $firstName = trim(explode(' ', (string) ($order['customer_name'] ?? ''))[0] ?? '');
        $phoneDigits = '57' . preg_replace('/\D+/', '', (string) ($order['customer_phone'] ?? ''));

        $userData = array_filter([
            'ph' => [$normalizeHash($phoneDigits)],
            'fn' => $firstName !== '' ? [$normalizeHash($firstName)] : null,
            'ct' => $normalizeHash($order['city'] ?? null) ? [$normalizeHash($order['city'])] : null,
            'st' => $normalizeHash($order['department'] ?? null) ? [$normalizeHash($order['department'])] : null,
            'country' => [hash('sha256', 'co')],
            'client_ip_address' => $order['ip'] ?? null,
            'fbc' => $fbc,
        ], fn ($v) => $v !== null);

        $bags = ($order['bundle_id'] ?? '') === '3_bolsas' ? 3 : (($order['bundle_id'] ?? '') === '2_bolsas' ? 2 : 1);
        $body = [
            'data' => [[
                'event_name' => 'Purchase',
                'event_time' => $eventTs,
                'event_id' => $order['order_code'],
                'action_source' => 'website',
                'event_source_url' => 'https://biolab.avipetapp.com/dermo-gut-superboost',
                'user_data' => $userData,
                'custom_data' => [
                    'currency' => 'COP',
                    'value' => (float) ($order['total_cop'] ?? 69900),
                    'order_id' => $order['order_code'],
                    'content_ids' => [$order['bundle_id'] ?? '1_bolsa'],
                    'content_type' => 'product',
                    'num_items' => $bags,
                ],
            ]],
        ];

        try {
            $client = new \GuzzleHttp\Client(['timeout' => 8.0, 'http_errors' => false]);
            $res = $client->post("https://graph.facebook.com/v21.0/{$pixelId}/events?access_token=" . urlencode($capiToken), [
                'json' => $body,
            ]);
            $decoded = json_decode((string) $res->getBody(), true);
            Cache::forever('biolab_last_capi_result', [
                'at' => now()->toIso8601String(),
                'order_code' => $order['order_code'],
                'status' => $res->getStatusCode(),
                'body' => $decoded,
                'resent' => true,
            ]);

            return response()->json([
                'ok' => $res->getStatusCode() >= 200 && $res->getStatusCode() < 300,
                'status' => $res->getStatusCode(),
                'meta_response' => $decoded,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
