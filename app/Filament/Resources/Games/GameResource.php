<?php

namespace App\Filament\Resources\Games;

use App\Filament\Resources\Games\Pages\ManageGames;
use App\Models\Game;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Form; // Added this import
use Filament\Forms; // Added this import
use Filament\Tables; // Added this import

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-puzzle-piece';
    protected static string | \UnitEnum | null $navigationGroup = 'Game Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('teacher_id')
                    ->relationship('teacher', 'name')
                    ->required(),
                Forms\Components\Select::make('subject_id')
                    ->relationship('subject', 'name')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('education_level')
                    ->options([
                        'MI' => 'MI',
                        'SMP' => 'SMP',
                        'MA' => 'MA'
                    ])
                    ->required(),
                Forms\Components\TextInput::make('class_level')
                    ->required(),
                Forms\Components\Toggle::make('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->sortable()
                    ->label('Teacher'),
                Tables\Columns\TextColumn::make('subject.name')
                    ->sortable()
                    ->label('Subject'),
                Tables\Columns\TextColumn::make('education_level')
                    ->sortable(),
                Tables\Columns\TextColumn::make('class_level')
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageGames::route('/'),
        ];
    }
}
