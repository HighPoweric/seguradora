<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'asegurado_id',
        'denunciante_id',
        'conductor_id',
        'contratante_id',
        'relacion_asegurado_conductor',
        'direccion_informada',
        'direccion_aproximada',
        'latitud',
        'longitud',
        'status',
        'aseguradora',

    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function asegurado()
    {
        return $this->belongsTo(Participante::class, 'asegurado_id');
    }

    public function denunciante()
    {
        return $this->belongsTo(Participante::class, 'denunciante_id');
    }

    public function conductor()
    {
        return $this->belongsTo(Participante::class, 'conductor_id');
    }

    public function contratante()
    {
        return $this->belongsTo(Participante::class, 'contratante_id');
    }
}
