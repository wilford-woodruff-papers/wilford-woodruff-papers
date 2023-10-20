<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Parental\HasParent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;

class QuarterlyUpdate extends Update implements HasMedia
{
    use HasFactory;
    use HasParent;
    use HasSlug;
    use InteractsWithMedia;

    public function getUrlAttribute()
    {
        return route('updates.show', ['update' => $this->slug]);
    }

    public function getPrimaryImageUrlAttribute()
    {
        if (! empty($this->primary_image)) {
            return \Illuminate\Support\Facades\Storage::disk('updates')
                ->url($this->primary_image);
        }

        return null;
    }

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (QuarterlyUpdate $update) {
            Cache::forget('quarterly-update');
        });
        static::updated(function (QuarterlyUpdate $update) {
            Cache::forget('quarterly-update');
        });
    }
}
