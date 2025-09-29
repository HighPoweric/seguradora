<?php

namespace App\Mail;

use App\Models\Siniestro;
use App\Models\Peritaje;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SiniestroPendienteMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Siniestro $siniestro)
    {
        $this->siniestro->loadMissing([
            'asegurado', 'denunciante', 'conductor', 'contratante', 'vehiculo',
            // 'peritaje.documentos'  // <- QUITAR esto
        ]);
    }

    public function build()
    {
        $nro  = (string) ($this->siniestro->id_interno ?? $this->siniestro->id);
        $aseg = (string) ($this->siniestro->aseguradora ?: 'Aseguradora');

        // Nombre + apellido (ajusta a tus campos reales)
        $destinatario = trim(
            ($this->siniestro->asegurado->nombre ?? '') . ' ' .
            ($this->siniestro->asegurado->apellido ?? '')
        ) ?: ($this->siniestro->asegurado->nombre ?? 'participante');

        // Busca el peritaje más reciente del siniestro y carga sus documentos
        $peritaje = Peritaje::with(['documentos' => function ($q) {
                $q->orderBy('nombre');
            }])
            ->where('siniestro_id', $this->siniestro->id)
            ->latest()
            ->first();

        $documentos = $peritaje
            ? $peritaje->documentos()->wherePivot('requerido', true)->get()
            : collect();

        $urlDetalle = url("/admin/siniestros/{$this->siniestro->id}/edit");

        return $this
            ->subject("LIQUIDACIÓN SINIESTRO {$nro} {$aseg}")
            ->markdown('emails.siniestros.pendiente', [
                'nro'          => $nro,
                'aseguradora'  => $aseg,
                'destinatario' => $destinatario,
                'documentos'   => $documentos,
                'urlDetalle'   => $urlDetalle,
            ]);
    }
}
