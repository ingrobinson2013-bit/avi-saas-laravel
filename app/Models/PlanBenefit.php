<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanBenefit extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'plan_id',
        'benefit_definition_id',
        'quantity',
        'expires_each_cycle',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'expires_each_cycle' => 'boolean',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function benefitDefinition(): BelongsTo
    {
        return $this->belongsTo(BenefitDefinition::class);
    }
}
