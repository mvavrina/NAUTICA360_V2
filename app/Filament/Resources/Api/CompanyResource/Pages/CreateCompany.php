<?php

namespace App\Filament\Resources\Api\CompanyResource\Pages;

use App\Filament\Resources\Api\CompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCompany extends CreateRecord
{
    protected static string $resource = CompanyResource::class;
}
