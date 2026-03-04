<?php

namespace App\Filament\Resources\ConsentimientoResource\Pages;

use App\Filament\Resources\ConsentimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConsentimiento extends EditRecord
{
    protected static string $resource = ConsentimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
