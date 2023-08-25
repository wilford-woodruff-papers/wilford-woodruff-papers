<?php

namespace App\Macros\Stringable;

use Illuminate\Support\Str;

class StripLanguageTag
{
    public function __invoke()
    {
        return function () {
            return new static(Str::stripLanguageTag($this->value));
        };
    }
}
