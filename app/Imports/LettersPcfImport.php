<?php

namespace App\Imports;

use App\Jobs\ImportLetterFromPcf;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LettersPcfImport implements ToCollection, WithHeadingRow
{
    public $id;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            ImportLetterFromPcf::dispatch($row);
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
