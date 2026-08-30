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
        // 1. Crear Clínica Demo (Tenant)
        $tenant = Tenant::create([
            'name' => 'Clínica Veterinaria Patitas Felices',
            'slug' => 'patitas-felices',
            'domain' => 'patitas.aviplan.co',
            'branding' => [
                'logo_url' => 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=300',
                'primary_color' => '#10B981', // Verde esmeralda
                'secondary_color' => '#065F46',
            ],
            'is_active' => true,
            'saas_plan_tier' => 'pro',
        ]);

        // 2. Crear Usuarios (Admin de la clínica & Veterinario)
        $admin = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Dra. Robinson Naranjo',
            'email' => 'admin@patitasfelices.com',
            'password' => Hash::make('Ashley2023##'),
            'role' => 'clinic_admin',
        ]);

        // 3. Crear Catálogo de Beneficios
        $bConsulta = BenefitDefinition::create([
            'tenant_id' => $tenant->id,
            'name' => 'Consulta Médica General',
            'description' => 'Valoración médica clínica preventiva y revisión general.',
            'category' => 'consulta',
        ]);

        $bVacuna = BenefitDefinition::create([
            'tenant_id' => $tenant->id,
            'name' => 'Vacuna Anual (Rabia / Sextuple / Triple Felina)',
            'description' => 'Aplicación de biológico certificado anual con carnet digital.',
            'category' => 'vacuna',
        ]);

        $bDesparasitacion = BenefitDefinition::create([
            'tenant_id' => $tenant->id,
            'name' => 'Desparasitación Interna y Externa',
            'description' => 'Tratamiento profiláctico trimestral.',
            'category' => 'desparasitacion',
        ]);

        $bBano = BenefitDefinition::create([
            'tenant_id' => $tenant->id,
            'name' => 'Baño Medicado y Corte de Uñas',
            'description' => 'Higiene y estética con shampoo hipoalergénico.',
            'category' => 'bano',
        ]);

        // 4. Crear Planes de la Clínica
        $planVital = Plan::create([
            'tenant_id' => $tenant->id,
            'name' => 'Plan Patitas Vital',
            'description' => 'El plan ideal para el cuidado preventivo integral de todo el año.',
            'price_cop' => 45000.00,
            'billing_interval' => 'monthly',
            'is_active' => true,
        ]);

        PlanBenefit::create(['plan_id' => $planVital->id, 'benefit_definition_id' => $bConsulta->id, 'quantity' => 6]);
        PlanBenefit::create(['plan_id' => $planVital->id, 'benefit_definition_id' => $bVacuna->id, 'quantity' => 2]);
        PlanBenefit::create(['plan_id' => $planVital->id, 'benefit_definition_id' => $bDesparasitacion->id, 'quantity' => 4]);

        $planVIP = Plan::create([
            'tenant_id' => $tenant->id,
            'name' => 'Plan Patitas VIP / Completo',
            'description' => 'Cobertura total con baños mensuales y consultas ilimitadas.',
            'price_cop' => 85000.00,
            'billing_interval' => 'monthly',
            'is_active' => true,
        ]);

        PlanBenefit::create(['plan_id' => $planVIP->id, 'benefit_definition_id' => $bConsulta->id, 'quantity' => 12]);
        PlanBenefit::create(['plan_id' => $planVIP->id, 'benefit_definition_id' => $bVacuna->id, 'quantity' => 3]);
        PlanBenefit::create(['plan_id' => $planVIP->id, 'benefit_definition_id' => $bDesparasitacion->id, 'quantity' => 4]);
        PlanBenefit::create(['plan_id' => $planVIP->id, 'benefit_definition_id' => $bBano->id, 'quantity' => 6]);

        // 5. Crear Tutores y Mascotas con Suscripciones Activas
        $tutor = Customer::create([
            'tenant_id' => $tenant->id,
            'name' => 'Carlos Mendoza',
            'phone' => '+573001234567',
            'email' => 'carlos.mendoza@gmail.com',
            'identification' => '1020304050',
        ]);

        $pet = Pet::create([
            'customer_id' => $tutor->id,
            'name' => 'Max',
            'species' => 'dog',
            'breed' => 'Golden Retriever',
            'birthdate' => now()->subYears(3),
            'medical_notes' => 'Alergia estacional leve al pasto.',
        ]);

        $sub = Subscription::create([
            'tenant_id' => $tenant->id,
            'pet_id' => $pet->id,
            'plan_id' => $planVIP->id,
            'status' => 'active',
            'current_period_start' => now(),
            'current_period_end' => now()->addMonth(),
        ]);

        // Crear Saldos de Beneficios en el Ledger
        $balConsulta = SubscriptionBenefitBalance::create([
            'subscription_id' => $sub->id,
            'benefit_definition_id' => $bConsulta->id,
            'total_granted' => 12,
            'used_count' => 2,
            'remaining_count' => 10,
        ]);

        SubscriptionBenefitBalance::create([
            'subscription_id' => $sub->id,
            'benefit_definition_id' => $bVacuna->id,
            'total_granted' => 3,
            'used_count' => 1,
            'remaining_count' => 2,
        ]);

        SubscriptionBenefitBalance::create([
            'subscription_id' => $sub->id,
            'benefit_definition_id' => $bDesparasitacion->id,
            'total_granted' => 4,
            'used_count' => 0,
            'remaining_count' => 4,
        ]);

        SubscriptionBenefitBalance::create([
            'subscription_id' => $sub->id,
            'benefit_definition_id' => $bBano->id,
            'total_granted' => 6,
            'used_count' => 1,
            'remaining_count' => 5,
        ]);

        // Registrar un Canje de Prueba Histórico
        BenefitRedemption::create([
            'tenant_id' => $tenant->id,
            'balance_id' => $balConsulta->id,
            'redeemed_at' => now()->subDays(5),
            'vet_user_id' => $admin->id,
            'quantity' => 1,
            'notes' => 'Consulta de control general y pesaje.',
        ]);
    }
}
