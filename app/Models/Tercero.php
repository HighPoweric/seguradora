<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tercero extends Model
{
    protected $fillable = [
        'siniestro_id',
        'participante_id',
        'rol',
    ];

    /**
     * Relación con el modelo Siniestro.
     */
    public function siniestro(): BelongsTo
    {
        return $this->belongsTo(Siniestro::class);
    }

    /**
     * Relación con el modelo Participante.
     */
    public function participante(): BelongsTo
    {
        return $this->belongsTo(Participante::class);
    }
}
