<?php

namespace App\Filament\Resources\Api\ShipyardResource\Pages;

use App\Filament\Resources\Api\ShipyardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShipyard extends EditRecord
{
    protected static string $resource = ShipyardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
