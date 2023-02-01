<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;

class Set extends Item
{
    use HasFactory;
    use HasParent;

    public function pages()
    {
        return $this->hasManyThrough(Page::class, Item::class)->orderBy('order', 'ASC');
    }
}
