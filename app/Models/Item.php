<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class Item extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable, GeneratesUuid, HasFactory;

    protected $guarded = ['id'];

    protected $dates = [
        'added_to_collection_at',
    ];

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

    public function dates()
    {
        return $this->morphMany(Date::class, 'dateable');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
