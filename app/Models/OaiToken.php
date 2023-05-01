<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OaiToken extends Model
{
    use HasFactory;

    protected $casts = [
        'from' => 'date',
        'until' => 'date',
        'expires_at' => 'datetime',
    ];

    public function usesTimestamps()
    {
        return false;
    }

    protected $guarded = [];
}
