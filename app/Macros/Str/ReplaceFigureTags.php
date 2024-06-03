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

                    return '<a href="'.route('figures').'" target="_blank" class="text-secondary"
                                x-data
                                x-tooltip="'.collect([
                        '<h2><strong>FIGURE '.$trackingNumber.'</strong></h2>',
                        '<strong>Description: </strong>',
                        $figure->design_description,
                        '<strong>Meaning: </strong>',
                        $figure->qualitative_utilization,
                        $figure->quantitative_utilization,
                        '<strong>Time of Use: </strong>',
                        $figure->period_usage,
                    ])
                        ->filter()
                        ->join('<br />').'"
                                type="button"
                                class="">
                        <img src="'.Storage::disk('figures')->url($figure->filename).'"
                                alt="'.$figure->design_description.'"
                                class="h-8 w-auto inline-block"
                            ></a>';
                });
        };
    }
}
