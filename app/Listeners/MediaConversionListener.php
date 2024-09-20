<?php

namespace App\Listeners;

use App\Models\Subject;
use Spatie\MediaLibrary\Conversions\Events\ConversionHasBeenCompleted;

class MediaConversionListener
{
    public function __construct() {}

    public function handle(ConversionHasBeenCompleted $event): void
    {
        $media = $event->media;
        if (class_basename($media->model) === class_basename(Subject::class)) {
            if (! empty($media->model->getFirstMedia('maps'))) {
                $media->model->searchable();
            }
        }
    }
}
