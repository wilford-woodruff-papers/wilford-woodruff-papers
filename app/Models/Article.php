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

    public function getCallToActionAttribute()
    {
        return 'Read';
    }

    public function getIconAttribute()
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>';
    }
}
