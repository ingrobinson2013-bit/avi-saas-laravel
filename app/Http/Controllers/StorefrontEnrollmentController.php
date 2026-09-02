<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StorefrontEnrollmentController extends Controller
{
    public function store(Request $request, string $slug): JsonResponse
    {
        $tenant = Tenant::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'tutor_name' => 'required|string|max:255',
            'tutor_phone' => 'required|string|max:50',
            'tutor_email' => 'required|email|max:255',
            'tutor_doc' => 'nullable|string|max:50',
            'pet_name' => 'required|string|max:255',
            'pet_species' => 'required|string|in:Canino,Felino,dog,cat,Perro,Gato',
            'pet_breed' => 'nullable|string|max:255',
            'pet_age' => 'nullable|string|max:50',
            'plan_slug' => 'nullable|string',
            'billing_cycle' => 'nullable|string|in:monthly,annual',
        ]);

        $billingCycle = $validated['billing_cycle'] ?? 'monthly';
        $species = in_array(strtolower($validated['pet_species']), ['felino', 'cat', 'gato']) ? 'Felino' : 'Canino';
        
        // Buscar el plan adecuado (por slug o fallback a primer plan activo)
        $plan = null;
        if (!empty($validated['plan_slug'])) {
            $plan = $tenant->plans()->where('slug', $validated['plan_slug'])->where('is_active', true)->first();
        }
        if (!$plan) {
            $plan = $tenant->plans()->where('is_active', true)->first();
        }

        if (!$plan) {
            return response()->json(['error' => 'No hay planes activos configurados para esta veterinaria.'], 422);
        }

        $subscription = DB::transaction(function () use ($tenant, $plan, $validated, $species, $billingCycle) {
            // 1. Crear o actualizar Tutor (Customer)
            $customer = Customer::updateOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'phone' => $validated['tutor_phone'],
                ],
                [
                    'name' => $validated['tutor_name'],
                    'email' => $validated['tutor_email'],
                    'identification' => $validated['tutor_doc'] ?? null,
                ]
            );

            // 2. Crear Mascota (Pet)
            $birthdate = null;
            if (!empty($validated['pet_age']) && is_numeric($validated['pet_age'])) {
                $birthdate = now()->subYears((int) $validated['pet_age'])->toDateString();
            }

            $pet = Pet::firstOrCreate(
                [
                    'customer_id' => $customer->id,
                    'name' => trim($validated['pet_name']),
                ],
                [
                    'species' => $species,
                    'breed' => $validated['pet_breed'] ?? 'Criollo / Mestizo',
                    'birthdate' => $birthdate ?? now()->subYears(2)->toDateString(),
                ]
            );

            // 3. Crear Suscripción Digital
            $contractNumber = 'VP-' . date('Y') . '-' . rand(1000, 9999);
            $startDate = now();
            $endDate = ($billingCycle === 'annual') ? now()->addYear() : now()->addMonth();

            $sub = Subscription::create([
                'tenant_id' => $tenant->id,
                'pet_id' => $pet->id,
                'plan_id' => $plan->id,
                'status' => 'active',
                'current_period_start' => $startDate,
                'current_period_end' => $endDate,
                'gateway_subscription_id' => $contractNumber,
            ]);

            // 4. Inicializar bolsa de beneficios
            $planBenefits = $plan->planBenefits()->with('benefitDefinition')->get();
            foreach ($planBenefits as $pb) {
                SubscriptionBenefitBalance::create([
                    'subscription_id' => $sub->id,
                    'benefit_definition_id' => $pb->benefit_definition_id,
                    'total_granted' => $pb->annual_quota,
                    'used_count' => 0,
                    'remaining_count' => $pb->annual_quota,
                ]);
            }

            return $sub;
        });

        $contractId = $subscription->gateway_subscription_id;
        $clinicPhone = preg_replace('/[^0-9]/', '', $tenant->branding['phone'] ?? '3508742543');
        $planPrice = ($billingCycle === 'annual') ? '$' . number_format($plan->price_annual ?? 540000, 0, ',', '.') . ' COP/año' : '$' . number_format($plan->price_monthly ?? 50000, 0, ',', '.') . ' COP/mes';

        $waMessage = "¡Hola {$tenant->name}! 👋 Acabo de afiliar a mi mascota en su plataforma digital:\n\n" .
            "🐾 *Mascota:* {$validated['pet_name']} ({$species} - {$validated['pet_breed']})\n" .
            "👤 *Tutor:* {$validated['tutor_name']}\n" .
            "📱 *WhatsApp:* {$validated['tutor_phone']}\n" .
            "📋 *Plan:* {$plan->name} ({$billingCycle})\n" .
            "💳 *Valor:* {$planPrice}\n" .
            "🏷️ *Contrato:* {$contractId}\n\n" .
            "Quedo a la espera de la confirmación y bienvenida en la clínica. ¡Muchas gracias! 🐶🐱";

        $whatsappUrl = "https://wa.me/57{$clinicPhone}?text=" . urlencode($waMessage);

        return response()->json([
            'success' => true,
            'contract_id' => $contractId,
            'pet_name' => $validated['pet_name'],
            'pet_species' => $species,
            'pet_breed' => $validated['pet_breed'] ?? 'Criollo / Mestizo',
            'tutor_name' => $validated['tutor_name'],
            'plan_name' => $plan->name,
            'billing_cycle' => $billingCycle,
            'whatsapp_url' => $whatsappUrl,
            'message' => '¡Afiliación registrada con éxito! Tu carnet digital ya está activo.',
        ]);
    }
}
