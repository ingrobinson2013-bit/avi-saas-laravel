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
}
