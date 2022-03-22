<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class ContentUses extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    function content()
    {
        return $this->belongsTo(Content::class);
    }
}
