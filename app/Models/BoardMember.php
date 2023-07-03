<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class BoardMember extends Model implements Sortable
{
    use HasFactory;
    use Searchable;
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function buildSortQuery()
    {
        return static::query()->where('team_id', $this->team_id);
    }

    public function toSearchableArray(): array
    {

        return [
            'id' => 'team'.$this->id,
            'is_published' => true,
            'resource_type' => 'Team Member',
            'type' => $this->team->name,
            'url' => route('about.meet-the-team').'#'.str($this->name)->slug(),
            'thumbnail' => Storage::disk('board_members')->url($this->image),
            'name' => collect([$this->name, $this->title])->reject(function ($item) {
                    return empty($item);
                })->join(', '),
            'description' => strip_tags($this->bio ?? ''),
        ];
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with([
            'team',
        ]);
    }

    public function searchableAs(): string
    {
        return 'resources';
    }
}
