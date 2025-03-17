<?php

namespace App\Filament\Resources\Api\YachtEquipmentResource\Pages;

use App\Filament\Resources\Api\YachtEquipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYachtEquipment extends EditRecord
{
    protected static string $resource = YachtEquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
