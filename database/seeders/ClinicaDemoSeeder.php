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
        // 1. Crear o Recuperar Clínica Demo (Tenant)
        $tenant = Tenant::firstOrCreate(
            ['slug' => 'patitas-felices'],
            [
                'name' => 'Clínica Veterinaria Patitas Felices',
                'domain' => 'patitas.aviplan.co',
                'branding' => [
                    'logo_url' => 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=300',
                    'primary_color' => '#10B981',
                    'secondary_color' => '#065F46',
                ],
                'is_active' => true,
                'saas_plan_tier' => 'pro',
            ]
        );

        // 2. Crear o Recuperar Usuario Administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@patitasfelices.com'],
            [
                'tenant_id' => $tenant->id,
                'name' => 'Dr. Robinson Naranjo',
                'password' => Hash::make('Ashley2023##'),
                'role' => 'clinic_admin',
            ]
        );

        // 3. Catálogo de Beneficios
        $bConsulta = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Consulta Médica General'],
            ['description' => 'Valoración médica clínica preventiva.', 'category' => 'consulta']
        );

        $bVacuna = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Vacuna Anual (Rabia / Sextuple / Triple Felina)'],
            ['description' => 'Aplicación de biológico certificado.', 'category' => 'vacuna']
        );

        $bDesparasitacion = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Desparasitación Interna y Externa'],
            ['description' => 'Tratamiento profiláctico trimestral.', 'category' => 'desparasitacion']
        );

        $bBano = BenefitDefinition::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Baño Medicado y Corte de Uñas'],
            ['description' => 'Higiene y estética con shampoo hipoalergénico.', 'category' => 'bano']
        );

        // 4. Planes
        $planVIP = Plan::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Plan Patitas VIP / Completo'],
            [
                'description' => 'Cobertura total con baños mensuales y consultas ilimitadas.',
                'price_cop' => 85000.00,
                'billing_interval' => 'monthly',
                'is_active' => true,
            ]
        );

        PlanBenefit::firstOrCreate(['plan_id' => $planVIP->id, 'benefit_definition_id' => $bConsulta->id], ['quantity' => 12]);
        PlanBenefit::firstOrCreate(['plan_id' => $planVIP->id, 'benefit_definition_id' => $bVacuna->id], ['quantity' => 3]);
        PlanBenefit::firstOrCreate(['plan_id' => $planVIP->id, 'benefit_definition_id' => $bDesparasitacion->id], ['quantity' => 4]);
        PlanBenefit::firstOrCreate(['plan_id' => $planVIP->id, 'benefit_definition_id' => $bBano->id], ['quantity' => 6]);

        // 5. Tutor y Mascota
        $tutor = Customer::firstOrCreate(
            ['tenant_id' => $tenant->id, 'identification' => '1020304050'],
            [
                'name' => 'Carlos Mendoza',
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
                'medical_notes' => 'Alergia estacional leve al pasto.',
            ]
        );

        $sub = Subscription::firstOrCreate(
            ['tenant_id' => $tenant->id, 'pet_id' => $pet->id],
            [
                'plan_id' => $planVIP->id,
                'status' => 'active',
                'current_period_start' => now(),
                'current_period_end' => now()->addMonth(),
            ]
        );

        SubscriptionBenefitBalance::firstOrCreate(
            ['subscription_id' => $sub->id, 'benefit_definition_id' => $bConsulta->id],
            ['total_granted' => 12, 'used_count' => 2, 'remaining_count' => 10]
        );

        SubscriptionBenefitBalance::firstOrCreate(
            ['subscription_id' => $sub->id, 'benefit_definition_id' => $bVacuna->id],
            ['total_granted' => 3, 'used_count' => 1, 'remaining_count' => 2]
        );

        SubscriptionBenefitBalance::firstOrCreate(
            ['subscription_id' => $sub->id, 'benefit_definition_id' => $bDesparasitacion->id],
            ['total_granted' => 4, 'used_count' => 0, 'remaining_count' => 4]
        );

        SubscriptionBenefitBalance::firstOrCreate(
            ['subscription_id' => $sub->id, 'benefit_definition_id' => $bBano->id],
            ['total_granted' => 6, 'used_count' => 1, 'remaining_count' => 5]
        );
    }
}
