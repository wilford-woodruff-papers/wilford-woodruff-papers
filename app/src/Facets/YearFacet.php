<?php

namespace App\src\Facets;

class YearFacet
{
    public $name = 'Year';

    public $key = 'year';

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
