<?php

namespace App\Models\Scriptures;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Volume extends Model
{
    protected $guarded = ['id'];

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class)
            ->withPivot('book', 'chapter', 'verse');
    }
}
