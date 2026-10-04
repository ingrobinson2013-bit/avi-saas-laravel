<?php

namespace App\Notifications;

use App\Models\BenefitRedemption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BenefitRedeemedCustomerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public BenefitRedemption $redemption
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $balance = $this->redemption->balance;
        $benefit = $balance?->benefitDefinition;
        $pet = $balance?->subscription?->pet;
        $customer = $pet?->customer;

        return [
            'type' => 'benefit_redeemed',
            'title' => '💉 Canje de Beneficio Aplicado',
            'message' => "Se aplicó {$this->redemption->quantity} cupo(s) de '{$benefit?->name}' a {$pet?->name}.",
            'redemption_id' => $this->redemption->id,
            'benefit_name' => $benefit?->name,
            'quantity' => $this->redemption->quantity,
            'remaining_count' => $balance?->remaining_count,
            'pet_name' => $pet?->name,
            'customer_name' => $customer?->name,
            'redeemed_at' => $this->redemption->redeemed_at?->toIso8601String() ?? now()->toIso8601String(),
        ];
    }
}
