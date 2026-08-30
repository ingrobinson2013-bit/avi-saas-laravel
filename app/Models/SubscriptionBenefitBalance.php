<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionBenefitBalance extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'subscription_id',
        'benefit_definition_id',
        'total_granted',
        'used_count',
        'remaining_count',
    ];

    protected $casts = [
        'total_granted' => 'integer',
        'used_count' => 'integer',
        'remaining_count' => 'integer',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function benefitDefinition(): BelongsTo
    {
        return $this->belongsTo(BenefitDefinition::class);
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(BenefitRedemption::class, 'balance_id');
    }
}
