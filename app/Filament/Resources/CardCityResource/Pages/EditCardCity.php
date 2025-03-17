<?php

namespace App\Filament\Resources\CardCityResource\Pages;

use App\Filament\Resources\CardCityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCardCity extends EditRecord
{
    protected static string $resource = CardCityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
