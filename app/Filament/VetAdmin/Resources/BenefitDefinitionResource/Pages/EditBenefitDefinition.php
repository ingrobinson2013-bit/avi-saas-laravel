<?php

namespace App\Filament\VetAdmin\Resources\BenefitDefinitionResource\Pages;

use App\Filament\VetAdmin\Resources\BenefitDefinitionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBenefitDefinition extends EditRecord
{
    protected static string $resource = BenefitDefinitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
