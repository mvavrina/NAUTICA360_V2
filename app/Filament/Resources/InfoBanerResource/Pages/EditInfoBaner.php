<?php

namespace App\Filament\Resources\InfoBanerResource\Pages;

use App\Filament\Resources\InfoBanerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInfoBaner extends EditRecord
{
    protected static string $resource = InfoBanerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
