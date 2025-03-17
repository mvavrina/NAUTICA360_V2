<?php

namespace App\Filament\Resources\Api\CountryResource\Pages;

use App\Filament\Resources\Api\CountryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCountry extends EditRecord
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
