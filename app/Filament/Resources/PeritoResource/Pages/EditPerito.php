<?php

namespace App\Filament\Resources\PeritoResource\Pages;

use App\Filament\Resources\PeritoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPerito extends EditRecord
{
    protected static string $resource = PeritoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
