<?php

namespace App\Macros\Stringable;

use Illuminate\Support\Str;

class ExtractContentOnDate
{
    public function __invoke()
    {
        return function ($date) {
            return new static(Str::extractContentOnDate($this->value, $date));
        };
    }
}
