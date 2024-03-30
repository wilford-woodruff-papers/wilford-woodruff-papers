<?php

namespace App\Imports;

use App\Jobs\ImportMetatdataRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MetadataFieldsImport implements ToCollection, WithHeadingRow
{
    public function __construct()
    {
        //
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            ImportMetatdataRow::dispatch($row->toArray())
                ->onQueue('import');
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
