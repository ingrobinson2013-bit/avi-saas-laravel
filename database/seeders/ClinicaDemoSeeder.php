<?php

namespace Database\Seeders;

use App\Models\BenefitDefinition;
use App\Models\BenefitRedemption;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\PlanBenefit;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClinicaDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clínica Patitas Felices (Tenant)
        $tenant = Tenant::firstOrCreate(
            ['slug' => 'patitas-felices'],
            [
                'name' => 'Clínica Veterinaria Patitas Felices',
                'domain' => 'patitas.aviplan.co',
                'branding' => [
                    'logo_url' => 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=300',
                    'primary_color' => '#10B981',
                    'secondary_color' => '#065F46',
                    'phone' => '3508742543',
                ],
                'is_active' => true,
                'saas_plan_tier' => 'pro',
            ]
        );

        // 2. Super Administrador (Robinson)
        User::firstOrCreate(
            ['email' => 'superadmin@aviplan.co'],
            [
                'name' => 'Robinson Naranjo (CEO NODIA)',
                'password' => Hash::make('Ashley2023##'),
                'role' => 'super_admin',
            ]
        );

        // 3. Usuario Administrador de la Clínica
        $admin = User::firstOrCreate(
            ['email' => 'admin@patitasfelices.com'],
            [
                'tenant_id' => $tenant->id,
                'name' => 'Dra. Robinson & Hermana (Patitas Felices)',
                'password' => Hash::make('Ashley2023##'),
                'role' => 'clinic_admin',
            ]
        );

        // 4. Catálogo de Beneficios Oficiales Patitas Felices
        $bKit = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Kit Bienvenida (Cédula + Collar Placa + Carnet Digital)'],
            ['description' => 'Identificación oficial, placa grabada y registro médico inicial.', 'category' => 'bienvenida']
        );

        $bConsultaVirtual = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Consultas Virtuales Ilimitadas'],
            ['description' => 'Teleorientación médica veterinaria de lunes a domingo.', 'category' => 'consulta']
        );

        $bConsultaPresencial = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Consultas Presenciales en Clínica'],
            ['description' => 'Valoración médica clínica por sintomatología o control.', 'category' => 'consulta']
        );

        $bChequeoPreventivo = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Chequeos Preventivos Trimestrales'],
            ['description' => 'Control de peso, constantes vitales y prevención cada 3 meses.', 'category' => 'consulta']
        );

        $bVacunaAnual = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Vacunación Anual Completa (Pentavalente/Triple + Rabia)'],
            ['description' => 'Biológico certificado anual con firma veterinaria.', 'category' => 'vacuna']
        );

        $bDesparasitacion = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Desparasitación Interna'],
            ['description' => 'Tratamiento profiláctico trimestral (3 veces al año).', 'category' => 'desparasitacion']
        );

        $bAntipulgas = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Desparasitación Externa / Antipulgas (Credelio / Pipeta)'],
            ['description' => 'Protección antiparasitaria externa semestral (cada 6 meses).', 'category' => 'desparasitacion']
        );

        $bLaboratorio = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Exámenes de Laboratorio al 100% (Hemograma + Creatinina/ALT/BUN)'],
            ['description' => 'Perfil bioquímico básico y cuadro hemático por enfermedad o urgencia.', 'category' => 'laboratorio']
        );

        $bCitologia = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Citología de Oídos'],
            ['description' => 'Evaluación microscópica ótica para prevención de otitis.', 'category' => 'laboratorio']
        );

        $bBano = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Baño y Peluquería Canina/Felina'],
            ['description' => 'Higiene, corte de uñas y estética profesional.', 'category' => 'bano']
        );

        $bFunerario = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Servicio Funerario y Cremación'],
            ['description' => 'Cobertura exequial digna para tu mascota.', 'category' => 'funerario']
        );

        // 5. Crear Plan Patitas Básico ($50.000 COP/mes)
        $planBasico = Plan::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Plan Patitas Básico'],
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

        // 6. Crear Plan Patitas Premium ($150.000 1er mes / $80.000 COP/mes)
        $planPremium = Plan::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Plan Patitas Premium'],
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

        // 7. Tutor y Mascota Demo
        $tutor = Customer::firstOrCreate(
            ['tenant_id' => $tenant->id, 'identification' => '1020304050'],
            [
                'name' => 'Carlos Mendoza (Tutor)',
                'phone' => '+573001234567',
                'email' => 'carlos.mendoza@gmail.com',
            ]
        );

        $pet = Pet::firstOrCreate(
            ['customer_id' => $tutor->id, 'name' => 'Max'],
            [
                'species' => 'dog',
                'breed' => 'Golden Retriever',
                'birthdate' => now()->subYears(3),
                'medical_notes' => 'Paciente afiliado a Plan Patitas Premium.',
            ]
        );

        $sub = Subscription::firstOrCreate(
            ['tenant_id' => $tenant->id, 'pet_id' => $pet->id],
            [
                'plan_id' => $planPremium->id,
                'status' => 'active',
                'current_period_start' => now(),
                'current_period_end' => now()->addMonth(),
            ]
        );

        // Saldos en el Ledger
        SubscriptionBenefitBalance::firstOrCreate(
            ['subscription_id' => $sub->id, 'benefit_definition_id' => $bConsultaPresencial->id],
            ['total_granted' => 3, 'used_count' => 1, 'remaining_count' => 2]
        );

        SubscriptionBenefitBalance::firstOrCreate(
            ['subscription_id' => $sub->id, 'benefit_definition_id' => $bVacunaAnual->id],
            ['total_granted' => 1, 'used_count' => 0, 'remaining_count' => 1]
        );

        SubscriptionBenefitBalance::firstOrCreate(
            ['subscription_id' => $sub->id, 'benefit_definition_id' => $bLaboratorio->id],
            ['total_granted' => 2, 'used_count' => 0, 'remaining_count' => 2]
        );

        SubscriptionBenefitBalance::firstOrCreate(
            ['subscription_id' => $sub->id, 'benefit_definition_id' => $bAntipulgas->id],
            ['total_granted' => 2, 'used_count' => 1, 'remaining_count' => 1]
        );
    }
}
