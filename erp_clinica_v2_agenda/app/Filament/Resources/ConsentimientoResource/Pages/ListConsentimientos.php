<?php

namespace App\Filament\Resources\ConsentimientoResource\Pages;

use App\Filament\Resources\ConsentimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConsentimientos extends ListRecords
{
    protected static string $resource = ConsentimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
