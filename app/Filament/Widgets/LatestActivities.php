<?php

namespace App\Filament\Widgets;

use App\Models\GameSession;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestActivities extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Aktivitas Terbaru';

    protected static ?int $sort = 3;



    public function table(Table $table): Table
    {
        return $table
            ->query(
                GameSession::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('game.title')
                    ->label('Game')
                    ->limit(20),
                Tables\Columns\TextColumn::make('total_score')
                    ->label('Nilai')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state >= 90 => 'success',
                        $state >= 70 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
