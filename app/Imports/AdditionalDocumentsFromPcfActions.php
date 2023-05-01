<?php

namespace App\Imports;

use App\Jobs\ImportAdditionalMasterFileAction;
use App\Jobs\ImportNewAdditionalDocumentsFromPcfAction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdditionalDocumentsFromPcfActions implements ToCollection, WithHeadingRow
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
                    ImportNewAdditionalDocumentsFromPcfAction::dispatch($row);
                    break;
                case 'Import Master File':
                    ImportAdditionalMasterFileAction::dispatch($row);
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
