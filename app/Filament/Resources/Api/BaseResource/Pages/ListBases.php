<?php

namespace App\Filament\Resources\Api\BaseResource\Pages;

use App\Filament\Resources\Api\BaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBases extends ListRecords
{
    protected static string $resource = BaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
