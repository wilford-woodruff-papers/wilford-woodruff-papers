<?php

namespace App\src\Facets;

class ResourceTypeFacet extends Facet
{
    public $name = 'Resource Type';

    public $key = 'resource_type';

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
