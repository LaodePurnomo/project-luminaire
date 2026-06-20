<?php

namespace App\Filament\Resources\CustomCharacters\Pages;

use App\Filament\Resources\CustomCharacters\CustomCharacterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCustomCharacters extends ListRecords
{
    protected static string $resource = CustomCharacterResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
