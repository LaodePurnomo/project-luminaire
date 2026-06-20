<?php

namespace App\Filament\Resources\CustomCharacters\Pages;

use App\Filament\Resources\CustomCharacters\CustomCharacterResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCustomCharacter extends EditRecord
{
    protected static string $resource = CustomCharacterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
