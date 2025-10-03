<?php

namespace App\Jobs;

use App\Models\Siniestro;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SiniestroAutoCompletar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $siniestroId;

    /** Evita ejecuciones duplicadas durante 1h (opcional) */
    public int $uniqueFor = 3600;

    public int $tries = 3;
    public int $backoff = 10;

    public function __construct(int $siniestroId)
    {
        $this->siniestroId = $siniestroId;
        $this->onQueue('default');
    }

    public function handle(): void
    {
        DB::transaction(function () {
            $s = Siniestro::lockForUpdate()->find($this->siniestroId);
            if (! $s) {
                Log::warning('AutoCompletar: siniestro no encontrado', ['id' => $this->siniestroId]);
                return;
            }

            // Solo cerrar si aún sigue pendiente
            if ($s->status === 'pendiente') {
                $s->update(['status' => 'completado']); // ajusta el estado si usas otro
                Log::info('AutoCompletar: siniestro marcado como completado', ['id' => $s->id]);
            } else {
                Log::info('AutoCompletar: sin acción, status no es pendiente', [
                    'id' => $s->id,
                    'status' => $s->status,
                ]);
            }
        });
    }
}
