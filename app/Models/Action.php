<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function actionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function type(): BelongsTo
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

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function finisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}
