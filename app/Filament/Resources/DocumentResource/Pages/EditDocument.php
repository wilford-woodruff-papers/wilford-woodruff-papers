<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Models\Value;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    #[On('refreshItem')]
    public function refresh(): void
    {
    }

    public function getRecordTitle(): string
    {
        return $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn () => auth()->user()->hasAnyRole(['Admin', 'Super Admin'])),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        //        dd($data);
        //        ray(collect(data_get($data, 'values')));

        $values = collect(data_get($data, 'values'));

        foreach ($values as $key => $value) {
            if (! empty(trim($value))) {
                Value::updateOrCreate([
                    'item_id' => $record->id,
                    'property_id' => $key,
                ], [
                    'value' => $value,
                ]);
            } else {
                Value::query()
                    ->where('item_id', $record->id)
                    ->where('property_id', $key)
                    ->delete();
            }
        }
        //        ray()->showApp();
        //        dd('Check Ray');
        $record->update($data);

        return $record;
    }
}
