<?php

namespace App\Observers;

use App\Models\Peritaje;
use App\Models\Documento;
use App\Models\ChecklistDocumento;
use App\Models\Tarea;
use App\Models\ChecklistTarea;

class PeritajeObserver
{
    public function created(Peritaje $peritaje): void
    {
        // Documentos activos
        $docs = Documento::where('activo', true)->get(['id']);
        foreach ($docs as $d) {
            ChecklistDocumento::firstOrCreate([
                'peritaje_id'  => $peritaje->id,
                'documento_id' => $d->id,
            ], [
                'requerido' => true,
                'cargado'   => false,
            ]);
        }

        // Tareas (todas las de catálogo)
        $tareas = Tarea::query()->get(['id']);
        foreach ($tareas as $t) {
            ChecklistTarea::firstOrCreate([
                'peritaje_id' => $peritaje->id,
                'tarea_id'    => $t->id,
            ], [
                'estado' => 'no_iniciada',
            ]);
        }
    }
}
