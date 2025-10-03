<?php

namespace App\Mail;

use App\Models\Siniestro;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SiniestroCierreColaboracionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Siniestro $siniestro,
        public ?string $peritoEmail = null,
        public ?string $peritoNombre = null,
        public ?string $nro = null,
        public ?string $aseguradora = null,
        public ?string $destinatario = null,
        public ?string $urlDetalle = null,
    ) {}

    public function build()
    {
        $nro          = $this->nro ?? ($this->siniestro->id_interno ?? (string) $this->siniestro->id);
        $aseguradora  = $this->aseguradora ?? ($this->siniestro->aseguradora ?? 'Aseguradora');
        $destinatario = $this->destinatario ?? ($this->siniestro->asegurado->nombre ?? 'Cliente');
        $urlDetalle   = $this->urlDetalle ?? route('siniestro.show', $this->siniestro->id); // ajusta

        $mail = $this->subject('Liquidación de siniestro — Cierre por colaboración')
            ->markdown('emails.siniestro.cierre', [
                'siniestro'     => $this->siniestro,
                'peritoEmail'   => $this->peritoEmail,
                'peritoNombre'  => $this->peritoNombre,
                'nro'           => $nro,
                'aseguradora'   => $aseguradora,
                'destinatario'  => $destinatario,
                'urlDetalle'    => $urlDetalle,
            ]);

        if ($this->peritoEmail) {
            $mail->replyTo($this->peritoEmail, $this->peritoNombre);
        }

        return $mail;
    }
}
