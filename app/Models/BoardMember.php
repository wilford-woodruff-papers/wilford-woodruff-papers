<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use OpenAI\Laravel\Facades\OpenAI;
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

    protected $guarded = ['id'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function buildSortQuery()
    {
        return static::query()->where('team_id', $this->team_id);
    }

    public function toSearchableArray(): array
    {
        $data = [
            'id' => 'team_'.$this->id,
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

        if (
            ! Storage::exists('embeddings/'.static::class.'/'.$this->id.'.json')
        ) {
            $vectors = [];
            $response = OpenAI::embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => strip_tags($this->bio ?? ''),
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
        return 'team_'.$this->id;
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with([
            'team',
        ]);
    }

    public function searchableAs(): string
    {
        return app()->environment('production') ? 'resources' : 'dev-resources';
    }
}
