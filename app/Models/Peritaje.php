<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class Peritaje extends Model
{
    protected $fillable = [
        'solicitante',
        'siniestro_id',
        'perito_id',
        'fecha_siniestro',
        'iniciado_at',              // ✅ habilitamos escritura
    ];

    protected $casts = [
        'fecha_siniestro' => 'date',
        'iniciado_at'     => 'datetime',   // ✅ casteo correcto
    ];

    /** Helpers */
    public function getEstaIniciadoAttribute(): bool
    {
        return filled($this->iniciado_at);
    }

    public function iniciar(): void
    {
        if (!$this->esta_iniciado) {
            $this->iniciado_at = Carbon::now();
            $this->save();
        }
    }

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

    /** Relación muchos a muchos con documentos (incluye archivo en pivot) */
    public function documentos(): BelongsToMany
    {
        return $this->belongsToMany(Documento::class, 'documento_peritaje')
            ->withPivot(['requerido', 'estado', 'observacion', 'archivo'])
            ->withTimestamps();
    }

    /** Checklist de documentos del peritaje */
    public function checklistDocumentos(): HasMany
    {
        return $this->hasMany(ChecklistDocumento::class);
    }

    /** Checklist de tareas del peritaje */
    public function checklistTareas(): HasMany
    {
        return $this->hasMany(ChecklistTarea::class);
    }

    /** Hook al crear: agrega los documentos obligatorios */
    protected static function booted()
    {
        static::created(function (Peritaje $peritaje) {
            $obligatorios = Documento::where('obligatorio', true)->get();

            foreach ($obligatorios as $doc) {
                $peritaje->documentos()->attach($doc->id, [
                    'requerido'   => true,
                    'estado'      => 'pendiente',
                    'observacion' => null,
                    'archivo'     => null,
                ]);
            }
        });
    }
}
