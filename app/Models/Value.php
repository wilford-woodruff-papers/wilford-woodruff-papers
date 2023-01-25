<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Value extends Model
{
    use HasFactory;
    use Userstamps;

    protected $guarded = ['id'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
