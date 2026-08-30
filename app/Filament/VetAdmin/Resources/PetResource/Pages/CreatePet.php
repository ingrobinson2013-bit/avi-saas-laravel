<?php

namespace App\Filament\VetAdmin\Resources\PetResource\Pages;

use App\Filament\VetAdmin\Resources\PetResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePet extends CreateRecord
{
    protected static string $resource = PetResource::class;
}
