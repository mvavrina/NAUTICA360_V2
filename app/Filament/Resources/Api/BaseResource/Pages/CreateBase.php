<?php

namespace App\Filament\Resources\Api\BaseResource\Pages;

use App\Filament\Resources\Api\BaseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBase extends CreateRecord
{
    protected static string $resource = BaseResource::class;
}
