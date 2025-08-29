<?php

namespace App\Mail;

use App\Models\Siniestro;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
// app/Mail/SiniestroPendienteMail.php
class SiniestroPendienteMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Siniestro $siniestro)
    {
        $this->siniestro->loadMissing(['asegurado','denunciante','conductor','contratante','vehiculo']);
    }

    public function build()
    {
        $nro = $this->siniestro->id_interno ?? $this->siniestro->id;
        $destinatario = $this->siniestro->asegurado?->nombre ?? 'participante'; // <- AQUÍ el ?->

        return $this->subject("LIQUIDACIÓN SINIESTRO {$nro} BCI SEGUROS O ZENIT SEGUROS")
            ->markdown('emails.siniestros.pendiente', [
                'nro'          => $nro,
                'destinatario' => $destinatario,
            ]);
    }
}
