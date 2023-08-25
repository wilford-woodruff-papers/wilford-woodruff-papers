<?php

namespace App\src\Facets;

class TimelineCategoryFacet
{
    public $name = 'Context';

    public $key = 'type';

    public $display;

    public $sortUsing = [];

    public function __construct($display = true, $sortUsing = [])
    {
        $this->display = $display;
        $this->sortUsing = $sortUsing;
    }

    public function sort($facetDistribution)
    {
        return collect($facetDistribution)->sortKeysUsing(function ($a, $b) {
            $pos_a = array_search($a, $this->sortUsing);
            $pos_b = array_search($b, $this->sortUsing);

            return $pos_a - $pos_b;
        })->toArray();
    }
}
