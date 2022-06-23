<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Update extends Model
{
    use HasChildren;
    use HasFactory;
    use HasSlug;

    protected $guarded = ['id'];

    protected $dates = [
        'publish_at'
    ];

    protected $childTypes = [
        'Newsletter' => Newsletter::class,
        'Quarterly' => QuarterlyUpdate::class,
    ];

    public function getPrimaryImageUrlAttribute()
    {
        return \Illuminate\Support\Facades\Storage::disk('updates')->url($this->primary_image);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('subject')
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
}
