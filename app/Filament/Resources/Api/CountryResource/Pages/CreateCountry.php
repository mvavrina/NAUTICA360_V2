<?php

namespace App\Filament\Resources\Api\CountryResource\Pages;

use App\Filament\Resources\Api\CountryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;
}
