<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participante extends Model
{
    // Habilitar asignación masiva para estos campos
    protected $fillable = [
        'rut',
        'dv',
        'nombre',
        'apellido',
        'telefono',
        'email',
        'licencia_conducir',
    ];

    // Si deseas ocultar campos en arrays o respuestas JSON (opcional)
    // protected $hidden = [];

    // Si deseas agregar atributos virtuales como "nombre_completo"
    protected $appends = ['nombre_completo'];

    /**
     * Relación con peritajes (si corresponde)
     * Este método puedes eliminarlo si no usas esta relación
     */
    public function peritajes(): HasMany
    {
        return $this->hasMany(Peritaje::class, 'participante_id');
    }

    /**
     * Atributo virtual: nombre completo
     * Permite usar `$participante->nombre_completo` en las vistas
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
