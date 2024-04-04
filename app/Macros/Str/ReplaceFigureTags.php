<?php

namespace App\Macros\Str;

use App\Models\Figure;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReplaceFigureTags
{
    public function __invoke()
    {
        return function ($subject) {
            if (auth()->guest() || ! auth()->user()->hasAnyRole('Editor|Admin|Super Admin')) {
                return $subject;
            }

            return Str::of($subject)
                ->replaceMatches('/(\[FIGURE.*?\])/is', function ($match) {
                    $trackingNumber = str($match[1])
                        ->replace('[FIGURE', '')
                        ->replace(']', '')
                        ->trim();

                    if (empty($trackingNumber)) {
                        return '<a href="'.route('figures').'" target="_blank" class="text-secondary">'.$match[1].'</a>';
                    }

                    $figure = Figure::query()
                        ->where('tracking_number', $trackingNumber)
                        ->first();

                    if (empty($figure)) {
                        return '<a href="'.route('figures').'" target="_blank" class="text-secondary">'.$match[1].'</a>';
                    }

                    return '<a href="'.route('figures').'" target="_blank" class=""><img src="'.Storage::disk('figures')->url($figure->filename).'"
                                alt="'.$figure->design_description.'"
                                class="h-8 w-auto inline-block"
                            ></a>';
                });
        };
    }
}
