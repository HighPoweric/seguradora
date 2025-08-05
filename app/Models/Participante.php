<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participante extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'rut',
        'dv',
        'nombre',
        'apellido',
        'telefono',
        'email',
        'licencia_conducir',
    ];

    /**
     * Relación con otros modelos si es necesario.
     * Puedes eliminar este método si no tienes relación aún.
     */
    public function peritajes(): HasMany
    {
        return $this->hasMany(Peritaje::class, 'participante_id');
    }

    /**
     * Devuelve el nombre completo (nombre + apellido)
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
