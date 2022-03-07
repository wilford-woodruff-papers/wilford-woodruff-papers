<?php

namespace App\Models;

use App\Presenters\Presses\UrlPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Parental\HasChildren;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Press extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia;
    use HasChildren;

    protected $guarded = ['id'];

    protected $dates = [
        'date',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
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

    protected $childTypes = [
        'Article' => Article::class,
        'News' => News::class,
        'Podcast' => Podcast::class,
        'Video' => Video::class,
    ];
}
