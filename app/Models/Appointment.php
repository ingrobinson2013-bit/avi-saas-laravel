<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tenant_id',
        'pet_id',
        'customer_id',
        'benefit_definition_id',
        'doctor_name',
        'title',
        'scheduled_at',
        'end_at',
        'duration_minutes',
        'status',
        'service_type',
        'notes',
        'google_event_id',
        'google_calendar_url',
        'sync_status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'end_at' => 'datetime',
        'duration_minutes' => 'integer',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function benefitDefinition(): BelongsTo
    {
        return $this->belongsTo(BenefitDefinition::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'Confirmada',
            'completed' => 'Atendida',
            'cancelled' => 'Cancelada',
            'no_show' => 'No Asistió',
            default => 'Programada',
        };
    }
}
