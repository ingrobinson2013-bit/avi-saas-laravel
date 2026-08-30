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
        // 1. Clínica Vet-Pet Patitas (Tenant Piloto)
        $tenant = Tenant::firstOrCreate(
            ['slug' => 'vet-pet-patitas'],
            [
                'name' => 'Vet-Pet Patitas Consultorio Veterinario',
                'domain' => 'patitas.aviplan.co',
                'branding' => [
                    'logo_url' => 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=300',
                    'primary_color' => '#10B981',
                    'secondary_color' => '#065F46',
                    'phone' => '3508742543',
                    'email' => 'petmovilveterinario@gmail.com',
                    'city' => 'Cajicá, Cundinamarca',
                    'address' => 'Calle 7 # 4-73 Este (hacia El Parasol rojo)',
                ],
                'is_active' => true,
                'saas_plan_tier' => 'pro',
            ]
        );

        // Actualizar también el tenant previo si existía con patitas-felices
        Tenant::where('slug', 'patitas-felices')->update([
            'name' => 'Vet-Pet Patitas Consultorio Veterinario',
            'slug' => 'vet-pet-patitas',
        ]);

        // 2. Super Administrador (Robinson - CEO NODIA)
        User::firstOrCreate(
            ['email' => 'superadmin@aviplan.co'],
            [
                'name' => 'Robinson Naranjo (CEO NODIA)',
                'password' => Hash::make('Ashley2023##'),
                'role' => 'super_admin',
            ]
        );

        // 3. Usuario Administrador de Vet-Pet Patitas
        User::firstOrCreate(
            ['email' => 'petmovilveterinario@gmail.com'],
            [
                'tenant_id' => $tenant->id,
                'name' => 'Dra. Vet-Pet Patitas',
                'password' => Hash::make('Ashley2023##'),
                'role' => 'clinic_admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@patitasfelices.com'],
            [
                'tenant_id' => $tenant->id,
                'name' => 'Administración Vet-Pet Patitas',
                'password' => Hash::make('Ashley2023##'),
                'role' => 'clinic_admin',
            ]
        );

        // 4. Beneficios
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

        // 5. Planes
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

        // 6. Tutores y Mascotas Demo
        $vetUser = User::where('email', 'petmovilveterinario@gmail.com')->first();

        // ==========================================
        // EJEMPLO 1: MAX (Golden Retriever - Plan Premium)
        // ==========================================
        $tutorMax = Customer::firstOrCreate(
            ['tenant_id' => $tenant->id, 'identification' => '1020304050'],
            [
                'name' => 'Carlos Mendoza',
                'phone' => '+573001234567',
                'email' => 'carlos.mendoza@gmail.com',
            ]
        );

        $petMax = Pet::firstOrCreate(
            ['customer_id' => $tutorMax->id, 'name' => 'Max'],
            [
                'species' => 'dog',
                'breed' => 'Golden Retriever',
                'birthdate' => now()->subYears(3),
                'medical_notes' => 'Paciente afiliado a Plan Patitas Premium en Cajicá. Alergia leve a pollo.',
            ]
        );

        $subMax = Subscription::firstOrCreate(
            ['tenant_id' => $tenant->id, 'pet_id' => $petMax->id],
            [
                'plan_id' => $planPremium->id,
                'status' => 'active',
                'current_period_start' => now()->subDays(10),
                'current_period_end' => now()->addDays(20),
            ]
        );

        // Saldos en Vivo para Max (Plan Premium)
        $balMaxKit = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subMax->id, 'benefit_definition_id' => $bKit->id],
            ['total_granted' => 1, 'used_count' => 1, 'remaining_count' => 0]
        );

        $balMaxVirtual = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subMax->id, 'benefit_definition_id' => $bConsultaVirtual->id],
            ['total_granted' => 999, 'used_count' => 2, 'remaining_count' => 997]
        );

        $balMaxConsulta = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subMax->id, 'benefit_definition_id' => $bConsultaPresencial->id],
            ['total_granted' => 3, 'used_count' => 1, 'remaining_count' => 2]
        );

        $balMaxChequeo = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subMax->id, 'benefit_definition_id' => $bChequeoPreventivo->id],
            ['total_granted' => 4, 'used_count' => 1, 'remaining_count' => 3]
        );

        $balMaxVacuna = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subMax->id, 'benefit_definition_id' => $bVacunaAnual->id],
            ['total_granted' => 1, 'used_count' => 0, 'remaining_count' => 1]
        );

        $balMaxAntipulgas = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subMax->id, 'benefit_definition_id' => $bAntipulgas->id],
            ['total_granted' => 2, 'used_count' => 1, 'remaining_count' => 1]
        );

        $balMaxLab = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subMax->id, 'benefit_definition_id' => $bLaboratorio->id],
            ['total_granted' => 2, 'used_count' => 0, 'remaining_count' => 2]
        );

        $balMaxBano = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subMax->id, 'benefit_definition_id' => $bBano->id],
            ['total_granted' => 2, 'used_count' => 1, 'remaining_count' => 1]
        );

        $balMaxFunerario = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subMax->id, 'benefit_definition_id' => $bFunerario->id],
            ['total_granted' => 1, 'used_count' => 0, 'remaining_count' => 1]
        );

        // Canjes Auditados en el Historial de Max
        BenefitRedemption::firstOrCreate(
            ['tenant_id' => $tenant->id, 'balance_id' => $balMaxKit->id],
            [
                'redeemed_at' => now()->subDays(10),
                'vet_user_id' => $vetUser?->id,
                'quantity' => 1,
                'notes' => 'Entrega de Kit Oficial: Cédula de Identidad, Placa QR y Collar de Bienvenida.',
            ]
        );

        BenefitRedemption::firstOrCreate(
            ['tenant_id' => $tenant->id, 'balance_id' => $balMaxConsulta->id],
            [
                'redeemed_at' => now()->subDays(7),
                'vet_user_id' => $vetUser?->id,
                'quantity' => 1,
                'notes' => 'Consulta preventiva general. Paciente con peso óptimo (31.5kg). Examen cardiopulmonar normal.',
            ]
        );

        BenefitRedemption::firstOrCreate(
            ['tenant_id' => $tenant->id, 'balance_id' => $balMaxAntipulgas->id],
            [
                'redeemed_at' => now()->subDays(4),
                'vet_user_id' => $vetUser?->id,
                'quantity' => 1,
                'notes' => 'Aplicación y entrega de comprimido Credelio 450mg para protección antiparasitaria externa.',
            ]
        );

        BenefitRedemption::firstOrCreate(
            ['tenant_id' => $tenant->id, 'balance_id' => $balMaxBano->id],
            [
                'redeemed_at' => now()->subDays(2),
                'vet_user_id' => $vetUser?->id,
                'quantity' => 1,
                'notes' => 'Baño medicado dermatológico, corte de uñas y limpieza de oídos.',
            ]
        );


        // ==========================================
        // EJEMPLO 2: LUNA (Gata Siamés - Plan Básico por vencer en 4 días)
        // ==========================================
        $tutorLuna = Customer::firstOrCreate(
            ['tenant_id' => $tenant->id, 'identification' => '1030405060'],
            [
                'name' => 'María Fernanda Gómez',
                'phone' => '+573109876543',
                'email' => 'mafe.gomez@hotmail.com',
            ]
        );

        $petLuna = Pet::firstOrCreate(
            ['customer_id' => $tutorLuna->id, 'name' => 'Luna'],
            [
                'species' => 'cat',
                'breed' => 'Siamés',
                'birthdate' => now()->subYears(2),
                'medical_notes' => 'Esterilizada. Esquema de vacunación felina al día.',
            ]
        );

        $subLuna = Subscription::firstOrCreate(
            ['tenant_id' => $tenant->id, 'pet_id' => $petLuna->id],
            [
                'plan_id' => $planBasico->id,
                'status' => 'active',
                'current_period_start' => now()->subDays(26),
                'current_period_end' => now()->addDays(4), // Vence en 4 días (Alerta de renovación activa)
            ]
        );

        // Saldos en Vivo para Luna (Plan Básico)
        $balLunaKit = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subLuna->id, 'benefit_definition_id' => $bKit->id],
            ['total_granted' => 1, 'used_count' => 1, 'remaining_count' => 0]
        );

        $balLunaVirtual = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subLuna->id, 'benefit_definition_id' => $bConsultaVirtual->id],
            ['total_granted' => 999, 'used_count' => 1, 'remaining_count' => 998]
        );

        $balLunaConsulta = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subLuna->id, 'benefit_definition_id' => $bConsultaPresencial->id],
            ['total_granted' => 3, 'used_count' => 2, 'remaining_count' => 1]
        );

        $balLunaChequeo = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subLuna->id, 'benefit_definition_id' => $bChequeoPreventivo->id],
            ['total_granted' => 4, 'used_count' => 1, 'remaining_count' => 3]
        );

        $balLunaVacuna = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subLuna->id, 'benefit_definition_id' => $bVacunaAnual->id],
            ['total_granted' => 1, 'used_count' => 0, 'remaining_count' => 1]
        );

        $balLunaDesp = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subLuna->id, 'benefit_definition_id' => $bDesparasitacion->id],
            ['total_granted' => 3, 'used_count' => 1, 'remaining_count' => 2]
        );

        $balLunaAntipulgas = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subLuna->id, 'benefit_definition_id' => $bAntipulgas->id],
            ['total_granted' => 2, 'used_count' => 1, 'remaining_count' => 1]
        );

        $balLunaLab = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subLuna->id, 'benefit_definition_id' => $bLaboratorio->id],
            ['total_granted' => 1, 'used_count' => 0, 'remaining_count' => 1]
        );

        $balLunaCitologia = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subLuna->id, 'benefit_definition_id' => $bCitologia->id],
            ['total_granted' => 2, 'used_count' => 1, 'remaining_count' => 1]
        );

        // Beneficio con 0 cupos disponibles para demostrar bloqueo de límite
        $balLunaBano = SubscriptionBenefitBalance::updateOrCreate(
            ['subscription_id' => $subLuna->id, 'benefit_definition_id' => $bBano->id],
            ['total_granted' => 2, 'used_count' => 2, 'remaining_count' => 0]
        );

        // Canjes Auditados en el Historial de Luna
        BenefitRedemption::firstOrCreate(
            ['tenant_id' => $tenant->id, 'balance_id' => $balLunaKit->id],
            [
                'redeemed_at' => now()->subDays(25),
                'vet_user_id' => $vetUser?->id,
                'quantity' => 1,
                'notes' => 'Kit de Bienvenida felino entregado en recepción.',
            ]
        );

        BenefitRedemption::firstOrCreate(
            ['tenant_id' => $tenant->id, 'balance_id' => $balLunaConsulta->id],
            [
                'redeemed_at' => now()->subDays(18),
                'vet_user_id' => $vetUser?->id,
                'quantity' => 1,
                'notes' => 'Consulta por control de peso y asesoría en cambio de alimentación.',
            ]
        );

        BenefitRedemption::firstOrCreate(
            ['tenant_id' => $tenant->id, 'balance_id' => $balLunaCitologia->id],
            [
                'redeemed_at' => now()->subDays(12),
                'vet_user_id' => $vetUser?->id,
                'quantity' => 1,
                'notes' => 'Citología de oído derecho por rascado leve. Negativo para levaduras.',
            ]
        );

        BenefitRedemption::firstOrCreate(
            ['tenant_id' => $tenant->id, 'balance_id' => $balLunaBano->id],
            [
                'redeemed_at' => now()->subDays(8),
                'vet_user_id' => $vetUser?->id,
                'quantity' => 1,
                'notes' => 'Baño seco y corte de uñas felino especializado.',
            ]
        );

        BenefitRedemption::firstOrCreate(
            ['tenant_id' => $tenant->id, 'balance_id' => $balLunaBano->id, 'notes' => 'Segundo baño del período. Cupos de baño completados (2/2).'],
            [
                'redeemed_at' => now()->subDays(2),
                'vet_user_id' => $vetUser?->id,
                'quantity' => 1,
            ]
        );
    }
}
