<?php

namespace App\Notifications;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEnrollmentClinicNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Subscription $subscription,
        public Customer $customer,
        public Pet $pet,
        public Plan $plan,
        public string $paymentMethod
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'new_patient_enrolled',
            'title' => '🎉 ¡Nuevo Paciente Afiliado!',
            'message' => "{$this->customer->name} ha inscrito a {$this->pet->name} ({$this->pet->species} - {$this->pet->breed}) en el plan {$this->plan->name}.",
            'subscription_id' => $this->subscription->id,
            'contract_id' => $this->subscription->gateway_subscription_id,
            'pet_id' => $this->pet->id,
            'pet_name' => $this->pet->name,
            'customer_name' => $this->customer->name,
            'customer_phone' => $this->customer->phone,
            'plan_name' => $this->plan->name,
            'payment_method' => $this->paymentMethod,
            'amount_cop' => $this->plan->price_cop,
            'carnet_url' => url("/v/" . ($this->subscription->tenant->slug ?? 'vet-pet-patitas') . "/carnet/{$this->subscription->gateway_subscription_id}"),
            'created_at' => now()->toIso8601String(),
        ];
    }
}
