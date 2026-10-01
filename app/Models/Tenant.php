<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'branding',
        'is_active',
        'saas_plan_tier',
    ];

    protected $casts = [
        'branding' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::created(function (Tenant $tenant) {
            $tenant->provisionDefaultPlansAndBenefits();
        });
    }

    /**
     * Clona y aprovisiona los planes y la matriz de beneficios médicos estándar para esta clínica.
     */
    public function provisionDefaultPlansAndBenefits(): void
    {
        // 1. Beneficios Estándar
        $bKit = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Kit Bienvenida (Cédula + Collar Placa + Carnet Digital)'],
            ['description' => 'Identificación oficial, placa grabada y registro médico inicial.', 'category' => 'bienvenida']
        );

        $bConsultaVirtual = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Consultas Virtuales Ilimitadas'],
            ['description' => 'Teleorientación médica veterinaria de lunes a domingo.', 'category' => 'consulta']
        );

        $bConsultaPresencial = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Consultas Presenciales en Clínica'],
            ['description' => 'Valoración médica clínica por sintomatología o control.', 'category' => 'consulta']
        );

        $bChequeoPreventivo = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Chequeos Preventivos Trimestrales'],
            ['description' => 'Control de peso, constantes vitales y prevención cada 3 meses.', 'category' => 'consulta']
        );

        $bVacunaAnual = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Vacunación Anual Completa (Pentavalente/Triple + Rabia)'],
            ['description' => 'Biológico certificado anual con firma veterinaria.', 'category' => 'vacuna']
        );

        $bDesparasitacion = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Desparasitación Interna'],
            ['description' => 'Tratamiento profiláctico trimestral (3 veces al año).', 'category' => 'desparasitacion']
        );

        $bAntipulgas = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Desparasitación Externa / Antipulgas (Credelio / Pipeta)'],
            ['description' => 'Protección antiparasitaria externa semestral (cada 6 meses).', 'category' => 'desparasitacion']
        );

        $bLaboratorio = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Exámenes de Laboratorio al 100% (Hemograma + Creatinina/ALT/BUN)'],
            ['description' => 'Perfil bioquímico básico y cuadro hemático por enfermedad o urgencia.', 'category' => 'laboratorio']
        );

        $bCitologia = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Citología de Oídos'],
            ['description' => 'Evaluación microscópica ótica para prevención de otitis.', 'category' => 'laboratorio']
        );

        $bBano = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Baño y Peluquería Canina/Felina'],
            ['description' => 'Higiene, corte de uñas y estética profesional.', 'category' => 'bano']
        );

        $bFunerario = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Servicio Funerario y Cremación'],
            ['description' => 'Cobertura exequial digna para tu mascota.', 'category' => 'funerario']
        );

        // 2. Plan Básico ($50.000 COP)
        $planBasico = Plan::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Plan Patitas Básico'],
            [
                'description' => 'Afiliación $50.000 + mensualidad de $50.000 COP. Incluye Kit Bienvenida, 3 consultas, vacunas, desparasitaciones y descuentos.',
                'price_cop' => 50000.00,
                'billing_interval' => 'monthly',
                'is_active' => true,
            ]
        );

        PlanBenefit::firstOrCreate(['plan_id' => $planBasico->id, 'benefit_definition_id' => $bKit->id], ['quantity' => 1]);
        PlanBenefit::firstOrCreate(['plan_id' => $planBasico->id, 'benefit_definition_id' => $bConsultaVirtual->id], ['quantity' => 999]);
        PlanBenefit::firstOrCreate(['plan_id' => $planBasico->id, 'benefit_definition_id' => $bConsultaPresencial->id], ['quantity' => 3]);
        PlanBenefit::firstOrCreate(['plan_id' => $planBasico->id, 'benefit_definition_id' => $bChequeoPreventivo->id], ['quantity' => 4]);
        PlanBenefit::firstOrCreate(['plan_id' => $planBasico->id, 'benefit_definition_id' => $bVacunaAnual->id], ['quantity' => 1]);
        PlanBenefit::firstOrCreate(['plan_id' => $planBasico->id, 'benefit_definition_id' => $bDesparasitacion->id], ['quantity' => 3]);
        PlanBenefit::firstOrCreate(['plan_id' => $planBasico->id, 'benefit_definition_id' => $bAntipulgas->id], ['quantity' => 2]);
        PlanBenefit::firstOrCreate(['plan_id' => $planBasico->id, 'benefit_definition_id' => $bLaboratorio->id], ['quantity' => 1]);
        PlanBenefit::firstOrCreate(['plan_id' => $planBasico->id, 'benefit_definition_id' => $bCitologia->id], ['quantity' => 2]);
        PlanBenefit::firstOrCreate(['plan_id' => $planBasico->id, 'benefit_definition_id' => $bBano->id], ['quantity' => 2]);

        // 3. Plan Premium ($80.000 COP)
        $planPremium = Plan::firstOrCreate(
            ['tenant_id' => $this->id, 'name' => 'Plan Patitas Premium'],
            [
                'description' => 'Primer mes $150.000 y $80.000 COP desde el 2do mes. Cobertura premium total con laboratorio, consultas, vacunación y servicio funerario 100% incluido.',
                'price_cop' => 80000.00,
                'billing_interval' => 'monthly',
                'is_active' => true,
            ]
        );

        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bKit->id], ['quantity' => 1]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bConsultaVirtual->id], ['quantity' => 999]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bConsultaPresencial->id], ['quantity' => 3]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bChequeoPreventivo->id], ['quantity' => 4]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bVacunaAnual->id], ['quantity' => 1]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bAntipulgas->id], ['quantity' => 2]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bLaboratorio->id], ['quantity' => 2]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bFunerario->id], ['quantity' => 1]);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }

    public function benefitDefinitions(): HasMany
    {
        return $this->hasMany(BenefitDefinition::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
