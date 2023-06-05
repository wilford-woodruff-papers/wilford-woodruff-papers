<?php

namespace App\Macros;

class RemoveQZCodes
{
    public function __invoke()
    {
        return function ($isQuoteTagger = false) {
            return new static(str($this->value)->replaceMatches('/QZ[0-9]*/smi', function ($match) use ($isQuoteTagger) {
                return $isQuoteTagger
                    ? '<span class="bg-green-300">'.array_pop($match).'</span>'
                    : '';
            }));
        };
    }
}
