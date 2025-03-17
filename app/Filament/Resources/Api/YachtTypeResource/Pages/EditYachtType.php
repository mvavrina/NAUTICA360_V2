<?php

namespace App\Filament\Resources\Api\YachtTypeResource\Pages;

use App\Filament\Resources\Api\YachtTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYachtType extends EditRecord
{
    protected static string $resource = YachtTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
