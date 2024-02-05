<?php

namespace App\Filament\Resources\UnknownPeopleResource\Pages;

use App\Filament\Actions\Forms\Identification\CopyUnidentifiedPersonToPeople;
use App\Filament\Resources\UnknownPeopleResource;
use App\Notifications\UnknownPersonAssignmentNotification;
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

    protected function afterSave(): void
    {
        $record = $this->getRecord();
        if (! empty($record->researcher_id)
            && ($record->researcher_id != auth()->id())
        ) {
            $record->researcher->notify(new UnknownPersonAssignmentNotification($record));
        }
    }
}
