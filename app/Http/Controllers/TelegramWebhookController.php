<?php

namespace App\Http\Controllers;

use App\Models\TriageCase;
use App\Services\TelegramBeeperService;
use App\Services\WhatsAppCloudApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{
    /**
     * Webhook de Telegram para capturar las aprobaciones con 1-clic del médico.
     */
    public function handle(
        Request $request,
        TelegramBeeperService $beeperService,
        WhatsAppCloudApiService $waService
    ): JsonResponse {
        $payload = $request->all();

        // 1. Manejo de Botones Inline (Callback Queries)
        if (isset($payload['callback_query'])) {
            $callback = $payload['callback_query'];
            $callbackId = $callback['id'];
            $data = $callback['data'] ?? '';
            $doctorUser = $callback['from']['first_name'] ?? 'Médico Veterinario';
            $message = $callback['message'] ?? [];
            $chatId = (string) ($message['chat']['id'] ?? '');
            $messageId = (int) ($message['message_id'] ?? 0);
            $originalText = $message['text'] ?? '';

            Log::info("[Telegram Webhook] Doctor {$doctorUser} accionó: {$data}");

            // Formato esperado: action:case_id
            $parts = explode(':', $data);
            $action = $parts[0] ?? '';
            $caseId = $parts[1] ?? '';

            $case = TriageCase::with(['tenant', 'pet', 'customer'])->find($caseId);

            if (!$case) {
                $beeperService->answerCallbackQuery($callbackId, "Caso no encontrado o ya archivado.", true);
                return response()->json(['status' => 'case_not_found']);
            }

            if ($case->status === 'approved') {
                $beeperService->answerCallbackQuery($callbackId, "Este caso ya fue aprobado previamente.", false);
                return response()->json(['status' => 'already_approved']);
            }

            switch ($action) {
                case 'appr':
                    // Marcar como aprobado
                    $case->status = 'approved';
                    $case->doctor_reviewed_by = $doctorUser;
                    $case->approved_at = now();
                    $case->sent_to_whatsapp_at = now();
                    $case->save();

                    // Notificar por WhatsApp al tutor
                    $tenantName = $case->tenant->name;
                    $petName = $case->pet ? $case->pet->name : 'tu mascota';
                    $tutorName = $case->customer ? strtok($case->customer->name, ' ') : '';

                    $saludo = $tutorName ? "Hola {$tutorName}," : "Hola,";
                    $whatsappMsg = "🩺 *Revisión Médica ({$tenantName})*\n\n" .
                                   "{$saludo} el equipo médico ha revisado los síntomas de *{$petName}*:\n\n" .
                                   "{$case->ai_draft_response}\n\n" .
                                   "👨‍⚕️ *Validado y firmado por:* {$doctorUser}\n" .
                                   "📍 Si necesitas consulta presencial o los síntomas persisten, estamos atentos en sede.";

                    $waService->sendTextMessage($case->phone_number, $whatsappMsg);

                    // Agradecer al doctor y retirar botones
                    $beeperService->answerCallbackQuery($callbackId, "✅ Aprobado y enviado al WhatsApp del tutor.", false);
                    $beeperService->updateMessageStatus(
                        $chatId,
                        $messageId,
                        $originalText,
                        "✅ *APROBADO POR:* {$doctorUser} el " . now()->format('d/m/Y H:i') . ".\nEnviado al WhatsApp del tutor."
                    );
                    break;

                case 'appt':
                    $case->status = 'scheduled_appointment';
                    $case->doctor_reviewed_by = $doctorUser;
                    $case->save();

                    $tenant = $case->tenant;
                    $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');
                    $storeUrl = !empty($tenant->domain) ? "https://{$tenant->domain}" : "https://{$tenant->slug}.{$baseDomain}";

                    $waMsg = "🚨 *Recomendación Médica Prioritaria*\n\n" .
                             "El médico {$doctorUser} de *{$tenant->name}* ha evaluado el caso y recomienda una *valoración presencial prioritaria* en consultorio.\n\n" .
                             "📍 Dirección: " . ($tenant->branding['address'] ?? 'Consultorio principal') . "\n" .
                             "👉 Puedes confirmar tu turno en: {$storeUrl}";

                    $waService->sendTextMessage($case->phone_number, $waMsg);

                    $beeperService->answerCallbackQuery($callbackId, "📅 Se solicitó cita presencial al tutor.", false);
                    $beeperService->updateMessageStatus(
                        $chatId,
                        $messageId,
                        $originalText,
                        "📅 *CITA PRESENCIAL SOLICITADA* por {$doctorUser}."
                    );
                    break;

                case 'rejc':
                    $case->status = 'rejected';
                    $case->doctor_reviewed_by = $doctorUser;
                    $case->save();

                    $beeperService->answerCallbackQuery($callbackId, "Caso descartado.", false);
                    $beeperService->updateMessageStatus(
                        $chatId,
                        $messageId,
                        $originalText,
                        "❌ *CASO DESCARTADO* por {$doctorUser}."
                    );
                    break;
            }

            return response()->json(['status' => 'callback_processed']);
        }

        return response()->json(['status' => 'ok']);
    }
}
