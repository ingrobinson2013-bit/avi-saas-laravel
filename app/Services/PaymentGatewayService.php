<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentGatewayService
{
    protected BenefitLedgerService $ledgerService;

    public function __construct(BenefitLedgerService $ledgerService)
    {
        $this->ledgerService = $ledgerService;
    }

    /**
     * Procesar webhook de pago exitoso (Wompi / Bold / Stripe)
     */
    public function handleSuccessfulPayment(array $payload, string $gateway = 'wompi'): Subscription
    {
        return DB::transaction(function () use ($payload, $gateway) {
            $petId = $payload['customer_data']['pet_id'] ?? null;
            $planId = $payload['customer_data']['plan_id'] ?? null;
            $transactionId = $payload['id'] ?? null;

            $plan = Plan::findOrFail($planId);
            $pet = Pet::with('customer')->findOrFail($petId);

            // Crear o renovar suscripción
            $subscription = Subscription::updateOrCreate(
                [
                    'pet_id' => $pet->id,
                    'plan_id' => $plan->id,
                ],
                [
                    'tenant_id' => $plan->tenant_id,
                    'status' => 'active',
                    'current_period_start' => now(),
                    'current_period_end' => now()->addMonth(),
                    'gateway_subscription_id' => $transactionId,
                ]
            );

            // Cargar saldos de beneficios en el Ledger
            $this->ledgerService->resetCycleBalances($subscription);

            Log::info("Suscripción activada con éxito para la mascota {$pet->name} ({$subscription->id})");

            return $subscription;
        });
    }
}
