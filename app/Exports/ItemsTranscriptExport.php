<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ItemsTranscriptExport implements FromCollection
{
    public function __construct($items)
    {
        $this->items = $items;
    }

    public function collection(): Collection
    {
        return $this->items;
    }
}
