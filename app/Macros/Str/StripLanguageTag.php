<?php

namespace App\Macros\Str;

use Illuminate\Support\Str;

class StripLanguageTag
{
    public function __invoke()
    {
        return function ($subject) {
            return Str::of($subject)->replaceMatches('/\[Language:.*?\][\s|\n]*/', '')->trim();
        };
    }
}
