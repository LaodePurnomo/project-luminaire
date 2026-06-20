<?php

namespace App\Filament\Resources\CustomCharacters\Pages;

use App\Filament\Resources\CustomCharacters\CustomCharacterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomCharacter extends CreateRecord
{
    protected static string $resource = CustomCharacterResource::class;
}
