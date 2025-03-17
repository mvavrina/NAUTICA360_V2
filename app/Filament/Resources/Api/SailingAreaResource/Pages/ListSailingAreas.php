<?php

namespace App\Filament\Resources\Api\SailingAreaResource\Pages;

use App\Filament\Resources\Api\SailingAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSailingAreas extends ListRecords
{
    protected static string $resource = SailingAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
