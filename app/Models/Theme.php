<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Theme extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $guarded = ['id'];

    public function contents(): MorphMany
    {
        return $this->morphMany(Content::class, 'contentable');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class)->withPivot(['approved_at', 'approved_by', 'created_at', 'created_by']);
    }
}
