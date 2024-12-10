<?php

namespace App\Models;

use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\DB;
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
use Wildside\Userstamps\Userstamps;

class Item extends Model implements \OwenIt\Auditing\Contracts\Auditable, HasMedia, Sortable
{
    use Auditable;
    use BindsOnUuid;
    use GeneratesUuid;
    use HasFactory;
    use HasHashid;
    use InteractsWithMedia;
    use KeepsDeletedModels;
    use LogsActivity;
    use Searchable;
    use SortableTrait;
    use Userstamps;

    protected $guarded = ['id'];

    private $suffixes = [
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'aa', 'bb', 'cc', 'dd', 'ee', 'ff', 'gg', 'hh', 'ii', 'jj', 'kk', 'll', 'mm', 'nn', 'oo', 'pp', 'qq', 'rr', 'ss', 'tt', 'uu', 'vv', 'ww', 'xx', 'yy', 'zz',
    ];

    public function pages()
    {
        /*if(Str::of(optional($this->type)->name)->exactly(['Autobiographies', 'Journals'])){
            return $this->hasManyThrough(Page::class, Item::class)->orderBy('order', 'ASC');
        }else{
            return $this->hasMany(Page::class)->orderBy('order', 'ASC');
        }*/
        if (array_key_exists('id', $this->attributes) && Page::where('item_id', $this->attributes['id'])->count() > 0) {
            return $this->hasMany(Page::class)->orderBy('order', 'ASC');
        } else {
            return $this->hasManyThrough(Page::class, self::class)->orderBy('order', 'ASC');
        }
    }

    public function realPages()
    {
        return $this
            ->hasMany(Page::class)
            ->orderBy('order', 'ASC');
    }

    public function containerPages()
    {
        return $this
            ->hasMany(Page::class, 'parent_item_id')
            ->orderBy('order', 'ASC');
    }

    public function firstPage(): HasOne
    {
        return $this
            ->hasOne(Page::class, 'parent_item_id')
            ->ofMany('order', 'min');
    }

    public function firstPageWithText()
    {
        return $this
            ->hasMany(Page::class, 'parent_item_id')
            ->where('is_blank', 0)
            ->orderByRaw('CHAR_LENGTH(transcript) DESC')
            ->one();
    }

    public function items()
    {
        return $this
            ->hasMany(self::class)
            ->orderBy('order', 'ASC');
    }

    public function item()
    {
        return $this
            ->belongsTo(self::class);
    }

    public function parent()
    {
        if (empty($this->item_id)) {
            return $this;
        }

        return self::findOrFail($this->item_id);
    }

    public function copyright(): BelongsTo
    {
        return $this->belongsTo(Copyright::class);
    }

    public function canBePublished()
    {
        $this->load([
            'completed_actions',
            'completed_actions.type',
        ]);

        if (
            $this->completed_actions->contains('type.name', 'Transcription')
            && $this->completed_actions->contains('type.name', 'Verification')
            && $this->completed_actions->contains('type.name', 'Subject Tagging')
            && $this->completed_actions->contains('type.name', 'Date Tagging')
        ) {
            return true;
        }

        return false;
    }

