<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
     */
    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'bundle_id' => 'required|string|in:1_bolsa,2_bolsas,3_bolsas',
            'customer_name' => 'required|string|max:120',
            'customer_phone' => 'required|string|max:40',
            'customer_email' => 'nullable|email|max:120',
            'department' => 'required|string|max:80',
            'city' => 'required|string|max:80',
            'address' => 'required|string|max:255',
            'neighborhood' => 'nullable|string|max:120',
            'pet_type' => 'nullable|string|max:40',
            'pet_name' => 'nullable|string|max:80',
            'pet_weight' => 'nullable|string|max:60',
            'payment_method' => 'nullable|string|max:60',
            'order_bump' => 'nullable|boolean',
            'notes' => 'nullable|string|max:500',
        ]);

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
                'savings' => '$14.900 COP adicionales ($62.450 c/u)',
            ],
            '3_bolsas' => [
                'title' => 'Tratamiento Completo 90 Días — 3 Bolsas (750g)',
                'bags' => 3,
                'grams' => '750g',
                'price' => 169900,
                'formatted_price' => '$169.900 COP',
                'savings' => '$39.800 COP ($56.633 c/u)',
            ],
        ];

        $selectedBundle = $bundles[$validated['bundle_id']] ?? $bundles['2_bolsas'];
        $orderCode = 'BIO-' . now()->format('ym') . '-' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
        $hasOrderBump = (bool) ($validated['order_bump'] ?? true);

        $orderPayload = [
            'order_code' => $orderCode,
            'created_at' => now()->toIso8601String(),
            'product' => 'AVIPET BioLab® — Dermo & Gut Superboost',
            'bundle_id' => $validated['bundle_id'],
            'bundle_title' => $selectedBundle['title'],
            'total_cop' => $selectedBundle['price'],
            'formatted_total' => $selectedBundle['formatted_price'],
            'order_bump_vip_guide' => $hasOrderBump,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
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
            'ip' => $request->ip(),
            'host' => $request->getHost(),
        ];

        // 1. Guardar en registro persistente JSON y Log del sistema
        try {
            $existingOrders = [];
            if (Storage::disk('local')->exists('biolab_orders.json')) {
                $existingOrders = json_decode(Storage::disk('local')->get('biolab_orders.json'), true) ?? [];
            }
            array_unshift($existingOrders, $orderPayload);
            Storage::disk('local')->put('biolab_orders.json', json_encode($existingOrders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } catch (\Throwable $e) {
            Log::warning('No se pudo escribir biolab_orders.json: ' . $e->getMessage());
        }

        Log::info("📦 [AVIPET BioLab] Nuevo Pedido Contraentrega {$orderCode}", $orderPayload);

        $guidePdfUrl = 'https://biolab.avipetapp.com/guias/guia-nutricion-clinica-hipoalergenica-avipet-biolab.pdf';

        // 2. Notificar por correo al equipo de despachos
        try {
            $notifyEmails = array_filter(array_map('trim', explode(',', env('ADMIN_NOTIFY_EMAILS', 'contacto@avipetapp.com'))));
            if (!empty($notifyEmails)) {
                $customerDigits = preg_replace('/\D+/', '', $orderPayload['customer_phone']);
                if (strlen($customerDigits) === 10) {
                    $customerDigits = '57' . $customerDigits;
                }
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
                    . "Bono Guía PDF + Despacho Prioritario: " . ($orderPayload['order_bump'] ? 'SÍ INCLUIDO (GRATIS)' : 'No seleccionado') . "\n"
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
            . "¡Quedo atento(a) a la guía de despacho y a mi Guía Clínica Hipoalergénica!";

        $whatsappUrl = 'https://wa.me/573235813942?text=' . rawurlencode($waMessage);

        return response()->json([
            'success' => true,
            'order_code' => $orderCode,
            'order' => $orderPayload,
            'whatsapp_url' => $whatsappUrl,
            'guide_pdf_url' => '/guias/guia-nutricion-clinica-hipoalergenica-avipet-biolab.pdf',
        ]);
    }
}
