<?php

namespace App\Filament\Resources\Api\YachtResource\Pages;

use App\Filament\Resources\Api\YachtResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYachts extends ListRecords
{
    protected static string $resource = YachtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
