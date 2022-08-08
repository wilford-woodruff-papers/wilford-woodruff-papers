<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Permission\Traits\HasRoles;

class ActionType extends Model implements Sortable
{
    use HasFactory;
    use HasRoles;
    use SortableTrait;

    protected $guard_name = 'web';

    protected $guarded = ['id'];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function scopeFor($query, $type)
    {
        return $query->where('type', $type);
    }
}
