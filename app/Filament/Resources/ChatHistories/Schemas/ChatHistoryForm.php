<?php

namespace App\Filament\Resources\ChatHistories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ChatHistoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Select::make('character')
                    ->options(['kak-ara' => 'Kak ara', 'kak-reza' => 'Kak reza', 'custom' => 'Custom'])
                    ->required(),
                Select::make('role')
                    ->options(['user' => 'User', 'assistant' => 'Assistant'])
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
