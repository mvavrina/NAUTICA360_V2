<?php

namespace App\Filament\Resources\Api\YachtLicenseResource\Pages;

use App\Filament\Resources\Api\YachtLicenseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYachtLicense extends EditRecord
{
    protected static string $resource = YachtLicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
