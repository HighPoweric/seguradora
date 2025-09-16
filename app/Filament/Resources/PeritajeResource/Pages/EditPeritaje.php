<?php

namespace App\Filament\Resources\PeritajeResource\Pages;

use App\Filament\Resources\PeritajeResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use Filament\Notifications\Notification; // 👈 importa Notification
use App\Models\{Documento, Tarea, ChecklistDocumento, ChecklistTarea};

class EditPeritaje extends EditRecord
{
    protected static string $resource = PeritajeResource::class;

    protected function getHeaderActions(): array
    {
        return [
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

                    // ✅ Notificación en Filament v3
                    Notification::make()
                        ->title('Checklist sincronizado')
                        ->success()
                        ->send();
                }),
        ];
    }
}
