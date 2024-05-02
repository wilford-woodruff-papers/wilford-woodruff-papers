<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function comeFollowMe()
    {
        return $this->belongsTo(ComeFollowMe::class);
    }

    public function buildSortQuery()
    {
        return static::query()
            ->where('come_follow_me_id', $this->come_follow_me_id);
    }
}
