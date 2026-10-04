<?php

namespace App\Listeners;

use App\Events\BenefitRedeemedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class AuditRedemptionLogListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(BenefitRedeemedEvent $event): void
    {
        $redemption = $event->redemption;
        $balance = $redemption->balance;

        // Auditoría forense inmutable de consumos médicos
        Log::channel('daily')->notice("🛡️ [AUDITORIA MEDICA INMUTABLE] Redención verificada:", [
            'redemption_id' => $redemption->id,
            'tenant_id' => $redemption->tenant_id,
            'balance_id' => $redemption->balance_id,
            'vet_user_id' => $redemption->vet_user_id ?? 'recepcion_general',
            'quantity_deducted' => $redemption->quantity,
            'remaining_balance' => $balance?->remaining_count,
            'used_balance' => $balance?->used_count,
            'redeemed_at' => $redemption->redeemed_at?->toIso8601String(),
            'notes' => $redemption->notes,
        ]);
    }
}
