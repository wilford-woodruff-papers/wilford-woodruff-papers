<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use GeneratesUuid, HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
