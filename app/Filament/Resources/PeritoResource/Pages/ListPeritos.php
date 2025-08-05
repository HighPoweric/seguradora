<?php

namespace App\Filament\Resources\PeritoResource\Pages;

use App\Filament\Resources\PeritoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeritos extends ListRecords
{
    protected static string $resource = PeritoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
