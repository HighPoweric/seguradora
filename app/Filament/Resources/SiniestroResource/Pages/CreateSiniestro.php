<?php

namespace App\Filament\Resources\SiniestroResource\Pages;

use App\Filament\Resources\SiniestroResource;
use App\Models\Siniestro;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class CreateSiniestro extends CreateRecord
{
    protected static string $resource = SiniestroResource::class;

    /** Setea status por defecto y genera id_interno si vino vacío */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = strtolower($data['status'] ?? 'pendiente');

        if (blank($data['id_interno'] ?? null)) {
            // Pequeña protección ante condiciones de carrera:
            $data['id_interno'] = (string) DB::transaction(function () {
                // bloquea lectura mientras calcula el siguiente
                $max = Siniestro::query()->lockForUpdate()->max('id_interno');
                return ((int) ($max ?? 0)) + 1;
            });
        }

        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        $nro = $this->record->id_interno ?? $this->record->id;

        return Notification::make()
            ->title("Siniestro {$nro} creado")
            ->body(
                $this->record->status === 'pendiente'
                    ? 'Se notificó al asegurado por correo.'
                    : 'Cambia el estado a Pendiente para notificar por correo.'
            )
            ->success();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
}
