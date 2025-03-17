<?php

namespace App\Filament\Resources\Api\YachtCrewResource\Pages;

use App\Filament\Resources\Api\YachtCrewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYachtCrew extends EditRecord
{
    protected static string $resource = YachtCrewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
