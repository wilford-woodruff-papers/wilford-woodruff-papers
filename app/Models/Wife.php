<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wife extends Model
{
    use HasFactory;

    public function person(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Child::class);
    }
}
