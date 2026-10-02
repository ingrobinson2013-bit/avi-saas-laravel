<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionWallet extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tenant_id',
        'subscription_id',
        'balance_cop',
        'total_accrued_cop',
        'total_redeemed_cop',
        'reserve_percentage',
        'is_active',
    ];

    protected $casts = [
        'balance_cop' => 'float',
        'total_accrued_cop' => 'float',
        'total_redeemed_cop' => 'float',
        'reserve_percentage' => 'float',
        'is_active' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'wallet_id')->latest();
    }

    public function getFormattedBalanceAttribute(): string
    {
        return '$' . number_format($this->balance_cop, 0, ',', '.') . ' COP';
    }
}
