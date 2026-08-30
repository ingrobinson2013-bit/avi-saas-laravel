<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BenefitRedemption extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tenant_id',
        'balance_id',
        'redeemed_at',
        'vet_user_id',
        'quantity',
        'notes',
    ];

    protected $casts = [
        'redeemed_at' => 'datetime',
        'quantity' => 'integer',
    ];

    public function balance(): BelongsTo
    {
        return $this->belongsTo(SubscriptionBenefitBalance::class, 'balance_id');
    }
}
