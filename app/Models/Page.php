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
        return Str::of($this->transcript)
            ->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/s', function ($match) {
                return '<a href="/subjects/'.Str::of(Str::of($match[1])->explode('|')->first())->slug().'" class="text-secondary popup">'.Str::of($match[1])->explode('|')->last().'</a>';
            })
            ->replaceMatches('/(?:\#\#)(.*?)(?:\#\#)/s', function ($match) {
                return '<a href="'.$this->getScriptureLink(str($match[1])->explode('|')->first()).'" class="text-secondary" target="_blank">'.str($match[1])->explode('|')->last().'</a>';
            })
            ->replaceMatches('/QZ[0-9]*/smi', function ($match) use ($isQuoteTagger) {
                return $isQuoteTagger
                    ? '<span class="bg-green-300">'.array_pop($match).'</span>'
                    : '';
            })
            ->replace('&amp;', '&');
    }

    public function getScriptureLink($scripture)
    {
        $book = str($scripture)->match('/([1-9]*\s?[A-Za-z]+)/s')->toString();
        $reference = str($scripture)->match('/([0-9]+:?[0-9-]*)/s');
        $volume = $this->getVolume($book);
        $verseRange = '';
        // Sometimes the verse is a range "1-4" or might be non-existent
        if ($reference->isEmpty()) {
            $chapter = '';
            $verse = '';
        } elseif ($reference->contains(':')) {
            $chapter = $reference->explode(':')->first();
            $verse = $reference->explode(':')->last();
            $verseRange = "p$verse";
            if (str($verse)->contains('-')) {
                $verseRange = str($verse)->explode('-')->map(function ($item) {
                    return "p$item";
                })->join('-');
                $verse = str($verse)->explode('-')->first();
            }
        } else {
            $chapter = $reference->toString();
            $verse = '';
        }

        $query = '';
        if (! empty($volume)) {
            $query .= $volume;
        }
        if (! empty($bookAbbreviation = $this->getBookAbbreviation($book))) {
            $query .= "/$bookAbbreviation";
        }
        if (! empty($chapter)) {
            $query .= "/$chapter";
        }
        if (! empty($verse)) {
            $query .= "?lang=eng&id=$verseRange#p$verse";
        }

        return "https://www.churchofjesuschrist.org/study/scriptures/$query";
        // Example: https://www.churchofjesuschrist.org/study/scriptures/ot/josh/1?lang=eng&id=p8#p8
    }

    private function getVolume($volume)
    {
        return match ($volume) {
            'Genesis', 'Exodus', 'Leviticus', 'Numbers', 'Deuteronomy', 'Joshua', 'Judges', 'Ruth', '1 Samuel', '2 Samuel', '1 Kings', '2 Kings', '1 Chronicles', '2 Chronicles', 'Ezra', 'Nehemiah', 'Esther', 'Job', 'Psalms', 'Proverbs', 'Ecclesiastes', 'Song of Solomon', 'Isaiah', 'Jeremiah', 'Lamentations', 'Ezekiel', 'Daniel', 'Hosea', 'Joel', 'Amos', 'Obadiah', 'Jonah', 'Micah', 'Nahum', 'Habakkuk', 'Zephaniah', 'Haggai', 'Zechariah', 'Malachi' => 'ot',
            'Matthew', 'Mark', 'Luke', 'John', 'Acts', 'Romans', '1 Corinthians', '2 Corinthians', 'Galatians', 'Ephesians', 'Philippians', 'Colossians', '1 Thessalonians', '2 Thessalonians', '1 Timothy', '2 Timothy', 'Titus', 'Philemon', 'Hebrews', 'James', '1 Peter', '2 Peter', '1 John', '2 John', '3 John', 'Jude', 'Revelation' => 'nt',
            '1 Nephi', '2 Nephi', 'Jacob', 'Enos', 'Jarom', 'Omni', 'Words of Mormon', 'Mosiah', 'Alma', 'Helaman', '3 Nephi', '4 Nephi', 'Mormon', 'Ether', 'Moroni' => 'bofm',
            'D&C' => 'dc-testament',
            default => '',
        };
    }

    private function getBookAbbreviation($book)
    {
        return match ($book) {
            'Genesis' => 'gen', // Old Testament
            'Exodus' => 'ex',
            'Leviticus' => 'lev',
            'Numbers' => 'num',
            'Deuteronomy' => 'deut',
            'Joshua' => 'josh',
            'Judges' => 'judg',
            'Ruth' => 'ruth',
            '1 Samuel' => '1-sam',
            '2 Samuel' => '2-sam',
            '1 Kings' => '1-kgs',
            '2 Kings' => '2-kgs',
            '1 Chronicles' => '1-chr',
            '2 Chronicles' => '2-chr',
            'Ezra' => 'ezra',
            'Nehemiah' => 'neh',
            'Esther' => 'esth',
            'Job' => 'job',
            'Psalms' => 'ps',
            'Proverbs' => 'prov',
            'Ecclesiastes' => 'eccl',
            'Song of Solomon' => 'song',
            'Isaiah' => 'isa',
            'Jeremiah' => 'jer',
            'Lamentations' => 'lam',
            'Ezekiel' => 'ezek',
            'Daniel' => 'dan',
            'Hosea' => 'hosea',
            'Joel' => 'joel',
            'Amos' => 'amos',
            'Obadiah' => 'obad',
            'Jonah' => 'jonah',
            'Micah' => 'micah',
            'Nahum' => 'nahum',
            'Habakkuk' => 'hab',
            'Zephaniah' => 'zeph',
            'Haggai' => 'hag',
            'Zechariah' => 'zech',
            'Malachi' => 'mal',
            'Matthew' => 'matt', // New Testament
            'Mark' => 'mark',
            'Luke' => 'luke',
            'John' => 'john',
            'Acts' => 'acts',
            'Romans' => 'rom',
            '1 Corinthians' => '1-cor',
            '2 Corinthians' => '2-cor',
            'Galatians' => 'gal',
            'Ephesians' => 'eph',
            'Philippians' => 'philip',
            'Colossians' => 'col',
            '1 Thessalonians' => '1-thes',
            '2 Thessalonians' => '2-thes',
            '1 Timothy' => '1-tim',
            '2 Timothy' => '2-tim',
            'Titus' => 'titus',
            'Philemon' => 'philem',
            'Hebrews' => 'heb',
            'James' => 'james',
            '1 Peter' => '1-pet',
            '2 Peter' => '2-pet',
            '1 John' => '1-jn',
            '2 John' => '2-jn',
            '3 John' => '3-jn',
            'Jude' => 'jude',
            'Revelation' => 'rev',
            '1 Nephi' => '1-ne', // Book of Mormon
            '2 Nephi' => '2-ne',
            'Jacob' => 'jacob',
            'Enos' => 'enos',
            'Jarom' => 'jarom',
            'Omni' => 'omni',
            'Words of Mormon' => 'w-o-m',
            'Mosiah' => 'mosiah',
            'Alma' => 'alma',
            'Helaman' => 'hel',
            '3 Nephi' => '3-ne',
            '4 Nephi' => '4-ne',
            'Mormon' => 'morm',
            'Ether' => 'ether',
            'Moroni' => 'moro',
            default => '',
        };
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

    public function toArray()
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'full_name' => $this->full_name,
            'name' => $this->name,
            'transcript' => $this->transcript,
            'text' => strip_tags($this->transcript),
            'dates' => $this->dates,
            'people' => $this->people,
            'places' => $this->places,
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
}
