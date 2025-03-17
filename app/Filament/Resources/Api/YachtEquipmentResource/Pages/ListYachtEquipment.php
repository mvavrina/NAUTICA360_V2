<?php

namespace App\Filament\Resources\Api\YachtEquipmentResource\Pages;

use App\Filament\Resources\Api\YachtEquipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYachtEquipment extends ListRecords
{
    protected static string $resource = YachtEquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
