<?php

namespace App\Filament\Resources\PeopleResource\Pages;

use App\Filament\Resources\PeopleResource;
use App\Notifications\PersonAssignmentNotification;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeople extends EditRecord
{
    protected static string $resource = PeopleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(
                    auth()->user()->hasAnyRole(['Bio Admin'])
                ),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->getRecord();
        if (! empty($record->researcher_id)
            && $record->wasChanged('researcher_id')
            && ($record->researcher_id != auth()->id())
        ) {
            $record->researcher->notify(new PersonAssignmentNotification($record));
        }
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('edit', [
            'record' => $this->record,
        ]);
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
