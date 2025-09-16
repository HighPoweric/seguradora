<?php

namespace App\Filament\Resources\ChecklistTareaResource\Pages;

use App\Filament\Resources\ChecklistTareaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChecklistTareas extends ListRecords
{
    protected static string $resource = ChecklistTareaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
