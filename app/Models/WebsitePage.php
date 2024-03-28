<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use Spatie\Tags\HasTags;

class WebsitePage extends Model
{
    use HasFactory;
    use HasTags;
    use Searchable;

    protected $guarded = ['id'];

    public function toSearchableArray(): array
    {
        return [
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
