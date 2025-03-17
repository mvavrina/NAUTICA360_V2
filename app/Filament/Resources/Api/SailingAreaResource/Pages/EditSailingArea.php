<?php

namespace App\Filament\Resources\Api\SailingAreaResource\Pages;

use App\Filament\Resources\Api\SailingAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSailingArea extends EditRecord
{
    protected static string $resource = SailingAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
