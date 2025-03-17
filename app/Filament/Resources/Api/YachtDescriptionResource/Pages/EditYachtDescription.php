<?php

namespace App\Filament\Resources\Api\YachtDescriptionResource\Pages;

use App\Filament\Resources\Api\YachtDescriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYachtDescription extends EditRecord
{
    protected static string $resource = YachtDescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
