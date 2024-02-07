<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function scopePeopleCategories(Builder $query): void
    {
        $people = Category::query()->where('name', 'People')->first();
        $query->where('categories.category_id', $people->id);
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
        ];
    }
}
