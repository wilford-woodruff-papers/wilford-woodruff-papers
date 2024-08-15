<?php

namespace App\Filament\Resources\PlaceResource\Pages;

use App\Filament\Resources\PlaceResource;
use App\Models\Category;
use App\Models\Subject;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreatePlace extends CreateRecord
{
    protected static string $resource = PlaceResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        if ($data['visited'] === false && $data['mentioned'] === false) {
            $error = ValidationException::withMessages([
                'data.visited' => 'You must select at least one of the Visited or Mentioned checkboxes.',
                'data.mentioned' => 'You must select at least one of the Visited or Mentioned checkboxes.',
            ]);
            throw $error;
        }

        if ($data['visited'] === true) {
            $data['mentioned'] = true;
        }

        $data['name'] = collect([
            $data['specific_place'],
            $data['city'],
            $data['county'],
            $data['state_province'],
            Subject::countryName($data['state_province'], $data['country']),
        ])
            ->filter()
            ->implode(', ');

        $place = static::getModel()::create($data);

        $place->category()->syncWithoutDetaching(
            Category::query()
                ->where('name', 'Places')
                ->first()
        );

        return $place;
    }
}
