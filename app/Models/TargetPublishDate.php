<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TargetPublishDate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'publish_at' => 'datetime:Y-m-d',
        ];
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }
}
