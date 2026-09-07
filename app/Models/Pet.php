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
        'photo_url',
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

    /**
     * Accessor para asegurar que la URL de la foto siempre apunte al CDN de Cloudflare R2 o storage público
     */
    public function getPhotoUrlAttribute(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        try {
            return \Illuminate\Support\Facades\Storage::disk('r2')->url($value);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($value);
        }
    }
}

