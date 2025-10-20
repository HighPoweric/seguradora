<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrevista extends Model
{
    protected $fillable = [
        'peritaje_id',
        'participante_id',
        'perito_id',
        'fecha_entrevista',
        'archivo_audio',
        'transcripcion',
        'estado',
    ];

    /**
     * Relación con el modelo Peritaje.
     */
    public function peritaje(): BelongsTo
    {
        return $this->belongsTo(Peritaje::class);
    }

    /**
     * Relación con el modelo Participante.
     */
    public function participante(): BelongsTo
    {
        return $this->belongsTo(Participante::class);
    }

    /**
     * Relación con el modelo Perito.
     */
    public function perito(): BelongsTo
    {
        return $this->belongsTo(Perito::class);
    }
}
