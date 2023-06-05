<?php

namespace App\Macros;

class AddSubjectLinks
{
    public function __invoke()
    {
        return function () {
            return new static(str($this->value)->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/s', function ($match) {
                return '<a href="/subjects/'.str(str($match[1])->explode('|')->first())->slug().'" class="text-secondary popup">'.str($match[1])->explode('|')->last().'</a>';
            }));
        };
    }
}
