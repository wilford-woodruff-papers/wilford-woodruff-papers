<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

class Item extends Model implements \OwenIt\Auditing\Contracts\Auditable, Sortable
{
    use Auditable, GeneratesUuid, HasFactory, SortableTrait;
    use HasHashid;
    use KeepsDeletedModels;
    use LogsActivity;
    use Searchable;

    protected $guarded = ['id'];

    protected $casts = [
        'added_to_collection_at' => 'datetime',
        'sort_date' => 'datetime',
        'first_date' => 'datetime',
        'imported_at' => 'datetime',
        'uuid' => EfficientUuid::class,
    ];

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

    public function firstPage()
    {
        return $this->hasOne(Page::class, 'parent_item_id')->ordered()->ofMany();
    }

    public function items()
    {
        return $this->hasMany(self::class)->orderBy('order', 'ASC');
    }

    public function item()
    {
        return $this->belongsTo(self::class);
    }

    public function parent()
    {
        if (empty($this->item_id)) {
            return $this;
        }

        return self::findOrFail($this->item_id);
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

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function dates()
    {
        return $this->morphMany(Date::class, 'dateable');
    }

    public function taggedDates()
    {
        return $this->morphMany(Date::class, 'dateable');
    }

    public function values()
    {
        return $this->hasMany(Value::class);
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

    /**
     * Get all of the events that are assigned this item.
     */
    public function events()
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

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontLogIfAttributesChangedOnly(['transcript']);
    }

    public function actions()
    {
        return $this->morphMany(Action::class, 'actionable');
    }

    public function pending_actions()
    {
        return $this->morphMany(Action::class, 'actionable')
            ->where(
                'actionable_type',
                \App\Models\Item::class
            )->where('assigned_to', auth()->id())
            ->whereNull('completed_at');
    }

    public function pending_actions_for_user($userId)
    {
        return $this->morphMany(Action::class, 'actionable')
            ->where(
                'actionable_type',
                \App\Models\Item::class
            )->where('assigned_to', $userId)
            ->whereNull('completed_at')
            ->get();
    }

    public function unassigned_actions()
    {
        return $this->morphMany(Action::class, 'actionable')
            ->whereNull('assigned_to')
            ->whereNull('completed_at');
    }

    public function completed_actions()
    {
        return $this->morphMany(Action::class, 'actionable')
            ->whereNotNull('completed_at');
    }

    public function page_actions()
    {
        return $this->hasManyThrough(Action::class, Page::class, 'item_id', 'actionable_id')
            ->where(
                'actionable_type',
                \App\Models\Page::class
            );
    }

    public function pending_page_actions()
    {
        return $this->hasManyThrough(Action::class, Page::class, 'item_id', 'actionable_id')
            ->where(
                'actionable_type',
                \App\Models\Page::class
            )
            ->where('assigned_to', auth()->id())
            ->whereNull('completed_at');
    }

    public function pending_page_actions_for_user($userId)
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

    public function admin_comments()
    {
        return $this->morphMany(AdminComment::class, 'admincommentable');
    }

    public function target_publish_dates()
    {
        return $this->belongsToMany(TargetPublishDate::class);
    }

    public function active_target_publish_date()
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

    public function toArray()
    {
        if ($this->exists) {
            return [
                'id' => $this->id,
                'uuid' => $this->uuid,
                'type' => $this->type?->name,
                'name' => $this->name,
                'links' => [
                    'frontend_url' => route('documents.show', ['item' => $this->uuid]),
                    'api_url' => route('api.documents.show', ['item' => $this->uuid]),
                    'images' => [
                        'thumbnail_url' => $this->firstPage?->getFirstMedia()?->getUrl('thumb'),
                        'original_url' => $this->firstPage?->getFirstMedia()?->getUrl(),
                    ],
                ],

            ];
        } else {
            return array_merge($this->attributesToArray(), $this->relationsToArray());
        }
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => 'item_'.$this->id,
            'is_published' => true,
            'resource_type' => 'Document',
            'type' => $this->type?->name,
            'url' => route('documents.show', ['item' => $this->uuid]),
            'thumbnail' => $this->firstPage?->getFirstMedia()?->getUrl('thumb'),
            'uuid' => $this->uuid,
            'name' => $this->name,
        ];
    }

    public function getScoutKey(): mixed
    {
        return 'item_'.$this->id;
    }

    public function searchableAs(): string
    {
        return 'resources';
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
        return $this->enabled;
    }
}
