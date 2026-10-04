<?php

namespace App\Listeners;

use App\Events\BenefitRedeemedEvent;
use App\Models\User;
use App\Notifications\BenefitRedeemedCustomerNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendRedemptionReceiptListener implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;

    public function handle(BenefitRedeemedEvent $event): void
    {
        $redemption = $event->redemption;
        $balance = $redemption->balance;
        $benefit = $balance?->benefitDefinition;
        $pet = $balance?->subscription?->pet;
        $customer = $pet?->customer;
        $tenant = $balance?->subscription?->tenant;

        Log::info("💉 [QUEUE ASYNC] Canje Registrado con Éxito:", [
            'tenant' => $tenant->name ?? 'Clínica',
            'benefit' => $benefit?->name,
            'quantity' => $redemption->quantity,
            'pet' => $pet?->name,
            'tutor' => $customer?->name,
            'remaining_balance' => $balance?->remaining_count,
        ]);

        // Notificar a los administradores de la clínica para su registro en base de datos
        $staffUsers = User::where('tenant_id', $redemption->tenant_id)->get();
        if ($staffUsers->isNotEmpty()) {
            Notification::send($staffUsers, new BenefitRedeemedCustomerNotification($redemption));
        }
    }
}
