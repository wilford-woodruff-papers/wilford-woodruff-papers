<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationshipFinderQueue extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'relationship_finder_queue';

    protected function casts(): array
    {
        return [
            'in_progress' => 'boolean',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
