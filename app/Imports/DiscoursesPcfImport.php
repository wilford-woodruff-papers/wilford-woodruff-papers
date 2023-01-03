<?php

namespace App\Imports;

use App\Jobs\ImportDiscourseFromPcf;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DiscoursesPcfImport implements ToCollection, WithHeadingRow
{
    public $id;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            ImportDiscourseFromPcf::dispatch($row);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
