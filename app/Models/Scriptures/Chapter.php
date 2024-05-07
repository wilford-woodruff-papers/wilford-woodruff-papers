<?php

namespace App\Models\Scriptures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chapter extends Model
{
    protected $guarded = ['id'];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
