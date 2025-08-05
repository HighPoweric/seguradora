<?php

namespace App\Filament\Resources\SiniestroResource\Pages;

use App\Filament\Resources\SiniestroResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSiniestro extends EditRecord
{
    protected static string $resource = SiniestroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
