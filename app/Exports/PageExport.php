<?php

namespace App\Exports;

use App\Models\Page;
use Maatwebsite\Excel\Concerns\FromCollection;

class PageExport implements FromCollection
{
    public function __construct($pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->pages;
    }
}
