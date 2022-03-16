<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Subject extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = ['id'];

    protected $casts = [
        'geolocation' => 'array',
    ];

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function children()
    {
        return $this->hasMany(self::class);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function mapUrl()
    {
        $url = 'https://maps.googleapis.com/maps/api/staticmap?';

        $url .= 'center='.$this->geolocation['formatted_address'];
        $url .= '&zoom='.$this->zoomLevel().'&size=600x300&maptype=roadmap';
        $url .= '&markers=color:red%7Clabel:.%7C'.$this->geolocation['geometry']['location']['lat'].','.$this->geolocation['geometry']['location']['lng'];

        $url .= '&key='.config('googlemaps.public_key');

        return $url;
    }

    private function zoomLevel()
    {
        return in_array('continent', $this->geolocation['types']) ? '2' : '6';
    }
}
