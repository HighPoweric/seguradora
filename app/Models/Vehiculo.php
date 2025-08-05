<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $fillable = [
        'patente',
        'tipo',
        'marca',
        'modelo',
    ];
}
