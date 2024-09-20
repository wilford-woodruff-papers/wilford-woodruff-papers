<?php

namespace App\Macros\Stringable;

use Illuminate\Support\Str;

class ClearText
{
    public function __invoke()
    {
        return function () {
            return new static(Str::clearText($this->value));
        };
    }
}
