<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;

class ImageTestimonial extends Testimonial implements HasMedia
{
    use HasFactory;
    use HasParent;
    use HasSlug;
    use InteractsWithMedia;
}
