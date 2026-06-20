<?php

namespace App\Filament\Widgets;

use App\Models\ChatHistory;
use App\Models\CustomCharacter;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total User', User::where('is_admin', false)->count())
                ->description('Pengguna terdaftar')
                ->color('success'),

            Stat::make('Total Chat Hari Ini', ChatHistory::whereDate('created_at', today())->count())
                ->description('Pesan masuk hari ini')
                ->color('info'),

            Stat::make('Total Chat', ChatHistory::count())
                ->description('Semua pesan')
                ->color('warning'),

            Stat::make('Custom Character', CustomCharacter::count())
                ->description('Karakter dibuat user')
                ->color('danger'),

            Stat::make('Kak Ara', ChatHistory::where('character', 'kak-ara')->count())
                ->description('Total chat Kak Ara')
                ->color('success'),

            Stat::make('Kak Reza', ChatHistory::where('character', 'kak-reza')->count())
                ->description('Total chat Kak Reza')
                ->color('info'),
        ];
    }
}