<?php

namespace App\Filament\Resources\ChatHistories\Pages;

use App\Filament\Resources\ChatHistories\ChatHistoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditChatHistory extends EditRecord
{
    protected static string $resource = ChatHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
