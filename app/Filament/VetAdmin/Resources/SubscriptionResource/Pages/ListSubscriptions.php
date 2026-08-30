<?php

namespace App\Filament\VetAdmin\Resources\SubscriptionResource\Pages;

use App\Filament\VetAdmin\Resources\SubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Afiliar Mascota a Plan'),
        ];
    }
}
