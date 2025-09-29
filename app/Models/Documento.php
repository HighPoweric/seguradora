<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Documento extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'activo', 'obligatorio']; // <-- agrega obligatorio

    protected $casts = [
        'activo'      => 'boolean',
        'obligatorio' => 'boolean', // <-- castea a boolean
    ];

    public function checklistDocumentos(): HasMany
    {
        return $this->hasMany(ChecklistDocumento::class);
    }

    public function peritajes()
    {
        return $this->belongsToMany(Peritaje::class, 'documento_peritaje')
            ->withPivot(['requerido','estado','observacion'])
            ->withTimestamps();
    }
}
