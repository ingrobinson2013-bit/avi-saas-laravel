<?php

namespace App\Services;

use App\Models\TriageCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramBeeperService
{
    protected ?string $botToken;
    protected ?string $defaultChatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token') ?: env('TELEGRAM_BOT_TOKEN');
        $this->defaultChatId = config('services.telegram.default_chat_id') ?: env('TELEGRAM_CHAT_ID');
    }

    /**
     * Envía una tarjeta ejecutiva de triaje al Telegram del veterinario de turno.
     */
    public function sendTriageCaseAlert(TriageCase $case): ?string
    {
        if (empty($this->botToken)) {
            Log::info("[Telegram Beeper] Token no configurado. Notificación simulada para caso: {$case->id}");
            return 'mocked_telegram_msg_' . time();
        }

        $case->loadMissing('tenant', 'pet', 'customer');
        $tenant = $case->tenant;
        $pet = $case->pet;
        $customer = $case->customer;

        // Chat ID específico de la clínica o fallback central
        $chatId = $tenant->branding['telegram_chat_id'] ?? $this->defaultChatId;
        if (empty($chatId)) {
            Log::warning("[Telegram Beeper] No hay Telegram Chat ID configurado para {$tenant->name}.");
            return null;
        }

        $severityEmoji = match ($case->ai_severity_level) {
            'leve' => '🟢 LEVE',
            'urgente' => '🟠 URGENTE',
            'critico' => '🔴 CRÍTICO',
            default => '🟡 MODERADO',
        };

        $petName = $pet ? $pet->name : 'Mascota no registrada';
        $petDetails = $pet ? "{$pet->species}, {$pet->breed}" : 'Detalles pendientes';
        $tutorName = $customer ? $customer->name : 'Tutor';
        $phone = $case->phone_number;

        $text = "🚨 *NUEVO CASO CLÍNICO EN ESPERA*\n\n" .
                "🏥 *Clínica:* {$tenant->name}\n" .
                "🐾 *Paciente:* *{$petName}* ({$petDetails})\n" .
                "👤 *Tutor:* {$tutorName} (`{$phone}`)\n" .
                "⚡ *Nivel de Gravedad:* {$severityEmoji}\n\n" .
                "📝 *Síntomas reportados:*\n" .
                "_{$case->symptoms_raw}_\n\n" .
                "🤖 *Borrador generado por IA:*\n" .
                "{$case->ai_draft_response}\n\n" .
                "👇 *Acción médica rápida:*";

        $buttons = [
            'inline_keyboard' => [
                [
                    [
                        'text' => '✅ Aprobar y Enviar a WhatsApp',
                        'callback_data' => 'appr:' . $case->id,
                    ],
                ],
                [
                    [
                        'text' => '📅 Solicitar Cita Presencial',
                        'callback_data' => 'appt:' . $case->id,
                    ],
                    [
                        'text' => '❌ Descartar',
                        'callback_data' => 'rejc:' . $case->id,
                    ],
                ],
            ],
        ];

        try {
            $response = Http::timeout(6.0)->post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode($buttons),
            ]);

            if ($response->successful()) {
                $messageId = (string) $response->json('result.message_id');
                $case->telegram_message_id = $messageId;
                $case->save();
                return $messageId;
            } else {
                Log::error("[Telegram Beeper] Error al enviar a Telegram: " . $response->body());
            }
        } catch (\Throwable $e) {
            Log::error("[Telegram Beeper] Excepción al contactar Telegram: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Responde al callback_query para quitar el spinner en la app de Telegram.
     */
    public function answerCallbackQuery(string $callbackQueryId, string $text = '', bool $showAlert = false): bool
    {
        if (empty($this->botToken)) {
            return true;
        }

        try {
            $response = Http::timeout(4.0)->post("https://api.telegram.org/bot{$this->botToken}/answerCallbackQuery", [
                'callback_query_id' => $callbackQueryId,
                'text' => $text,
                'show_alert' => $showAlert,
            ]);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::warning("[Telegram Beeper] Error respondiendo callback: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza el mensaje en Telegram para reflejar la aprobación del médico y desactivar botones.
     */
    public function updateMessageStatus(string $chatId, int $messageId, string $originalText, string $statusNote): bool
    {
        if (empty($this->botToken)) {
            return true;
        }

        try {
            $updatedText = $originalText . "\n\n━━━━━━━━━━━━━━━━━━━━\n" . $statusNote;

            $response = Http::timeout(4.0)->post("https://api.telegram.org/bot{$this->botToken}/editMessageText", [
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'text' => $updatedText,
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode(['inline_keyboard' => []]), // Quitar botones
            ]);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::warning("[Telegram Beeper] Error editando mensaje: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Envía un mensaje directo a un chat de Telegram.
     */
    public function sendMessage(string $chatId, string $text): bool
    {
        if (empty($this->botToken)) {
            Log::info("[Telegram Beeper] Mensaje simulado a {$chatId}: {$text}");
            return true;
        }

        try {
            $response = Http::timeout(5.0)->post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown',
            ]);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error("[Telegram Beeper] Error enviando mensaje a Telegram: " . $e->getMessage());
            return false;
        }
    }
}
