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

    protected static function booted(): void
    {
        static::creating(function (Subscription $subscription) {
            if (empty($subscription->gateway_subscription_id)) {
                $tenant = $subscription->tenant ?? Tenant::find($subscription->tenant_id);
                if ($tenant) {
                    $subscription->gateway_subscription_id = static::generateNextContractNumber($tenant);
                }
            }
        });
    }

    /**
     * Genera el siguiente número de contrato secuencial único para la clínica veterinaria (Tenant).
     * Formato: [PREFIJO]-[AÑO]-[0001...]
     * Ejemplo: VP-2026-0001, VP-2026-0002...
     */
    public static function generateNextContractNumber(Tenant|string $tenant): string
    {
        $tenantModel = is_string($tenant) ? Tenant::findOrFail($tenant) : $tenant;
        $year = date('Y');

        // Determinar prefijo de la veterinaria a partir del slug o nombre
        $prefix = 'VP';
        $slug = $tenantModel->slug ?? '';
        if (!empty($slug)) {
            $parts = explode('-', $slug);
            if (count($parts) >= 2) {
                $initials = '';
                foreach ($parts as $p) {
                    if (!empty($p) && !in_array(strtolower($p), ['de', 'la', 'el', 'los', 'las', 'y'])) {
                        $initials .= strtoupper($p[0]);
                    }
                }
                if (strlen($initials) >= 2) {
                    $prefix = substr($initials, 0, 3);
                }
            } else {
                $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $slug), 0, 2));
            }
        }

        // Buscar contratos existentes de este tenant para este año
        $likePattern = $prefix . '-' . $year . '-%';
        $existingSubscriptions = static::where('tenant_id', $tenantModel->id)
            ->where('gateway_subscription_id', 'like', $likePattern)
            ->pluck('gateway_subscription_id');

        $maxSequence = 0;
        foreach ($existingSubscriptions as $contractCode) {
            if (preg_match('/-(\d+)$/', $contractCode, $matches)) {
                $num = (int) $matches[1];
                if ($num > $maxSequence) {
                    $maxSequence = $num;
                }
            }
        }

        if ($maxSequence === 0) {
            // Si no hay contratos con el nuevo formato, calcular según total de contratos previos del tenant
            $count = static::where('tenant_id', $tenantModel->id)->count();
            $maxSequence = $count;
        }

        $nextSequence = $maxSequence + 1;
        return sprintf('%s-%s-%04d', $prefix, $year, $nextSequence);
    }
}

