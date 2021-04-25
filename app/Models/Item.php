<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Encoders\Base64Encoder;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Item extends Model implements \OwenIt\Auditing\Contracts\Auditable, Sortable
{
    use Auditable, GeneratesUuid, HasFactory, SortableTrait;

    protected $guarded = ['id'];

    protected $dates = [
        'added_to_collection_at',
    ];

    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];

    public function pages()
    {
        if(Str::of($this->type->name)->contains(['Autobiographies', 'Journals'])){
            return $this->hasManyThrough(Page::class, Item::class)->orderBy('order', 'ASC');
        }else{
            return $this->hasMany(Page::class)->orderBy('order', 'ASC');
        }
    }

    public function items()
    {
        return $this->hasMany(Item::class)->orderBy('order', 'ASC');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function parent()
    {
        if(empty($this->item_id)){
            return $this;
        }
        return Item::findOrFail($this->item_id);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function dates()
    {
        return $this->morphMany(Date::class, 'dateable');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected $attributeModifiers = [
        'uuid' => Base64Encoder::class,
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    public function buildSortQuery()
    {
        return static::query()->where('item_id', $this->item_id);
    }

    /*protected static function booted()
    {
        static::updated(function ($item) {
            $pages = $item->pages;
            Page::whereIn('id', $pages->pluck('id')->all())->update([
                'parent_item_id' => $item->parent()->id
            ]);
        });
    }*/
}
