<?php

namespace App\Mail;

use App\Models\Siniestro;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class LiquidacionSiniestroMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Siniestro $siniestro,
        public string $nombreLiquidador,
        public string $cargo,
        public string $compania,
        public string $telefono,
        public string $correo
    ) {}

    /**
     * Define el asunto del correo.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'LIQUIDACIÓN SINIESTRO ' . $this->siniestro->id_interno . ' - ' . $this->compania,
        );
    }

    /**
     * Define la plantilla y los datos que se pasarán a la vista.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.liquidacion-siniestro',
        );
    }

    /**
     * Define si hay archivos adjuntos (opcional).
     */
    public function attachments(): array
    {
        return [];
    }
}
