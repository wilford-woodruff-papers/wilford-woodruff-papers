<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Parental\HasParent;

class Document extends Item
{
    use HasFactory;
    use HasParent;

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class)->orderBy('order', 'ASC');
    }
}
