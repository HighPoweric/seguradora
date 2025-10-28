<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siniestro extends Model
{
    protected $fillable = [
        'id_interno',
        'fecha_siniestro',
        'comuna',
        'ciudad',
        'region',
        'hora_siniestro',
        'policia_presente',
        'alcolemia_realizada',
        'vehiculo_inmovilizado',
        'vehiculo_id',
        'direccion_informada',
        'direccion_aproximada',
        'latitud',
        'longitud',
        'status',
        'aseguradora',

    ];

    protected $casts = [
        'fecha_siniestro' => 'date',
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
    
    public function participantes()
    {
        return $this->belongsToMany(Participante::class, 'participante_siniestro')
            ->withPivot('asegurado', 'conductor', 'contratante', 'denunciante', 'otro_rol')
            ->withTimestamps();
    }

    //agregamos relacion con la pivot participante_siniestro
    public function participanteSiniestros()
    {
        return $this->hasMany(ParticipanteSiniestro::class);
    }

    //agregamos la relacion con Entrevistas
    public function entrevistas(): HasMany
    {
        return $this->hasMany(Entrevista::class);
    }
}
