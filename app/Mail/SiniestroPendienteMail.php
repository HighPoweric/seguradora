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
        ]);
    }

    public function build()
    {
        $nro  = (string) ($this->siniestro->id_interno ?? $this->siniestro->id);
        $aseg = (string) ($this->siniestro->aseguradora ?: 'Aseguradora');

        // ✅ null-safe en asegurado
        $nombre   = $this->siniestro->asegurado?->nombre ?? '';
        $apellido = $this->siniestro->asegurado?->apellido ?? '';
        $destinatario = trim($nombre.' '.$apellido) ?: ($nombre ?: 'participante');

        // Peritaje más reciente con documentos y perito
        $peritaje = Peritaje::with([
                'documentos' => fn($q) => $q->orderBy('nombre'),
                'perito',
            ])
            ->where('siniestro_id', $this->siniestro->id)
            ->latest()
            ->first();

        // Siempre colección
        $documentos = $peritaje
            ? $peritaje->documentos()->wherePivot('requerido', true)->get()
            : collect();

        $urlDetalle = url("/admin/siniestros/{$this->siniestro->id}/edit");

        $mail = $this
            ->subject("LIQUIDACIÓN SINIESTRO {$nro} {$aseg}")
            // Asegúrate de que esta ruta de vista exista (emails/siniestros/pendiente.blade.php)
            ->markdown('emails.siniestros.pendiente', [
                'nro'          => $nro,
                'aseguradora'  => $aseg,
                'destinatario' => $destinatario,
                'documentos'   => $documentos,
                'urlDetalle'   => $urlDetalle,
                'perito'       => $peritaje?->perito,
            ]);

        // CC automático al perito si existe y es válido
        if ($peritaje?->perito && filter_var($peritaje->perito->email, FILTER_VALIDATE_EMAIL)) {
            $mail->cc($peritaje->perito->email, $peritaje->perito->nombreCompleto);
        }

        return $mail;
    }
}