    public function parentCanBePublished()
    {
        foreach ($this->items as $item) {
            if (! $item->canBePublished()) {
                return false;
            }
        }

        return true;
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function dates(): MorphMany
    {
        return $this->morphMany(Date::class, 'dateable');
    }

    public function taggedDates(): MorphMany
    {
        return $this->morphMany(Date::class, 'dateable');
    }

    public function values(): HasMany
    {
        return $this->hasMany(Value::class);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        return $query->whereUuid($value);
    }

    protected $attributeModifiers = [
        'uuid' => Base64Encoder::class,
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected function casts(): array
    {
        return [
            'added_to_collection_at' => 'datetime',
            'sort_date' => 'datetime',
            'first_date' => 'datetime',
            'imported_at' => 'datetime',
            'uuid' => EfficientUuid::class,
        ];
    }

    public function buildSortQuery()
    {
        return static::query()
            ->where('item_id', $this->item_id);
    }

    /**
     * Get all of the events that are assigned this item.
     */
    public function events(): MorphToMany
    {
        return $this->morphToMany(Event::class, 'timelineable');
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

    protected static function booted()
    {
        static::creating(function ($item) {
            if (empty($item->pcf_unique_id) && empty($item->item_id)) {
                $uniqueId = DB::table('items')
                    ->where('pcf_unique_id_prefix', $item->pcf_unique_id_prefix)
                    ->max('pcf_unique_id');
                $item->pcf_unique_id = $uniqueId + 1;
            } elseif (empty($item->pcf_unique_id)) {
                $item->pcf_unique_id = $item->parent()->pcf_unique_id;
                $item->pcf_unique_id_suffix = $item->getSuffix(
                    Item::where('item_id', $item->item_id)->count()
                );
            }
        });

        static::updating(function ($item) {
            if (empty($item->pcf_unique_id) && empty($item->item_id)) {
                $uniqueId = DB::table('items')
                    ->where('pcf_unique_id_prefix', $item->pcf_unique_id_prefix)
                    ->max('pcf_unique_id');
                $item->pcf_unique_id = $uniqueId + 1;
            } elseif (empty($item->pcf_unique_id)) {
                $item->pcf_unique_id = $item->parent()->pcf_unique_id;
                $item->pcf_unique_id_suffix = $item->getSuffix(
                    Item::where('item_id', $item->item_id)->count()
                );
            }
        });

        static::deleting(function ($item) {
            foreach ($item->pages ?? [] as $page) {
                foreach ($page->quotes ?? [] as $quote) {
                    $quote->delete();
                }
                foreach ($page->actions ?? [] as $action) {
                    $action->delete();
                }
                $page->delete();
            }
            foreach ($item->actions ?? [] as $action) {
                $action->delete();
            }
        });
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function quotes(): HasManyThrough
    {
        return $this->hasManyThrough(
            Quote::class,
            Page::class,
            'parent_item_id',
            'page_id',
        )
            ->whereNull('continued_from_previous_page')
            ->orderBy('pages.order', 'ASC');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontLogIfAttributesChangedOnly(['transcript']);
    }

    public function actions(): MorphMany
    {
        return $this->morphMany(Action::class, 'actionable');
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

    public function pending_actions(): MorphMany
    {
        return $this->morphMany(Action::class, 'actionable')
            ->where(
                'actionable_type',
                \App\Models\Item::class
            )->where('assigned_to', auth()->id())
            ->whereNull('completed_at');
    }

    public function pending_actions_for_user($userId): MorphMany
    {
        return $this->morphMany(Action::class, 'actionable')
            ->where(
                'actionable_type',
                \App\Models\Item::class
            )->where('assigned_to', $userId)
            ->whereNull('completed_at')
            ->get();
    }

    public function unassigned_actions(): MorphMany
    {
        return $this->morphMany(Action::class, 'actionable')
            ->whereNull('assigned_to')
            ->whereNull('completed_at');
    }

    public function completed_actions(): MorphMany
    {
        return $this->morphMany(Action::class, 'actionable')
            ->whereNotNull('completed_at');
    }

    public function page_actions(): HasManyThrough
    {
        return $this->hasManyThrough(Action::class, Page::class, 'item_id', 'actionable_id')
            ->where(
                'actionable_type',
                \App\Models\Page::class
            );
    }

    public function pending_page_actions(): HasManyThrough
    {
        return $this->hasManyThrough(Action::class, Page::class, 'item_id', 'actionable_id')
            ->where(
                'actionable_type',
                \App\Models\Page::class
            )
            ->where('assigned_to', auth()->id())
            ->whereNull('completed_at');
    }

    public function pending_page_actions_for_user($userId): HasManyThrough
    {
        return $this->hasManyThrough(Action::class, Page::class, 'item_id', 'actionable_id')
            ->where(
                'actionable_type',
                \App\Models\Page::class
            )
            ->where('assigned_to', $userId)
            ->whereNull('completed_at')
            ->get();
    }

    public function admin_comments(): MorphMany
    {
        return $this->morphMany(AdminComment::class, 'admincommentable');
    }

    public function target_publish_dates(): BelongsToMany
    {
        return $this->belongsToMany(TargetPublishDate::class);
    }

    public function active_target_publish_date(): BelongsToMany
    {
        return $this->belongsToMany(TargetPublishDate::class)
            ->where('publish_at', '>', now());
    }

    public function getPublicNameAttribute()
    {
        return \Illuminate\Support\Str::of($this->name)->replaceMatches('/\[.*?\]/', '')->trim();
    }

    public function getPcfUniqueIdFullAttribute()
    {
        return (! empty($this->pcf_unique_id_prefix)
                ? ($this->pcf_unique_id_prefix.'-')
                : (mb_substr($this->type?->name, 0, 1).'-')).($this->pcf_unique_id).($this->pcf_unique_id_suffix);
    }

    protected function getSuffix(int $index): string
    {
        return $this->suffixes[$index];
    }

    //    public function toArray()
    //    {
    //        if ($this->exists) {
    //            return [
    //                'id' => $this->id,
    //                'uuid' => $this->uuid,
    //                'type' => $this->type?->name,
    //                'name' => $this->name,
    //                'links' => [
    //                    'frontend_url' => route('documents.show', ['item' => $this->uuid]),
    //                    'api_url' => route('api.documents.show', ['item' => $this->uuid]),
    //                    'images' => [
    //                        'thumbnail_url' => $this->firstPage?->getFirstMedia()?->getUrl('thumb'),
    //                        'original_url' => $this->firstPage?->getFirstMedia()?->getUrl(),
    //                    ],
    //                ],
    //
    //            ];
    //        } else {
    //            return array_merge($this->attributesToArray(), $this->relationsToArray());
    //        }
    //    }

    public function toSearchableArray(): array
    {
        $data = [
            'id' => 'item_'.$this->id,
            'is_published' => (bool) $this->enabled,
            'resource_type' => 'Document',
            'type' => $this->type?->name,
            'url' => route('documents.show', ['item' => $this->uuid]),
            'thumbnail' => $this->firstPage?->getFirstMedia()?->getUrl('thumb'),
            'uuid' => $this->uuid,
            'name' => str($this->name)->stripBracketedID()->toString(),
            'description' => '',
        ];

        if (
            ! Storage::exists('embeddings/'.static::class.'/'.$this->id.'.json')
        ) {
            $vectors = [];
            $response = OpenAI::embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => str($this->name)->stripBracketedID()->toString(),
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
        return 'item_'.$this->id;
    }

    public function searchableAs(): string
    {
        return app()->environment('production') ? 'resources' : 'dev-resources';
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with([
            'firstPage',
            'type',
        ]);
    }

    public function shouldBeSearchable(): bool
    {
        return (bool) $this->enabled && empty($this->item_id);
    }
}
