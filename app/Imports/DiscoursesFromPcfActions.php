<?php

namespace App\Imports;

use App\Jobs\ImportDiscoursesMasterFileAction;
use App\Jobs\ImportNewDiscoursesFromPcfAction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DiscoursesFromPcfActions implements ToCollection, WithHeadingRow
{
    public $action;

    public function __construct($action)
    {
        $this->action = $action;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            switch ($this->action) {
                case 'Import New':
                    ImportNewDiscoursesFromPcfAction::dispatch($row);
                    break;
                case 'Import Master File':
                    ImportDiscoursesMasterFileAction::dispatch($row);
                    break;
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
