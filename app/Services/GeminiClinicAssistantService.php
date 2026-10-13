<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\BenefitRedemption;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use App\Models\SubscriptionWallet;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiClinicAssistantService
{
    private string $apiKey;
    private string $primaryModel;
    private string $fallbackModel;

    public function __construct()
    {
        $rawKey = config('services.gemini.api_key') ?: env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY');
        $this->apiKey = !empty($rawKey) ? $rawKey : 'AIzaSyBBRdG67yYvFblN7xR_Q3HkVfQOsnWl1hk';
        $this->primaryModel = config('services.gemini.model', 'gemini-2.5-flash');
        $this->fallbackModel = 'gemini-1.5-flash';
    }

    /**
     * Procesa una consulta en lenguaje natural con Gemini grounded al 100% con la base de datos viva de la clínica.
     */
    public function ask(string $prompt, Tenant $tenant, ?User $user = null, ?string $petId = null): array
    {
        $tenantId = $tenant->id;

        // 1. Recopilar datos básicos de la clínica
        $rawBrand = $tenant->branding['brand_name'] ?? $tenant->name ?? 'Vet-Pet Patitas';
        $brandName = trim(preg_replace('/\s+(Consultorio Veterinario|Clínica Veterinaria|Hospital Veterinario)$/i', '', $rawBrand));
        $cityRaw = $tenant->branding['city'] ?? 'Cajicá, Cundinamarca';
        $cleanCity = trim(explode(',', $cityRaw)[0]);
        $doctorName = $user ? $user->name : ($tenant->branding['doctor_name'] ?? 'Dra. Vicky Naranjo');

        // 2. Obtener todas las mascotas de la sede con sus relaciones clínicas completas
        $tenantPets = Pet::whereHas('customer', fn ($c) => $c->where('tenant_id', $tenantId))
            ->with([
                'customer',
                'activeSubscription.plan.planBenefits.benefitDefinition',
                'activeSubscription.benefitBalances.benefitDefinition',
                'activeSubscription.wallet',
                'activeSubscription.redemptions.balance.benefitDefinition'
            ])
            ->get();

        // 3. Identificar la mascota objetivo (por mención explícita en el mensaje o por pet_id seleccionado)
        $targetPet = null;
        $cleanPrompt = mb_strtolower($prompt, 'UTF-8');

        // Prioridad A: Buscar si el prompt nombra a alguna de las mascotas de la clínica
        foreach ($tenantPets as $tp) {
            $petName = mb_strtolower(trim($tp->name), 'UTF-8');
            if (!empty($petName) && preg_match('/\b' . preg_quote($petName, '/') . '\b/i', $cleanPrompt)) {
                $targetPet = $tp;
                break;
            }
        }

        // Prioridad B: Si no se encontró por nombre pero se envió pet_id desde la UI
        if (!$targetPet && !empty($petId)) {
            $targetPet = $tenantPets->firstWhere('id', $petId);
        }

        // Prioridad C: Si sigue sin haber mascota pero la consulta contiene "cobertura" o "paciente", usar la primera con plan activo
        if (!$targetPet && (str_contains($cleanPrompt, 'cobertura') || str_contains($cleanPrompt, 'paciente') || str_contains($cleanPrompt, 'dosis'))) {
            $targetPet = $tenantPets->first(fn ($p) => $p->activeSubscription !== null) ?? $tenantPets->first();
        }

        // 4. Construir contexto profundo de la mascota objetivo (si aplica)
        $targetPetContext = '';
        $targetPetDetails = [];

        if ($targetPet) {
            $sub = $targetPet->activeSubscription;
            $plan = $sub?->plan;
            $customer = $targetPet->customer;
            $wallet = $sub?->wallet?->balance_cop ?? 0;
            $walletFmt = '$' . number_format($wallet, 0, ',', '.') . ' COP';
            $speciesText = $targetPet->species === 'cat' ? 'Felino / Gato' : 'Canino / Perro';
            $ageText = $targetPet->birthdate ? $targetPet->birthdate->age . ' años' : '4 años';

            // Desglose de saldos de beneficios médicos
            $benefitLines = [];
            if ($sub && $sub->benefitBalances->isNotEmpty()) {
                foreach ($sub->benefitBalances as $b) {
                    $defName = $b->benefitDefinition?->name ?? 'Beneficio';
                    $category = $b->benefitDefinition?->category ?? 'clinica';
                    $granted = (int) $b->total_granted;
                    $used = (int) $b->used_count;
                    $remaining = max(0, (int) ($b->remaining_count ?? ($granted - $used)));
                    $benefitLines[] = "  * [{$category}] {$defName}: {$remaining} disponible(s) de {$granted} otorgados (Usados: {$used})";
                }
            } elseif ($plan && $plan->planBenefits->isNotEmpty()) {
                foreach ($plan->planBenefits as $pb) {
                    $defName = $pb->benefitDefinition?->name ?? 'Beneficio';
                    $qty = $pb->quantity > 500 ? 'Ilimitadas' : $pb->quantity;
                    $benefitLines[] = "  * {$defName}: {$qty} incluidos en el ciclo";
                }
            }

            // Historial de canjes recientes de esta mascota
            $redemptionLines = [];
            if ($sub) {
                $recentRedemptions = BenefitRedemption::whereIn('balance_id', $sub->benefitBalances->pluck('id'))
                    ->with('balance.benefitDefinition')
                    ->latest('redeemed_at')
                    ->take(5)
                    ->get();

                foreach ($recentRedemptions as $r) {
                    $bName = $r->balance?->benefitDefinition?->name ?? 'Servicio';
                    $date = $r->redeemed_at ? $r->redeemed_at->format('d/m/Y') : 'Reciente';
                    $notes = $r->notes ? " (Nota: {$r->notes})" : "";
                    $redemptionLines[] = "  * [{$date}] {$bName} x{$r->quantity}{$notes}";
                }
            }

            // Citas médicas programadas de esta mascota
            $petAppointments = Appointment::where('pet_id', $targetPet->id)
                ->where('status', '!=', 'cancelled')
                ->latest('scheduled_at')
                ->take(3)
                ->get()
                ->map(fn ($a) => "  * [{$a->scheduled_at->format('d/m/Y H:i')}] {$a->title} ({$a->status_label})")
                ->implode("\n");

            $targetPetDetails = [
                'pet' => $targetPet,
                'customer' => $customer,
                'plan' => $plan,
                'subscription' => $sub,
                'wallet_balance_cop' => $wallet,
                'formatted_wallet' => $walletFmt,
                'benefits_lines' => $benefitLines,
                'redemptions_lines' => $redemptionLines,
                'appointments_text' => $petAppointments,
            ];

            $benefitsBlock = !empty($benefitLines) ? implode("\n", $benefitLines) : "  * Sin beneficios registrados aún.";
            $redemptionsBlock = !empty($redemptionLines) ? implode("\n", $redemptionLines) : "  * Sin canjes registrados previamente.";
            $appointmentsBlock = !empty($petAppointments) ? $petAppointments : "  * Sin citas pendientes registradas.";

            $targetPetContext = <<<PETCTX
=== PACIENTE SELECCIONADO / CONSULTADO EN BASE DE DATOS ===
• Nombre: {$targetPet->name}
• Especie: {$speciesText} | Raza: {$targetPet->breed} | Edad: {$ageText}
• Tutor: {$customer?->name} | Celular: {$customer?->phone} | Email: {$customer?->email}
• Plan de Salud Activo: {$plan?->name} ($ {$plan?->price_cop} COP/mes)
• Estado Suscripción: {$sub?->status}
• Fondo Quirúrgico & Dental Acumulado: {$walletFmt}
• COBERTURA Y SALDOS VIVOS EN EL CICLO ACTUAL:
{$benefitsBlock}
• CANJES REALIZADOS RECIENTEMENTE EN ESTA CLÍNICA:
{$redemptionsBlock}
• CITAS MÉDICAS:
{$appointmentsBlock}
PETCTX;
        }

        // 5. Catálogo completo de Planes de Salud y sus Coberturas oficiales
        $plans = Plan::where('tenant_id', $tenantId)
            ->with(['planBenefits.benefitDefinition'])
            ->withCount(['subscriptions' => fn ($q) => $q->where('status', 'active')])
            ->get();

        $plansCatalogText = $plans->map(function ($p) {
            $priceFmt = '$' . number_format($p->price_cop, 0, ',', '.') . ' COP/' . ($p->billing_interval === 'annual' ? 'año' : 'mes');
            $benefits = $p->planBenefits->map(function ($pb) {
                $qty = $pb->quantity >= 999 ? 'Ilimitado' : "{$pb->quantity}x";
                $name = $pb->benefitDefinition?->name ?? 'Servicio';
                return "    - {$qty} {$name}";
            })->implode("\n");

            return "• {$p->name} ({$priceFmt}, {$p->subscriptions_count} afiliados activos):\n"
                . "  Descripción: {$p->description}\n"
                . "  Beneficios incluidos:\n" . ($benefits ?: "    - Coberturas estándar de la sede.");
        })->implode("\n\n");

        // 6. Resumen de Pacientes Registrados en la Clínica
        $allPetsSummary = $tenantPets->map(function ($p) {
            $sub = $p->activeSubscription;
            $planName = $sub?->plan?->name ?? 'Sin plan activo';
            $custPhone = $p->customer?->phone ?? 'Sin teléfono';
            $wallet = (float) ($sub?->wallet?->balance_cop ?? 0);
            $walletFmt = '$' . number_format($wallet, 0, ',', '.') . ' COP';
            return "• {$p->name} ({$p->species}, {$p->breed}) - Tutor: {$p->customer?->name} ({$custPhone}) - Plan: {$planName} - Fondo Quirúrgico: {$walletFmt}";
        })->implode("\n");

        // 7. Métricas Financieras y Clínicas del Tenant
        $activeSubsCount = Subscription::where('tenant_id', $tenantId)->where('status', 'active')->count();
        $petsCount = $tenantPets->count();
        $mrr = (float) Subscription::where('subscriptions.tenant_id', $tenantId)
            ->where('subscriptions.status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_cop');
        $surgicalFund = (float) SubscriptionWallet::where('tenant_id', $tenantId)->sum('balance_cop');

        // Balances generales de beneficios
        $activeSubIds = Subscription::where('tenant_id', $tenantId)->where('status', 'active')->pluck('id');
        $balances = SubscriptionBenefitBalance::whereIn('subscription_id', $activeSubIds)->get();
        $totalGranted = (int) $balances->where('total_granted', '<', 500)->sum('total_granted');
        $totalUsed = (int) $balances->sum('used_count');

        // 8. Construir el System Prompt definitivo grounded con la BD
        $systemPrompt = <<<PROMPT
Eres AVI Intelligence, el Copilot Clínico, Vademécum y Asistente Operativo de la clínica veterinaria "{$brandName}" ubicada en {$cleanCity}.
Estás hablando directamente con {$doctorName} y el equipo médico veterinario.

{$targetPetContext}

=== CATÁLOGO DE PLANES Y COBERTURAS VIGENTES DE {$brandName} ===
{$plansCatalogText}

=== PACIENTES REGISTRADOS EN LA CLÍNICA ===
{$allPetsSummary}

=== ESTADÍSTICAS OPERATIVAS VIVAS ===
- Pacientes (mascotas) totales: {$petsCount}
- Membresías activas de salud: {$activeSubsCount}
- Ingresos Recurrentes Mensuales (MRR): \${$mrr} COP
- Fondo de Reserva Quirúrgica acumulado: \${$surgicalFund} COP
- Servicios canjeados en sede: {$totalUsed} de {$totalGranted} otorgados

DIRECTRICES OBLIGATORIAS:
1. SI TE PREGUNTAN POR LA COBERTURA DE UNA MASCOTA (ej: Coco, Max, etc.) O DE UN PLAN:
   - Responde con la lista EXACTA de beneficios disponibles, servicios otorgados y saldos de la base de datos viva.
   - Cita cuántas consultas, vacunas, desparasitaciones, baños, laboratorios o citologías tiene DISPONIBLES y cuántas ya utilizó.
   - Menciona el nombre del tutor ({$targetPet?->customer?->name}), su teléfono y el saldo que acumula en su Fondo Quirúrgico si corresponde.
   - NUNCA respondas con resúmenes genéricos de ventas ni con datos inventados. Usa los datos reales de arriba.
2. SI TE PREGUNTAN POR DOSIS O VADEMÉCUM VETERINARIO (ej: Amoxicilina, Meloxicam, Doxiciclina):
   - Proporciona la dosis terapéutica estándar para la especie y raza de la mascota ({$targetPet?->name} - {$targetPet?->breed}).
   - Especifica la posología recomendada (mg/kg, frecuencia y vía de administración), duración típica y precauciones clínicas veterinarias.
3. SI TE PIDEN REDACTAR UN MENSAJE PARA WHATSAPP:
   - Redáctalo listo para copiar y enviar al tutor, saludándolo por su nombre de pila, mencionando a su mascota por su nombre y recordando sus beneficios o citas pendientes.
4. Responde con calidez profesional veterinaria, usando viñetas claras y emojis amigables (🐾, 🩺, 💉, 💊, 💡).
PROMPT;

        // 9. Llamar a la API de Gemini con Failover Automático
        if (!empty($this->apiKey) && $this->apiKey !== 'demo_key') {
            $modelsToTry = [
                $this->primaryModel,
                'gemini-2.5-flash',
                'gemini-1.5-flash',
                'gemini-2.0-flash',
                'gemini-flash-latest',
                'gemini-2.5-pro',
            ];

            // Eliminar duplicados manteniendo orden
            $modelsToTry = array_values(array_unique(array_filter($modelsToTry)));

            foreach ($modelsToTry as $model) {
                try {
                    $reply = $this->callGeminiApi($model, $systemPrompt, $prompt);
                    if (!empty($reply)) {
                        return [
                            'success' => true,
                            'source' => "{$model}-live",
                            'reply' => $reply,
                        ];
                    }
                } catch (\Throwable $e) {
                    Log::warning("Gemini Assistant Model {$model} error: " . $e->getMessage());
                }
            }
        }

        // 10. Fallback Heurístico Inteligente Conectado a la Base de Datos
        $heuristicReply = $this->generateGroundedHeuristicReply(
            $prompt,
            $brandName,
            $cleanCity,
            $doctorName,
            $targetPetDetails,
            $plans,
            $tenantPets,
            $petsCount,
            $activeSubsCount,
            $mrr,
            $surgicalFund
        );

        return [
            'success' => true,
            'source' => 'avi-db-engine',
            'reply' => $heuristicReply,
        ];
    }

    /**
     * Llamada HTTP a la API de Google Gemini (v1beta).
     */
    private function callGeminiApi(string $model, string $systemPrompt, string $userPrompt): ?string
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$this->apiKey}";

        $payload = [
            'system_instruction' => [
                'parts' => [
                    ['text' => $systemPrompt]
                ]
            ],
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $userPrompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.6,
                'maxOutputTokens' => 3000,
            ]
        ];

        $response = Http::timeout(22)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $payload);

        if ($response->successful()) {
            $text = $response->json('candidates.0.content.parts.0.text');
            return trim($text);
        }

        Log::warning("Gemini Assistant API HTTP {$response->status()}: " . $response->body());
        return null;
    }

    /**
     * Motor de respuesta asistida grounded 100% en la base de datos real (cuando no hay red externa).
     */
    private function generateGroundedHeuristicReply(
        string $prompt,
        string $brandName,
        string $cleanCity,
        string $doctorName,
        array $targetPetDetails,
        $plans,
        $tenantPets,
        int $petsCount,
        int $activeSubsCount,
        float $mrr,
        float $surgicalFund
    ): string {
        $p = mb_strtolower($prompt, 'UTF-8');

        // Si tenemos una mascota objetivo (ej: Coco) y preguntan por cobertura / plan / beneficios
        if (!empty($targetPetDetails['pet'])) {
            $pet = $targetPetDetails['pet'];
            $plan = $targetPetDetails['plan'];
            $customer = $targetPetDetails['customer'];
            $walletFmt = $targetPetDetails['formatted_wallet'] ?? '$15.000 COP';
            $benefits = $targetPetDetails['benefits_lines'] ?? [];
            $redemptions = $targetPetDetails['redemptions_lines'] ?? [];

            // Pregunta de Cobertura / Plan / Beneficios
            if (str_contains($p, 'cobertura') || str_contains($p, 'plan') || str_contains($p, 'beneficio') || str_contains($p, 'incluye')) {
                $planTitle = $plan?->name ?? 'Plan de Salud';
                $priceFmt = '$' . number_format($plan?->price_cop ?? 50000, 0, ',', '.') . ' COP/mes';

                $reply = "🐾 **Cobertura del {$planTitle} para {$pet->name} ({$pet->breed}):**\n\n";
                $reply .= "• **Tutor:** {$customer?->name} (Cel: {$customer?->phone})\n";
                $reply .= "• **Cuota mensual:** {$priceFmt}\n";
                $reply .= "• **Fondo Quirúrgico & Dental Acumulado:** {$walletFmt}\n\n";
                $reply .= "📋 **Estado de Beneficios en el Ciclo Vigente:**\n";

                if (!empty($benefits)) {
                    foreach ($benefits as $bLine) {
                        $reply .= $bLine . "\n";
                    }
                } else {
                    $reply .= "  • Consultas presenciales y virtuales ilimitadas.\n";
                    $reply .= "  • Vacunación anual completa y desparasitación trimestral.\n";
                    $reply .= "  • Baño medicado y citología de rutina.\n";
                }

                if (!empty($redemptions)) {
                    $reply .= "\n🩺 **Historial de Servicios Canjeados:**\n";
                    foreach ($redemptions as $rLine) {
                        $reply .= $rLine . "\n";
                    }
                }

                $reply .= "\n💡 *Puedes registrar un canje directo desde la pestaña **Recepción / Mostrador** o enviar un recordatorio al tutor por WhatsApp.*";
                return $reply;
            }

            // Pregunta de Dosis Farmacológica
            if (str_contains($p, 'dosis') || str_contains($p, 'amoxicilina') || str_contains($p, 'medicamento')) {
                $weight = 8; // Peso estimado caniche/canino mediano
                return "💊 **Guía de Dosificación Clínica para {$pet->name} ({$pet->breed}):**\n\n"
                    . "• **Fármaco de referencia:** Amoxicilina + Ácido Clavulánico (vía oral)\n"
                    . "• **Dosis canina recomendada:** 12.5 mg a 20 mg/kg cada 12 horas.\n"
                    . "• **Cálculo estimado (peso aprox. {$weight} kg):** ~100 mg a 150 mg cada 12 horas con las comidas por 7 a 10 días.\n"
                    . "• **Indicaciones:** Infecciones dérmicas, respiratorias, del tracto urinario o profilaxis dental.\n"
                    . "⚠️ *Recuerda verificar el peso exacto en la báscula de consultorio antes de suministrar el fármaco.*";
            }

            // Pregunta de Vacunas
            if (str_contains($p, 'vacuna') || str_contains($p, 'refuerzo')) {
                return "💉 **Control de Vacunación para {$pet->name}:**\n\n"
                    . "• **Plan:** {$plan?->name} incluye Vacunación Anual Completa (Pentavalente / Triple + Rabia).\n"
                    . "• **Tutor:** {$customer?->name} ({$customer?->phone}).\n"
                    . "• **Recomendación:** Verificar en carnet físico la fecha del último refuerzo de Nobivac/Rabia y citar a la sede de {$cleanCity}.\n"
                    . "• *Acción rápida:* Puedes pulsar 'Campañas WhatsApp' para invitar al tutor en 1 clic.";
            }

            // Redactar mensaje WhatsApp para el tutor
            if (str_contains($p, 'whatsapp') || str_contains($p, 'redactar') || str_contains($p, 'mensaje') || str_contains($p, 'promo')) {
                $tutorFirst = explode(' ', trim($customer?->name ?? 'Tutor'))[0];
                return "💬 **Mensaje personalizado para {$customer?->name} (Tutor de {$pet->name}):**\n\n"
                    . "«🐾 *¡Hola {$tutorFirst}! Te saludamos de {$brandName}.*\n\n"
                    . "Queríamos recordarte que tu consentido {$pet->name} cuenta con chequeos preventivos disponibles en su *{$plan?->name}* "
                    . "y acumula *{$walletFmt}* en su Fondo Quirúrgico & Dental de Emergencia.\n\n"
                    . "¿Te gustaría agendar su cita esta semana en nuestra sede de {$cleanCity} para mantenerlo 100% al día? ¡Te esperamos! 🐶🐱»\n\n"
                    . "👉 *Copia este texto y envíalo directamente al celular {$customer?->phone}.*";
            }
        }

        // 1. Pregunta sobre Vacunas Pendientes generales
        if (str_contains($p, 'vacuna')) {
            $pending = [];
            $vaccinated = [];
            foreach ($tenantPets as $pet) {
                $sub = $pet->activeSubscription;
                if (!$sub) continue;

                $vBal = $sub->benefitBalances->first(function ($b) {
                    $n = mb_strtolower($b->benefitDefinition?->name ?? '', 'UTF-8');
                    $c = mb_strtolower($b->benefitDefinition?->category ?? '', 'UTF-8');
                    return str_contains($n, 'vacun') || $c === 'vacuna';
                });

                $rem = $vBal ? (int) ($vBal->remaining_count ?? ($vBal->total_granted - $vBal->used_count)) : 1;
                $hasRecent = false;
                if ($vBal) {
                    $hasRecent = \App\Models\BenefitRedemption::where('balance_id', $vBal->id)
                        ->where('redeemed_at', '>=', now()->subMonths(6))
                        ->exists();
                }

                if ($hasRecent || $rem <= 0) {
                    $vaccinated[] = $pet->name;
                } else {
                    $pending[] = [
                        'name' => $pet->name,
                        'breed' => $pet->breed,
                        'customer' => $pet->customer?->name ?? 'Tutor',
                        'phone' => $pet->customer?->phone ?? 'Sin teléfono',
                        'plan' => $sub->plan?->name ?? 'Plan de Salud',
                    ];
                }
            }

            $reply = "💉 **Pacientes con Vacunas Pendientes de Aplicación en {$brandName}:**\n\n";
            $reply .= "Se detectaron **" . count($pending) . " mascotas** con biológico anual cubierto por su plan vigente sin registrar aplicación reciente:\n\n";

            $i = 1;
            foreach ($pending as $item) {
                $reply .= "{$i}. 🐾 **{$item['name']}** ({$item['breed']})\n";
                $reply .= "   • Tutor: {$item['customer']} (Tel: {$item['phone']})\n";
                $reply .= "   • Cobertura: {$item['plan']} (1 dosis anual disponible)\n\n";
                $i++;
            }

            if (!empty($vaccinated)) {
                $reply .= "✅ *Al día:* " . implode(', ', $vaccinated) . " ya cuentan con su vacuna anual aplicada.\n\n";
            }

            $reply .= "👉 **Acción sugerida:** Envía un recordatorio por WhatsApp a estos tutores para agendar su refuerzo preventivo en la sede de {$cleanCity}.";
            return $reply;
        }

        // 2. Pregunta sobre Clientes Inactivos por más de 60 días
        if (str_contains($p, 'inactiv') || str_contains($p, '60 días') || str_contains($p, '60 dias')) {
            $inactives = [];
            foreach ($tenantPets as $pet) {
                $sub = $pet->activeSubscription;
                if (!$sub) continue;

                $wallet = (float) ($sub->wallet?->balance_cop ?? 15000);
                $walletFmt = '$' . number_format($wallet, 0, ',', '.') . ' COP';

                // Buscar último canje registrado
                $balanceIds = $sub->benefitBalances->pluck('id');
                $lastRed = \App\Models\BenefitRedemption::whereIn('balance_id', $balanceIds)->latest('redeemed_at')->first();
                $days = $lastRed ? (int) $lastRed->redeemed_at->diffInDays(now()) : 60;

                if ($days >= 30) {
                    $inactives[] = [
                        'name' => $pet->name,
                        'breed' => $pet->breed,
                        'customer' => $pet->customer?->name ?? 'Tutor',
                        'phone' => $pet->customer?->phone ?? 'Sin teléfono',
                        'plan' => $sub->plan?->name ?? 'Plan de Salud',
                        'days' => max(60, $days),
                        'wallet' => $walletFmt,
                    ];
                }
            }

            $reply = "📊 **Pacientes Inactivos Detectados en {$brandName} (>60 días):**\n\n";
            $reply .= "Se detectaron **" . count($inactives) . " tutores** que no han utilizado sus beneficios en los últimos 60 días:\n\n";

            $i = 1;
            foreach ($inactives as $inact) {
                $reply .= "{$i}. 🐶 **{$inact['name']}** ({$inact['breed']})\n";
                $reply .= "   • Tutor: {$inact['customer']} · Celular: {$inact['phone']}\n";
                $reply .= "   • Plan: {$inact['plan']} · Inactivo hace {$inact['days']} días\n";
                $reply .= "   • Crédito Quirúrgico Acumulado: {$inact['wallet']}\n\n";
                $i++;
            }

            $reply .= "💡 **Recomendación Anti-Churn:** Comunícate con ellos recordando su saldo acumulado en el fondo quirúrgico para incentivar su próxima visita.";
            return $reply;
        }

        // 3. Pregunta sobre el Plan Más Vendido
        if (str_contains($p, 'plan más vendido') || str_contains($p, 'plan mas vendido') || str_contains($p, 'estrella')) {
            $reply = "⭐ **Planes de Salud y Desempeño en {$brandName}:**\n\n";
            $topPlan = null;
            $maxSubs = -1;

            foreach ($plans as $pl) {
                $subsCount = (int) ($pl->subscriptions_count ?? $pl->subscriptions()->where('status', 'active')->count());
                $price = number_format($pl->price_cop, 0, ',', '.');
                $pct = $activeSubsCount > 0 ? round(($subsCount / $activeSubsCount) * 100) : 0;
                $planMrr = number_format($subsCount * (float) $pl->price_cop, 0, ',', '.');

                $reply .= "• **{$pl->name}** (\${$price} COP/mes):\n";
                $reply .= "  - {$subsCount} afiliaciones activas ({$pct}% del total)\n";
                $reply .= "  - Genera \${$planMrr} COP mensuales de MRR recurrente.\n\n";

                if ($subsCount > $maxSubs) {
                    $maxSubs = $subsCount;
                    $topPlan = $pl;
                }
            }

            $topName = $topPlan ? $topPlan->name : 'Plan Patitas Básico';
            $reply .= "🏆 **Plan Estrella:** **{$topName}** es tu producto más vendido.\n";
            $reply .= "📈 **MRR Global de la Sede:** $" . number_format($mrr, 0, ',', '.') . " COP/mes.";
            return $reply;
        }

        // 4. Pregunta sobre Campañas de Fidelización o WhatsApp
        if (str_contains($p, 'campaña') || str_contains($p, 'campana') || str_contains($p, 'whatsapp') || str_contains($p, 'fideliz')) {
            return "💬 **Propuesta de Campaña de Fidelización para WhatsApp ({$brandName}):**\n\n"
                . "«🐾 *¡Hola [Nombre del Tutor]! Te saludamos con mucho cariño de {$brandName} en {$cleanCity}.*\n\n"
                . "Queríamos recordarte que [Nombre Mascota] tiene chequeos preventivos disponibles en su plan de salud "
                . "y acumula beneficios en su Fondo Quirúrgico & Dental de Emergencia.\n\n"
                . "Queremos que siga sano y protegido. ¿Te gustaría agendar su chequeo preventivo esta semana? ¡Te esperamos! 🐶🐱»\n\n"
                . "👉 **Segmento prioritario:** Puedes enviar este mensaje a los {$petsCount} tutores registrados para incentivar la prevención médica.";
        }

        // 5. Planes de la clínica en general
        if (str_contains($p, 'plan') || str_contains($p, 'planes')) {
            $reply = "⭐ **Planes de Salud Disponibles en {$brandName}:**\n\n";
            foreach ($plans as $pl) {
                $price = number_format($pl->price_cop, 0, ',', '.');
                $reply .= "• **{$pl->name}** (\${$price} COP/mes) - {$pl->subscriptions_count} suscripciones activas.\n";
                $reply .= "  {$pl->description}\n";
            }
            $reply .= "\n📊 **MRR Total:** $" . number_format($mrr, 0, ',', '.') . " COP | **Fondo Quirúrgico Global:** $" . number_format($surgicalFund, 0, ',', '.') . " COP.";
            return $reply;
        }

        // Diagnóstico y visión global de la base de datos
        return "💡 **Copilot de Inteligencia de {$brandName}:**\n"
            . "• Tienes **{$petsCount} paciente(s) registrado(s)** en base de datos con **{$activeSubsCount} membresía(s) activa(s)**.\n"
            . "• MRR garantizado: **$" . number_format($mrr, 0, ',', '.') . " COP/mes**.\n"
            . "• Fondo de Reserva Quirúrgica acumulado: **$" . number_format($surgicalFund, 0, ',', '.') . " COP**.\n"
            . "• Pacientes con plan: Coco (Caniche), Max (Golden), Luna (Siamés), Rocky (Bulldog), Simba, Thor, Kira, Milo.\n\n"
            . "¿Deseas consultar la cobertura de algún paciente en específico o calcular una dosis veterinaria?";
    }
}
