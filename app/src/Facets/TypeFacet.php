<?php

namespace App\src\Facets;

class TypeFacet
{
    public $name = 'Type';

    public $key = 'type';

    public $display;

    public function __construct($display = true, $sortUsing = [])
    {
        $this->display = $display;
    }

    public function sort($facetDistribution)
    {
        return $facetDistribution;
    }

    public function tips()
    {
        return null;

    }
}
