<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FastApiClient
{
    protected string $baseUrl;
    protected float $timeout;

    public function __construct()
    {
        $this->baseUrl = config('services.ai_service.url', env('AI_SERVICE_URL', 'http://avi-ai:8001'));
        $this->timeout = (float) config('services.ai_service.timeout', env('AI_SERVICE_TIMEOUT', 4.0));
    }

    public function recommendPlan(string $species, int $ageMonths, array $conditions = [], string $budget = 'medium'): array
    {
        try {
            $response = Http::timeout($this->timeout)->post("{$this->baseUrl}/recommend-plan", [
                'species' => $species,
                'age_months' => $ageMonths,
                'health_conditions' => $conditions,
                'budget_tier' => $budget,
            ]);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $e) {
            Log::warning("FastAPI AI Service unreachable: " . $e->getMessage());
        }

        // Fallback determinista si la IA no responde
        return [
            'recommended_plan' => 'Plan Patitas Completo',
            'confidence' => 0.85,
            'rationale' => 'Recomendación estándar basada en perfil preventivo integral.',
            'is_fallback' => true,
        ];
    }
}
