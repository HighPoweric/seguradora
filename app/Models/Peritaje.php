<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peritaje extends Model
{
    // Campos asignables masivamente
    protected $fillable = [
        'solicitante',
        'siniestro_id',
        'perito_id',
        'fecha_sinis',
    ];

    /**
     * Relación con el siniestro al que pertenece el peritaje
     */
    public function siniestro(): BelongsTo
    {
        return $this->belongsTo(Siniestro::class);
    }

    /**
     * Relación con el perito que realiza el peritaje
     */
    public function perito(): BelongsTo
    {
        return $this->belongsTo(Perito::class);
    }
}
