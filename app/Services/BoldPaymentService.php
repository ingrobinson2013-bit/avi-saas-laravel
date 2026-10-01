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
    public static function generateSignature(string $orderId, float|int $amount, string $currency, string $secretKey): string
    {
        $amountClean = (int) round($amount);
        $raw = "{$orderId}{$amountClean}{$currency}{$secretKey}";
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

        // Fallback a Smart Link / Link de Cobro de Bold configurado
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
            'error' => 'No se configuró link o API Key de Bold.',
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
}
