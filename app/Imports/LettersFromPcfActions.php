<?php

namespace App\Imports;

use App\Jobs\ImportLettersMasterFileAction;
use App\Jobs\UpdateLetterFromPcfAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LettersFromPcfActions implements ToCollection, WithHeadingRow
{
    public $action;

    public function __construct($action)
    {
        $this->action = $action;
    }

    public function collection(Collection $rows)
    {
        $jobs = [];

        foreach ($rows as $row) {
            switch ($this->action) {
                case 'Import New':
                    if (! empty(data_get($row, 'transcription_completion_date'))) {
                        $jobs[] = new UpdateLetterFromPcfAction($row);
                    }
                    //ImportNewLettersFromPcfAction::dispatch($row);
                    break;
                case 'Import Master File':
                    ImportLettersMasterFileAction::dispatch($row);
                    break;
            }
        }

        $batch = Bus::batch($jobs)
            ->onQueue('import')
            ->name($this->action)
            ->allowFailures()
            ->dispatch();
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
