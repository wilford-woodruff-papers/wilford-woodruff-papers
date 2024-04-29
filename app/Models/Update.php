<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Parental\HasChildren;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Update extends Model implements HasMedia
{
    use HasChildren;
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;
    use Searchable;

    protected $guarded = ['id'];

    protected $casts = [
        'publish_at' => 'datetime',
    ];

    protected $childTypes = [
        'Annual' => AnnualReport::class,
        'Newsletter' => Newsletter::class,
        'Quarterly' => QuarterlyUpdate::class,
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('subject')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function toSearchableArray(): array
    {
        $route = str($this->type)->lower()->toString();
        //dd($route);

        if ($this->type == 'Newsletter') {
            $summary = str(strip_tags(str($this->content)->after('</head>')->replace('[[trackingImage]]', '') ?? ''))->limit(200)->trim(' ')->toString();
        } else {
            $summary = strip_tags($this->content);
        }

        return [
            'id' => 'newsletter_'.$this->id,
            'is_published' => ($this->enabled && $this->publish_at < now('America/Denver')),
            'resource_type' => 'Newsletter',
            'type' => $this->type,
            'url' => $this->url,
            'thumbnail' => $this->getFirstMedia('images', ['primary' => true])?->getFullUrl(),
            'name' => $this->subject,
            'description' => $summary,
            'date' => $this->publish_at ? $this->publish_at?->timestamp : null,
        ];
    }

    public function getScoutKey(): mixed
    {
        return 'newsletter_'.$this->id;
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with([
            'media',
        ]);
    }

    public function searchableAs(): string
    {
        return app()->environment('production') ? 'resources' : 'dev-resources';
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }
}
