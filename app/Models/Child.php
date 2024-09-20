<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Child extends Model
{
    use HasFactory;

    public function person(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Wife::class);
    }
}
