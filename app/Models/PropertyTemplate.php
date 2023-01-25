<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class PropertyTemplate extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    protected $guarded = ['id'];

    protected $table = 'property_template';

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }

    public function buildSortQuery()
    {
        return static::query()->where('template_id', $this->template_id);
    }
}
