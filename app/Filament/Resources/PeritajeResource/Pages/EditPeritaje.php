<?php

namespace App\Filament\Resources\PeritajeResource\Pages;

use App\Filament\Resources\PeritajeResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use Filament\Notifications\Notification; // UI
use Illuminate\Support\Facades\Mail;     // 👈 mail
use App\Mail\SiniestroPendienteMail;     // 👈 tu mailable
use App\Models\{Documento, Tarea, ChecklistDocumento, ChecklistTarea};
use App\Jobs\ReenviarCorreoPeritajeJob;

class EditPeritaje extends EditRecord
{
    protected static string $resource = PeritajeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // --- Botón existente ---
            Actions\Action::make('syncChecklist')
                ->label('Sincronizar checklist')
                ->icon('heroicon-o-arrow-path')
                ->requiresConfirmation()
                ->action(function () {
                    $p = $this->record;

                    Documento::where('activo', true)->pluck('id')->each(function ($docId) use ($p) {
                        ChecklistDocumento::firstOrCreate(
                            ['peritaje_id' => $p->id, 'documento_id' => $docId],
                            ['requerido' => true, 'cargado' => false]
                        );
                    });

                    Tarea::pluck('id')->each(function ($tareaId) use ($p) {
                        ChecklistTarea::firstOrCreate(
                            ['peritaje_id' => $p->id, 'tarea_id' => $tareaId],
                            ['estado' => 'no_iniciada']
                        );
                    });

                    Notification::make()
                        ->title('Checklist sincronizado')
                        ->success()
                        ->send();
                }),

            // --- Nuevo botón: Iniciar peritaje ---
            Actions\Action::make('iniciarPeritaje')
                ->label('Iniciar peritaje')
                ->icon('heroicon-o-play')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $peritaje = $this->record;
                    $siniestro = $peritaje->siniestro; // relación BelongsTo

                    if (!$siniestro) {
                        Notification::make()
                            ->title('Este peritaje no tiene siniestro asociado.')
                            ->danger()
                            ->send();
                        return;
                    }

                    if ($siniestro->status !== 'pendiente') {
                        Notification::make()
                            ->title('El siniestro no está en estado "pendiente".')
                            ->body('Estado actual: ' . ($siniestro->status ?? '—'))
                            ->warning()
                            ->send();
                        return;
                    }

                    // ===== Destinatarios =====
                    $emails = [];

                    // Asegurado (si existe y tiene email)
                    if ($siniestro->asegurado?->email) {
                        $emails[] = $siniestro->asegurado->email;
                    }

                    // Correos extra desde .env (separados por coma)
                    $extra = env('SINIESTRO_ALERT_EMAILS'); // ej: mesa@empresa.cl,supervisor@empresa.cl
                    if ($extra) {
                        $emails = array_merge($emails, array_map('trim', explode(',', $extra)));
                    }

                    $emails = array_values(array_filter(array_unique($emails)));

                    if (empty($emails)) {
                        Notification::make()
                            ->title('No hay destinatarios configurados.')
                            ->body('Configura SINIESTRO_ALERT_EMAILS en .env o agrega email del asegurado.')
                            ->danger()
                            ->send();
                        return;
                    }

                    // Envío (tu mailable implementa ShouldQueue → usamos queue)
                    foreach ($emails as $email) {
                        Mail::to($email)->queue(new SiniestroPendienteMail($siniestro));
                    }
                    // ⏳ Programar reenvío (1 min en pruebas; luego addHours(24))
                    ReenviarCorreoPeritajeJob::dispatch($siniestro->id)
                    ->onConnection(config('queue.default')) // p.ej. "database"
                    ->onQueue('default')
                    ->delay(now()->addMinute());
                    // (Opcional) cambiar estado del siniestro a "en_proceso"
                    // Descomenta si quieres actualizar estado automáticamente:
                    // $siniestro->update(['status' => 'en_proceso']);

                    Notification::make()
                        ->title('Peritaje iniciado')
                        ->body('Se envió el correo porque el siniestro está en estado PENDIENTE.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
