<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        return \Illuminate\Support\Facades\Storage::disk('updates')->url($this->primary_image);
    }
}
