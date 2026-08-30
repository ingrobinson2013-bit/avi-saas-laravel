<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tenant_id',
        'pet_id',
        'plan_id',
        'status', // active, past_due, canceled, paused
        'current_period_start',
        'current_period_end',
        'gateway_subscription_id',
    ];

    protected $casts = [
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function benefitBalances(): HasMany
    {
        return $this->hasMany(SubscriptionBenefitBalance::class);
    }

    public function isExpiringSoon(): bool
    {
        if ($this->status !== 'active' || !$this->current_period_end) {
            return false;
        }
        return $this->current_period_end->isBetween(now(), now()->addDays(7));
    }

    public function isOverdue(): bool
    {
        if (!$this->current_period_end) {
            return false;
        }
        return $this->current_period_end->isPast();
    }

    public function getComputedStatusAttribute(): string
    {
        if ($this->status === 'canceled') {
            return 'canceled';
        }
        if ($this->isOverdue()) {
            return 'overdue';
        }
        if ($this->isExpiringSoon()) {
            return 'expiring_soon';
        }
        return $this->status ?? 'active';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->computed_status) {
            'active' => '🟢 Activa',
            'expiring_soon' => '🟡 Por vencer',
            'overdue' => '🔴 Vencida / Mora',
            'canceled' => '⚫ Cancelada',
            'paused' => '⏸️ Pausada',
            default => '🟢 Activa',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->computed_status) {
            'active' => 'success',
            'expiring_soon' => 'warning',
            'overdue' => 'danger',
            'canceled' => 'gray',
            'paused' => 'info',
            default => 'success',
        };
    }

    public function getTotalGrantedAttribute(): int
    {
        return (int) $this->benefitBalances->sum('total_granted');
    }

    public function getTotalUsedAttribute(): int
    {
        return (int) $this->benefitBalances->sum('used_count');
    }

    public function getTotalRemainingAttribute(): int
    {
        return (int) $this->benefitBalances->sum('remaining_count');
    }

    public function getUsagePercentageAttribute(): int
    {
        $granted = max(1, $this->total_granted);
        return (int) min(100, round(($this->total_used / $granted) * 100));
    }
}
