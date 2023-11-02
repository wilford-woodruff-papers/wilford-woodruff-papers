<?php

namespace App\Macros\Str;

class ExtractContentOnDate
{
    public function __invoke()
    {
        return function ($content, $date) {
            $text = str($content)
                ->replace('<p></p>', '')
                ->match('/(<time datetime="'.$date->toDateString().'">.*)/ms');
            // This will happen if a day is not entered for the date field.
            if ($text->isEmpty()) {
                $text = str($content)
                    ->replace('<p></p>', '');
            } else {
                $text = $text
                    ->prepend('<p>');
            }

            return $text
                ->replaceFirst('time datetime', 'temp datetime')
                ->before('<time datetime')
                ->append('</p>')
                ->replaceFirst('temp datetime', 'time datetime')
                ->replaceMatches('/(<time datetime="'.$date->toDateString().'">.*<\/time>)(.*ay)?(<\/strong>)/msU', '')
                ->replaceMatches('/(<time datetime="'.$date->toDateString().'">.*<\/time>)/msU', '')
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
