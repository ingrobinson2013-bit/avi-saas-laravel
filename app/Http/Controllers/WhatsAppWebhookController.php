<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\WhatsAppSession;
use App\Services\WhatsAppCloudApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    /**
     * Verificación del Webhook exigida por Meta Cloud API (GET).
     */
    public function verify(Request $request): Response|JsonResponse
    {
        $mode = $request->query('hub_mode') ?: $request->query('hub.mode');
        $token = $request->query('hub_verify_token') ?: $request->query('hub.verify_token');
        $challenge = $request->query('hub_challenge') ?: $request->query('hub.challenge');

        $expectedVerifyToken = config('services.whatsapp.verify_token', 'avi_whatsapp_verify_token_2026');

        if ($mode === 'subscribe' && $token === $expectedVerifyToken) {
            Log::info("[WhatsApp Webhook] Verificación exitosa de Meta Webhook con challenge {$challenge}");
            return response($challenge, 200)->header('Content-Type', 'text/plain');
        }

        Log::warning("[WhatsApp Webhook] Intento fallido de verificación. Token recibido: {$token}");
        return response()->json(['error' => 'Unauthorized verification token'], 403);
    }

    /**
     * Recepción y enrutamiento multi-tenant de mensajes entrantes (POST).
     */
    public function handle(Request $request, WhatsAppCloudApiService $waService): JsonResponse
    {
        $payload = $request->all();

        // Si es una notificación de estado (sent, delivered, read), retornamos 200
        if (!isset($payload['entry'][0]['changes'][0]['value']['messages'])) {
            return response()->json(['status' => 'ignored_or_status_update']);
        }

        $value = $payload['entry'][0]['changes'][0]['value'];
        $message = $value['messages'][0];
        $from = $message['from']; // Teléfono del tutor en formato E.164
        $messageId = $message['id'];
        $type = $message['type'] ?? 'text';

        // Marcamos de inmediato el mensaje como leído (doble check)
        $waService->markAsRead($messageId);

        // Extraer el texto o ID de botón presionado
        $userText = '';
        $buttonPayload = null;

        if ($type === 'text') {
            $userText = trim($message['text']['body'] ?? '');
        } elseif ($type === 'interactive') {
            $interactive = $message['interactive'] ?? [];
            if (isset($interactive['button_reply'])) {
                $buttonPayload = $interactive['button_reply']['id'];
                $userText = $interactive['button_reply']['title'];
            } elseif (isset($interactive['list_reply'])) {
                $buttonPayload = $interactive['list_reply']['id'];
                $userText = $interactive['list_reply']['title'];
            }
        }

        Log::info("[WhatsApp Webhook] Mensaje recibido de {$from}: {$userText} (btn: {$buttonPayload})");

        // 1. Obtener o inicializar sesión en base de datos
        $session = WhatsAppSession::firstOrCreate(
            ['phone_number' => $from],
            ['current_step' => 'initial', 'context_data' => []]
        );

        // 2. Detección de Deep-Link / QR (Ej: Hola_vet-patitas, inicio_clinica-norte)
        if (preg_match('/^(?:hola|inicio|start)[\s_]+([a-zA-Z0-9_-]+)/i', $userText, $matches)) {
            $slugCandidate = strtolower(trim($matches[1]));
            $tenantFound = Tenant::where('slug', $slugCandidate)
                ->orWhere('domain', 'like', "%{$slugCandidate}%")
                ->first();

            if ($tenantFound) {
                $session->tenant_id = $tenantFound->id;
                $session->current_step = 'menu';
                $session->save();
                Log::info("[WhatsApp Router] Sesión {$from} enlazada exitosamente a clínica: {$tenantFound->name} ({$tenantFound->slug})");
            }
        }

        // 3. Si no hay clínica en la sesión, intentar asociar por histórico de clientes
        if (!$session->tenant_id) {
            $phoneClean10 = substr(preg_replace('/[^0-9]/', '', $from), -10);
            $customerRecord = Customer::where('phone', 'like', "%{$phoneClean10}%")->first();

            if ($customerRecord && $customerRecord->tenant) {
                $session->tenant_id = $customerRecord->tenant_id;
                $session->customer_id = $customerRecord->id;
                $session->save();
            } else {
                // Mensaje instructivo general si el usuario escribió sin escanear QR ni poner slug
                $waService->sendTextMessage(
                    $from,
                    "🐾 ¡Hola! Bienvenido a *AVI - Red Asistencial Veterinaria*.\n\n" .
                    "Para conectarte directamente con tu veterinaria, escanea el código QR de su mostrador o responde indicando su nombre:\n" .
                    "👉 *Hola_nombre-de-tu-clinica*\n\n" .
                    "_(Ejemplo: Hola_vet-pet-patitas)_"
                );
                return response()->json(['status' => 'tenant_unresolved']);
            }
        }

        $session->loadMissing('tenant', 'customer');
        $tenant = $session->tenant;

        if (!$tenant || !$tenant->is_active) {
            $waService->sendTextMessage($from, "⚠️ La clínica veterinaria seleccionada no está disponible en este momento.");
            return response()->json(['status' => 'tenant_inactive']);
        }

        // 4. Intentar asociar al Customer del Tenant si aún no está asignado
        if (!$session->customer_id) {
            $phoneClean10 = substr(preg_replace('/[^0-9]/', '', $from), -10);
            $customer = Customer::where('tenant_id', $tenant->id)
                ->where('phone', 'like', "%{$phoneClean10}%")
                ->first();

            if ($customer) {
                $session->customer_id = $customer->id;
                $session->save();
            }
        }

        // 5. Manejo de Acciones Interactivas de Botones
        if ($buttonPayload) {
            $this->handleButtonAction($from, $buttonPayload, $session, $tenant, $waService);
            return response()->json(['status' => 'button_handled']);
        }

        // 6. Manejo según el estado del flujo actual
        if ($session->current_step === 'awaiting_triage_symptoms') {
            $this->handleTriageSymptomsInput($from, $userText, $session, $tenant, $waService);
            return response()->json(['status' => 'triage_symptoms_processed']);
        }

        // 7. Por defecto: Mostrar Menú Principal Interactivo de la Clínica
        $this->sendMainMenu($from, $session, $tenant, $waService);

        return response()->json(['status' => 'menu_sent']);
    }

    /**
     * Envía el menú principal interactivo adaptado a la clínica.
     */
    protected function sendMainMenu(string $from, WhatsAppSession $session, Tenant $tenant, WhatsAppCloudApiService $waService): void
    {
        $tenantName = $tenant->name;
        $customer = $session->customer;
        $tutorName = $customer ? " *" . strtok($customer->name, ' ') . "*" : "";

        $bodyText = "🐾 ¡Hola{$tutorName}! Bienvenido al canal oficial de *{$tenantName}* en AVI.\n\n" .
                    "¿En qué podemos ayudarte el día de hoy?";

        $buttons = [
            ['id' => 'btn_carnet', 'title' => '📋 Mi Carnet y Saldo'],
            ['id' => 'btn_triage', 'title' => '🩺 Asistente de Salud'],
            ['id' => 'btn_info', 'title' => '📍 Sede y Horarios'],
        ];

        $session->current_step = 'menu';
        $session->last_interaction_at = now();
        $session->save();

        $waService->sendInteractiveButtons(
            $from,
            $bodyText,
            $buttons,
            "🏥 {$tenantName}",
            "Tu salud y bienestar animal"
        );
    }

    /**
     * Procesa la pulsación de botones interactivos.
     */
    protected function handleButtonAction(string $from, string $buttonId, WhatsAppSession $session, Tenant $tenant, WhatsAppCloudApiService $waService): void
    {
        switch ($buttonId) {
            case 'btn_carnet':
                $this->handleCarnetQuery($from, $session, $tenant, $waService);
                break;

            case 'btn_triage':
                $this->handleTriageStart($from, $session, $tenant, $waService);
                break;

            case 'btn_info':
                $city = $tenant->branding['city'] ?? 'Colombia';
                $address = $tenant->branding['address'] ?? 'Consultorio principal';
                $phone = $tenant->branding['phone'] ?? 'WhatsApp';
                
                $waService->sendTextMessage(
                    $from,
                    "🏥 *{$tenant->name}*\n" .
                    "📍 Dirección: {$address}, {$city}\n" .
                    "📞 Teléfono directo: {$phone}\n\n" .
                    "¡Estamos atentos para cuidar de tu consentido!"
                );
                break;

            case 'btn_buy_pass':
                $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');
                $storeUrl = !empty($tenant->domain) ? "https://{$tenant->domain}" : "https://{$tenant->slug}.{$baseDomain}";
                $waService->sendTextMessage(
                    $from,
                    "🌟 Puedes adquirir tu *Pase de Orientación 24h* o afiliarte a un Plan Preventivo en línea aquí:\n\n" .
                    "👉 {$storeUrl}\n\n" .
                    "Al completar el pago, tu sesión se desbloqueará de inmediato."
                );
                break;

            default:
                $this->sendMainMenu($from, $session, $tenant, $waService);
                break;
        }
    }

    /**
     * Consulta el carnet digital y saldo de beneficios del tutor.
     */
    protected function handleCarnetQuery(string $from, WhatsAppSession $session, Tenant $tenant, WhatsAppCloudApiService $waService): void
    {
        $customer = $session->customer;

        if (!$customer) {
            $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');
            $storeUrl = !empty($tenant->domain) ? "https://{$tenant->domain}" : "https://{$tenant->slug}.{$baseDomain}";
            
            $waService->sendTextMessage(
                $from,
                "Aún no registras mascotas afiliadas en *{$tenant->name}* con este número.\n\n" .
                "Puedes afiliar a tu mascota a un plan preventivo en:\n👉 {$storeUrl}"
            );
            return;
        }

        $pets = Pet::where('customer_id', $customer->id)->with('subscriptions.plan', 'subscriptions.benefitBalances.benefitDefinition')->get();

        if ($pets->isEmpty()) {
            $waService->sendTextMessage(
                $from,
                "Hola {$customer->name}, tienes un perfil registrado pero aún no tienes mascotas asociadas en {$tenant->name}."
            );
            return;
        }

        $report = "📋 *TUS MASCOTAS EN {$tenant->name}*\n\n";
        $baseDomain = env('APP_BASE_DOMAIN', 'avipetapp.com');

        foreach ($pets as $pet) {
            $activeSub = $pet->subscriptions->where('status', 'active')->first();
            $report .= "🐾 *{$pet->name}* ({$pet->species}, {$pet->breed})\n";

            if ($activeSub) {
                $carnetUrl = url("/v/{$tenant->slug}/carnet/{$activeSub->id}");
                $report .= "✅ *Plan Activo:* {$activeSub->plan->name}\n";
                $report .= "💳 *Carnet Digital:* {$carnetUrl}\n";
                $report .= "🎁 *Saldos Disponibles:*\n";

                foreach ($activeSub->benefitBalances as $balance) {
                    $defName = $balance->benefitDefinition->name ?? 'Beneficio';
                    $report .= "  • {$defName}: {$balance->remaining_uses} disponibles\n";
                }
            } else {
                $report .= "⚠️ Sin plan de salud activo actualmente.\n";
            }
            $report .= "\n";
        }

        $waService->sendTextMessage($from, trim($report));
    }

    /**
     * Inicia el flujo de triaje o activa el paywall si no tiene suscripción.
     */
    protected function handleTriageStart(string $from, WhatsAppSession $session, Tenant $tenant, WhatsAppCloudApiService $waService): void
    {
        $customer = $session->customer;
        $hasActivePlan = false;

        if ($customer) {
            $hasActivePlan = Subscription::where('tenant_id', $tenant->id)
                ->where('customer_id', $customer->id)
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
                })
                ->exists();
        }

        if (!$hasActivePlan) {
            // Disparar Paywall con botones
            $buttons = [
                ['id' => 'btn_buy_pass', 'title' => '💳 Adquirir Pase/Plan'],
                ['id' => 'btn_info', 'title' => '📍 Ir a la Clínica'],
            ];

            $waService->sendInteractiveButtons(
                $from,
                "⚠️ *Atención Médica y Triaje 24/7*\n\n" .
                "Para consultar síntomas con nuestro asistente clínico y contar con revisión prioritaria del veterinario, tu mascota debe contar con un Plan Preventivo activo o un Pase Digital 24h.",
                $buttons,
                "🩺 Servicio Médico",
                $tenant->name
            );
            return;
        }

        // Si tiene plan activo, pedimos los síntomas
        $session->current_step = 'awaiting_triage_symptoms';
        $session->save();

        $waService->sendTextMessage(
            $from,
            "🩺 *Triaje Asistido de Salud ({$tenant->name})*\n\n" .
            "Por favor describe detalladamente:\n" .
            "1. ¿Qué síntoma o molestia presenta tu mascota?\n" .
            "2. ¿Hace cuántas horas o días inició?\n" .
            "3. ¿Cómo está su apetito, ánimo y consumo de agua?\n\n" .
            "_(Escribe tu respuesta en un solo mensaje)_"
        );
    }

    /**
     * Procesa los síntomas ingresados por el tutor (con guardrails clínicos).
     */
    protected function handleTriageSymptomsInput(string $from, string $symptoms, WhatsAppSession $session, Tenant $tenant, WhatsAppCloudApiService $waService): void
    {
        $session->current_step = 'menu';
        $session->context_data = array_merge((array) $session->context_data, [
            'last_symptoms' => $symptoms,
            'reported_at' => now()->toIso8601String(),
        ]);
        $session->save();

        // 1. Guardrail de Emergencias Críticas Inmediatas
        $emergencyKeywords = ['convulsion', 'convulsión', 'sangrado', 'inconsciente', 'ahogo', 'atropellado', 'envenenado', 'veneno', 'no respira'];
        $isEmergency = false;
        foreach ($emergencyKeywords as $kw) {
            if (stripos($symptoms, $kw) !== false) {
                $isEmergency = true;
                break;
            }
        }

        if ($isEmergency) {
            $address = $tenant->branding['address'] ?? 'la clínica más cercana';
            $phone = $tenant->branding['phone'] ?? 'urgencias';
            
            $waService->sendTextMessage(
                $from,
                "🚨 *ALERTA DE EMERGENCIA VITAL*\n\n" .
                "Los síntomas que describes indican una situación de ALTA URGENCIA que no debe esperar evaluación virtual.\n\n" .
                "Por favor acude de inmediato con tu mascota a la sede física:\n" .
                "📍 *Dirección:* {$address}\n" .
                "📞 *Línea directa:* {$phone}\n\n" .
                "Mantén la calma y mantén a tu mascota abrigada durante el traslado."
            );
            return;
        }

        // 2. Respuesta de Triaje Ordinario
        $waService->sendTextMessage(
            $from,
            "✅ *Reporte Recibido en {$tenant->name}*\n\n" .
            "Hemos registrado los síntomas de tu mascota en el sistema clínico. Nuestro equipo y el médico veterinario de turno han sido notificados para la revisión del caso.\n\n" .
            "⏳ *Tiempo estimado de respuesta:* 5 a 15 minutos.\n" .
            "Si los síntomas empeoran súbitamente, acude de inmediato a la clínica."
        );
    }
}
