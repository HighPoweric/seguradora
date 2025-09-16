<?php

// app/Models/ChecklistTarea.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChecklistTarea extends Model
{
    protected $table = 'checklist_tareas';

    protected $fillable = [
        'tarea_id','peritaje_id','estado','observaciones','completada_at','responsable_id',
    ];

    protected $casts = [
        'completada_at' => 'datetime',
    ];

    public function tarea(): BelongsTo { return $this->belongsTo(Tarea::class); }
    public function peritaje(): BelongsTo { return $this->belongsTo(Peritaje::class); }
    public function responsable(): BelongsTo { return $this->belongsTo(User::class, 'responsable_id'); }
}
