<?php

namespace App\Filament\Widgets;

use App\Models\Game;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\GameSession;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Games', Game::count())
                ->description('Game edukasi yang tersedia')
                ->descriptionIcon('heroicon-m-puzzle-piece')
                ->color('success')
                ->chart([7, 12, 15, 18, 22, 25, Game::count()]),
            
            Stat::make('Total Guru', Teacher::count())
                ->description('Guru terdaftar')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('warning')
                ->chart([5, 8, 10, 12, 15, 18, Teacher::count()]),
            
            Stat::make('Total Siswa', Student::count())
                ->description('Siswa aktif')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->chart([20, 35, 45, 60, 75, 85, Student::count()]),
            
            Stat::make('Total Orang Tua', ParentModel::count())
                ->description('Orang tua terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            
            Stat::make('Game Sessions', GameSession::count())
                ->description('Total sesi permainan')
                ->descriptionIcon('heroicon-m-play')
                ->color('danger')
                ->chart([10, 25, 40, 55, 70, 90, GameSession::count()]),
            
            Stat::make('Avg Score', number_format(GameSession::avg('total_score') ?? 0, 1))
                ->description('Rata-rata nilai siswa')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('success'),
        ];
    }
}
