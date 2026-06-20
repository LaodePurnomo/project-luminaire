<?php

namespace App\Filament\Resources\ChatHistories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ChatHistoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('character')
                    ->badge(),
                TextEntry::make('role')
                    ->badge(),
                TextEntry::make('content')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
