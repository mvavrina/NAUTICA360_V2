<?php

namespace App\Filament\Resources\Api\YachtTypeResource\Pages;

use App\Filament\Resources\Api\YachtTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYachtTypes extends ListRecords
{
    protected static string $resource = YachtTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
