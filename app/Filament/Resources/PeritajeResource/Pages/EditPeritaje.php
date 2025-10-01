<?php

namespace App\Filament\Resources\PeritajeResource\Pages;

use App\Filament\Resources\PeritajeResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\SiniestroPendienteMail;
use App\Models\{Documento, Tarea, ChecklistDocumento, ChecklistTarea};
use App\Jobs\SiniestroNotificacionProgramada; // 👈 nuevo job

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
                    $siniestro = $peritaje->siniestro;

                    if (! $siniestro) {
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

                    // Asegurado
                    if (!empty($siniestro->asegurado?->email)) {
                        $emails[] = $siniestro->asegurado->email;
                    }

                    // Correos extra desde .env (separados por coma)
                    $extra = config('services.siniestros.alert_emails') ?? env('SINIESTRO_ALERT_EMAILS'); // ej: mesa@empresa.cl,supervisor@empresa.cl
                    if (!empty($extra)) {
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

                    // 1) Envío inicial
                    foreach ($emails as $email) {
                        Mail::to($email)->queue(new SiniestroPendienteMail($siniestro));
                    }

                    // 2) Programar recordatorios día 1, 3, 5
                    SiniestroNotificacionProgramada::dispatch($siniestro->id, 'recordatorio')
                        ->afterCommit()->onConnection(config('queue.default'))->onQueue('default')
                        ->delay(now()->addMinutes(1));
                        //->delay(now()->addDays(1));

                    SiniestroNotificacionProgramada::dispatch($siniestro->id, 'recordatorio')
                        ->afterCommit()->onConnection(config('queue.default'))->onQueue('default')
                        ->delay(now()->addMinutes(2));
                        //->delay(now()->addDays(3));

                    SiniestroNotificacionProgramada::dispatch($siniestro->id, 'recordatorio')
                        ->afterCommit()->onConnection(config('queue.default'))->onQueue('default')
                        ->delay(now()->addMinutes(3));
                        //->delay(now()->addDays(5));

                    // 3) Programar cierre por colaboración día 6
                    SiniestroNotificacionProgramada::dispatch($siniestro->id, 'cierre')
                        ->afterCommit()->onConnection(config('queue.default'))->onQueue('default')
                        ->delay(now()->addMinutes(4));
                        //->delay(now()->addDays(6));

                    Notification::make()
                        ->title('Peritaje iniciado')
                        ->body('Correo inicial enviado y recordatorios/cierre programados.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
