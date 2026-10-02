<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'wallet_id',
        'type',
        'amount_cop',
        'balance_after_cop',
        'description',
        'reference_id',
        'created_by_user_id',
    ];

    protected $casts = [
        'amount_cop' => 'float',
        'balance_after_cop' => 'float',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(SubscriptionWallet::class, 'wallet_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function getFormattedAmountAttribute(): string
    {
        $prefix = $this->type === 'redemption' ? '-' : '+';
        return $prefix . '$' . number_format($this->amount_cop, 0, ',', '.') . ' COP';
    }
}
