<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    public $timestamps = false;

    public function dateable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function toArray()
    {
        return [
            'date' => $this->date?->toDateString(),
        ];
    }
}
