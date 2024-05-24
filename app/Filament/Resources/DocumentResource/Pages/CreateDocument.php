<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Models\Item;
use App\Models\Type;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected static bool $canCreateAnother = false;

    protected function handleRecordCreation(array $data): Model
    {
        if ($data['section_count'] > 1) {
            $data['parental_type'] = \App\Models\Set::class;
            $data['manual_page_count'] = 0;
        } else {
            $data['parental_type'] = \App\Models\Document::class;
        }

        $item = static::getModel()::create($data);

        if (($sectionCount = data_get($data, 'section_count')) > 0) {
            $type = Type::query()
                ->with(['subType'])
                ->firstWhere('id', $item->type_id);

            for ($i = 1; $i <= $sectionCount; $i++) {
                $section = new Item;
                $section->parental_type = \App\Models\Document::class;
                $section->name = $item->name.' Section '.$i;
                $section->item_id = $item->id;
                $section->type_id = $type->subType?->id;
                $section->pcf_unique_id_prefix = $item->pcf_unique_id_prefix;
                //$section->pcf_unique_id = $item->pcf_unique_id;
                $section->save();
            }
        }

        return $item;
    }
}
