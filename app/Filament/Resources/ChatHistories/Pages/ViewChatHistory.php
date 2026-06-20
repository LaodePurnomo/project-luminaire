<?php

namespace App\Filament\Resources\ChatHistories\Pages;

use App\Filament\Resources\ChatHistories\ChatHistoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewChatHistory extends ViewRecord
{
    protected static string $resource = ChatHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
