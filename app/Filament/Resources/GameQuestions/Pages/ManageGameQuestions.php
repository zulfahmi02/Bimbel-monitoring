<?php

namespace App\Filament\Resources\GameQuestions\Pages;

use App\Filament\Resources\GameQuestions\GameQuestionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageGameQuestions extends ManageRecords
{
    protected static string $resource = GameQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
