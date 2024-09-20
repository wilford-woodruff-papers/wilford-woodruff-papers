<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiSession extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function questions(): HasMany
    {
        return $this->hasMany(AiQuestion::class);
    }
}
