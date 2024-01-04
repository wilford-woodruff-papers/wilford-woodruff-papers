<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Maize\Markable\Markable;
use Maize\Markable\Models\Like;
use OwenIt\Auditing\Auditable;
use Parental\HasParent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
use Spatie\Sluggable\HasSlug;

class SocialMedia extends Press implements \OwenIt\Auditing\Contracts\Auditable, HasMedia
{
    use Auditable;
    use HasFactory;
    use HasParent;
    use HasSlug;
    use InteractsWithMedia;
    use Markable;

    protected static $marks = [
        Like::class,
    ];

    public $casts = [
        'date' => 'datetime',
        'extra_attributes' => SchemalessAttributes::class,
    ];

    public function scopeWithExtraAttributes(): Builder
    {
        return $this->extra_attributes->modelScope();
    }

    public function url()
    {
        return route('media.instagram', ['instagram' => $this->slug]);
    }

    public function getCallToActionAttribute()
    {
        return 'View';
    }

    public function getIconAttribute()
    {
        return '<svg class="h-6 w-6 mr-2 inline text-secondary" xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Logo Instagram</title><path fill="#792310" d="M349.33 69.33a93.62 93.62 0 0193.34 93.34v186.66a93.62 93.62 0 01-93.34 93.34H162.67a93.62 93.62 0 01-93.34-93.34V162.67a93.62 93.62 0 0193.34-93.34h186.66m0-37.33H162.67C90.8 32 32 90.8 32 162.67v186.66C32 421.2 90.8 480 162.67 480h186.66C421.2 480 480 421.2 480 349.33V162.67C480 90.8 421.2 32 349.33 32z"/><path fill="#792310" d="M377.33 162.67a28 28 0 1128-28 27.94 27.94 0 01-28 28zM256 181.33A74.67 74.67 0 11181.33 256 74.75 74.75 0 01256 181.33m0-37.33a112 112 0 10112 112 112 112 0 00-112-112z"/></svg>';
    }
}
