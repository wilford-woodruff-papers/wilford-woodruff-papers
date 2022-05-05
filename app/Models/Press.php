<?php

namespace App\Models;

use App\Presenters\Presses\UrlPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Maize\Markable\Markable;
use Maize\Markable\Models\Like;
use OwenIt\Auditing\Auditable;
use Parental\HasChildren;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class Press extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia;
    use HasChildren;
    use Markable;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
                        ->where(function(Builder $query){
                            $query->where('status', 1)
                                    ->orWhere('user_id', Auth::id());
                        })
                        ->whereNull('parent_id')
                        ->orderBy('created_at', 'DESC');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $childTypes = [
        'Article' => Article::class,
        'News' => News::class,
        'Podcast' => Podcast::class,
        'Video' => Video::class,
        'Social' => SocialMedia::class,
    ];
}
