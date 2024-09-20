<?php

namespace App\Models\Scriptures;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volume extends Model
{
    protected $guarded = ['id'];

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class)
            ->withPivot('book', 'chapter', 'verse');
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
