<?php

namespace App\Filament\Resources\PeritajeResource\Pages;

use App\Filament\Resources\PeritajeResource;
use Filament\Resources\Pages\CreateRecord;
use App\Mail\SiniestroPendienteMail;
use App\Jobs\ReenviarCorreoPeritajeJob;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; // 👈 importar aquí

class CreatePeritaje extends CreateRecord
{
    protected static string $resource = PeritajeResource::class;

    /**
     * Se ejecuta después de crear el Peritaje.
     */
    protected function afterCreate(): void
    {
        $peritaje  = $this->record; // Peritaje recién creado
        $siniestro = $peritaje->siniestro;

        Log::info('afterCreate() disparado', ['peritaje_id' => $peritaje->id]);

        if ($siniestro && $siniestro->correo_contacto) {
            // 📧 Envío inicial
            Mail::to($siniestro->correo_contacto)
                ->send(new SiniestroPendienteMail($siniestro));

            // ⏳ Programar Job de reenvío (1 minuto para pruebas)
            ReenviarCorreoPeritajeJob::dispatch($siniestro->id)
                ->onConnection(config('queue.default')) // normalmente "database"
                ->onQueue('default')
                ->delay(now()->addMinute());

            Log::info('Job de reenvío despachado', [
                'siniestro_id' => $siniestro->id,
                'queue' => 'default',
                'connection' => config('queue.default'),
                'run_at' => now()->addMinute()->toDateTimeString(),
            ]);
        } else {
            Log::warning('No se pudo enviar correo inicial (faltan datos de siniestro/correo)', [
                'peritaje_id' => $peritaje->id,
            ]);
        }
    }
}
