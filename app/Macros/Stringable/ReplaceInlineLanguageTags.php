<?php

namespace App\Macros\Stringable;

use Illuminate\Support\Str;

class ReplaceInlineLanguageTags
{
    public function __invoke()
    {
        return function () {
            return new static(Str::replaceInlineLanguageTags($this->value));
        };
    }
}
