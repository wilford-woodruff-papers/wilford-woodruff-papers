<?php

namespace App\Imports;

use App\Jobs\ImportPublishDateFromPcfAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AllDocumentTypePcfActions implements ToCollection, WithHeadingRow
{
    public $action;

    public $filename;

    public function __construct($filename, $action)
    {
        $this->filename = $filename;
        $this->action = $action;
    }

    public function collection(Collection $rows)
    {
        $jobs = [];

        if (str()->contains($this->filename, 'Additional Documents')) {
            $type = 'Additional';
        }

        if (str()->contains($this->filename, 'Autobiographies')) {
            $type = 'Autobiographies';
        }

        if (str()->contains($this->filename, 'Journals')) {
            $type = 'Journals';
        }

        if (str()->contains($this->filename, 'Letters')) {
            $type = 'Letters';
        }

        if (str()->contains($this->filename, 'Daybooks')) {
            $type = 'Daybooks';
        }

        if (empty($type)) {
            throw new \Exception('Type not found');
        }

        foreach ($rows as $row) {
            switch ($this->action) {
                case 'Import Publish Dates':
                    if (! empty(data_get($row, 'unique_identifier'))) {
                        $jobs[] = new ImportPublishDateFromPcfAction($type, $row);
                    }
                    break;
            }
        }

        $batch = Bus::batch($jobs)
            ->onQueue('import')
            ->name($this->action)
            ->allowFailures()
            ->dispatch();
    }
}
