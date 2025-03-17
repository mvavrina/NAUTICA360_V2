<?php

namespace App\Filament\Resources\Api\YachtExtraResource\Pages;

use App\Filament\Resources\Api\YachtExtraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYachtExtra extends EditRecord
{
    protected static string $resource = YachtExtraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
