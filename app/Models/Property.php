<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Property extends Model
{
    use HasFactory;
    use HasSlug;

    protected $guarded = ['id'];

    public function templates()
    {
        return $this->belongsToMany(Template::class)
            ->withPivot([
                'order_column',
                'is_required',
            ])
            ->orderBy('name', 'ASC');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
