<?php

namespace App\Filament\Resources\Api\YachtCrewResource\Pages;

use App\Filament\Resources\Api\YachtCrewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYachtCrews extends ListRecords
{
    protected static string $resource = YachtCrewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
