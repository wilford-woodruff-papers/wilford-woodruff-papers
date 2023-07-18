<?php

namespace App\src\Facets;

class YearFacet
{
    public $name = 'Year';

    public $key = 'year';

    public $display;

    public function __construct($display = true)
    {
        $this->display = $display;
    }
}
