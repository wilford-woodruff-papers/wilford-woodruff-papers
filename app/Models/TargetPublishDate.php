<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetPublishDate extends Model
{
    use HasFactory;

    protected $dates = ['publish_at'];

    protected $casts = [
        'publish_at' => 'datetime:Y-m-d',
    ];

    protected $guarded = ['id'];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
