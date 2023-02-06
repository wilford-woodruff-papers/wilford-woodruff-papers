<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Testimonial extends Model implements HasMedia
{
    use HasChildren;
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;

    protected $guarded = ['id'];

    protected $childTypes = [
        'Audio' => AudioTestimonial::class,
        'Image' => ImageTestimonial::class,
        'Text' => TextTestimonial::class,
        'Video' => VideoTestimonial::class,
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);

        $this->addMediaConversion('vintage')
            ->sepia()
            ->border(10, 'black', Manipulations::BORDER_OVERLAY);

        $this->addMediaConversion('square')
            ->crop('crop-center', 800, 800); // Trim or crop the image to the center for specified width and height.

        $this->addMediaConversion('square-thumb')
            ->crop('crop-center', 200, 200); // Trim or crop the image to the center for specified width and height.
    }
}
