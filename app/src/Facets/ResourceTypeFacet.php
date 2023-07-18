<?php

namespace App\src\Facets;

class ResourceTypeFacet
{
    public $name = 'Resource Type';

    public $key = 'resource_type';

    public $display;

    public function __construct($display = true)
    {
        $this->display = $display;
    }
}
