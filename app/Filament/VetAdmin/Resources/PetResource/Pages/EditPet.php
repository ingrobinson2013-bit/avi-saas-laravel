<?php

namespace App\Filament\VetAdmin\Resources\PetResource\Pages;

use App\Filament\VetAdmin\Resources\PetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPet extends EditRecord
{
    protected static string  = PetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
