<?php

namespace App\Services;

use App\Models\Pet;
use App\Models\Tenant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TriageAiService
{
    protected string $fastApiUrl;
    protected ?string $geminiApiKey;
    protected string $geminiModel;

    public function __construct()
    {
        $this->fastApiUrl = config('services.ai_service.url', env('AI_SERVICE_URL', 'http://avi-ai:8001'));
        $this->geminiApiKey = config('services.gemini.api_key') ?: env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY');
        $this->geminiModel = config('services.gemini.model', 'gemini-3.8-flash');
    }

    /**
     * Analiza los síntomas y genera un borrador de triaje clínico estructurado.
     */
    public function analyzeSymptoms(string $symptoms, Tenant $tenant, ?Pet $pet = null): array
    {
        // 1. Intentar primero con el microservicio FastAPI (Cerebro Python)
        try {
            $response = Http::timeout(4.0)->post("{$this->fastApiUrl}/v1/triage/analyze", [
                'tenant_slug' => $tenant->slug,
                'symptoms' => $symptoms,
                'pet_data' => $pet ? [
                    'name' => $pet->name,
                    'species' => $pet->species,
                    'breed' => $pet->breed,
                    'age_years' => $pet->birthdate ? now()->diffInYears($pet->birthdate) : null,
                    'medical_notes' => $pet->medical_notes,
                ] : null,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'severity' => $data['severity'] ?? 'moderado',
                    'draft' => $data['draft_response'] ?? '',
                    'confidence' => $data['confidence'] ?? 0.88,
                    'engine' => 'fastapi_python',
                ];
            }
        } catch (\Throwable $e) {
            Log::info("[Triage AI] FastAPI microservice no disponible (" . $e->getMessage() . "). Usando motor Gemini nativo.");
        }

        // 2. Fallback a Gemini Flash con Grounding Clínico
        return $this->analyzeWithGemini($symptoms, $tenant, $pet);
    }

    /**
     * Motor de inferencia directo con Gemini Multimodal / Flash.
     */
    protected function analyzeWithGemini(string $symptoms, Tenant $tenant, ?Pet $pet = null): array
    {
        if (empty($this->geminiApiKey)) {
            return $this->ruleBasedFallback($symptoms, $tenant, $pet);
        }

        $petContext = $pet 
            ? "Paciente: {$pet->name} ({$pet->species}, raza {$pet->breed})." 
            : "Paciente veterinario no identificado previamente.";

        $systemPrompt = <<<PROMPT
Eres el Asistente Clínico de Triaje Veterinario para la clínica "{$tenant->name}".
Tu rol es analizar el reporte de síntomas entregado por el tutor y redactar un borrador conciso, empático y clínicamente prudente para revisión del veterinario.

REGLAS INQUEBRANTABLES:
1. NUNCA recetes medicamentos antibióticos, esteroides ni fármacos de prescripción restringida.
2. Si hay signos de alarma (deshidratación, vómito persistente, letargo severo), recomienda cita prioritaria o consulta presencial.
3. Sugiere medidas de soporte seguras en casa (hidratación con suero oral en pequeñas tomas, dieta blanda si tolera, reposo y monitoreo de temperatura).
4. El tono debe ser profesional, tranquilizador y firmado por el equipo médico de {$tenant->name}.
5. Tu respuesta debe ser un JSON estricto con:
   - "severity": "leve" | "moderado" | "urgente" | "critico"
   - "draft_response": "Texto claro para enviar al tutor por WhatsApp tras aprobación médica."
   - "confidence": número decimal entre 0.70 y 0.99
PROMPT;

        $userPrompt = "Datos del paciente: {$petContext}\nSíntomas reportados por el tutor: \"{$symptoms}\"\nGenera el dictamen de triaje en formato JSON.";

        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->geminiModel}:generateContent?key={$this->geminiApiKey}";
            $response = Http::timeout(8.0)->post($url, [
                'systemInstruction' => [
                    'parts' => [['text' => $systemPrompt]]
                ],
                'contents' => [
                    ['role' => 'user', 'parts' => [['text' => $userPrompt]]]
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                    'temperature' => 0.2,
                ],
            ]);

            if ($response->successful()) {
                $jsonText = $response->json('candidates.0.content.parts.0.text');
                $parsed = json_decode($jsonText, true);

                if (is_array($parsed) && isset($parsed['draft_response'])) {
                    return [
                        'severity' => $parsed['severity'] ?? 'moderado',
                        'draft' => $parsed['draft_response'],
                        'confidence' => (float) ($parsed['confidence'] ?? 0.90),
                        'engine' => 'gemini_flash',
                    ];
                }
            }
        } catch (\Throwable $e) {
            Log::error("[Triage AI] Error en llamada Gemini: " . $e->getMessage());
        }

        return $this->ruleBasedFallback($symptoms, $tenant, $pet);
    }

    /**
     * Fallback determinista seguro en caso de corte total de APIs externas.
     */
    protected function ruleBasedFallback(string $symptoms, Tenant $tenant, ?Pet $pet = null): array
    {
        $petName = $pet ? $pet->name : 'tu mascota';
        $draft = "Hemos revisado los síntomas reportados para {$petName}. Te recomendamos vigilar de cerca su hidratación y estado de ánimo. Si continúa con malestar durante las próximas 4 a 6 horas, te sugerimos agendar una valoración presencial en nuestra sede para examinarlo adecuadamente.";

        return [
            'severity' => 'moderado',
            'draft' => $draft,
            'confidence' => 0.75,
            'engine' => 'deterministic_fallback',
        ];
    }
}
