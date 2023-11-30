<?php

namespace App\Macros\Str;

class ExtractContentOnDate
{
    public function __invoke()
    {
        return function ($content, $date) {
            //dd($content);
            $lines = preg_split("/\r\n|\n|\r/", $content);
            $start = false;
            $partialText = '';
            foreach ($lines as $line) {
                $line = str($line);
                if ($line->contains('<time datetime="')) {
                    if ($line->contains('<time datetime="'.$date->toDateString().'">')) {
                        $start = true;
                    } else {
                        $start = false;
                    }
                }
                if ($start === true) {
                    if (
                        (
                            $line->contains('<time datetime="')
                            && $line->contains('<strong>')
                        )
                        || $line->exactly('<br/>')
                        || $line->isEmpty()
                    ) {
                        continue;
                    } else {
                        $line = $line
                            ->replaceMatches('/(<time datetime=".*">.*<\/time>)/U', '')
                            ->replaceMatches('/(<strong>.*)(\d{4}.*day)?(<\/strong>)/U', '')
                            ->trim();
                        if (! $line->isEmpty()) {
                            $partialText .= $line
                                ->append("\n");
                        }
                    }
                }
            }

            return $partialText;
            dd($partialText);

            $fulltext = collect();
            $textMatches = str($partialText)
                ->replace('<p></p>', '')
                ->matchAll('/(<time datetime="'.$date->toDateString().'">.*)/ms');

            // This will happen if a day is not entered for the date field.
            foreach ($textMatches as $text) {
                $text = str($text);
                if ($text->isEmpty()) {
                    $text = str($content)
                        ->replace('<p></p>', '');
                } else {
                    $text = $text
                        ->prepend('<p>');
                }
                $fulltext->push($text);
            }
            $fulltext = str($fulltext->implode(' '));

            dd($fulltext);
            dd(
                $fulltext
                    ->replaceFirst('time datetime', 'temp datetime')
                    ->before('<time datetime')
                    ->append('</p>')
                    ->replaceFirst('temp datetime', 'time datetime')
                    ->replaceMatches('/(<time datetime="'.$date->toDateString().'">.*<\/time>)(.*ay)?(<\/strong>)/U', '')
            );

            return $fulltext
                ->replaceFirst('time datetime', 'temp datetime')
                ->before('<time datetime')
                ->append('</p>')
                ->replaceFirst('temp datetime', 'time datetime')
                ->replaceMatches('/(<time datetime="'.$date->toDateString().'">.*<\/time>)(.*ay)?(<\/strong>)/U', '')
                ->replaceMatches('/(<time datetime="'.$date->toDateString().'">.*<\/time>)/U', '')
                ->replaceMatches('/(<p>.*~.*<\/p>)/U', '')
                ->replace('<strong>', '')
                ->replace('</strong>', '');
            //                ->match('/(<p>)|(<strong>)?(<time datetime="'.$date->toDateString().'">.*)/ms')
            //                ->replaceFirst('time datetime', 'temp datetime')
            //                ->before('<p><time datetime')
            //                ->replaceFirst('temp datetime', 'time datetime')
            //                ->replaceMatches('/(<time datetime="'.$date->toDateString().'">.*)(<\/time>)/smU', '')
        };
    }
}
