<?php

namespace App\Filament\Resources\GameTemplates;

use App\Filament\Resources\GameTemplates\Pages\CreateGameTemplate;
use App\Filament\Resources\GameTemplates\Pages\EditGameTemplate;
use App\Filament\Resources\GameTemplates\Pages\ListGameTemplates;
use App\Filament\Resources\GameTemplates\Schemas\GameTemplateForm;
use App\Filament\Resources\GameTemplates\Tables\GameTemplatesTable;
use App\Models\GameTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GameTemplateResource extends Resource
{
    protected static ?string $model = GameTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return GameTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GameTemplatesTable::configure($table);
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
            'index' => ListGameTemplates::route('/'),
            'create' => CreateGameTemplate::route('/create'),
            'edit' => EditGameTemplate::route('/{record}/edit'),
        ];
    }
}
