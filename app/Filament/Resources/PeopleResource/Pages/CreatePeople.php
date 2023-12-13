<?php

namespace App\Filament\Resources\PeopleResource\Pages;

use App\Filament\Resources\PeopleResource;
use App\Models\Category;
use App\Models\Subject;
use Filament\Resources\Pages\CreateRecord;

class CreatePeople extends CreateRecord
{
    protected static string $resource = PeopleResource::class;

    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        if (empty($record->unique_id)) {
            $uniqueId = Subject::query()
                ->whereHas('category', function ($query) {
                    $query->whereIn('categories.name', ['People']);
                })
                ->max('unique_id');
            $record->unique_id = $uniqueId + 1;
            $record->save();
        }

        $record->category()->syncWithoutDetaching(
            Category::firstWhere('name', 'People')->id
        );
    }
}
