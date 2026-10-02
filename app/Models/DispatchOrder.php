<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DispatchOrder extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tenant_id',
        'subscription_id',
        'pet_id',
        'customer_id',
        'product_name',
        'dosage',
        'frequency_months',
        'scheduled_dispatch_date',
        'status',
        'tracking_number',
        'courier_name',
        'delivery_address',
        'recipient_phone',
        'delivered_at',
    ];

    protected $casts = [
        'scheduled_dispatch_date' => 'date',
        'delivered_at' => 'datetime',
        'frequency_months' => 'integer',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'scheduled' => 'Programado',
            'in_preparation' => 'En Empaque',
            'shipped' => 'En Camino',
            'delivered' => 'Entregado',
            default => 'Pendiente',
        };
    }
}
