<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;

class AnnualReport extends Update implements HasMedia
{
    use HasFactory;
    use HasParent;
    use HasSlug;
    use InteractsWithMedia;

    public function getUrlAttribute()
    {
        return $this->link;
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
    }
}
