<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChecklistDocumento extends Model
{
    protected $table = 'checklist_documentos';

    protected $fillable = [
        'documento_id','peritaje_id','requerido','cargado','ruta',
    ];

    protected $casts = [
        'requerido' => 'boolean',
        'cargado'   => 'boolean',
    ];

    public function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class);
    }

    public function peritaje(): BelongsTo
    {
        return $this->belongsTo(Peritaje::class);
    }
}
