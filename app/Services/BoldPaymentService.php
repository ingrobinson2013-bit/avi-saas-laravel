<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BoldPaymentService
{
    /**
     * Genera la firma de integridad SHA256 requerida por Bold.
     */
    public static function generateSignature(string $orderId, float|int $amount, string $currency, ?string $secretKey = null): string
    {
        $key = !empty($secretKey) ? $secretKey : (config('bold.secret_key') ?: 'sandbox_secret_key');
        $amountClean = (int) round($amount);
        $raw = "{$orderId}{$amountClean}{$currency}{$key}";
        return hash('sha256', $raw);
    }

    /**
     * Crea un link de pago dinámico en Bold o genera el fallback al link oficial.
     */
    public function createPaymentLink(
        string $orderId,
        float|int $amount,
        string $description,
        array $payer,
        string $redirectUrl,
        ?Tenant $tenant = null
    ): array {
        $apiKey = $tenant->branding['bold_api_key'] ?? config('bold.api_key');
        $secretKey = $tenant->branding['bold_secret_key'] ?? config('bold.secret_key');
        $apiUrl = config('bold.api_url', 'https://integrations.api.bold.co/online/link/v1');
        $currency = 'COP';
        $amountInt = (int) round($amount);

        // Si existen credenciales de API de Bold, llamar al endpoint oficial de checkout
        if (!empty($apiKey) && !empty($secretKey)) {
            try {
                $integritySignature = self::generateSignature($orderId, $amountInt, $currency, $secretKey);
                $webhookUrl = url('/api/webhooks/bold');

                $payload = [
                    'amount' => $amountInt,
                    'currency' => $currency,
                    'order_id' => $orderId,
                    'description' => substr($description, 0, 100),
                    'tax' => 0,
                    'integrity_signature' => $integritySignature,
                    'redirect_url' => $redirectUrl,
                    'callback_url' => $webhookUrl,
                    'payer' => [
                        'email' => $payer['email'] ?? 'tutor@mascota.com',
                        'name' => $payer['name'] ?? 'Tutor Mascota',
                        'phone' => preg_replace('/[^0-9]/', '', $payer['phone'] ?? '3000000000'),
                    ],
                ];

                $response = Http::timeout(10)
                    ->withHeaders([
                        'x-api-key' => $apiKey,
                        'Content-Type' => 'application/json',
                    ])
                    ->post($apiUrl, $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    $paymentUrl = $data['payload']['url'] ?? $data['url'] ?? $data['payment_url'] ?? null;
                    if ($paymentUrl) {
                        return [
                            'success' => true,
                            'payment_url' => $paymentUrl,
                            'source' => 'bold_api',
                            'data' => $data,
                        ];
                    }
                }

                Log::warning('Bold API Link generation returned non-success:', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            } catch (\Throwable $e) {
                Log::error('Error connecting to Bold API: ' . $e->getMessage());
            }
        }

        // 0. Si la veterinaria configuró su Llave Pública de Wompi (Multi-Tenant Wompi Web Checkout)
        $wompiPublicKey = trim($tenant?->branding['wompi_public_key'] ?? '');
        $wompiIntegritySecret = trim($tenant?->branding['wompi_integrity_secret'] ?? '');
        if (!empty($wompiPublicKey) && str_starts_with($wompiPublicKey, 'pub_')) {
            $amountInCents = $amountInt * 100;
            $params = [
                'public-key' => $wompiPublicKey,
                'currency' => $currency,
                'amount-in-cents' => $amountInCents,
                'reference' => $orderId,
                'redirect-url' => $redirectUrl,
            ];
            if (!empty($wompiIntegritySecret)) {
                $params['signature:integrity'] = hash('sha256', "{$orderId}{$amountInCents}{$currency}{$wompiIntegritySecret}");
            }
            if (!empty($payer['email'])) {
                $params['customer-data:email'] = $payer['email'];
            }
            if (!empty($payer['name'])) {
                $params['customer-data:full-name'] = $payer['name'];
            }
            if (!empty($payer['phone'])) {
                $params['customer-data:phone-number'] = preg_replace('/[^0-9]/', '', $payer['phone']);
                $params['customer-data:phone-number-prefix'] = '+57';
            }

            return [
                'success' => true,
                'payment_url' => 'https://checkout.wompi.co/p/?' . http_build_query($params),
                'source' => 'wompi_checkout',
            ];
        }

        // Fallback a Smart Link / Link de Cobro de Bold o Wompi configurado
        $fallbackLink = $tenant->branding['payment_bold_link'] ?? config('bold.default_payment_link');

        if (!empty($fallbackLink)) {
            return [
                'success' => true,
                'payment_url' => $fallbackLink,
                'source' => 'bold_smart_link',
            ];
        }

        return [
            'success' => false,
            'payment_url' => null,
            'error' => 'No se configuró link o API Key de Bold / Wompi.',
        ];
    }

    /**
     * Valida la firma de integridad de un Webhook recibido de Bold.
     */
    public function verifyWebhook(array $payload, ?string $secretKey = null): bool
    {
        $secret = $secretKey ?: config('bold.secret_key');
        if (empty($secret)) return true;

        $receivedHash = $payload['integrity_signature'] ?? $payload['signature'] ?? null;
        $orderId = $payload['order_id'] ?? $payload['reference'] ?? null;
        $amount = $payload['amount'] ?? 0;
        $currency = $payload['currency'] ?? 'COP';

        if (!$receivedHash || !$orderId) {
            return false;
        }

        $calculatedHash = self::generateSignature($orderId, $amount, $currency, $secret);
        return hash_equals($calculatedHash, $receivedHash);
    }

    /**
     * Valida el checksum de un evento Webhook de Wompi (transaction.updated).
     */
    public function verifyWompiWebhook(array $payload, ?string $eventsSecret = null, ?string $headerChecksum = null): bool
    {
        if (empty($eventsSecret)) {
            return true;
        }

        $tx = $payload['data']['transaction'] ?? [];
        $txId = $tx['id'] ?? '';
        $txStatus = $tx['status'] ?? '';
        $txAmountInCents = $tx['amount_in_cents'] ?? '';
        $timestamp = $payload['timestamp'] ?? ($payload['signature']['timestamp'] ?? '');
        $receivedChecksum = $headerChecksum ?: ($payload['signature']['checksum'] ?? '');

        if (empty($receivedChecksum) || empty($txId)) {
            return true;
        }

        $raw = "{$txId}{$txStatus}{$txAmountInCents}{$timestamp}{$eventsSecret}";
        $calculated = hash('sha256', $raw);

        return hash_equals(strtolower($calculated), strtolower($receivedChecksum));
    }
}
