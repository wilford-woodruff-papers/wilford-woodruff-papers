<?php

namespace App\Macros\Str;

use Illuminate\Support\Str;

class ReplaceInlineLanguageTags
{
    public function __invoke()
    {
        return function ($subject) {
            return Str::of($subject)
                ->replaceMatches('/(?<!-)(?:{)(.*?)(?:})/m', function (array $match) {
                    $parts = str($match[1])->explode('|');
                    switch ($parts->count()) {
                        case 1:
                            return '<span title="Shorthand">{'.$parts->first().'}</span>';
                        case 2:
                            return '<span title="'.$parts->last().'">{'.$parts->first().'}</span>';
                        case 3:
                            return '<span title="'.$parts->last().'">{'.$parts->first().'}</span>';
                        default:
                            return '{'.$match[1].'}';
                    }
                });
        };
    }
}
