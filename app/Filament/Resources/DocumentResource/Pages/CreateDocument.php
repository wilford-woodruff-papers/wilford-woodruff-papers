<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        if ($data['sections'] > 1) {
            $data['parental_type'] = \App\Models\Set::class;
        } else {
            $data['parental_type'] = \App\Models\Document::class;
        }

        return static::getModel()::create($data);
    }
}
