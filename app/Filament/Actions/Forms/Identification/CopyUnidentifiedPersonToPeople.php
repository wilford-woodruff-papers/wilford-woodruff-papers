<?php

namespace App\Filament\Actions\Forms\Identification;

use App\Models\Category;
use App\Models\Subject;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class CopyUnidentifiedPersonToPeople extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'copy-to-known-people';
    }

    public function getLabel(): ?string
    {
        return 'Copy to Known People';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->button()
            ->action(function (Model $record): void {
                $person = new Subject();

                $person->first_name = str($record->first_middle_name)->explode(' ')->first();
                $person->middle_name = str($record->first_middle_name)->after($person->first_name)->trim();
                $person->last_name = $record->last_name;
                $person->name = collect([$person->first_name, $person->middle_name, $person->last_name])->filter()->join(' ');

                $person->pid = $record->fs_id;

                $person->birth_date = $record->approximate_birth_date;
                $person->death_date = $record->approximate_death_date;

                $person->notes = $record->guesses.'<br />'.$record->notes;

                $uniqueId = Subject::query()
                    ->whereHas('category', function ($query) {
                        $query->whereIn('categories.name', ['People']);
                    })
                    ->max('unique_id');
                $person->unique_id = $uniqueId + 1;

                $person->save();

                $person->category()->syncWithoutDetaching(
                    Category::query()
                        ->where('name', 'People')
                        ->first()
                );

                $this->redirect(route('filament.admin.resources.people.edit', ['record' => $person]));

            });

    }
}
