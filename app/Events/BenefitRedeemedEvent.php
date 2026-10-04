<?php

namespace App\Events;

use App\Models\BenefitRedemption;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BenefitRedeemedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public BenefitRedemption $redemption
    ) {}
}
