<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;

class VideoTestimonial extends Testimonial implements HasMedia
{
    use HasFactory;
    use HasParent;
    use HasSlug;
    use InteractsWithMedia;

    public function getEmbedLinkAttribute()
    {
        return str($this->attributes['video'])->replace('watch?v=', 'embed/')->replaceFirst('&', '?');
    }

    public function getCallToActionAttribute()
    {
        return 'Watch full testimony';
    }

    public function getIconAttribute()
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>';
    }
}
