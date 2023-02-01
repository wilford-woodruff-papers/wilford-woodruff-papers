<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;

class AudioTestimonial extends Testimonial implements HasMedia
{
    use HasFactory;
    use HasParent;
    use HasSlug;
    use InteractsWithMedia;

    public function getCallToActionAttribute()
    {
        return 'Listen to full testimony';
    }
}
