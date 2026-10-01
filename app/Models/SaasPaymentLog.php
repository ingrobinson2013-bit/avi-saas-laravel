<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaasPaymentLog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tenant_id',
        'order_id',
        'gateway',
        'amount',
        'currency',
        'plan_tier',
        'status',
        'transaction_id',
        'payer_name',
        'payer_email',
        'payer_phone',
        'period_start',
        'period_end',
        'notes',
        'raw_payload',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'period_start' => 'date',
        'period_end' => 'date',
        'paid_at' => 'datetime',
        'raw_payload' => 'array',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
