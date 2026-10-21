<?php

namespace App\Http\Controllers;

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
        ];

        // 1. Guardar en registro persistente JSON, Cache y Log del sistema
        try {
            $existingOrders = Cache::get('biolab_orders_cache', []);
            if (empty($existingOrders) && Storage::disk('local')->exists('biolab_orders.json')) {
                $existingOrders = json_decode(Storage::disk('local')->get('biolab_orders.json'), true) ?? [];
            }
            array_unshift($existingOrders, $orderPayload);
            Storage::disk('local')->put('biolab_orders.json', json_encode($existingOrders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            Cache::forever('biolab_orders_cache', $existingOrders);
        } catch (\Throwable $e) {
            Log::warning('No se pudo escribir biolab_orders.json: ' . $e->getMessage());
        }

        Log::info("📦 [AVIPET BioLab] Nuevo Pedido Contraentrega {$orderCode}", $orderPayload);

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
        } catch (\Throwable $e) {
            Log::warning('No se pudo guardar lead BioLab: ' . $e->getMessage());
        }

        return response()->json(['saved' => true]);
    }

    /**
     * Panel rápido de consulta de pedidos registrados y carritos iniciados (protegido por PIN)
     */
    public function listOrders(Request $request)
    {
        if ($request->query('pin') !== '2026') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $orders = Cache::get('biolab_orders_cache', []);
        $leads = Cache::get('biolab_leads_cache', []);
        try {
            if (empty($orders) && Storage::disk('local')->exists('biolab_orders.json')) {
                $orders = json_decode(Storage::disk('local')->get('biolab_orders.json'), true) ?? [];
            }
            if (empty($leads) && Storage::disk('local')->exists('biolab_leads.json')) {
                $leads = json_decode(Storage::disk('local')->get('biolab_leads.json'), true) ?? [];
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return response()->json([
            'total_orders' => count($orders),
            'orders' => $orders,
            'total_abandoned_checkouts' => count($leads),
            'abandoned_checkouts' => $leads,
        ]);
    }
}
