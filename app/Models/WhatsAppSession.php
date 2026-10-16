<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppSession extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'whatsapp_sessions';

    protected $fillable = [
        'phone_number',
        'tenant_id',
        'customer_id',
        'active_pet_id',
        'current_step',
        'context_data',
        'last_interaction_at',
    ];

    protected $casts = [
        'context_data' => 'array',
        'last_interaction_at' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function activePet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'active_pet_id');
    }
}
