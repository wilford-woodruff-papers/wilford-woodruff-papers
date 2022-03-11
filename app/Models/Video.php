<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable;
use Parental\HasParent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Tags\HasTags;

class Video extends Press implements HasMedia, \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;
    use HasFactory;
    use HasParent;
    use HasSlug;
    use HasTags;
    use InteractsWithMedia;

    function getEmbedLinkAttribute()
    {
        return Str::of($this->attributes['link'])->replace('watch?v=', 'embed/')->replaceFirst('&', '?');
    }
}
