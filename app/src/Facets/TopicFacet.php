<?php

namespace App\src\Facets;

class TopicFacet
{
    public $name = 'Topic';

    public $key = 'topics';

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
