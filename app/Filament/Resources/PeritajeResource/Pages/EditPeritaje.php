<?php

namespace App\Filament\Resources\PeritajeResource\Pages;

use App\Filament\Resources\PeritajeResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Services\InformeService;

use App\Mail\SiniestroPendienteMail;
use App\Models\{Documento, Tarea, ChecklistDocumento, ChecklistTarea};
use App\Jobs\{SiniestroNotificacionProgramada, SiniestroAutoCompletar};

class EditPeritaje extends EditRecord
{
    protected static string $resource = PeritajeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // --- Botón: Sincronizar checklist (se oculta si ya está iniciado) ---
            Actions\Action::make('syncChecklist')
                ->label('Sincronizar checklist')
                ->icon('heroicon-o-arrow-path')
                ->hidden(fn () => filled($this->record?->iniciado_at))
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

            // --- Botón: Iniciar peritaje (dinámico según iniciado_at) ---
            Actions\Action::make('iniciarPeritaje')
                ->label(fn () => filled($this->record?->iniciado_at) ? 'Peritaje activo' : 'Iniciar peritaje')
                ->icon(fn () => filled($this->record?->iniciado_at) ? 'heroicon-o-check-circle' : 'heroicon-o-play')
                ->color(fn () => filled($this->record?->iniciado_at) ? 'gray' : 'success')
                ->disabled(fn () => filled($this->record?->iniciado_at))
                ->requiresConfirmation()
                ->action(function () {
                    $peritaje = $this->record;
                    $siniestro = $peritaje->siniestro;

                    if (filled($peritaje->iniciado_at)) {
                        Notification::make()->title('El peritaje ya está activo.')->success()->send();
                        return;
                    }

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
                    $to = null;
                    if (filter_var($siniestro->asegurado?->email, FILTER_VALIDATE_EMAIL)) {
                        $to = $siniestro->asegurado->email;
                    }
                    if (! $to && filter_var($siniestro->correo_contacto, FILTER_VALIDATE_EMAIL)) {
                        $to = $siniestro->correo_contacto;
                    }

                    $cc = [];
                    if (filter_var($peritaje->perito?->email, FILTER_VALIDATE_EMAIL)) {
                        $cc[] = $peritaje->perito->email;
                    }

                    $bcc = [];
                    $extra = config('services.siniestros.alert_emails') ?? env('SINIESTRO_ALERT_EMAILS');
                    if (!empty($extra)) {
                        $extras = array_map('trim', explode(',', $extra));
                        $validos = array_filter($extras, fn ($e) => filter_var($e, FILTER_VALIDATE_EMAIL));
                        $bcc = array_values(array_unique($validos));
                    }

                    if (! $to) {
                        Notification::make()
                            ->title('No hay destinatario principal (To).')
                            ->body('Agrega email del asegurado o correo_contacto para enviar la notificación.')
                            ->danger()
                            ->send();
                        return;
                    }

                    try {
                        // (1) Envío inicial: To + CC + BCC
                        Mail::to($to)->cc($cc)->bcc($bcc)->queue(new SiniestroPendienteMail($siniestro));

                        Log::info('Correo inicial enviado', [
                            'siniestro_id' => $siniestro->id,
                            'to'  => $to,
                            'cc'  => $cc,
                            'bcc' => $bcc,
                        ]);

                        // (2) Programar recordatorios
                        SiniestroNotificacionProgramada::dispatch($siniestro->id, 'recordatorio')
                            ->afterCommit()->onConnection(config('queue.default'))->onQueue('default')
                            ->delay(now()->addDays(1));

                        SiniestroNotificacionProgramada::dispatch($siniestro->id, 'recordatorio')
                            ->afterCommit()->onConnection(config('queue.default'))->onQueue('default')
                            ->delay(now()->addDays(3));

                        SiniestroNotificacionProgramada::dispatch($siniestro->id, 'recordatorio')
                            ->afterCommit()->onConnection(config('queue.default'))->onQueue('default')
                            ->delay(now()->addDays(5));

                        // (3) Programar cierre automático
                        SiniestroAutoCompletar::dispatch($siniestro->id)
                            ->afterCommit()->onConnection(config('queue.default'))->onQueue('default')
                            ->delay(now()->addDays(6));

                        // (4) Marcar como iniciado
                        $peritaje->forceFill(['iniciado_at' => now()])->save();

                        Notification::make()
                            ->title('Peritaje iniciado')
                            ->body('Correo inicial enviado y recordatorios/cierre programados.')
                            ->success()
                            ->send();

                        // refrescar para ver el cambio del botón
                        $this->dispatch('refresh');

                    } catch (\Throwable $e) {
                        Log::error('Error al enviar correo inicial de siniestro', [
                            'siniestro_id' => $siniestro->id,
                            'error' => $e->getMessage(),
                        ]);

                        Notification::make()
                            ->title('Error al enviar el correo inicial')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
            // Boton para generar informe usando el InformeService
            Actions\Action::make('generarInforme')
                ->label('Generar Informe')
                ->icon('heroicon-o-document-text')
                ->color('success')
                ->action(function () {
                    $informeService = app(InformeService::class);
                    return response()->download($informeService->generarInformePeritaje($this->record->id));
                }),
        ];
    }
}
