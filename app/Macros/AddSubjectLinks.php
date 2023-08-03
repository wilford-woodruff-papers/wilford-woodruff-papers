<?php

namespace App\Macros;

class AddSubjectLinks
{
    public function __invoke()
    {
        return function () {
            return new static(str($this->value)->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/s', function ($match) {
                if (str($match[1])->lower()->contains("can't be identified")) {
                    return str($match[1])->explode('|')->last();
                } else {
                    return '<a href="/subjects/'.str(str($match[1])->explode('|')->first())->slug().'" class="text-secondary popup">'.str($match[1])->explode('|')->last().'</a>';
                }
            }));
        };
    }
}
