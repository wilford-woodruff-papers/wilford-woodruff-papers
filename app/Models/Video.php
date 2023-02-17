<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Maize\Markable\Markable;
use Maize\Markable\Models\Like;
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
    use Markable;

    protected static $marks = [
        Like::class,
    ];

    public function getEmbedLinkAttribute()
    {
        $link = str($this->attributes['link']);

        if ($link->contains('youtu.be')) {
            $link = $link->replace('https://youtu.be/', 'https://www.youtube.com/watch?v=');
        }

        if ($link->contains('watch?v=')) {
            $link = $link->replace('watch?v=', 'embed/')->replaceFirst('&', '?');
        }

        if (! $link->contains('rel=0')) {
            if (! $link->contains('?')) {
                $link = $link->append('?rel=0');
            } else {
                $link = $link->append('&rel=0');
            }
        }

        return $link;
    }

    public function getCallToActionAttribute()
    {
        return 'Watch';
    }

    public function getIconAttribute()
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>';
    }
}
