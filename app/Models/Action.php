<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\DeletedModels\Models\Concerns\KeepsDeletedModels;
use Wildside\Userstamps\Userstamps;
use Znck\Eloquent\Traits\BelongsToThrough;

class Action extends Model
{
    use BelongsToThrough;
    use HasFactory;
    use KeepsDeletedModels;
    use Userstamps;

    protected $guarded = ['id'];

    protected $casts = [
        'assigned_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function actionable()
    {
        return $this->morphTo();
    }

    public function type()
    {
        return $this->belongsTo(ActionType::class, 'action_type_id')->ordered();
    }

    public function item()
    {
        return $this->belongsToThrough(
            Item::class,
            Page::class,
            foreignKeyLookup: [Page::class => 'actionable_id'],
            localKeyLookup: [Page::class => 'id']
        );
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function finisher()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}
