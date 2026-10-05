<?php

namespace App\Observers;

use App\Models\Subscription;
use App\Models\SubscriptionWallet;
use Illuminate\Support\Facades\Log;

class SubscriptionObserver
{
    /**
     * Handle the Subscription "created" event.
     */
    public function created(Subscription $subscription): void
    {
        // 1. Inicializar automáticamente la Billetera de Salud Digital si no existe
        SubscriptionWallet::firstOrCreate(
            ['subscription_id' => $subscription->id],
            [
                'tenant_id' => $subscription->tenant_id,
                'balance_cop' => 0,
                'total_accrued_cop' => 0,
                'total_redeemed_cop' => 0,
                'reserve_percentage' => 15.0,
                'is_active' => true,
            ]
        );

        Log::info("🛡️ [OBSERVER] Suscripción creada y Billetera Médica inicializada:", [
            'subscription_id' => $subscription->id,
            'contract_id' => $subscription->gateway_subscription_id,
            'tenant_id' => $subscription->tenant_id,
        ]);
    }

    /**
     * Handle the Subscription "updated" event.
     */
    public function updated(Subscription $subscription): void
    {
        // 2. Máquina de Estados: Congelar o Descongelar Billetera y Servicios
        if ($subscription->isDirty('status')) {
            $oldStatus = $subscription->getOriginal('status');
            $newStatus = $subscription->status;

            Log::notice("🔄 [OBSERVER] Transición de estado en Suscripción {$subscription->gateway_subscription_id}: '{$oldStatus}' ➔ '{$newStatus}'", [
                'subscription_id' => $subscription->id,
                'tenant_id' => $subscription->tenant_id,
            ]);

            if (in_array($newStatus, ['cancelled', 'overdue', 'suspended'])) {
                // Suspender billetera médica por mora o cancelación
                $subscription->wallet()->update(['is_active' => false]);
            } elseif ($newStatus === 'active') {
                // Reactivar billetera médica al ponerse al día
                $subscription->wallet()->update(['is_active' => true]);
            }
        }
    }

    /**
     * Handle the Subscription "deleted" event.
     */
    public function deleted(Subscription $subscription): void
    {
        Log::warning("⚠️ [OBSERVER] Suscripción eliminada o archivada:", [
            'subscription_id' => $subscription->id,
            'contract_id' => $subscription->gateway_subscription_id,
            'tenant_id' => $subscription->tenant_id,
        ]);
    }
}
