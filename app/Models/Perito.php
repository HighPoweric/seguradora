<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perito extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'email',
    ];

    public function peritajes(): HasMany
    {
        return $this->hasMany(Peritaje::class, 'peritor_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
