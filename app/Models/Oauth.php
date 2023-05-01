<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oauth extends Model
{
    use HasFactory;

    protected $table = 'oauth';

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
