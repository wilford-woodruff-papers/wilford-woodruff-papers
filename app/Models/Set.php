<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Set extends Item
{
    use HasFactory;
    use HasParent;

    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];

    public function pages()
    {
        return $this->hasManyThrough(Page::class, Item::class)->orderBy('order', 'ASC');
    }
}
