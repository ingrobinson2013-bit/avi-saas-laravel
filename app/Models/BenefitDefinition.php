<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BenefitDefinition extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        'category', // consulta, vacuna, desparasitacion, bano, laboratorio, urgencia, guarderia, bienvenida, descuento, funerario
        'default_validity_days',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function planBenefits(): HasMany
    {
        return $this->hasMany(PlanBenefit::class);
    }

    public function balances(): HasMany
    {
        return $this->hasMany(SubscriptionBenefitBalance::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'consulta' => '🩺 Consulta Médica',
            'vacuna' => '💉 Vacunación',
            'desparasitacion' => '💊 Desparasitación',
            'bano' => '🛁 Baño & Estética',
            'laboratorio' => '🔬 Exámenes & Laboratorio',
            'urgencia' => '🚨 Urgencias / Prioritaria',
            'guarderia' => '🏠 Guardería / Hotel',
            'bienvenida' => '🎁 Kit Bienvenida',
            'descuento' => '🏷️ Descuento Especial',
            'funerario' => '🕊️ Previsión Exequial',
            default => '🐾 ' . ucfirst($this->category ?? 'Servicio'),
        };
    }
}
