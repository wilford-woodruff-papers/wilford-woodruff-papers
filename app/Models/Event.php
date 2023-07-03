<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Event extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Searchable;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function getManualDisplayDateAttribute()
    {
        return $this->attributes['display_date'];
    }

    public function getDisplayDateAttribute()
    {
        if (! empty($this->attributes['display_date'])) {
            return $this->attributes['display_date'];
        }

        $date = $this->start_at?->format('F j, Y');

        if (! empty($this->end_at)) {
            $date = $date.' - '.$this->end_at?->format('F j, Y');
        }

        return $date;
    }

    /**
     * Get all of the resources that are assigned this item.
     */
    public function items()
    {
        return $this->morphedByMany(Item::class, 'timelineable');
    }

    /**
     * Get all of the resources that are assigned this item.
     */
    public function pages()
    {
        return $this->morphedByMany(Page::class, 'timelineable');
    }

    /**
     * Get all of the photos that are assigned this item.
     */
    public function photos()
    {
        return $this->morphedByMany(Photo::class, 'timelineable');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function toArray()
    {
        $event = [];
        $this->loadMissing([
            'photos',
            'media',
        ]);
        $displayStart = str($this->display_date)->before('-')->trim();
        $displayEnd = str($this->display_date)->after('-')->trim();

        $event['start_date']['display_date'] = $displayStart;
        $event['start_date']['year'] = $this->start_at?->year;
        $event['start_date']['month'] = $this->start_at?->month;
        $event['start_date']['day'] = $this->start_at?->day;

        if (! empty($this->end_at)) {
            $event['end_date']['display_date'] = $displayEnd;
            $event['end_date']['year'] = $this->end_at?->year;
            $event['end_date']['month'] = $this->end_at?->month;
            $event['end_date']['day'] = $this->end_at?->day;
        }

        $event['text'] = [
            'headline' => $this->headline,
            'text' => '<div class="view-more flex flex-col space-y-2"><div>'.$this->text.'</div><div><a href="#event-'.$this->id.'" class="bg-secondary py-1 px-2 text-sm" target="_self">View in Table</a></div></div>',
            'autolink' => false,
        ];

        if ($this->photos->count() > 0) {
            $event['media'] = [
                'url' => $this->photos->first()->getFirstMediaUrl('default', 'thumb'),
                'thumbnail' => $this->photos->first()->getFirstMediaUrl('default', 'thumb'),
            ];
        } elseif ($this->media->count() > 0) {
            $event['media'] = [
                'url' => $this->getFirstMediaUrl('default', 'thumb'),
                'thumbnail' => $this->getFirstMediaUrl('default', 'thumb'),
            ];
        }

        $event['group'] = $this->group;

        return $event;
    }

    public function formattedDate($side = 'start')
    {
        $date = [];

        if (! empty($this->{$side.'_month'})) {
            $date[] = Event::monthName($this->{$side.'_month'});
        }

        if (! empty($this->{$side.'_day'})) {
            $date[] = $this->{$side.'_day'}.',';
        }

        if (! empty($this->{$side.'_year'})) {
            $date[] = $this->{$side.'_year'};
        }

        return collect($date)->filter()->join(' ');
    }

    public static function monthName($num)
    {
        switch ($num) {
            case 1:
                return 'Jan';
            case 2:
                return 'Feb';
            case 3:
                return 'Mar';
            case 4:
                return 'Apr';
            case 5:
                return 'May';
            case 6:
                return 'June';
            case 7:
                return 'July';
            case 8:
                return 'Aug';
            case 9:
                return 'Sep';
            case 10:
                return 'Oct';
            case 11:
                return 'Nov';
            case 12:
                return 'Dec';
        }
    }

    public function toSearchableArray(): array
    {

        return [
            'id' => 'event'.$this->id,
            'is_published' => true,
            'resource_type' => 'Timeline',
            'type' => $this->group,
            'url' => route('timeline').'#event-'.$this->id,
            'thumbnail' => '', // TODO: Add thumbnail
            'name' => $this->text,
            'description' => '',
        ];
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with([
            'media',
        ]);
    }

    public function searchableAs(): string
    {
        return 'resources';
    }
}
