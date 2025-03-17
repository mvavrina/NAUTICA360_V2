<?php

namespace App\Filament\Resources\CardRegionResource\Pages;

use App\Filament\Resources\CardRegionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCardRegions extends ListRecords
{
    protected static string $resource = CardRegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
