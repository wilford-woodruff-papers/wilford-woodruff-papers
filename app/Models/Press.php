<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Parental\HasChildren;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Press extends Model implements HasMedia
{
    use HasChildren;
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;
    use Searchable;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
                        ->where(function (Builder $query) {
                            $query->where('status', 1)
                                    ->orWhere('user_id', Auth::id());
                        })
                        ->whereNull('parent_id')
                        ->orderBy('created_at', 'DESC');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function scopeHasCoverImage($query)
    {
        return $query->whereNotNull('cover_image');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $childTypes = [
        'Article' => Article::class,
        'News' => News::class,
        'Podcast' => Podcast::class,
        'Video' => Video::class,
        'Instagram' => SocialMedia::class,
    ];

    public function toSearchableArray(): array
    {
        $route = str($this->type)->lower()->toString();
        //dd($route);

        return [
            'id' => 'media_'.$this->id,
            'is_published' => ($this->date < now('America/Denver')),
            'resource_type' => 'Media',
            'type' => $this->type,
            'url' => route('media.'.$route, [$route => $this->slug]),
            'thumbnail' => $this->getFirstMedia()?->getUrl('thumb'),
            'name' => $this->title,
            'description' => strip_tags($this->description ?? ''),
        ];
    }

    public function getScoutKey(): mixed
    {
        return 'media_'.$this->id;
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
}
