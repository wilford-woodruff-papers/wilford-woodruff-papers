<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JournalsPcfImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        set_time_limit(600);

        foreach ($rows as $row) {
            if (empty(trim($row['spelling']))) {
            }
        }
    }
}
