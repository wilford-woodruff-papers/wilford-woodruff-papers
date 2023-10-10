<?php

namespace App\Macros\Stringable;

use Illuminate\Support\Str;

class RemoveSubjectTags
{
    public function __invoke()
    {
        return function () {
            return new static(Str::removeSubjectTags($this->value));
        };
    }
}
