<?php

namespace App\Imports;

use App\Models\Day;
use App\Models\Item;
use App\Models\Page;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DocumentsByDayImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $day = Day::updateOrCreate([
                'date' => $row['date'],
                'order' => $row['order_id'],
                'item_id' => Item::find($row['parent_id'])?->id,
                'page_id' => Page::firstWhere('uuid', $row['uuid'])?->id,
            ], [
                'content' => $row['text'],
            ]);
        }
    }
}
