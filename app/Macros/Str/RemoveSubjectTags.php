<?php

namespace App\Macros\Str;

use Illuminate\Support\Str;

class RemoveSubjectTags
{
    public function __invoke()
    {
        return function ($subject) {
            return Str::of($subject)->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/s', function ($match) {
                return str($match[1])->explode('|')->last();
            });
        };
    }
}
