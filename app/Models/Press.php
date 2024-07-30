<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use OpenAI\Laravel\Facades\OpenAI;
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
        'day_in_the_life_date' => 'date',
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

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'press_subject', 'press_id', 'subject_id');
    }

    public function topLevelIndexTopics(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'press_subject', 'press_id', 'subject_id')
            ->index()
            ->whereNull('subjects.subject_id');
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

        if (! empty($this->cover_image)) {
            $image_url = ($this->type == 'Instagram' ? $this->cover_image : Storage::disk('media')->url($this->cover_image));
        }

        if (str($this->title)->contains('Instagram:')) {
            $title = str(strip_tags($this->description))
                ->limit(64, '...')
                ->trim('"')
                ->trim(' ')
                ->trim("'")
                ->toString();
        } else {
            $title = str($this->title)
                ->trim('"')
                ->trim(' ')
                ->trim("'")
                ->toString();
        }

        $authors = [];
        if ($this->authors->count() > 0) {
            $authors = $this->authors->pluck('name')->map(function ($author) {
                return str($author)->title();
            })->toArray();
        } elseif (! empty($this->subtitle)) {
            $authors = [str($this->subtitle)->title()];
        }

        $data = [
            'id' => 'media_'.$this->id,
            'is_published' => ($this->date < now('America/Denver')),
            'resource_type' => 'Media',
            'type' => $this->type,
            'url' => $this->url(),
            'thumbnail' => $image_url ?? null,
            'name' => $title,
            'description' => strip_tags($this->description ?? ''),
            'authors' => $authors ?? null,
            'date' => $this->date ? $this->date?->timestamp : null,
            'topics' => $this->topLevelIndexTopics->pluck('name')->map(function ($topic) {
                return str($topic)->title();
            })->toArray(),
        ];

        if (
            empty($this->embeddings_created_at)
            || $this->embeddings_created_at < now()->subDay()
            || ! Storage::exists('embeddings/'.static::class.'/'.$this->id.'.json')
        ) {
            $vectors = [];
            $response = OpenAI::embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => strip_tags($this->description ?? ''),
            ]);

            foreach ($response->embeddings as $embedding) {
                $vectors = $embedding->embedding;
            }
            Storage::put('embeddings/'.static::class.'/'.$this->id.'.json', json_encode($vectors));
            $this->update([
                'embeddings_created_at' => now(),
            ]);
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
        return 'media_'.$this->id;
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with([
            'media',
            'topLevelIndexTopics',
            'authors',
        ]);
    }

    public function searchableAs(): string
    {
        return app()->environment('production') ? 'resources' : 'dev-resources';
    }

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (Press $press) {
            Cache::forget('first-instagram');
            Cache::forget('top-press');
        });
        static::updated(function (Press $press) {
            Cache::forget('first-instagram');
            Cache::forget('top-press');
        });

    }
}
