<?php

namespace App\Filament\Resources\UnknownPeopleResource\Pages;

use App\Filament\Resources\UnknownPeopleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnknownPeople extends ListRecords
{
    protected static string $resource = UnknownPeopleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
