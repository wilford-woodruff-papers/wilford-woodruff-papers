<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Announcement extends Model
{
    use HasFactory;
    use HasSlug;

    protected $casts = [
        'start_publishing_at' => 'datetime',
        'end_publishing_at' => 'datetime',
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
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (Announcement $announcement) {
            Cache::forget('top-announcements');
            Cache::forget('bottom-announcements');
        });
        static::updated(function (Announcement $announcement) {
            Cache::forget('top-announcements');
            Cache::forget('bottom-announcements');
        });
    }
}
