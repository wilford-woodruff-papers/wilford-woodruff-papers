<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn () => auth()->user()->hasAnyRole(['Admin', 'Super Admin'])),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        dd($data);
        $record->update($data);

        return $record;
    }
}
