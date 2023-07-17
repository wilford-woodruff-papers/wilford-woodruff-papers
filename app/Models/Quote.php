<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
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

    public function contents()
    {
        return $this->morphMany(Content::class, 'contentable');
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function continuation()
    {
        return $this->hasOne(Quote::class, 'continued_from_previous_page', 'id');
    }

    public function topics()
    {
        return $this->belongsToMany(Subject::class)->withPivot(['approved_at', 'approved_by', 'created_at', 'created_by']);
    }

    public function actions()
    {
        return $this->morphMany(Action::class, 'actionable');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => 'quote_'.$this->id,
            'is_published' => (bool) $this->actions_count > 0,
            'resource_type' => 'Quote',
            'type' => 'Quote',
            'url' => ($this->page ? route('pages.show', ['item' => $this->page->item?->uuid, 'page' => $this->page?->uuid]) : ''),
            'thumbnail' => $this->page->getFirstMedia()?->getUrl('thumb'),
            'name' => $this->page->full_name,
            'description' => strip_tags($this->text),
            'decade' => null,
            'year' => null,
            'date' => null,
            'topics' => $this->topics->pluck('name')->map(function ($topic) {
                    return str($topic)->title();
                })->toArray(),
        ];
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
