<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia, \OwenIt\Auditing\Contracts\Auditable, Sortable
{
    use Auditable;
    use GeneratesUuid;
    use HasFactory;
    use InteractsWithMedia;
    use SortableTrait;

    protected $guarded = ['id'];

    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function dates()
    {
        return $this->morphMany(Date::class, 'dateable');
    }

    public function text()
    {
        return Str::of($this->transcript)->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/', function ($match) {
            return '<a href="/subjects/' . Str::of(Str::of($match[1])->explode("|")->first())->slug() . '" class="text-secondary" target="_subject">'. Str::of($match[1])->explode("|")->last() .'</a>';
        });

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


    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    public function buildSortQuery()
    {
        return static::query()->where('item_id', $this->item_id);
    }

}
