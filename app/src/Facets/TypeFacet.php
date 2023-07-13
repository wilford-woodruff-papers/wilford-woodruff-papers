<?php

namespace App\src\Facets;

class TypeFacet
{
    public $name = 'Type';

    public $key = 'type';

    public $display;

    public function __construct($display = true)
    {
        $this->display = $display;
    }
}
