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

    public function tips()
    {
        return <<<'blade'
            <div class="grid grid-cols-2 gap-2">
                <div>Individual:</div>
                <div class="font-normal">Includes events in Wilford Woodruff's life</div>
                <div>Family:</div>
                <div class="font-normal">Includes events in the lives of Wilford Woodruff's family</div>
                <div>Personal Religious:</div>
                <div class="font-normal">Includes personal events in Wilford Woodruff's life of a religious nature</div>
                <div>LDS Church Context:</div>
                <div class="font-normal">Includes select events related to the restoration and growth of the Church of Jesus Christ of Latter-day Saints</div>
                <div>Historical Context:</div>
                <div class="font-normal">Includes select events to provide historical context for other events in Wilford Woodruff's life</div>
            </div>
        blade;
    }
}
