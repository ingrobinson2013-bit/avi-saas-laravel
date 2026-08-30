<?php

namespace App\Filament\VetAdmin\Resources\CustomerResource\Pages;

use App\Filament\VetAdmin\Resources\CustomerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
