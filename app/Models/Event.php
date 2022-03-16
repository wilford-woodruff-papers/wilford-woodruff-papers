<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Event extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

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

        $event['start_date'] = [
            'year' => $this->start_at->year,
            'month' => $this->start_at->month,
            'day' => $this->start_at->day,
        ];
        if (! empty($this->end_at)) {
            $event['end_date'] = [
                'year' => $this->end_at->year,
                'month' => $this->end_at->month,
                'day' => $this->end_at->day,
            ];
        }

        $event['text'] = [
            'headline' => $this->headline,
            'text' => $this->text,
        ];

        if ($this->media->count() > 0) {
            $event['media'] = [
                'url' => $this->getFirstMediaUrl(),
                'thumbnail' => $this->getFirstMediaUrl('default', 'thumb'),
            ];
        } elseif ($this->photos->count() > 0) {
            $event['media'] = [
                'url' => $this->photos->first()->getFirstMediaUrl(),
                'thumbnail' => $this->photos->first()->getFirstMediaUrl('default', 'thumb'),
            ];
        }

        $event['group'] = $this->group;

        return $event;
    }
}
