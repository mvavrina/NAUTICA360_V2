<?php

namespace App\Filament\Resources\CardCityResource\Pages;

use App\Filament\Resources\CardCityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCardCities extends ListRecords
{
    protected static string $resource = CardCityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
