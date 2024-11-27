<?php

namespace App\Filament\Imports;

use App\Models\Item;
use App\Models\Property;
use App\Models\Value;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class DocumentIntroductionImporter extends Importer
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {
        $property = Property::query()->where('name', 'Introduction')->first();

        return [
            ImportColumn::make('id'),
            ImportColumn::make('new_introduction')
                ->fillRecordUsing(function (Item $record, ?string $state) use ($property): void {
                    if (! empty($state)) {
                        Value::updateOrCreate([
                            'item_id' => $record->id,
                            'property_id' => $property->id,
                        ], [
                            'value' => $state,
                        ]);
                    }
                }),
        ];
    }

    public function resolveRecord(): ?Item
    {
        return Item::query()
            ->where('id', $this->data['id'])
            ->first();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your item introduction import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
