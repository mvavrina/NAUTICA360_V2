<?php

namespace App\Filament\Resources\Api\YachtExtraResource\Pages;

use App\Filament\Resources\Api\YachtExtraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYachtExtras extends ListRecords
{
    protected static string $resource = YachtExtraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
