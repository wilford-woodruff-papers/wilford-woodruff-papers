<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use OpenAI\Laravel\Facades\OpenAI;
use Spatie\Tags\HasTags;

class WebsitePage extends Model
{
    use HasFactory;
    use HasTags;
    use Searchable;

    protected $guarded = ['id'];

    public function toSearchableArray(): array
    {
        $data = [
            'id' => 'website_'.$this->id,
            'is_published' => true,
            'resource_type' => 'Website',
            'url' => $this->url,
            'thumbnail' => Storage::disk('website')->url($this->thumbnail),
            'name' => $this->name,
            'description' => strip_tags($this->description ?? ''),
            'keywords' => $this->tags()->pluck('name')->map(function ($keyword) {
                return str($keyword)->title();
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
        return 'website_'.$this->id;
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query;
    }

    public function searchableAs(): string
    {
        return app()->environment('production') ? 'resources' : 'dev-resources';
    }
}
