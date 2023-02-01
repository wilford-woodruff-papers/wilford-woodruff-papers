<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;

class Document extends Item
{
    use HasFactory;
    use HasParent;

    public function pages()
    {
        return $this->hasMany(Page::class)->orderBy('order', 'ASC');
    }
}
