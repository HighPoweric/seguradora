<?php

namespace App\Observers;

use App\Mail\SiniestroPendienteMail;
use App\Models\Siniestro;
use Illuminate\Support\Facades\Mail;

class SiniestroObserver
{
    public function created(Siniestro $s)
    {
        // Si se crea ya en pendiente, dispara correo
        if ($this->estaPendiente($s)) {
            $this->enviarCorreos($s);
        }
    }

    public function updated(Siniestro $s)
    {
        // Solo si CAMBIÓ a pendiente (evita duplicar correos en edits)
        if ($s->wasChanged('status') && $this->estaPendiente($s)) {
            $this->enviarCorreos($s);
        }
    }

    private function estaPendiente(Siniestro $s): bool
    {
        return strtolower((string)$s->status) === 'pendiente';
    }

    private function enviarCorreos(Siniestro $s): void
    {
        // Toma email del asegurado; si no existe 'email', prueba 'correo'
        $correos = collect([
            $s->asegurado?->email ?? $s->asegurado?->correo,
        ])->filter(fn ($e) => is_string($e) && filter_var($e, FILTER_VALIDATE_EMAIL))
          ->unique()
          ->values();

        if ($correos->isEmpty()) {
            \Log::warning('Siniestro pendiente sin correos válidos de asegurado', ['siniestro_id' => $s->id]);
            return;
        }

        // Privacidad: enviamos de a uno (no exponemos direcciones entre sí)
        foreach ($correos as $email) {
            Mail::to($email)->queue(new SiniestroPendienteMail($s));
        }
    }

}
