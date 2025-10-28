<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrevista extends Model
{
    protected $fillable = [
        'participante_siniestro_id',
        'perito_id',
        'fecha_entrevista',
        'archivo_audio',
        'transcripcion',
        'estado',
    ];

    /**
     * Relación con el modelo ParticipanteSiniestro.
     */
    public function participanteSiniestro(): BelongsTo
    {
        return $this->belongsTo(ParticipanteSiniestro::class);
    }

    /**
     * Relación con el modelo Perito.
     */
    public function perito(): BelongsTo
    {
        return $this->belongsTo(Perito::class);
    }
}
