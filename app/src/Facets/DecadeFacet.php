<?php

namespace App\src\Facets;

class DecadeFacet
{
    public $name = 'Decade';

    public $key = 'decade';

    public $display;

    public function __construct($display = true)
    {
        $this->display = $display;
    }
}
