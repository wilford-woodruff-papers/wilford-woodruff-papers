<?php

namespace App\Models;

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

    public function toArray()
    {
        return [
            'name' => $this->name,
        ];
    }
}
