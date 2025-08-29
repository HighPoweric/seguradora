<?php
namespace App\Mail;

use App\Models\Siniestro;
use App\Models\Participante;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecordatorioDocumentos extends Mailable
{
    use Queueable, SerializesModels;

    public $participante;
    public $siniestro;

    public function __construct(Participante $participante, Siniestro $siniestro)
    {
        $this->participante = $participante;
        $this->siniestro = $siniestro;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recordatorio de Envío de Documentos'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.recordatorio-documentos',
            with: [
                'participante' => $this->participante,
                'siniestro' => $this->siniestro,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

