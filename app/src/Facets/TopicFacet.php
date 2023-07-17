<?php

namespace App\src\Facets;

class TopicFacet
{
    public $name = 'Topic';

    public $key = 'topics';

    public $display;

    public function __construct($display = true)
    {
        $this->display = $display;
    }
}
