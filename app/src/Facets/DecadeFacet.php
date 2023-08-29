<?php

namespace App\src\Facets;

class DecadeFacet
{
    public $name = 'Decade';

    public $key = 'decade';

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
