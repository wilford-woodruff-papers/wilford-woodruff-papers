<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    public $timestamps = false;

    public function dateable()
    {
        return $this->morphTo();
    }

    protected $casts = [
        'date' => 'datetime',
    ];
}
