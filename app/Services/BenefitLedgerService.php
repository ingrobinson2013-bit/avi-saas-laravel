<?php

namespace App\Services;

use App\Models\BenefitDefinition;
use App\Models\BenefitRedemption;
use App\Models\Subscription;
use App\Models\SubscriptionBenefitBalance;
use Exception;
use Illuminate\Support\Facades\DB;

class BenefitLedgerService
{
    /**
     * Canje atómico con bloqueo pesimista contra doble gasto.
     */
    public function redeemBenefit(
        Subscription $subscription,
        BenefitDefinition $benefit,
        int $quantity = 1,
        ?string $vetUserId = null,
        ?string $notes = null
    ): BenefitRedemption {
        return DB::transaction(function () use ($subscription, $benefit, $quantity, $vetUserId, $notes) {
            $balance = SubscriptionBenefitBalance::where('subscription_id', $subscription->id)
                ->where('benefit_definition_id', $benefit->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($balance->remaining_count < $quantity) {
                throw new Exception("Cupo insuficiente para el beneficio: {$benefit->name}. Restantes: {$balance->remaining_count}");
            }

            $balance->decrement('remaining_count', $quantity);
            $balance->increment('used_count', $quantity);

            return BenefitRedemption::create([
                'tenant_id' => $subscription->tenant_id,
                'balance_id' => $balance->id,
                'redeemed_at' => now(),
                'vet_user_id' => $vetUserId,
                'quantity' => $quantity,
                'notes' => $notes,
            ]);
        });
    }

    /**
     * Inicializar o renovar saldos mensuales de un ciclo.
     */
    public function resetCycleBalances(Subscription $subscription): void
    {
        DB::transaction(function () use ($subscription) {
            $plan = $subscription->plan()->with('planBenefits.benefitDefinition')->firstOrFail();

            foreach ($plan->planBenefits as $planBenefit) {
                SubscriptionBenefitBalance::updateOrCreate(
                    [
                        'subscription_id' => $subscription->id,
                        'benefit_definition_id' => $planBenefit->benefit_definition_id,
                    ],
                    [
                        'total_granted' => $planBenefit->quantity,
                        'used_count' => 0,
                        'remaining_count' => $planBenefit->quantity,
                    ]
                );
            }
        });
    }
}
