<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peritaje extends Model
{
    protected $fillable = [
        'solicitante',
        'siniestro_id',
        'perito_id',
        'fecha_sinis',
    ];

    protected $casts = [
        'fecha_sinis' => 'date',
    ];

    /** Pertenece a un siniestro */
    public function siniestro(): BelongsTo
    {
        return $this->belongsTo(Siniestro::class);
    }

    /** Pertenece a un perito */
    public function perito(): BelongsTo
    {
        return $this->belongsTo(Perito::class);
    }

    /** Checklist de documentos del peritaje */
    public function checklistDocumentos(): HasMany
    {
        return $this->hasMany(ChecklistDocumento::class); // <-- sin ->with() aquí
    }

    /** Checklist de tareas del peritaje */
    public function checklistTareas(): HasMany
    {
        return $this->hasMany(ChecklistTarea::class); // <-- sin ->with() aquí
    }
}
