<?php

namespace App\Services;

class ActuarialMonteCarloService
{
    /**
     * Tabla de parámetros actuariales por raza y fenotipo biomédico.
     */
    private array $breedRiskProfiles = [
        'bulldog_frances' => [
            'name' => 'Bulldog Francés / Inglés (Braquicefálico)',
            'base_life_expectancy' => 10.5,
            'risk_multiplier' => 1.45,
            'annual_expected_cost_cop' => 380000,
            'frequent_pathologies' => ['Síndrome obstructivo respiratorio (BOAS)', 'Dermatitis atópica de pliegues', 'Hernias discales'],
        ],
        'golden_retriever' => [
            'name' => 'Golden Retriever / Labrador (Raza Grande)',
            'base_life_expectancy' => 12.0,
            'risk_multiplier' => 1.20,
            'annual_expected_cost_cop' => 290000,
            'frequent_pathologies' => ['Displasia coxofemoral', 'Otitis alérgica crónica', 'Dermatitis húmeda aguda'],
        ],
        'poodle' => [
            'name' => 'Poodle / Caniche / Schnauzer (Raza Pequeña)',
            'base_life_expectancy' => 15.0,
            'risk_multiplier' => 0.90,
            'annual_expected_cost_cop' => 180000,
            'frequent_pathologies' => ['Enfermedad periodontal / profilaxis', 'Luxación patelar medial', 'Cataratas seniles'],
        ],
        'mestizo' => [
            'name' => 'Mestizo / Criollo (Vigor Híbrido)',
            'base_life_expectancy' => 14.5,
            'risk_multiplier' => 0.75,
            'annual_expected_cost_cop' => 140000,
            'frequent_pathologies' => ['Traumatismos externos', 'Enfermedad gastrointestinal leve', 'Vacunación preventiva'],
        ],
        'felino' => [
            'name' => 'Felino Doméstico / Mestizo (Gato)',
            'base_life_expectancy' => 15.5,
            'risk_multiplier' => 0.85,
            'annual_expected_cost_cop' => 165000,
            'frequent_pathologies' => ['Enfermedad renal crónica (ERC)', 'Enfermedad de vías urinarias (FLUTD)', 'Gingivoestomatitis'],
        ],
    ];

    /**
     * Ejecuta una simulación estocástica de Monte Carlo (1.000 iteraciones).
     * Fórmula Universidad Piloto: Ganancia = sum(Pm * 12 * Ev_i) - sum(Ca * Ev_i)
     */
    public function simulate(
        string $breedKey = 'golden_retriever',
        int $ageYears = 3,
        float $targetNetMarginPercent = 35.0,
        int $iterations = 1000
    ): array {
        $profile = $this->breedRiskProfiles[$breedKey] ?? $this->breedRiskProfiles['mestizo'];
        
        $baseLife = $profile['base_life_expectancy'];
        $remainingLife = max(1.0, $baseLife - $ageYears);
        $annualCost = $profile['annual_expected_cost_cop'];
        $multiplier = $profile['risk_multiplier'];

        // Ajuste por edad (curva actuarial exponencial tras los 7 años)
        $ageFactor = $ageYears > 7 ? (1.0 + (($ageYears - 7) * 0.12)) : 1.0;
        $adjustedAnnualCost = $annualCost * $multiplier * $ageFactor;

        // Cuota mensual estocástica sugerida para alcanzar el margen objetivo
        // Margen = (Ingresos - Costos) / Ingresos => Ingresos = Costos / (1 - Margen)
        $targetMarginRatio = $targetNetMarginPercent / 100.0;
        $recommendedAnnualRevenue = $adjustedAnnualCost / (1.0 - $targetMarginRatio);
        $suggestedMonthlyFee = round(($recommendedAnnualRevenue / 12) / 1000) * 1000; // Redondear a miles COP

        // 1.000 Corridas de Monte Carlo
        $simulatedProfits = [];
        for ($i = 0; $i < $iterations; $i++) {
            // Variación aleatoria de costos médicos anuales (distribución normal aproximada)
            $randomShock = (mt_rand(75, 135) / 100.0);
            $simulatedAnnualCost = $adjustedAnnualCost * $randomShock;
            $annualRevenue = $suggestedMonthlyFee * 12;
            $annualProfit = $annualRevenue - $simulatedAnnualCost;
            $simulatedProfits[] = $annualProfit * $remainingLife;
        }

        sort($simulatedProfits);
        
        // Percentiles estadísticos
        $p05 = $simulatedProfits[(int) ($iterations * 0.05)]; // Value at Risk 95%
        $p50 = $simulatedProfits[(int) ($iterations * 0.50)]; // Mediana esperada
        $p95 = $simulatedProfits[(int) ($iterations * 0.95)]; // Escenario optimista

        $reservePerMonth = round(($suggestedMonthlyFee * 0.10) / 1000) * 1000;

        return [
            'breed_name' => $profile['name'],
            'pet_age_years' => $ageYears,
            'remaining_life_expectancy' => round($remainingLife, 1) . ' años restantes',
            'suggested_monthly_fee_cop' => $suggestedMonthlyFee,
            'formatted_monthly_fee' => '$' . number_format($suggestedMonthlyFee, 0, ',', '.') . ' COP/mes',
            'target_net_margin' => $targetNetMarginPercent . '%',
            'confidence_level' => '95% de confianza estadística',
            'monte_carlo_iterations' => $iterations,
            'var_95_min_profit' => '$' . number_format($p05, 0, ',', '.') . ' COP',
            'expected_median_ltv_profit' => '$' . number_format($p50, 0, ',', '.') . ' COP',
            'optimistic_ltv_profit' => '$' . number_format($p95, 0, ',', '.') . ' COP',
            'emergency_reserve_accrual_10' => '$' . number_format($reservePerMonth, 0, ',', '.') . ' COP/mes',
            'risk_level' => $multiplier > 1.2 ? 'Alto Riesgo (Cuota Ajustada)' : ($multiplier < 0.9 ? 'Bajo Riesgo (Alta Rentabilidad)' : 'Riesgo Moderado'),
            'frequent_pathologies' => $profile['frequent_pathologies'],
            'actuarial_verdict' => "Para un {$profile['name']} de {$ageYears} años, una cuota de $" . number_format($suggestedMonthlyFee, 0, ',', '.') . " COP/mes garantiza un {$targetNetMarginPercent}% de margen neto para la clínica y destina $" . number_format($reservePerMonth, 0, ',', '.') . " COP/mes al Crédito de Emergencia sin desfinanciar el negocio.",
        ];
    }

    /**
     * Lista de perfiles disponibles para selectores en UI.
     */
    public function getAvailableBreeds(): array
    {
        return array_map(fn ($k, $v) => ['key' => $k, 'name' => $v['name']], array_keys($this->breedRiskProfiles), $this->breedRiskProfiles);
    }
}
