<?php

namespace App\Imports;

use App\Jobs\ImportLetterFromPcf;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LettersPcfImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    public $id;

    public function model(array $row)
    {
        ImportLetterFromPcf::dispatch($row);
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
