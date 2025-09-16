<?php

namespace App\Filament\Resources\ChecklistDocumentoResource\Pages;

use App\Filament\Resources\ChecklistDocumentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChecklistDocumentos extends ListRecords
{
    protected static string $resource = ChecklistDocumentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
