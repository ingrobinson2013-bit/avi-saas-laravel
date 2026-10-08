<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\BenefitDefinition;
use App\Models\BenefitRedemption;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\PlanBenefit;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use App\Models\SubscriptionWallet;
use App\Models\Tenant;
use App\Models\User;
use App\Models\WalletTransaction;
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
                'domain' => 'vet-pet-patitas.avipetapp.com',
                'branding' => [
                    'brand_name' => 'Vet-Pet Patitas',
                    'tagline' => 'Planes de salud para su mascota',
                    'logo_url' => 'https://pub-9b11349c37334765ad3e31861c78458f.r2.dev/tenants/logos/01M1WM7VP4PYQVQ7P0GBWK1RPW.webp',
                    'primary_color' => '#0080ff',
                    'secondary_color' => '#000000',
                    'phone' => '3508742543',
                    'email' => 'petmovilveterinario@gmail.com',
                    'city' => 'Cajicá, Cundinamarca',
                    'address' => 'Calle 7 # 4-73 Este (hacia El Parasol rojo)',
                    'saas_status' => 'paid',
                    'saas_paid_until' => '2026-10-30',
                ],
                'is_active' => true,
                'saas_plan_tier' => 'starter',
            ]
        );

        // 2. Usuarios
        $superadmin = User::firstOrCreate(
            ['email' => 'contacto@avipetapp.com'],
            [
                'name' => 'Dr. Robinson Naranjo (CEO NODIA)',
                'password' => Hash::make('Ashley2023##'),
                'role' => 'super_admin',
            ]
        );

        $vetVicky = User::firstOrCreate(
            ['email' => 'petmovilveterinario@gmail.com'],
            [
                'tenant_id' => $tenant->id,
                'name' => 'Dra. Vicky Naranjo',
                'password' => Hash::make('Ashley2023##'),
                'role' => 'clinic_admin',
            ]
        );

        $vetAdmin = User::firstOrCreate(
            ['email' => 'admin@patitasfelices.com'],
            [
                'tenant_id' => $tenant->id,
                'name' => 'Recepción Vet-Pet Patitas',
                'password' => Hash::make('Ashley2023##'),
                'role' => 'clinic_admin',
            ]
        );

        // 3. Catálogo de Servicios y Beneficios Clínicos
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

        // 4. Planes de Salud Oficiales
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
                'description' => 'Mensualidad de $80.000 COP. Cobertura premium total con laboratorio, consultas, vacunación, baño y servicio funerario 100% incluido.',
                'price_cop' => 80000.00,
                'billing_interval' => 'monthly',
                'is_active' => true,
            ]
        );

        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bKit->id], ['quantity' => 1]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bConsultaVirtual->id], ['quantity' => 999]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bConsultaPresencial->id], ['quantity' => 4]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bChequeoPreventivo->id], ['quantity' => 4]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bVacunaAnual->id], ['quantity' => 1]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bDesparasitacion->id], ['quantity' => 4]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bAntipulgas->id], ['quantity' => 2]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bLaboratorio->id], ['quantity' => 2]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bBano->id], ['quantity' => 4]);
        PlanBenefit::firstOrCreate(['plan_id' => $planPremium->id, 'benefit_definition_id' => $bFunerario->id], ['quantity' => 1]);

        // 5. Lista de Pacientes Reales de Cajicá / Chía / Cundinamarca
        $patientsData = [
            [
                'tutor_name' => 'María Camila Rodríguez',
                'identification' => '1020304050',
                'phone' => '3235813942',
                'email' => 'camilia.rodriguez@gmail.com',
                'pet_name' => 'Max',
                'species' => 'dog',
                'breed' => 'Golden Retriever',
                'photo_url' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=400&q=80',
                'age_years' => 3,
                'plan' => $planPremium,
                'period_start' => now()->subDays(15),
                'period_end' => now()->addDays(15),
                'wallet_balance' => 20000,
                'created_at' => now()->subMonths(2),
                'redemptions' => [
                    ['benefit' => $bKit, 'days_ago' => 15, 'notes' => 'Entrega de Kit Oficial: Cédula, Placa QR y Collar.'],
                    ['benefit' => $bConsultaPresencial, 'days_ago' => 10, 'notes' => 'Consulta preventiva. Peso 32kg, estado cardiopulmonar normal.'],
                    ['benefit' => $bAntipulgas, 'days_ago' => 4, 'notes' => 'Aplicación de Credelio 450mg.'],
                    ['benefit' => $bBano, 'days_ago' => 2, 'notes' => 'Baño medicado y corte de uñas.'],
                ],
            ],
            [
                'tutor_name' => 'María Fernanda Gómez',
                'identification' => '1030405060',
                'phone' => '3109876543',
                'email' => 'mafe.gomez@hotmail.com',
                'pet_name' => 'Luna',
                'species' => 'cat',
                'breed' => 'Siamés',
                'photo_url' => 'https://images.unsplash.com/photo-1513360309081-38f0762daed1?auto=format&fit=crop&w=400&q=80',
                'age_years' => 2,
                'plan' => $planBasico,
                'period_start' => now()->subDays(26),
                'period_end' => now()->addDays(4), // VENCE EN 4 DÍAS (Alerta de Renovación)
                'wallet_balance' => 15000,
                'created_at' => now()->subMonths(3),
                'redemptions' => [
                    ['benefit' => $bKit, 'days_ago' => 26, 'notes' => 'Kit de Bienvenida Felino.'],
                    ['benefit' => $bConsultaPresencial, 'days_ago' => 18, 'notes' => 'Control de peso y nutrición felina.'],
                    ['benefit' => $bCitologia, 'days_ago' => 8, 'notes' => 'Citología ótica preventiva. Sin hallazgos de otitis.'],
                ],
            ],
            [
                'tutor_name' => 'Sandra Milena Ortiz',
                'identification' => '1040506070',
                'phone' => '3124567890',
                'email' => 'sandra.ortiz@gmail.com',
                'pet_name' => 'Rocky',
                'species' => 'dog',
                'breed' => 'Bulldog Francés',
                'photo_url' => 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&w=400&q=80',
                'age_years' => 2,
                'plan' => $planPremium,
                'period_start' => now()->subDays(22),
                'period_end' => now()->addDays(8), // VENCE EN 8 DÍAS (Alerta de Renovación)
                'wallet_balance' => 25000,
                'created_at' => now()->subMonths(4),
                'redemptions' => [
                    ['benefit' => $bKit, 'days_ago' => 22, 'notes' => 'Kit oficial y carnet digital.'],
                    ['benefit' => $bLaboratorio, 'days_ago' => 14, 'notes' => 'Hemograma completo y perfil bioquímico (Creatinina/ALT normales).'],
                    ['benefit' => $bDesparasitacion, 'days_ago' => 5, 'notes' => 'Desparasitación interna de rutina.'],
                ],
            ],
            [
                'tutor_name' => 'David Alejandro Castro',
                'identification' => '1050607080',
                'phone' => '3208765432',
                'email' => 'david.castro@yahoo.com',
                'pet_name' => 'Simba',
                'species' => 'cat',
                'breed' => 'Criollo Mestizo',
                'photo_url' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=400&q=80',
                'age_years' => 4,
                'plan' => $planBasico,
                'period_start' => now()->subDays(18),
                'period_end' => now()->addDays(12), // VENCE EN 12 DÍAS (Alerta de Renovación)
                'wallet_balance' => 10000,
                'created_at' => now()->subMonths(1),
                'redemptions' => [
                    ['benefit' => $bKit, 'days_ago' => 18, 'notes' => 'Placa con código QR y carnet emitido.'],
                    ['benefit' => $bConsultaPresencial, 'days_ago' => 11, 'notes' => 'Revisión dental y desparasitación.'],
                ],
            ],
            [
                'tutor_name' => 'Andrea Ramírez',
                'identification' => '1060708090',
                'phone' => '3152345678',
                'email' => 'andrea.ramirez@gmail.com',
                'pet_name' => 'Thor',
                'species' => 'dog',
                'breed' => 'Pastor Alemán',
                'photo_url' => 'https://images.unsplash.com/photo-1589941013453-ec89f33b5e95?auto=format&fit=crop&w=400&q=80',
                'age_years' => 4,
                'plan' => $planPremium,
                'period_start' => now()->subDays(3),
                'period_end' => now()->addDays(27),
                'wallet_balance' => 8000,
                'created_at' => now()->subDays(3), // NUEVA AFILIACIÓN ESTE MES
                'redemptions' => [
                    ['benefit' => $bKit, 'days_ago' => 3, 'notes' => 'Afiliación express en sede y entrega de kit.'],
                    ['benefit' => $bVacunaAnual, 'days_ago' => 1, 'notes' => 'Vacunación Anual Antirrábica & Refuerzo Nobivac.'],
                ],
            ],
            [
                'tutor_name' => 'Juan Pablo Morales',
                'identification' => '1070809010',
                'phone' => '3188765432',
                'email' => 'juanpablo.m@outlook.com',
                'pet_name' => 'Milo',
                'species' => 'cat',
                'breed' => 'Persa',
                'photo_url' => 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?auto=format&fit=crop&w=400&q=80',
                'age_years' => 1,
                'plan' => $planBasico,
                'period_start' => now()->subDays(6),
                'period_end' => now()->addDays(24),
                'wallet_balance' => 5000,
                'created_at' => now()->subDays(6), // NUEVA AFILIACIÓN ESTE MES
                'redemptions' => [
                    ['benefit' => $bKit, 'days_ago' => 6, 'notes' => 'Kit de bienvenida y carnet digital activado.'],
                ],
            ],
            [
                'tutor_name' => 'Laura Valentina Ríos',
                'identification' => '1080901020',
                'phone' => '3167890123',
                'email' => 'laura.rios@gmail.com',
                'pet_name' => 'Kira',
                'species' => 'dog',
                'breed' => 'Beagle',
                'photo_url' => 'https://images.unsplash.com/photo-1505628346881-b72b27e84530?auto=format&fit=crop&w=400&q=80',
                'age_years' => 3,
                'plan' => $planPremium,
                'period_start' => now()->subDays(9),
                'period_end' => now()->addDays(21),
                'wallet_balance' => 8000,
                'created_at' => now()->subDays(9), // NUEVA AFILIACIÓN ESTE MES
                'redemptions' => [
                    ['benefit' => $bKit, 'days_ago' => 9, 'notes' => 'Kit y placa QR grabada.'],
                    ['benefit' => $bChequeoPreventivo, 'days_ago' => 5, 'notes' => 'Chequeo trimestral preventivo de oído y piel.'],
                ],
            ],
            [
                'tutor_name' => 'Jorge Eliécer Torres',
                'identification' => '1090102030',
                'phone' => '3013456789',
                'email' => 'jorge.torres@gmail.com',
                'pet_name' => 'Coco',
                'species' => 'dog',
                'breed' => 'Caniche Poodle',
                'photo_url' => 'https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?auto=format&fit=crop&w=400&q=80',
                'age_years' => 4,
                'plan' => $planBasico,
                'period_start' => now()->subDays(14),
                'period_end' => now()->addDays(16),
                'wallet_balance' => 15000,
                'created_at' => now()->subMonths(2),
                'redemptions' => [
                    ['benefit' => $bKit, 'days_ago' => 14, 'notes' => 'Kit oficial entregado.'],
                    ['benefit' => $bBano, 'days_ago' => 3, 'notes' => 'Baño estético, corte de pelo y limpieza dental básica.'],
                ],
            ],
        ];

        // 6. Creación e Inserción de Pacientes, Membresías, Balances y Transacciones
        foreach ($patientsData as $pData) {
            $customer = Customer::updateOrCreate(
                ['tenant_id' => $tenant->id, 'identification' => $pData['identification']],
                [
                    'name' => $pData['tutor_name'],
                    'phone' => $pData['phone'],
                    'email' => $pData['email'],
                    'created_at' => $pData['created_at'],
                ]
            );

            $pet = Pet::updateOrCreate(
                ['customer_id' => $customer->id, 'name' => $pData['pet_name']],
                [
                    'species' => $pData['species'],
                    'breed' => $pData['breed'],
                    'photo_url' => $pData['photo_url'] ?? null,
                    'birthdate' => now()->subYears($pData['age_years']),
                    'medical_notes' => 'Paciente activo afiliado en Vet-Pet Patitas (Sede Cajicá).',
                    'created_at' => $pData['created_at'],
                ]
            );

            $sub = Subscription::updateOrCreate(
                ['tenant_id' => $tenant->id, 'pet_id' => $pet->id],
                [
                    'plan_id' => $pData['plan']->id,
                    'status' => 'active',
                    'current_period_start' => $pData['period_start'],
                    'current_period_end' => $pData['period_end'],
                    'created_at' => $pData['created_at'],
                ]
            );

            // Monedero de Aporte de Emergencia Quirúrgica
            $wallet = SubscriptionWallet::updateOrCreate(
                ['tenant_id' => $tenant->id, 'subscription_id' => $sub->id],
                [
                    'balance_cop' => $pData['wallet_balance'],
                    'total_accrued_cop' => $pData['wallet_balance'],
                    'total_redeemed_cop' => 0,
                    'reserve_percentage' => 10.0,
                    'is_active' => true,
                ]
            );

            WalletTransaction::firstOrCreate(
                ['wallet_id' => $wallet->id, 'description' => "Aporte Fondo de Emergencia Quirúrgica (Mes 1) - {$pData['pet_name']}"],
                [
                    'type' => 'accrual',
                    'amount_cop' => $pData['wallet_balance'],
                    'balance_after_cop' => $pData['wallet_balance'],
                    'created_at' => $pData['created_at'],
                ]
            );

            // Generar Balances de Beneficios según el Plan
            $planBenefits = $pData['plan']->planBenefits()->get();
            $balanceMap = [];

            foreach ($planBenefits as $pb) {
                $bal = SubscriptionBenefitBalance::updateOrCreate(
                    [
                        'subscription_id' => $sub->id,
                        'benefit_definition_id' => $pb->benefit_definition_id,
                    ],
                    [
                        'total_granted' => $pb->quantity,
                        'used_count' => 0,
                        'remaining_count' => $pb->quantity,
                    ]
                );
                $balanceMap[$pb->benefit_definition_id] = $bal;
            }

            // Registrar Canjes Clínicos
            foreach ($pData['redemptions'] as $red) {
                $bDef = $red['benefit'];
                if (isset($balanceMap[$bDef->id])) {
                    $bal = $balanceMap[$bDef->id];
                    $bal->increment('used_count');
                    $bal->decrement('remaining_count');

                    BenefitRedemption::firstOrCreate(
                        [
                            'tenant_id' => $tenant->id,
                            'balance_id' => $bal->id,
                            'notes' => $red['notes'],
                        ],
                        [
                            'redeemed_at' => now()->subDays($red['days_ago']),
                            'vet_user_id' => $vetVicky->id,
                            'quantity' => 1,
                        ]
                    );
                }
            }
        }

        // 7. Citas Médicas Agendadas en Calendario
        $petMax = Pet::where('name', 'Max')->first();
        $petLuna = Pet::where('name', 'Luna')->first();
        $petRocky = Pet::where('name', 'Rocky')->first();

        if ($petMax) {
            Appointment::updateOrCreate(
                ['tenant_id' => $tenant->id, 'pet_id' => $petMax->id, 'scheduled_at' => now()->startOfDay()->addHours(9)],
                [
                    'customer_id' => $petMax->customer_id,
                    'benefit_definition_id' => $bConsultaPresencial->id,
                    'doctor_name' => 'Dra. Vicky Naranjo',
                    'title' => 'Consulta Médica General · Max',
                    'end_at' => now()->startOfDay()->addHours(9)->addMinutes(30),
                    'duration_minutes' => 30,
                    'status' => 'confirmed',
                    'service_type' => 'presencial',
                    'notes' => 'Chequeo de rutina por carnet digital.',
                    'sync_status' => 'synced',
                    'google_calendar_url' => 'https://calendar.google.com/calendar/r/eventedit',
                ]
            );
        }

        if ($petLuna) {
            Appointment::updateOrCreate(
                ['tenant_id' => $tenant->id, 'pet_id' => $petLuna->id, 'scheduled_at' => now()->startOfDay()->addHours(11)],
                [
                    'customer_id' => $petLuna->customer_id,
                    'benefit_definition_id' => $bVacunaAnual->id,
                    'doctor_name' => 'Dra. Vicky Naranjo',
                    'title' => 'Vacunación Anual · Luna',
                    'end_at' => now()->startOfDay()->addHours(11)->addMinutes(30),
                    'duration_minutes' => 30,
                    'status' => 'confirmed',
                    'service_type' => 'presencial',
                    'notes' => 'Refuerzo de vacuna triple felina y rabia.',
                    'sync_status' => 'synced',
                ]
            );
        }

        if ($petRocky) {
            Appointment::updateOrCreate(
                ['tenant_id' => $tenant->id, 'pet_id' => $petRocky->id, 'scheduled_at' => now()->addDay()->startOfDay()->addHours(14)],
                [
                    'customer_id' => $petRocky->customer_id,
                    'benefit_definition_id' => $bLaboratorio->id,
                    'doctor_name' => 'Dr. Robinson Naranjo',
                    'title' => 'Toma de Muestra de Laboratorio · Rocky',
                    'end_at' => now()->addDay()->startOfDay()->addHours(14)->addMinutes(30),
                    'duration_minutes' => 30,
                    'status' => 'confirmed',
                    'service_type' => 'presencial',
                    'notes' => 'Perfil bioquímico preventivo en ayuno.',
                    'sync_status' => 'synced',
                ]
            );
        }
    }
}
