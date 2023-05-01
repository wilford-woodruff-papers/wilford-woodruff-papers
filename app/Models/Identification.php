<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parental\HasChildren;

class Identification extends Model
{
    use HasChildren;
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'completed_at' => 'date',
    ];

    protected $childTypes = [
        'people' => PeopleIdentification::class,
        'place' => PlaceIdentification::class,
    ];
}
