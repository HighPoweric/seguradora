<?php

namespace App\Mail;

use App\Models\Siniestro;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SiniestroCierreColaboracionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Siniestro $siniestro) {}

    public function build()
    {
        $nro  = (string) ($this->siniestro->id_interno ?? $this->siniestro->id);
        $aseg = (string) ($this->siniestro->aseguradora ?: 'Aseguradora');

        return $this
            ->subject("CIERRE POR COLABORACIÓN - SINIESTRO {$nro} {$aseg}")
            ->markdown('emails.siniestros.cierre_colaboracion', [
                'nro'         => $nro,
                'aseguradora' => $aseg,
                'urlDetalle'  => url("/admin/siniestros/{$this->siniestro->id}/edit"),
            ]);
    }
}
