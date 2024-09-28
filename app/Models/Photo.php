<?php

namespace App\Models;

use Dyrynda\Database\Support\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use OpenAI\Laravel\Facades\OpenAI;
use OwenIt\Auditing\Encoders\Base64Encoder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class Photo extends Model implements HasMedia
{
    use GeneratesUuid;
    use HasFactory;
    use HasTags;
    use InteractsWithMedia;
    use Searchable;

    protected $guarded = ['id'];

    protected $attributeModifiers = [
        'uuid' => Base64Encoder::class,
    ];

    protected function casts(): array
    {
        return [
            'uuid' => EfficientUuid::class,
        ];
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        return $query->whereUuid($value);
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

    /**
     * Get all of the events that are assigned this item.
     */
    public function events(): MorphToMany
    {
        return $this->morphToMany(Event::class, 'timelineable');
    }

    public function toSearchableArray(): array
    {

        $data = [
            'id' => 'photo_'.$this->id,
            'is_published' => true,
            'resource_type' => 'Media',
            'type' => 'Photo',
            'url' => route('media.photos.show', ['photo' => $this->uuid]),
            'thumbnail' => $this->getFirstMedia()?->getUrl('thumb'),
            'name' => $this->title,
            'description' => strip_tags($this->description ?? ''),
            'authors' => $this->artist_or_photographer,
        ];

        if (
            ! Storage::exists('embeddings/'.static::class.'/'.$this->id.'.json')
        ) {
            $vectors = [];
            $response = OpenAI::embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => strip_tags($this->title.' '.$this->description ?? ''),
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
        return 'photo_'.$this->id;
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
