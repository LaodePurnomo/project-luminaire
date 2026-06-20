<?php

namespace App\Filament\Resources\CustomCharacters\Pages;

use App\Filament\Resources\CustomCharacters\CustomCharacterResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomCharacter extends ViewRecord
{
    protected static string $resource = CustomCharacterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
