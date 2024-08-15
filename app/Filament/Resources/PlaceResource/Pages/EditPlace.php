<?php

namespace App\Filament\Resources\PlaceResource\Pages;

use App\Filament\Resources\PlaceResource;
use App\Models\Subject;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPlace extends EditRecord
{
    protected static string $resource = PlaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {

        $data['name'] = collect([
            $data['specific_place'],
            $data['city'],
            $data['county'],
            $data['state_province'],
            Subject::countryName($data['state_province'], $data['country']),
        ])
            ->filter()
            ->implode(', ');

        $record->update($data);

        return $record;
    }
}
