<?php

namespace App\Macros;

class AddScriptureLinks
{
    public function __invoke()
    {
        return function () {
            return new static(str($this->value)->replaceMatches('/(?:\#\#)(.*?)(?:\#\#)/s', function ($match) {
                return '<a href="'.getScriptureLink(str($match[1])->explode('|')->first()).'" class="text-secondary" target="_blank">'.str($match[1])->explode('|')->last().'</a>';
            }));
        };
    }
}
