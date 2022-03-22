<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Content extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    public function contentable()
    {
        return $this->morphTo();
    }

    function uses()
    {
        return $this->hasMany(ContentUses::class);
    }
}
