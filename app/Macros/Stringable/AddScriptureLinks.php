<?php

namespace App\Macros\Stringable;

use Illuminate\Support\Str;

class AddScriptureLinks
{
    public function __invoke()
    {
        return function () {
            return new static(Str::addScriptureLinks($this->value));
        };
    }
}
