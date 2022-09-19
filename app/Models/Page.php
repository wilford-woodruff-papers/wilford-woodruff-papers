<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Mtvs\EloquentHashids\HasHashid;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Encoders\Base64Encoder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
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
    use HasHashid;
    use InteractsWithMedia;
    use LogsActivity;
    use SortableTrait;

    protected $guarded = ['id'];

    protected $casts = [
        'imported_at' => 'datetime',
        'uuid' => EfficientUuid::class,
    ];

    protected $appends = ['hashid'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function parent()
    {
        if (! empty($this->item) && empty($this->item->item_id)) {
            return $this->item();
        } else {
            return $this->belongsTo(Item::class, 'parent_item_id');
        }
    }

    public function next()
    {
        return Page::where('parent_item_id', $this->attributes['parent_item_id'])
                        ->where('order', '>', $this->attributes['order'])
                        ->orderBy('order', 'ASC')
                        ->first();
    }

    public function previous()
    {
        return Page::where('parent_item_id', $this->attributes['parent_item_id'])
                        ->where('order', '<', $this->attributes['order'])
                        ->orderBy('order', 'DESC')
                        ->first();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Subject::class)
                    ->whereHas('category', function (Builder $query) {
                        $query->whereIn('categories.name', ['Topic', 'Index']);
                    });
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function dates()
    {
        return $this->morphMany(Date::class, 'dateable');
    }

    public function getPageDateRangeAttribute()
    {
        // Is not a Journal so return page #
        if($this->item?->type_id !== Type::whereName('Journal Sections')->first()->id){
            return 'p. ' . $this->order;
        }

        // Has one or more dates
        if($this->dates()->get()->count() == 1){
            return $this->dates()->get()->first()->date->format('F j, Y');
        } elseif ($this->dates()->get()->count() > 1) {
            return $this->dates()->get()->first()->date->format('F j, Y') . ' - ' .  $this->dates()->get()->last()->date->format('F j, Y');
        }

        // Does not have a date so grab the last date on a previous page with dates
        // If there are none, return a page #. This is most likely to happen in the first few pages of a journal
        if($page = Page::has('dates')->where('parent_item_id', $this->parent_item_id)->where('order', '<', $this->order)->orderBy('order', 'DESC')->first()){
            return $page->dates()->get()->sortBy('date')->last()->date->format('F j, Y');
        } else {
            return 'p. ' . $this->order;
        }
    }

    public function text()
    {
        return Str::of($this->transcript)->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/', function ($match) {
            return '<a href="/subjects/'.Str::of(Str::of($match[1])->explode('|')->first())->slug().'" class="text-secondary popup">'.Str::of($match[1])->explode('|')->last().'</a>';
        })->replace('&amp;', '&');
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
        if (! empty($this->attributes['parent_item_id'])) {
            return static::query()->where('parent_item_id', $this->parent->id);
        } else {
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

    public function actions()
    {
        return $this->morphMany(Action::class, 'actionable');
    }

    public function pending_assigned_actions()
    {
        return $this->morphMany(Action::class, 'actionable')
                    ->whereNotNull('assigned_at')
                    ->whereNull('completed_at');
    }

    public function completed_actions()
    {
        return $this->morphMany(Action::class, 'actionable')
                    ->whereNotNull('completed_at');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function admin_comments()
    {
        return $this->morphMany(AdminComment::class, 'admincommentable')->latest();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->dontLogIfAttributesChangedOnly(['transcript']);
    }
}
