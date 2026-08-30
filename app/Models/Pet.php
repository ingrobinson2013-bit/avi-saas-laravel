<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'customer_id',
        'name',
        'species',
        'breed',
        'birthdate',
        'medical_notes',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tenant(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(
            Tenant::class,
            Customer::class,
            'id',          // Foreign key on customers table (Customer PK is id)
            'id',          // Foreign key on tenants table (Tenant PK is id)
            'customer_id', // Local key on pets table
            'tenant_id'    // Local key on customers table
        );
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active')->latestOfMany();
    }
}
