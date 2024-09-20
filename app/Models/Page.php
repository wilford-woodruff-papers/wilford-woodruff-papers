<?php

namespace App\Models;

use App\Models\Scriptures\Volume;
use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use Mtvs\EloquentHashids\HasHashid;
use OpenAI\Laravel\Facades\OpenAI;
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

class Page extends Model implements \OwenIt\Auditing\Contracts\Auditable, HasMedia, Sortable
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

    protected $appends = ['hashid'];

    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        return $query->whereUuid($value);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function parent(): BelongsTo
    {
        //if (! empty($this->item) && empty($this->item->item_id)) {
        //    return $this->item();
        //} else {
        return $this->belongsTo(Item::class, 'parent_item_id');
        //}
    }

    public function type(): HasManyThrough
    {
        return $this->hasManyThrough(
            Type::class,
            Item::class,
            'id',
            'id',
            'parent_item_id',
            'type_id'
        );
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

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class)
            ->whereHas('category', function (Builder $query) {
                $query->where('name', 'People');
            });
    }

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class)
            ->whereHas('category', function (Builder $query) {
                $query->where('name', 'Places');
            });
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class)
            ->whereHas('category', function (Builder $query) {
                $query->whereIn('categories.name', ['Topic', 'Index']);
            });
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function dates(): MorphMany
    {
        return $this->morphMany(Date::class, 'dateable');
    }

    public function taggedDates(): MorphMany
    {
        return $this->morphMany(Date::class, 'dateable')->orderBy('date', 'ASC');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class)
            ->orderBy('language', 'ASC');
    }

    public function publishing_tasks(): MorphMany
    {
        return $this->morphMany(Action::class, 'actionable')
            ->whereNotNull('completed_at')
            ->whereNotNull('completed_by')
            ->whereHas('type', function ($query) {
                $query->whereIn('name', [
                    'Transcription',
                    'Verification',
                    'Subject Tagging',
                    'Date Tagging',
                ]);
            });
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
            ->replaceFigureTags()
            ->addScriptureLinks()
            ->removeQZCodes($isQuoteTagger)
            ->replaceInlineLanguageTags()
            ->replace('&amp;', '&');
    }

    public function clearText($isQuoteTagger = false)
    {
        return str($this->clear_text_transcript)
            ->addSubjectLinks()
            ->addScriptureLinks()
            ->removeQZCodes($isQuoteTagger)
            ->replaceInlineLanguageTags()
            ->replace('&amp;', '&');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function registerMediaConversions(?Media $media = null): void
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

    protected function casts(): array
    {
        return [
            'imported_at' => 'datetime',
            'uuid' => EfficientUuid::class,
        ];
    }

    /**
     * Get all of the events that are assigned this page.
     */
    public function events(): MorphToMany
    {
        return $this->morphToMany(Event::class, 'timelineable');
    }

    public function actions(): MorphMany
    {
        return $this->morphMany(Action::class, 'actionable');
    }

    public function pending_assigned_actions(): MorphMany
    {
        return $this->morphMany(Action::class, 'actionable')
            ->whereNotNull('assigned_at')
            ->whereNull('completed_at');
    }

    public function completed_actions(): MorphMany
    {
        return $this->morphMany(Action::class, 'actionable')
            ->whereNotNull('completed_at');
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function admin_comments(): MorphMany
    {
        return $this->morphMany(AdminComment::class, 'admincommentable')->latest();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontLogIfAttributesChangedOnly(['transcript']);
    }

    /*public function toArray()
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'type' => $this->parent?->type?->name,
            'full_name' => $this->full_name,
            'name' => $this->name,
            'transcript' => $this->transcript,
            'text' => strip_tags($this->transcript),
            'links' => [
                'frontend_url' => route('pages.show', ['item' => $this->parent->uuid, 'page' => $this->uuid]),
                'api_url' => route('api.pages.show', ['page' => $this->uuid]),
                'images' => [
                    'thumbnail_url' => $this->getFirstMedia()?->getUrl('thumb'),
                    'original_url' => $this->getFirstMedia()?->getUrl(),
                ],
            ],
        ];
    }*/

    public function toArrayOld()
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

    public function volumes(): BelongsToMany
    {
        return $this->belongsToMany(Volume::class)
            ->withPivot('book', 'chapter', 'verse');
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
        $data = [
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
            'people' => $this->people->pluck('name')->map(function ($topic) {
                return str($topic)->title();
            })->toArray(),
            'places' => $this->places->pluck('name')->map(function ($topic) {
                return str($topic)->title();
            })->toArray(),
            'parent_id' => $this->parent->id,
            'order' => $this->order,
            'volumes' => $this->volumes->pluck('name')->unique()->toArray(),
            'books' => $this->volumes->pluck('pivot.book')->unique()->toArray(),
        ];

        if (
            ! Storage::exists('embeddings/'.static::class.'/'.$this->id.'.json')
        ) {
            $vectors = [];
            $response = OpenAI::embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => strip_tags($this->transcript),
            ]);

            foreach ($response->embeddings as $embedding) {
                $vectors = $embedding->embedding;
            }
            Storage::put('embeddings/'.static::class.'/'.$this->id.'.json', json_encode($vectors));
            $data['_vectors'] = [
                'semanticSearch' => $vectors,
            ];
        } else {
            $data['_vectors'] = [
                'semanticSearch' => json_decode(Storage::get('embeddings/'.static::class.'/'.$this->id.'.json')),
            ];
        }

        return $data;
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
            'people',
            'places',
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

    public static function nextDay($date)
    {
        return Date::query()
            ->select('date')
            ->where('date', '>', $date)
            ->where('dateable_type', Page::class)
            ->whereHasMorph('dateable', Page::class, function ($query) {
                $query->whereRelation('parent', 'type_id', 5);
            })
            ->orderBy('date', 'asc')
            ->first();
    }

    public static function previousDay($date)
    {
        return Date::query()
            ->select('date')
            ->where('date', '<', $date)
            ->where('dateable_type', Page::class)
            ->whereHasMorph('dateable', Page::class, function ($query) {
                $query->whereRelation('parent', 'type_id', 5);
            })
            ->orderBy('date', 'desc')
            ->first();
    }
}
