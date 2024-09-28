<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parental\HasParent;

class PlaceIdentification extends Identification
{
    use HasFactory;
    use HasParent;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'completed_at' => 'date',
        ];
    }
}
