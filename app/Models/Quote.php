<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Quote extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $guarded = ['id'];

    public function contents()
    {
        return $this->morphMany(Content::class, 'contentable');
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Subject::class)->withPivot(['approved_at', 'approved_by', 'created_at', 'created_by']);
    }

    public function actions()
    {
        return $this->morphMany(Action::class, 'actionable');
    }
}
