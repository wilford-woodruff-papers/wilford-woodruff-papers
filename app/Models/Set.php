<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Parental\HasParent;

class Set extends Item
{
    use HasFactory;
    use HasParent;

    public function pages(): HasManyThrough
    {
        return $this->hasManyThrough(Page::class, Item::class)->orderBy('order', 'ASC');
    }
}
