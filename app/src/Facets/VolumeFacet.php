<?php

namespace App\src\Facets;

class VolumeFacet
{
    public $name = 'Volume';

    public $key = 'volumes';

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
