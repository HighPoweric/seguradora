<?php

namespace App\Jobs;

use App\Models\Siniestro;
use App\Mail\SiniestroPendienteMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // 👈 importante
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;         // 👈 importar aquí
use Illuminate\Support\Facades\Mail;

class ReenviarCorreoPeritajeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $siniestroId;
    public $tries = 3;
    public $backoff = 5;

    public function __construct(int $siniestroId)
    {
        $this->siniestroId = $siniestroId;
    }

    public function handle(): void
{
    Log::info('JOB ejecutado', ['siniestro_id' => $this->siniestroId]);

    $siniestro = Siniestro::find($this->siniestroId);
    if (! $siniestro) {
        Log::warning('JOB siniestro no encontrado', ['siniestro_id' => $this->siniestroId]);
        return;
    }

    // ✅ Solo reenvía si sigue pendiente
    if ($siniestro->status !== 'pendiente') {
        Log::info('No se reenvía: status cambió', ['status' => $siniestro->status]);
        return;
    }

    // ✅ Destinatarios: mismo criterio que el botón
    $emails = [];

    // 1) contacto directo del siniestro (si tienes este campo)
    if (!empty($siniestro->correo_contacto)) {
        $emails[] = $siniestro->correo_contacto;
    }

    // 2) asegurado
    if (!empty($siniestro->asegurado?->email)) {
        $emails[] = $siniestro->asegurado->email;
    }

    // 3) extras desde config/env (mejor vía config que env() directo)
    $extra = config('services.siniestros.alert_emails') // ej: "mesa@empresa.cl,supervisor@empresa.cl"
        ?? env('SINIESTRO_ALERT_EMAILS');
    if (!empty($extra)) {
        $emails = array_merge($emails, array_map('trim', explode(',', $extra)));
    }

    // Normalizar
    $emails = array_values(array_filter(array_unique($emails)));

    if (empty($emails)) {
        Log::warning('No hay destinatarios para reenvío', ['siniestro_id' => $siniestro->id]);
        return;
    }

    Log::info('Reenviando a', ['to' => $emails]);

    // Puedes usar send() (sin cola) dentro del Job
    foreach ($emails as $to) {
        Mail::to($to)->send(new SiniestroPendienteMail($siniestro));
    }

    Log::info('Reenvío completado', ['siniestro_id' => $siniestro->id]);
}

}
