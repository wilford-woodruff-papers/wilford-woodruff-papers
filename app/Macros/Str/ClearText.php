<?php

namespace App\Macros\Str;

use Illuminate\Support\Str;

class ClearText
{
    public function __invoke()
    {
        return function ($subject) {
            $text = Str::of($subject);

            // Put double brackets around protected symbols
            // That way they aren't processed as a regular bracket.
            $text = $text
                ->replaceMatches('/\[illegible\]/i', '[[illegible]]')
                ->replaceMatches('/\[blank\]/i', '[[blank]]')
                ->replaceMatches('/\[figure\]/i', '[[figure]]');

            // Remove scripture tags and show original text (or editorial added text)
            $text = $text->replaceMatches('/(?:\#\#)(.*?)(?:\#\#)/s', function ($match) {
                return str($match[1])
                    ->explode('|')
                    ->last();
            });

            // Rearrange language tags to show language first, then translated text
            $text = $text->replaceMatches('/(?<!-)(?:{)(.*?)(?:})/m', function (array $match) {
                $parts = str($match[1])->explode('|');
                switch ($parts->count()) {
                    case 1:
                        return '{Shorthand: '.$parts->first().'}';
                    case 2:
                        return '{'.$parts->last().': '.$parts->first().'}';
                    case 3:
                        return '{'.$parts->last().': '.$parts->first().'}';
                    default:
                        return '{'.$match[1].'}';
                }
            });

            // Simple symbol deletion
            $patterns = collect([
                "/ ?<strike[^>]*>.*?<\/strike>", // Strike throughs and whatever's inside
                " ?<s[^>]*>.*?<\/s>", // Strike throughs and whatever's inside
                "\^", // Carrot insertions
                //"/(?<!^)<br\/>(?=$)", // Remove line breaks at the end of a line, but not the beginning of a line
                //"(?<!^)<br\/>(?=$)",
                " ?\[rest of page blank\]", // Rest of page blank
                " ?\[upside\-down text\]", // Upside-down text
                "\-(?=\[)", // Remove dashes before left bracket
                "(?<=\])\-", // Remove dash after right bracket
                "<i>\[(?!\[)", // Remove left italicized single brackets
                "(?<!\])\]<\/i>", // Remove right italicized single brackets
            ]);
            $text = $text->replaceMatches($patterns->implode('|').'/mi', '');

            // This function takes the bracket symbols we protected up above and restores them to their correct
            // single bracket form.
            // No need to about replacing figures - this will be a table in the front of back of the book
            $text = $text
                ->replaceMatches('/\[\[illegible\]\]/i', '[illegible]')
                ->replaceMatches('/\[\[blank\]\]/i', '[blank]')
                ->replaceMatches('/\[\[figure\]\]/i', '[figure]');

            // With all the previous deletions there is sometimes odd whitespace left over.
            // this function handles those cases that.
            $text = $text
                ->replaceMatches('/(?<=\w)-\s*(?=$)\s*/m', ' ')
                ->replaceMatches('/(?<!\.)  /m', ' ');

            return $text;
        };
    }
}
