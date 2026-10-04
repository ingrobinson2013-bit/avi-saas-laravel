<?php

namespace App\Events;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\Subscription;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PatientEnrolledEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Subscription $subscription,
        public Customer $customer,
        public Pet $pet,
        public string $paymentMethod = 'nequi'
    ) {}
}
