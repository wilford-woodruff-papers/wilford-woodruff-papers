<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Auditable;
use Parental\HasParent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;

class Article extends Press implements HasMedia, \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;
    use HasFactory;
    use HasParent;
    use HasSlug;
    use InteractsWithMedia;

    public function url()
    {
        return ! empty($this->attributes['link'])
                ? $this->attributes['link']
                : route('media.article', ['article' => $this->slug]);
    }
}
