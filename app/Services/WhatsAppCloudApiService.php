<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppCloudApiService
{
    protected ?string $token;
    protected ?string $phoneNumberId;
    protected string $graphApiVersion;

    public function __construct()
    {
        $this->token = config('services.whatsapp.token') ?: env('WHATSAPP_TOKEN');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id') ?: env('WHATSAPP_PHONE_NUMBER_ID');
        $this->graphApiVersion = config('services.whatsapp.api_version', 'v21.0');
    }

    /**
     * Endpoint base de Meta Graph API para mensajes
     */
    protected function endpoint(): string
    {
        return "https://graph.facebook.com/{$this->graphApiVersion}/{$this->phoneNumberId}/messages";
    }

    /**
     * Envía un mensaje de texto simple.
     */
    public function sendTextMessage(string $to, string $text): array
    {
        if (empty($this->token) || empty($this->phoneNumberId)) {
            Log::warning("[WhatsApp Cloud API] Token o Phone Number ID no configurados. Mensaje simulado a {$to}: {$text}");
            return ['mocked' => true, 'to' => $to, 'text' => $text];
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $this->cleanPhoneNumber($to),
            'type' => 'text',
            'text' => [
                'preview_url' => false,
                'body' => $text,
            ],
        ];

        return $this->postPayload($payload);
    }

    /**
     * Envía botones interactivos (Hasta 3 botones de respuesta rápida).
     *
     * @param array $buttons [ ['id' => 'btn_1', 'title' => 'Ver Carnet'], ... ]
     */
    public function sendInteractiveButtons(string $to, string $bodyText, array $buttons, ?string $headerText = null, ?string $footerText = null): array
    {
        if (empty($this->token) || empty($this->phoneNumberId)) {
            Log::warning("[WhatsApp Cloud API] Botones simulados a {$to}: {$bodyText}");
            return ['mocked' => true, 'to' => $to, 'buttons' => $buttons];
        }

        $formattedButtons = [];
        foreach (array_slice($buttons, 0, 3) as $btn) {
            $formattedButtons[] = [
                'type' => 'reply',
                'reply' => [
                    'id' => (string) $btn['id'],
                    'title' => mb_substr($btn['title'], 0, 20), // Meta limita títulos a 20 chars
                ],
            ];
        }

        $interactive = [
            'type' => 'button',
            'body' => [
                'text' => $bodyText,
            ],
            'action' => [
                'buttons' => $formattedButtons,
            ],
        ];

        if ($headerText) {
            $interactive['header'] = [
                'type' => 'text',
                'text' => mb_substr($headerText, 0, 60),
            ];
        }

        if ($footerText) {
            $interactive['footer'] = [
                'text' => mb_substr($footerText, 0, 60),
            ];
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $this->cleanPhoneNumber($to),
            'type' => 'interactive',
            'interactive' => $interactive,
        ];

        return $this->postPayload($payload);
    }

    /**
     * Marca un mensaje como leído (Doble check azul).
     */
    public function markAsRead(string $messageId): bool
    {
        if (empty($this->token) || empty($this->phoneNumberId)) {
            return true;
        }

        try {
            $response = Http::withToken($this->token)
                ->timeout(5)
                ->post($this->endpoint(), [
                    'messaging_product' => 'whatsapp',
                    'status' => 'read',
                    'message_id' => $messageId,
                ]);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::warning("[WhatsApp Cloud API] Fallo al marcar mensaje como leído: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Ejecuta la llamada HTTP a Meta Graph API.
     */
    protected function postPayload(array $payload): array
    {
        try {
            $response = Http::withToken($this->token)
                ->timeout(10)
                ->post($this->endpoint(), $payload);

            if ($response->failed()) {
                Log::error("[WhatsApp Cloud API] Error de envío Meta: " . $response->body());
                return ['error' => true, 'details' => $response->json()];
            }

            return $response->json() ?? ['success' => true];
        } catch (\Throwable $e) {
            Log::error("[WhatsApp Cloud API] Excepción HTTP: " . $e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * Limpia el número telefónico asegurando formato E.164 (sin signos + o espacios).
     */
    protected function cleanPhoneNumber(string $phone): string
    {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        // Si no tiene código de país y empieza con 3 (Colombia), anteponer 57
        if (strlen($clean) === 10 && str_starts_with($clean, '3')) {
            $clean = '57' . $clean;
        }
        return $clean;
    }
}
