<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Stringable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Subject extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;

    protected $guarded = ['id'];

    protected $casts = [
        'geolocation' => 'array',
        //'bio_approved_at' => 'date',
        'added_to_ftp_at' => 'date',
        'bio_completed_at' => 'date',
        'place_confirmed_at' => 'date',
        'mentioned' => 'boolean',
        'visited' => 'boolean',
    ];

    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: function () {

                $name = str($this->name);

                if (! empty($this->last_name)) {
                    $name = $name->replace(' '.$this->last_name, '')
                                    ->prepend($this->last_name.', ');
                }

                $name = $name
                    ->when(! empty($this->last_name), function (Stringable $string) {
                        return $string
                            ->replaceMatches('/\bII$/i', '(II)')
                            ->replaceMatches('/\bIII$/i', '(III)');
                    })
                    ->replaceMatches('/\bJr\.$/i', '(Jr.)')
                    ->replaceMatches('/\bSr\.$/i', '(Sr.)')
                    ->replaceMatches('/\(OT\)/i', '(Old Testament)')
                    ->replaceMatches('/\(NT\)/i', '(New Testament)')
                    ->replaceMatches('/\(BofM\)/i', '(Book of Mormon)');

                return $name;
            },
        );
    }

    public function getBioApprovedAtAttribute()
    {
        if (str($this->attributes['bio_approved_at'])->contains('-')) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['bio_approved_at'])->toDateString();
        }

        return $this->attributes['bio_approved_at'];
    }

    public function getBioCompletedAtAttribute()
    {
        if (str($this->attributes['bio_completed_at'])->contains('-')) {
            return Carbon::createFromFormat('Y-m-d', str($this->attributes['bio_completed_at'])->before(' '))->toDateString();
        }

        return $this->attributes['bio_completed_at'];
    }

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
        return $this->belongsTo(self::class, 'subject_id');
    }

    public function researcher()
    {
        return $this->belongsTo(User::class, 'researcher_id')->withTrashed();
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_subject');
    }

    public function scopePeople(Builder $query): void
    {
        $query->whereHas('category', function ($query) {
            $query->where('name', 'People');
        });
    }

    public function children()
    {
        return $this->hasMany(self::class)->with(['children' => function ($query) {
            $query->when(auth()->guest() || (auth()->check() && ! auth()->user()->hasAnyRole(['Super Admin'])), fn ($query) => $query->where('hide_on_index', 0)
                ->where(function ($query) {
                    $query->where('tagged_count', '>', 0)
                        ->orWhere('text_count', '>', 0);
                }));
        }]);
    }

    public function quotes()
    {
        return $this->belongsToMany(Quote::class)->withPivot(['approved_at', 'approved_by', 'created_at', 'created_by']);
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

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function mapUrl()
    {
        if (! empty($this->geolocation) && empty($this->getMedia('map')->first())) {
            $url = 'https://maps.googleapis.com/maps/api/staticmap?';

            $url .= 'center='.$this->geolocation['formatted_address'];
            $url .= '&zoom='.$this->zoomLevel().'&size=600x300&maptype=roadmap';
            $url .= '&markers=color:red%7Clabel:.%7C'.$this->geolocation['geometry']['location']['lat'].','.$this->geolocation['geometry']['location']['lng'];
            $url .= '&key='.config('googlemaps.public_key');

            //$file = Storage::disk('local')
            //    ->put($this->slug.'-map.png', file_get_contents($url));
//            $file = file_put_contents(
//                storage_path('app/maps/').$this->slug.'-maps.png',
//                file_get_contents(str($url)->replace(' ', '%20'))
//            );

            $this->addMediaFromUrl(str($url)->replace(' ', '%20'))
                ->usingFileName($this->slug.'-map.png')
                ->usingName($this->slug.'-map.png')
                ->toMediaCollection('map', 'maps');
        }

        $this->load([
            'media',
        ]);

        return $this->getMedia('map')->first()->getUrl('thumb');
    }

    private function zoomLevel()
    {
        return in_array('continent', $this->geolocation['types']) ? '2' : '6';
    }

    public function calculateNames()
    {
        /*$name_suffix = '';
        $year = '';

        if (str($this->name)->contains(', b.')) {
            $year = str($this->name)->afterLast(',')->trim();
        }
        if (str($this->name)->contains('Jr.')) {
            $name_suffix = 'Jr.';
            $name = str($this->name)->beforeLast(',')->replace('Jr.', '')->rtrim(', ');
        } elseif (str($this->name)->contains('Sr.')) {
            $name_suffix = 'Sr.';
            $name = str($this->name)->beforeLast(',')->replace('Sr.', '')->rtrim(', ');
        } elseif (str($this->name)->contains('III')) {
            $name_suffix = 'III';
            $name = str($this->name)->beforeLast(',')->replace('III', '')->rtrim(', ');
        } elseif (str($this->name)->contains('II')) {
            $name_suffix = 'II';
            $name = str($this->name)->beforeLast(',')->replace('II', '')->rtrim(', ');
        } elseif (str($this->name)->contains('(OT)')) {
            $name_suffix = 'Old Testament';
            $name = str($this->name)->replace('(OT)', '')->rtrim(', ');
        } elseif (str($this->name)->contains('(NT)')) {
            $name_suffix = 'New Testament';
            $name = str($this->name)->replace('(NT)', '')->rtrim(', ');
        } elseif (str($this->name)->contains('(BofM)')) {
            $name_suffix = 'Book of Mormon';
            $name = str($this->name)->replace('(BofM)', '')->rtrim(', ');
        } else {
            $name = str($this->name)->beforeLast(',');
        }

        $name = explode(' ', $name);
        if (count($name) > 1) {
            $this->attributes['sort_last_name'] = array_pop($name);
        } else {
            $this->attributes['sort_last_name'] = implode(' ', $name).(! empty($year) ? ', '.$year.' ' : '').(! empty($name_suffix) ? ' ('.$name_suffix.')' : '');
        }
        $this->attributes['sort_first_name'] = implode(' ', $name).(! empty($year) ? ', '.$year.' ' : '').(! empty($name_suffix) ? ' ('.$name_suffix.')' : '');*/
    }

    public function calculateIndex()
    {
        if (! empty($this->attributes['last_name'])) {
            return str($this->attributes['last_name'])->substr(0, 1);
        } elseif (! empty($this->attributes['first_name'])) {
            return str($this->attributes['first_name'])->substr(0, 1);
        } else {
            return null;
        }
    }

    protected static function booted()
    {
        static::creating(function ($item) {
            $item->attributes['index'] = $item->calculateIndex();
        });

        static::updating(function ($item) {
            $item->attributes['index'] = $item->calculateIndex();
        });
    }

    public function toArray()
    {
        if (auth()->check() && auth()->user()->hasAnyRole(['Super Admin'])) {
            return array_merge($this->attributesToArray(), $this->relationsToArray());
        }

        return [
            'name' => $this->name,
            'types' => $this->category,
            'links' => [
                'frontend_url' => $this->slug ?? route('subjects.show', ['subject' => $this->slug]),
                'api_url' => $this->id ?? route('api.subjects.show', ['subject' => $this->id]),
            ],
        ];
    }

    public function includeCountryInName($state, $country)
    {
        if (! str($country)->is('United States')) {
            return $country;
        }

        if (
            str($country)->is('United States')
            && str($state)->contains('Washington, D.C.')
        ) {
            return $country;
        } elseif (
            str($country)->is('United States')
            && empty($state)
        ) {
            return $country;
        } elseif (
            str($country)->is('United States')
        ) {
            return null;
        }

        return $country;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);

        $this->addMediaConversion('medium')
            ->width(640)
            ->height(480)
            ->sharpen(10);
    }
}
