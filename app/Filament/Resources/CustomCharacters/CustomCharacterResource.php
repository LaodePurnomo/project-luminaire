<?php

namespace App\Filament\Resources\CustomCharacters;

use App\Filament\Resources\CustomCharacters\Pages\CreateCustomCharacter;
use App\Filament\Resources\CustomCharacters\Pages\EditCustomCharacter;
use App\Filament\Resources\CustomCharacters\Pages\ListCustomCharacters;
use App\Filament\Resources\CustomCharacters\Pages\ViewCustomCharacter;
use App\Filament\Resources\CustomCharacters\Schemas\CustomCharacterForm;
use App\Filament\Resources\CustomCharacters\Schemas\CustomCharacterInfolist;
use App\Filament\Resources\CustomCharacters\Tables\CustomCharactersTable;
use App\Models\CustomCharacter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CustomCharacterResource extends Resource
{
    protected static ?string $model = CustomCharacter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'CustomCharacter';

    public static function form(Schema $schema): Schema
    {
        return CustomCharacterForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CustomCharacterInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomCharactersTable::configure($table);
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
            'index' => ListCustomCharacters::route('/'),
            'create' => CreateCustomCharacter::route('/create'),
            'view' => ViewCustomCharacter::route('/{record}'),
            'edit' => EditCustomCharacter::route('/{record}/edit'),
        ];
    }
}
