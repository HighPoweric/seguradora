<?php

namespace App\Filament\Resources\PeritajeResource\Pages;

use App\Filament\Resources\PeritajeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeritaje extends EditRecord
{
    protected static string $resource = PeritajeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
