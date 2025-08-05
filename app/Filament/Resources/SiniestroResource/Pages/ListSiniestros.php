<?php

namespace App\Filament\Resources\SiniestroResource\Pages;

use App\Filament\Resources\SiniestroResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiniestros extends ListRecords
{
    protected static string $resource = SiniestroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
