<?php

namespace App\Filament\VetAdmin\Resources\PlanResource\Pages;

use App\Filament\VetAdmin\Resources\PlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlans extends ListRecords
{
    protected static string $resource = PlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Crear Nuevo Plan'),
        ];
    }
}
