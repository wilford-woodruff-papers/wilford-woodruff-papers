<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use OpenAI\Laravel\Facades\OpenAI;
use Spatie\DeletedModels\Models\Concerns\KeepsDeletedModels;
use Spatie\Tags\HasTags;
use Wildside\Userstamps\Userstamps;

class Quote extends Model
{
    use HasFactory;
    use HasTags;
    use KeepsDeletedModels;
    use Searchable;
    use Userstamps;

    protected $guarded = ['id'];

    public function contents(): MorphMany
    {
        return $this->morphMany(Content::class, 'contentable');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function continuation(): HasOne
    {
        return $this->hasOne(Quote::class, 'continued_from_previous_page', 'id');
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class)->withPivot(['approved_at', 'approved_by', 'created_at', 'created_by']);
    }

    public function actions(): MorphMany
    {
        return $this->morphMany(Action::class, 'actionable');
    }

    public function toSearchableArray(): array
    {
        $data = [
            'id' => 'quote_'.$this->id,
            'is_published' => (bool) $this->actions_count > 0,
            'resource_type' => 'Quote',
            'type' => 'Quote',
            'url' => ($this->page ? route('pages.show', ['item' => $this->page->item?->uuid, 'page' => $this->page?->uuid]) : ''),
            'thumbnail' => $this->page->getFirstMedia()?->getUrl('thumb'),
            'name' => 'Page '.$this->page->order.' of '.str($this->page->parent?->name)->stripBracketedID()->toString(),
            'description' => strip_tags($this->text),
            'author' => $this->author,
            'decade' => null,
            'year' => null,
            'date' => null,
            'topics' => $this->topics->pluck('name')->map(function ($topic) {
                return str($topic)->title();
            })->toArray(),
        ];

        if (
            ! Storage::exists('embeddings/'.static::class.'/'.$this->id.'.json')
        ) {
            $vectors = [];
            $response = OpenAI::embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => strip_tags($this->text),
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
        return 'quote_'.$this->id;
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query
            ->with([
                'page',
                'page.item',
                'page.parent',
                'page.media',
                'topics',
            ])
            ->withCount([
                'actions',
            ]);
    }

    public function searchableAs(): string
    {
        return app()->environment('production') ? 'resources' : 'dev-resources';
    }

    public function shouldBeSearchable(): bool
    {
        return $this->actions_count > 0;
    }
}
