<?php

namespace App\Filament\Resources\Api\YachtDescriptionResource\Pages;

use App\Filament\Resources\Api\YachtDescriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYachtDescriptions extends ListRecords
{
    protected static string $resource = YachtDescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
