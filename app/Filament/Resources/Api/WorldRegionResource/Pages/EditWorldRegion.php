<?php

namespace App\Filament\Resources\Api\WorldRegionResource\Pages;

use App\Filament\Resources\Api\WorldRegionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorldRegion extends EditRecord
{
    protected static string $resource = WorldRegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
