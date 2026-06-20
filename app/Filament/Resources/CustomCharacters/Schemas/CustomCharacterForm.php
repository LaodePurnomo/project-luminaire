<?php

namespace App\Filament\Resources\CustomCharacters\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CustomCharacterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('avatar'),
                Textarea::make('personality')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('first_message')
                    ->columnSpanFull(),
            ]);
    }
}
