<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OaiToken extends Model
{
    use HasFactory;

    public function usesTimestamps()
    {
        return false;
    }

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'from' => 'date',
            'until' => 'date',
            'expires_at' => 'datetime',
        ];
    }
}
