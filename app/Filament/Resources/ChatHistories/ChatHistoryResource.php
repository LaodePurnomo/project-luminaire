<?php

namespace App\Filament\Resources\ChatHistories;

use App\Filament\Resources\ChatHistories\Pages\CreateChatHistory;
use App\Filament\Resources\ChatHistories\Pages\EditChatHistory;
use App\Filament\Resources\ChatHistories\Pages\ListChatHistories;
use App\Filament\Resources\ChatHistories\Pages\ViewChatHistory;
use App\Filament\Resources\ChatHistories\Schemas\ChatHistoryForm;
use App\Filament\Resources\ChatHistories\Schemas\ChatHistoryInfolist;
use App\Filament\Resources\ChatHistories\Tables\ChatHistoriesTable;
use App\Models\ChatHistory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ChatHistoryResource extends Resource
{
    protected static ?string $model = ChatHistory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ChatHistory';

    public static function form(Schema $schema): Schema
    {
        return ChatHistoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ChatHistoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChatHistoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChatHistories::route('/'),
            'create' => CreateChatHistory::route('/create'),
            'view' => ViewChatHistory::route('/{record}'),
            'edit' => EditChatHistory::route('/{record}/edit'),
        ];
    }
}
