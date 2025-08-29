<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Siniestro;
use App\Models\Participante;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecordatorioDocumentos;
use Carbon\Carbon;

class EnviarRecordatorios extends Command
{
    protected $signature = 'recordatorios:enviar';
    protected $description = 'Envía recordatorios a los participantes pendientes';

    public function handle(): void
{
    $siniestros = Siniestro::where('status', 'pendiente')->get();

    foreach ($siniestros as $siniestro) {
        $participante = Participante::find($siniestro->denunciante_id);

        if (!$participante || !$participante->email) {
            $this->warn("Participante no encontrado o sin email para siniestro {$siniestro->id}");
            continue;
        }

        $diasPendiente = \Carbon\Carbon::parse($siniestro->created_at)->diffInDays(now());

        if ($diasPendiente === 0) {
            // Solo enviamos el primer día (cuando recién se creó)
            \Mail::to($participante->email)->send(new \App\Mail\RecordatorioDocumentos($participante, $siniestro));
            $this->info("Primer recordatorio enviado a {$participante->email}");
        }
    }
}

}
