<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarea extends Model
{
    protected $fillable = ['tarea', 'descripcion'];

    public function checklistTareas(): HasMany
    {
        return $this->hasMany(ChecklistTarea::class);
    }
}
