<?php

namespace App\Macros;

class StripBracketedID
{
    public function __invoke()
    {
        return function () {

            return new static(str($this->value)->replaceMatches('/\[.*?\]/', '')->trim());

        };
    }
}
