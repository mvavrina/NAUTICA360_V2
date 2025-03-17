<?php

namespace App\Filament\Resources\CardRegionResource\Pages;

use App\Filament\Resources\CardRegionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCardRegion extends EditRecord
{
    protected static string $resource = CardRegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
