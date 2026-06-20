<?php

namespace App\Filament\Resources\ChatHistories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChatHistoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('character')
                    ->badge(),
                TextColumn::make('role')
                    ->badge(),
                TextColumn::make('content')
                    ->label('Pesan')
                    ->limit(60)
                    ->searchable(),
                IconColumn::make('is_flagged')
                    ->label('🚩')
                    ->boolean()
                    ->trueColor('danger')
                    ->falseColor('gray'),
                TextColumn::make('flag_reason')
                    ->label('Alasan Flag')
                    ->badge()
                    ->color('danger'),
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('is_flagged')
                    ->label('Hanya yang Di-flag')
                    ->query(fn (Builder $query) => $query->where('is_flagged', true)),
                SelectFilter::make('character')
                    ->options([
                        'kak-ara'  => 'Kak Ara',
                        'kak-reza' => 'Kak Reza',
                        'custom'   => 'Custom',
                    ]),
                SelectFilter::make('role')
                    ->options([
                        'user'      => 'User',
                        'assistant' => 'Assistant',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}