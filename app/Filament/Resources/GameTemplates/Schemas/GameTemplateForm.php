<?php

namespace App\Filament\Resources\GameTemplates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GameTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('game_type')
                    ->required()
                    ->default('multiple_choice'),
                Textarea::make('html_template')
                    ->columnSpanFull(),
                Textarea::make('css_style')
                    ->columnSpanFull(),
                Textarea::make('js_code')
                    ->columnSpanFull(),
                TextInput::make('thumbnail'),
            ]);
    }
}
