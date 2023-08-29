<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Mtvs\EloquentHashids\HasHashid;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Encoders\Base64Encoder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\DeletedModels\Models\Concerns\KeepsDeletedModels;
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
    use KeepsDeletedModels;
    use LogsActivity;
    use Searchable;
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
        //if (! empty($this->item) && empty($this->item->item_id)) {
        //    return $this->item();
        //} else {
            return $this->belongsTo(Item::class, 'parent_item_id');
        //}
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

    public function people()
    {
        return $this->belongsToMany(Subject::class)
            ->whereHas('category', function (Builder $query) {
                $query->where('name', 'People');
            });
    }

    public function places()
    {
        return $this->belongsToMany(Subject::class)
            ->whereHas('category', function (Builder $query) {
                $query->where('name', 'Places');
            });
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

    public function taggedDates()
    {
        return $this->morphMany(Date::class, 'dateable')->orderBy('date', 'ASC');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class)
            ->orderBy('language', 'ASC');
    }

    public function getPageDateRangeAttribute()
    {
        // Is not a Journal so return page #
        if ($this->item?->type_id !== Type::whereName('Journal Sections')->first()->id) {
            return 'p. '.$this->order;
        }

        // Has one or more dates
        if ($this->dates()->get()->count() == 1) {
            return $this->dates()->get()->first()->date->format('F j, Y');
        } elseif ($this->dates()->get()->count() > 1) {
            return $this->dates()->get()->first()->date->format('F j, Y').' - '.$this->dates()->get()->last()->date->format('F j, Y');
        }

        // Does not have a date so grab the last date on a previous page with dates
        // If there are none, return a page #. This is most likely to happen in the first few pages of a journal
        if ($page = Page::has('dates')->where('parent_item_id', $this->parent_item_id)->where('order', '<', $this->order)->orderBy('order', 'DESC')->first()) {
            return $page->dates()->get()->sortBy('date')->last()->date->format('F j, Y');
        } else {
            return 'p. '.$this->order;
        }
    }

    public function text($isQuoteTagger = false)
    {
        return str($this->transcript)
            ->addSubjectLinks()
            ->addScriptureLinks()
            ->removeQZCodes($isQuoteTagger)
            ->replace('&amp;', '&');
    }

    public function clearText($isQuoteTagger = false)
    {
        return str($this->clear_text_transcript)
            ->addSubjectLinks()
            ->addScriptureLinks()
            ->removeQZCodes($isQuoteTagger)
            ->replace('&amp;', '&');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('web')
            ->width(1472)
            ->height(928)
            ->sharpen(10);

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

    public function toArray()
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'type' => $this->parent?->type?->name,
            'full_name' => $this->full_name,
            'name' => $this->name,
            'transcript' => $this->transcript,
            'text' => strip_tags($this->transcript),
            'dates' => $this->dates,
            'people' => $this->people->map(function ($item) {
                return [
                    'id' => $item->id,
                    'family_search_id' => $item->pid,
                    'slug' => $item->slug,
                    'name' => $item->name,
                    'first_name' => $item->first_name,
                    'middle_name' => $item->middle_name,
                    'last_name' => $item->last_name,
                    'suffix' => $item->suffix,
                    'alternate_names' => $item->alternate_names,
                    'maiden_name' => $item->maiden_name,
                    'bio' => $item->bio,
                    'footnotes' => $item->footnotes,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'total_usage_count' => $item->total_usage_count,
                    'reference' => $item->reference,
                    'relationship' => $item->relationship,
                    'birth_date' => $item->birth_date,
                    'baptism_date' => $item->baptism_date,
                    'death_date' => $item->death_date,
                    'life_years' => $item->life_years,
                ];
            }),
            'places' => $this->places->map(function ($item) {
                return [
                    'id' => $item->id,
                    'slug' => $item->slug,
                    'name' => $item->name,
                    'address' => $item->address,
                    'country' => $item->country,
                    'state_province' => $item->state_province,
                    'county' => $item->county,
                    'city' => $item->city,
                    'specific_place' => $item->specific_place,
                    'modern_location' => $item->modern_location,
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'total_usage_count' => $item->total_usage_count,
                    'reference' => $item->reference,
                    'visited' => $item->visited,
                    'mentioned' => $item->mentioned,
                ];
            }),
            'links' => [
                'frontend_url' => route('pages.show', ['item' => $this->parent->uuid, 'page' => $this->uuid]),
                'api_url' => route('api.pages.show', ['page' => $this->uuid]),
                'images' => [
                    'thumbnail_url' => $this->getFirstMedia()?->getUrl('thumb'),
                    'original_url' => $this->getFirstMedia()?->getUrl(),
                ],
            ],

        ];
    }

    protected static function booted()
    {
        static::deleting(function ($page) {
            foreach ($page->quotes ?? [] as $quote) {
                $quote->delete();
            }
            foreach ($page->actions ?? [] as $action) {
                $action->delete();
            }
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => 'page_'.$this->id,
            'is_published' => (bool) $this->parent->enabled,
            'resource_type' => 'Page',
            'type' => $this->parent?->type?->name,
            'url' => ($this->parent ? route('pages.show', ['item' => $this->parent?->uuid, 'page' => $this->uuid]) : ''),
            'thumbnail' => $this->getFirstMedia()?->getUrl('thumb'),
            'name' => 'Page '.$this->order.' of '.str($this->parent?->name)->stripBracketedID()->toString(),
            'description' => strip_tags($this->transcript),
            'decade' => $this->dates()->first()?->date ? (floor($this->dates()->first()?->date?->year / 10) * 10) : null,
            'year' => $this->dates()->first()?->date ? $this->dates()->first()?->date?->year : null,
            'date' => $this->dates()->first()?->date ? $this->dates()->first()?->date?->timestamp : null,
            'dates' => $this->dates()->pluck('date')->map(function ($date) {
                    return $date->toDateString();
                })->toArray(),
            'topics' => $this->topics->pluck('name')->map(function ($topic) {
                    return str($topic)->title();
                })->toArray(),
        ];
    }

    public function getScoutKey(): mixed
    {
        return 'page_'.$this->id;
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with([
            'parent',
            'parent.type',
            'media',
            'topics',
        ]);
    }

    public function searchableAs(): string
    {
        return app()->environment('production') ? 'resources' : 'dev-resources';
    }

    public function shouldBeSearchable(): bool
    {
        return $this->parent && $this->parent->enabled;
    }
}
