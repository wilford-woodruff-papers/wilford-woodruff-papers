<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ItemsTranscriptExport implements FromCollection
{
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->items;
    }
}
