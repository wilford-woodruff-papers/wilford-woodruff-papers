<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;

class Newsletter extends Update implements HasMedia
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
        return $this->getFirstMedia('images', ['primary' => true])?->getFullUrl();
    }
}
