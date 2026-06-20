<?php

namespace App\Filament\Resources\ChatHistories\Pages;

use App\Filament\Resources\ChatHistories\ChatHistoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateChatHistory extends CreateRecord
{
    protected static string $resource = ChatHistoryResource::class;
}
