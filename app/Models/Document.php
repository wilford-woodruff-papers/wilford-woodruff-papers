<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Document extends Item
{
    use HasFactory;
    use HasParent;

    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];

    public function pages()
    {
        return $this->hasMany(Page::class)->orderBy('order', 'ASC');
    }
}
