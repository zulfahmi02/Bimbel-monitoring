<?php

namespace App\Filament\Resources\GameQuestions;

use App\Filament\Resources\GameQuestions\Pages\ManageGameQuestions;
use App\Models\GameQuestion;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms; // Added
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables; // Added
use Filament\Tables\Table;

class GameQuestionResource extends Resource
{
    protected static ?string $model = GameQuestion::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static string | \UnitEnum | null $navigationGroup = 'Game Management';

    protected static ?string $recordTitleAttribute = 'question_text';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('game_id')
                    ->relationship('game', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Textarea::make('question_text')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('question-images')
                    ->columnSpanFull(),
                Forms\Components\TagsInput::make('options')
                     ->helperText('Type option and hit Enter')
                     ->required()
                     ->columnSpanFull(),
                Forms\Components\TextInput::make('correct_answer')
                    ->required()
                    ->helperText('Must match one of the options exactly'),
                Forms\Components\TextInput::make('points')
                    ->required()
                    ->numeric()
                    ->default(10),
                Forms\Components\TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question_text')
            ->columns([
                TextColumn::make('game.title')
                    ->searchable(),
                TextColumn::make('correct_answer')
                    ->searchable(),
                TextColumn::make('points')
                    ->numeric()
                    ->sortable(),
                ImageColumn::make('image'),
                TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
            'index' => ManageGameQuestions::route('/'),
        ];
    }
}
