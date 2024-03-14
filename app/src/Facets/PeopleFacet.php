<?php

namespace App\src\Facets;

class PeopleFacet
{
    public $name = 'People';

    public $key = 'people';

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
