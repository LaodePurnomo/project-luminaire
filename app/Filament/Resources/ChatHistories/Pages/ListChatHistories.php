<?php

namespace App\Filament\Resources\ChatHistories\Pages;

use App\Filament\Resources\ChatHistories\ChatHistoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChatHistories extends ListRecords
{
    protected static string $resource = ChatHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
