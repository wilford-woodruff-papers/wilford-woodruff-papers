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

    public function scopePeopleCategories(Builder $query): void
    {
        $people = Category::query()->where('name', 'People')->first();
        $query->where('category_id', $people->id);
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
        ];
    }
}
