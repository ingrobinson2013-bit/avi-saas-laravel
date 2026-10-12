<?php

namespace App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource\Pages;

use App\Filament\SuperAdmin\Resources\ProspectoVeterinariaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProspectoVeterinaria extends CreateRecord
{
    protected static string $resource = ProspectoVeterinariaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
