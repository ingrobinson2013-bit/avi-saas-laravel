<?php

namespace App\Filament\VetAdmin\Resources\BenefitDefinitionResource\Pages;

use App\Filament\VetAdmin\Resources\BenefitDefinitionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBenefitDefinitions extends ListRecords
{
    protected static string $resource = BenefitDefinitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuevo Servicio / Beneficio'),
        ];
    }
}
