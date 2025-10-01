<?php

namespace App\Jobs;

use App\Models\Siniestro;
use App\Mail\SiniestroPendienteMail;
use App\Mail\SiniestroCierreColaboracionMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SiniestroNotificacionProgramada implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $siniestroId,
        public string $tipo // 'recordatorio' | 'cierre'
    ) {}

    public $tries = 3;
    public $backoff = 10;

    public function handle(): void
    {
        $s = Siniestro::with('asegurado')->find($this->siniestroId);
        if (! $s) { Log::warning('Siniestro no encontrado', ['id' => $this->siniestroId]); return; }

        // Solo actuar si sigue pendiente
        if ($s->status !== 'pendiente') {
            Log::info('Sin acción: status cambió', ['id' => $s->id, 'status' => $s->status, 'tipo' => $this->tipo]);
            return;
        }

        // Destinatarios (mismo criterio que el botón)
        $emails = [];
        if (!empty($s->correo_contacto))        $emails[] = $s->correo_contacto;
        if (!empty($s->asegurado?->email))      $emails[] = $s->asegurado->email;

        $extra = config('services.siniestros.alert_emails') ?? env('SINIESTRO_ALERT_EMAILS');
        if (!empty($extra)) $emails = array_merge($emails, array_map('trim', explode(',', $extra)));

        $emails = array_values(array_filter(array_unique($emails)));
        if (empty($emails)) { Log::warning('Sin destinatarios', ['id' => $s->id, 'tipo' => $this->tipo]); return; }

        if ($this->tipo === 'recordatorio') {
            foreach ($emails as $to) Mail::to($to)->send(new SiniestroPendienteMail($s));
            Log::info('Recordatorio enviado', ['id' => $s->id, 'to' => $emails]);
        } else { // cierre
            foreach ($emails as $to) Mail::to($to)->send(new SiniestroCierreColaboracionMail($s));
            Log::info('Cierre por colaboración enviado', ['id' => $s->id, 'to' => $emails]);

            // (Opcional) cerrar automáticamente
            if (config('services.siniestros.cerrar_automatico', false) || env('SINIESTRO_CERRAR_AUTOMATICO', false)) {
                $s->update(['status' => 'cerrado_colaboracion']);
                Log::info('Estado actualizado a cerrado_colaboracion', ['id' => $s->id]);
            }
        }
    }
}
