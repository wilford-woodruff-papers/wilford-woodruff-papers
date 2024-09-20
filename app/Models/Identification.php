<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parental\HasChildren;

class Identification extends Model
{
    use HasChildren;
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $childTypes = [
        'people' => PeopleIdentification::class,
        'place' => PlaceIdentification::class,
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'date',
        ];
    }

    public function researcher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'researcher_id')->withTrashed();
    }
}
