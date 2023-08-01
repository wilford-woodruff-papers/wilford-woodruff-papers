<?php

namespace App\src\Facets;

class TimelineCategoryFacet
{
    public $name = 'Context';

    public $key = 'type';

    public $display;

    public function __construct($display = true)
    {
        $this->display = $display;
    }
}
