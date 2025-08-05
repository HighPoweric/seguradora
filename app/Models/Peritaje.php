<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peritaje extends Model
{
    protected $fillable = [
        'solicitante',
        'siniestro_id',
        'perito_id',
    ];

    public function siniestro()
    {
        return $this->belongsTo(Siniestro::class);
    }

    public function perito()
    {
        return $this->belongsTo(Perito::class);
    }
}
