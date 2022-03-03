<?php

namespace App\Models;

use App\Presenters\Presses\UrlPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Press extends Model implements HasMedia, \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable, HasFactory, HasSlug,InteractsWithMedia;

    protected $guarded = ['id'];

    protected $dates = [
        'date',
    ];

    protected $appends = [
        'url'
    ];

    public function getUrlAttribute()
    {
        return new UrlPresenter($this);
    }

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
}
