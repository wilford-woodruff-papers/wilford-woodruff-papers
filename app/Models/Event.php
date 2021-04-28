<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Event extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $dates = [
        'start_at',
        'end_at',
    ];

    /**
     * Get all of the resources that are assigned this item.
     */
    public function items()
    {
        return $this->morphedByMany(Item::class, 'timelineable');
    }

    /**
     * Get all of the resources that are assigned this item.
     */
    public function pages()
    {
        return $this->morphedByMany(Page::class, 'timelineable');
    }

    /**
     * Get all of the photos that are assigned this item.
     */
    public function photos()
    {
        return $this->morphedByMany(Photo::class, 'timelineable');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }
}
