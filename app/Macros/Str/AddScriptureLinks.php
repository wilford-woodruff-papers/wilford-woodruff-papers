<?php

namespace App\Macros\Str;

use Illuminate\Support\Str;

class AddScriptureLinks
{
    public function __invoke()
    {
        return function ($subject) {
            return Str::of($subject)->replaceMatches('/(?:\#\#)(.*?)(?:\#\#)/s', function ($match) {
                return '<a href="'.getScriptureLink(Str::of($match[1])->explode('|')->first()).'" class="text-secondary" target="_blank">'.Str::of($match[1])->explode('|')->last().'</a>';
            });
        };
    }
}
