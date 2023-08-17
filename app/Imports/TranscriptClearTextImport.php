<?php

namespace App\Imports;

use App\Jobs\ImportClearTextTranscript;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TranscriptClearTextImport implements ToCollection, WithHeadingRow
{
    public $id;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $pageID = data_get($row, str('Internal ID')->lower()->snake()->toString());

            if (! empty($pageID)
                && ! empty(data_get($row, str('Clear Text')->lower()->snake()->toString()))
                && data_get($row, str('Clear Text')->lower()->snake()->toString()) != 'nan'
            ) {
                ImportClearTextTranscript::dispatch($row)
                    ->onQueue('import');
            }
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
