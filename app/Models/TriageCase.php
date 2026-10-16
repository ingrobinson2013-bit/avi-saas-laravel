<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TriageCase extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'triage_cases';

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'pet_id',
        'whatsapp_session_id',
        'phone_number',
        'symptoms_raw',
        'ai_draft_response',
        'ai_severity_level',
        'ai_confidence_score',
        'status',
        'doctor_notes',
        'doctor_reviewed_by',
        'telegram_message_id',
        'approved_at',
        'sent_to_whatsapp_at',
    ];

    protected $casts = [
        'ai_confidence_score' => 'float',
        'approved_at' => 'datetime',
        'sent_to_whatsapp_at' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function whatsappSession(): BelongsTo
    {
        return $this->belongsTo(WhatsAppSession::class);
    }
}
