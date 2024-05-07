<?php

namespace App\src\Facets;

class BookFacet
{
    public $name = 'Book';

    public $key = 'books';

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
