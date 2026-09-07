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
use Illuminate\Support\Facades\Storage;
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
            'pet_photo_base64' => 'nullable|string',
            'plan_slug' => 'nullable|string',
            'billing_cycle' => 'nullable|string|in:monthly,annual',
            'payment_method' => 'nullable|string|max:100',
        ]);

        $billingCycle = $validated['billing_cycle'] ?? 'monthly';
        $paymentMethod = $validated['payment_method'] ?? 'nequi';
        $species = in_array(strtolower($validated['pet_species']), ['felino', 'cat', 'gato']) ? 'Felino' : 'Canino';
        
        // Procesar foto de la mascota si fue adjuntada
        $photoUrl = null;
        if (!empty($validated['pet_photo_base64'])) {
            $base64 = $validated['pet_photo_base64'];
            if (preg_match('/^data:image\/(\w+);base64,/', $base64, $typeMatch)) {
                $ext = strtolower($typeMatch[1]);
                if ($ext === 'jpeg') $ext = 'jpg';
                $imageData = substr($base64, strpos($base64, ',') + 1);
                $decoded = base64_decode($imageData);
                if ($decoded !== false) {
                    $filename = 'tenants/pets/' . Str::uuid() . '.' . $ext;
                    try {
                        Storage::disk('r2')->put($filename, $decoded, 'public');
                        $photoUrl = Storage::disk('r2')->url($filename);
                    } catch (\Exception $e) {
                        Storage::disk('public')->put($filename, $decoded);
                        $photoUrl = Storage::disk('public')->url($filename);
                    }
                }
            }
        }

        // Buscar el plan adecuado (por nombre o fallback a primer plan activo)
        $plan = null;
        if (!empty($validated['plan_slug'])) {
            $plan = $tenant->plans()
                ->where('is_active', true)
                ->where(function ($q) use ($validated) {
                    $q->where('name', 'ilike', '%' . $validated['plan_slug'] . '%');
                })
                ->first();
        }
        if (!$plan) {
            $plan = $tenant->plans()->where('is_active', true)->first();
        }

        if (!$plan) {
            return response()->json(['error' => 'No hay planes activos configurados para esta veterinaria.'], 422);
        }

        $subscription = DB::transaction(function () use ($tenant, $plan, $validated, $species, $billingCycle, $photoUrl) {
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
                    'photo_url' => $photoUrl,
                ]
            );

            if ($photoUrl && empty($pet->photo_url)) {
                $pet->update(['photo_url' => $photoUrl]);
            }

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
                    'total_granted' => $pb->quantity ?? 1,
                    'used_count' => 0,
                    'remaining_count' => $pb->quantity ?? 1,
                ]);
            }

            return $sub;
        });

        $contractId = $subscription->gateway_subscription_id;
        $clinicPhone = preg_replace('/[^0-9]/', '', $tenant->branding['phone'] ?? '3508742543');
        $planPrice = ($billingCycle === 'annual') ? '$' . number_format($plan->price_annual ?? 540000, 0, ',', '.') . ' COP/año' : '$' . number_format($plan->price_monthly ?? 50000, 0, ',', '.') . ' COP/mes';
        $carnetUrl = url("/v/{$tenant->slug}/carnet/{$contractId}");
        $boldPaymentUrl = $tenant->branding['payment_bold_link'] ?? null;

        $paymentText = match($paymentMethod) {
            'bold', 'card_pse', 'card' => '💳 Tarjeta / PSE (Bold)',
            'bank_transfer', 'bancolombia' => '🏦 Transferencia Bancaria',
            'cash_reception', 'cash' => '🏥 Pago en Efectivo / Recepción Clínica',
            default => '📱 Nequi / Daviplata',
        };

        $waMessage = "¡Hola {$tenant->name}! 👋 Acabo de afiliar a mi mascota en su plataforma digital:\n\n" .
            "🐾 *Mascota:* {$validated['pet_name']} ({$species} - {$validated['pet_breed']})\n" .
            "👤 *Tutor:* {$validated['tutor_name']}\n" .
            "📱 *WhatsApp:* {$validated['tutor_phone']}\n" .
            "📋 *Plan:* {$plan->name} (" . ($billingCycle === 'annual' ? 'Pago Anual' : 'Pago Mensual') . ")\n" .
            "💳 *Valor:* {$planPrice}\n" .
            "💰 *Método de Pago Seleccionado:* {$paymentText}\n" .
            "🏷️ *Contrato:* {$contractId}\n\n" .
            "🪪 *Ver Carnet Digital:* {$carnetUrl}\n\n" .
            "Adjunto mi comprobante para la activación. ¡Muchas gracias!";

        $whatsappUrl = "https://wa.me/57{$clinicPhone}?text=" . urlencode($waMessage);

        return response()->json([
            'success' => true,
            'message' => '¡Afiliación completada exitosamente!',
            'contract_id' => $contractId,
            'pet_name' => $validated['pet_name'],
            'carnet_url' => $carnetUrl,
            'whatsapp_url' => $whatsappUrl,
            'bold_payment_url' => $boldPaymentUrl,
            'payment_method' => $paymentMethod,
        ]);
    }
}
