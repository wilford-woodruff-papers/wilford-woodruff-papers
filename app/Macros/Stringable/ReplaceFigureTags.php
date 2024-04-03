<?php

namespace App\Macros\Stringable;

use Illuminate\Support\Str;

class ReplaceFigureTags
{
    public function __invoke()
    {
        return function () {
            return new static(Str::replaceFigureTags($this->value));
        };
    }
}
