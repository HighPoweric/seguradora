<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParticipanteSiniestro extends Model
{
    protected $table = 'participante_siniestro';

    protected $fillable = [
        'siniestro_id',
        'participante_id',
        'asegurado',
        'conductor',
        'contratante',
        'denunciante',
        'otro_rol',
    ];

    public $timestamps = true;

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

    //relacion con entrevistas
    public function entrevistas(): HasMany
    {
        return $this->hasMany(Entrevista::class);
    }
}