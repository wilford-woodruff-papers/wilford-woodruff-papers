<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia, \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable, GeneratesUuid, HasFactory, InteractsWithMedia;

    protected $guarded = ['id'];

    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];

    public function item()
    {
        return $this->belongsToMany(Item::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function dates()
    {
        return $this->morphMany(Date::class, 'dateable');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

}
