<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspectoVeterinaria extends Model
{
    use HasFactory;

    protected $table = 'prospectos_veterinarias';

    protected $fillable = [
        'razon_social',
        'correo_comercial',
        'telefono',
        'departamento',
        'municipio',
        'direccion',
        'tipo',
        'estado',
        'intentos_envio',
        'ultimo_envio_at',
        'error_mensaje',
        'fuente',
    ];

    protected $casts = [
        'ultimo_envio_at' => 'datetime',
        'intentos_envio' => 'integer',
    ];

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEnviados($query)
    {
        return $query->where('estado', 'enviado');
    }

    public function scopeConError($query)
    {
        return $query->where('estado', 'error');
    }

    public function getCleanWhatsappNumberAttribute(): ?string
    {
        if (!$this->telefono) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $this->telefono);
        if (str_starts_with($digits, '57') && strlen($digits) === 12) {
            return $digits;
        }

        if (strlen($digits) === 10 && str_starts_with($digits, '3')) {
            return '57' . $digits;
        }

        return $digits;
    }

    /**
     * Mutator para garantizar correos siempre en minúsculas y sin espacios
     */
    protected function correoComercial(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            set: fn (?string $value) => $value ? strtolower(trim($value)) : null,
        );
    }

    /**
     * Upsert idempotente que previene duplicados y respeta estados históricos
     */
    public static function upsertProspectos(array $items): int
    {
        if (empty($items)) {
            return 0;
        }

        $now = now();
        $payload = [];
        $emailsProcessed = [];

        foreach ($items as $item) {
            $email = strtolower(trim($item['correo_comercial'] ?? ''));
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            // Evitar duplicados dentro del mismo lote entrante
            if (isset($emailsProcessed[$email])) {
                continue;
            }
            $emailsProcessed[$email] = true;

            $payload[] = [
                'razon_social' => trim($item['razon_social'] ?? 'Clínica Veterinaria'),
                'correo_comercial' => $email,
                'telefono' => isset($item['telefono']) ? trim($item['telefono']) : null,
                'departamento' => trim($item['departamento'] ?? 'Cundinamarca'),
                'municipio' => trim($item['municipio'] ?? 'Bogotá D.C.'),
                'direccion' => isset($item['direccion']) ? trim($item['direccion']) : null,
                'tipo' => trim($item['tipo'] ?? 'Clínica Veterinaria'),
                'fuente' => trim($item['fuente'] ?? 'Escaneo Nacional'),
                'estado' => $item['estado'] ?? 'pendiente',
                'intentos_envio' => (int) ($item['intentos_envio'] ?? 0),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (empty($payload)) {
            return 0;
        }

        // UPSERT SEGURO:
        // En conflicto por correo_comercial, actualiza campos informativos,
        // pero NO sobreescribe 'estado', 'intentos_envio' ni 'ultimo_envio_at' si ya fueron enviados.
        return static::upsert(
            $payload,
            uniqueBy: ['correo_comercial'],
            update: ['razon_social', 'municipio', 'departamento', 'direccion', 'tipo', 'telefono', 'fuente', 'updated_at']
        );
    }
}

