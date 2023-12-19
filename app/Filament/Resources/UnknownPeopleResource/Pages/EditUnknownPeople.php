<?php

namespace App\Filament\Resources\UnknownPeopleResource\Pages;

use App\Filament\Actions\Forms\Identification\CopyUnidentifiedPersonToPeople;
use App\Filament\Resources\UnknownPeopleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnknownPeople extends EditRecord
{
    protected static string $resource = UnknownPeopleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CopyUnidentifiedPersonToPeople::make('copy'),
            Actions\DeleteAction::make()->visible(
                auth()->user()->hasAnyRole(['Bio Admin'])
            ),
        ];
    }
}
