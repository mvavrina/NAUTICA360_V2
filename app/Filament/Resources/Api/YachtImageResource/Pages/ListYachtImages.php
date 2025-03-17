<?php

namespace App\Filament\Resources\Api\YachtImageResource\Pages;

use App\Filament\Resources\Api\YachtImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYachtImages extends ListRecords
{
    protected static string $resource = YachtImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
