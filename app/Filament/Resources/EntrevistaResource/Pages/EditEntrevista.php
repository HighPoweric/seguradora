<?php

namespace App\Filament\Resources\EntrevistaResource\Pages;

use App\Filament\Resources\EntrevistaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEntrevista extends EditRecord
{
    protected static string $resource = EntrevistaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
