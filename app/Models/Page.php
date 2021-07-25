<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Encoders\Base64Encoder;
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

    protected $dates = [
        'imported_at',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function parent()
    {
        if(empty($this->item->item_id)){
            return $this->item();
        }else{
            return $this->belongsTo(Item::class, 'parent_item_id');
        }
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
            return '<a href="/subjects/' . Str::of(Str::of($match[1])->explode("|")->first())->slug() . '" class="text-secondary popup">'. Str::of($match[1])->explode("|")->last() .'</a>';
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
        if(! empty($this->attributes['parent_item_id'])){
            return static::query()->where('parent_item_id', $this->parent->id);
        }else{
            return static::query()->where('item_id', $this->attributes['item_id']);
        }

    }

    protected $attributeModifiers = [
        'uuid' => Base64Encoder::class,
    ];

    /**
     * Get all of the events that are assigned this page.
     */
    public function events()
    {
        return $this->morphToMany(Event::class, 'timelineable');
    }

}
