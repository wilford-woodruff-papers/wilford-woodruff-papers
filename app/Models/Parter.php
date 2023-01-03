<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Parter extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    protected $guarded = ['id'];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function buildSortQuery()
    {
        return static::query()->where('category', $this->category);
    }
}
