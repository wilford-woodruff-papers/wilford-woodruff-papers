<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\SortableTrait;

class ComeFollowMeEvent extends Model
{
    use HasFactory;
    use SortableTrait;

    public $guarded = ['id'];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function comeFollowMe(): BelongsTo
    {
        return $this->belongsTo(ComeFollowMe::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function buildSortQuery()
    {
        return static::query()
            ->where('come_follow_me_id', $this->come_follow_me_id);
    }
}
