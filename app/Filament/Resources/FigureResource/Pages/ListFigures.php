<?php

namespace App\Filament\Resources\FigureResource\Pages;

use App\Filament\Resources\FigureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFigures extends ListRecords
{
    protected static string $resource = FigureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
