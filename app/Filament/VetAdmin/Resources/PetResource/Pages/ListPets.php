<?php
namespace App\Filament\VetAdmin\Resources\PetResource\Pages;
use App\Filament\VetAdmin\Resources\PetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListPets extends ListRecords {
    protected static string $resource = PetResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
