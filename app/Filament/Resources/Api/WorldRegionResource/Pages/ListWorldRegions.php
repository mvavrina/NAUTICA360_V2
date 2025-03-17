<?php

namespace App\Filament\Resources\Api\WorldRegionResource\Pages;

use App\Filament\Resources\Api\WorldRegionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorldRegions extends ListRecords
{
    protected static string $resource = WorldRegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
