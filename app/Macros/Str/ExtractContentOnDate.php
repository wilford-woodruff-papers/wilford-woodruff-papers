<?php

namespace App\Macros\Str;

use Illuminate\Support\Str;

class ExtractContentOnDate
{
    public function __invoke()
    {
        return function ($text, $date) {
            return Str::of($text)
                ->replace('<p></p>', '')
                ->match('/(<time datetime="'.$date->toDateString().'">.*)/ms')
                ->prepend('<p>')
                ->replaceFirst('time datetime', 'temp datetime')
                ->before('<time datetime')
                ->append('</p>')
                ->replaceFirst('temp datetime', 'time datetime')
                ->replaceMatches('/(<time datetime="'.$date->toDateString().'">.*<\/time>.*)/', '')
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
