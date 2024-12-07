<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Stringable;
use Laravel\Scout\Searchable;
use OpenAI\Laravel\Facades\OpenAI;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Audit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Subject extends Model implements \OwenIt\Auditing\Contracts\Auditable, HasMedia
{
    use Auditable;
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;
    use Searchable;

    protected $guarded = ['id'];

    //    protected $appends = [
    //        'gender',
    //    ];

    protected function casts(): array
    {
        return [
            'geolocation' => 'array',
            'northeast_box' => 'array',
            'southwest_box' => 'array',
            'added_to_ftp_at' => 'date',
            'bio_completed_at' => 'date',
            'place_confirmed_at' => 'date',
            'approved_for_print_at' => 'date',
            'confirmed_name_at' => 'date',
            'mentioned' => 'boolean',
            'visited' => 'boolean',
        ];
    }

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

    public function getConnectionToWilfordAttribute()
    {
        return trim(
            str($this->bio)
                ->explode('.')
                ->firstWhere(fn ($value) => str($value)->contains('Wilford Woodruff')) ?? ''
        );
    }

    protected function displayLifeYears(): Attribute
    {
        return Attribute::make(
            get: function () {
                $lifeYears = $this->life_years;
                if (
                    empty($this->bio_approved_at)
                    || empty($this->birth_date)
                    || empty($this->death_date)
                ) {
                    return $lifeYears;
                }

                $dates = [];
                if (! empty($this->birth_date) && ! empty($birthDate = $this->parseDateToCarbon($this->birth_date))) {
                    $dates[] = $birthDate->format('j M Y');
                } elseif (! empty($this->birth_date)) {
                    $dates[] = $this->birth_date;
                }
                if (! empty($this->death_date) && ! empty($deathDate = $this->parseDateToCarbon($this->death_date))) {
                    $dates[] = $deathDate->format('j M Y');
                } elseif (! empty($this->death_date)) {
                    $dates[] = $this->death_date;
                }

                return implode(' - ', $dates);
            },
        );
    }

    private function parseDateToCarbon($date)
    {
        try {
            return Carbon::createFromFormat('Y-m-d', $date);
        } catch (\Exception $exception) {
            return null;
        }
    }

    protected function latitude(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: function ($value) {
                if (str()->contains($value, '°')) {
                    $value = convertDMSToDecimal(
                        str($value)
                            ->replace('′', '\'')
                            ->replace('″', '"')
                            ->replace('°', ' ')
                            ->toString()
                    );
                }

                return $value;
            },
        );
    }

    protected function longitude(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: function ($value) {
                if (str()->contains($value, '°')) {
                    $value = convertDMSToDecimal(
                        str($value)
                            ->replace('′', '\'')
                            ->replace('″', '"')
                            ->replace('°', ' ')
                            ->toString()
                    );
                }

                return $value;
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

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function public_categories()
    {
        return $this->category()
            ->peopleCategories()
            ->where('name', '!=', 'People');
    }

    //    public function getGenderAttribute()
    //    {
    //        return str(data_get($this->familysearch_person, 'persons.0.gender.type'))
    //            ->afterLast('/');
    //    }

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'subject_id');
    }

    public function researcher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'researcher_id')->withTrashed();
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_subject');
    }

    public function press(): BelongsToMany
    {
        return $this->belongsToMany(Press::class, 'press_subject');
    }

    public function scopePeople(Builder $query): void
    {
        $query->whereHas('category', function ($query) {
            $query->where('name', 'People');
        });
    }

    public function scopePlaces(Builder $query): void
    {
        $query->whereHas('category', function ($query) {
            $query->where('name', 'Places');
        });
    }

    public function scopeIndex(Builder $query): void
    {
        $query->whereHas('category', function ($query) {
            $query->where('name', 'Index');
        });
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class)->with(['children' => function ($query) {
            $query->when(auth()->guest() || (auth()->check() && ! auth()->user()->hasAnyRole(['Super Admin'])), fn ($query) => $query->where('hide_on_index', 0)
                ->where(function ($query) {
                    $query->where('tagged_count', '>', 0)
                        ->orWhere('text_count', '>', 0);
                }));
        }]);
    }

    public function quotes(): BelongsToMany
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
        if (
            ! empty($this->latitude)
            && ! empty($this->longitude)
            //&& ! empty($this->google_map_address)
            && empty($this->getFirstMedia('maps'))
        ) {
            $url = 'https://maps.googleapis.com/maps/api/staticmap?';

            //$url .= 'center='.$this->google_map_address;
            $url .= '&zoom=4&size=600x300&maptype=roadmap';
            //$url .= '&zoom='.$this->zoomLevel().'&size=600x300&maptype=roadmap';
            $url .= '&markers=color:red%7Clabel:.%7C'.$this->latitude.','.$this->longitude;
            $url .= '&key='.config('googlemaps.public_key');

            //$file = Storage::disk('local')
            //    ->put($this->slug.'-map.png', file_get_contents($url));
            //            $file = file_put_contents(
            //                storage_path('app/maps/').$this->slug.'-maps.png',
            //                file_get_contents(str($url)->replace(' ', '%20'))
            //            );
            try {
                //$this->clearMediaCollection();
                $this->addMediaFromUrl(str($url)->replace(' ', '%20'))
                    ->usingFileName($this->slug.'-map.png')
                    ->usingName($this->slug.'-map.png')
                    ->toMediaCollection('maps', 'maps');
            } catch (\Exception $e) {
                logger()->error($e->getMessage());
            }

        }

        $this->load([
            'media',
        ]);

        return $this->getFirstMediaUrl('maps', 'thumb');
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

    //    public function toArray()
    //    {
    //        if (auth()->check() && auth()->user()->hasAnyRole(['Super Admin'])) {
    //            return array_merge($this->attributesToArray(), $this->relationsToArray());
    //        }
    //
    //        return [
    //            'name' => $this->name,
    //            'types' => $this->category,
    //            'links' => [
    //                'frontend_url' => $this->slug ? route('subjects.show', ['subject' => $this->slug]) : '',
    //                'api_url' => $this->id ? route('api.subjects.show', ['id' => $this->id]) : '',
    //            ],
    //        ];
    //    }

    public function toSearchableArray(): array
    {
        $collectionName = 'default';
        $geo = null;
        $thumbnail = null;

        if ($this->category->pluck('name')->contains('People')) {
            $resourceType = 'People';
            if (str($this->portrait)->startsWith('https://tree-portraits-bgt.familysearchcdn.org')) {
                $thumbnail = $this->portrait;
            }
        } elseif ($this->category->pluck('name')->contains('Places')) {
            $resourceType = 'Places';
            $collectionName = 'maps';
            if (! empty($this->latitude) && ! empty($this->longitude)) {
                $geo = [
                    'lat' => $this->latitude,
                    'lng' => $this->longitude,
                ];
            }
            $thumbnail = $this->getFirstMedia($collectionName)?->getUrl('thumb');
        } elseif ($this->category->pluck('name')->contains('Index')) {
            $resourceType = 'Topic';
        } else {
            $resourceType = null;
        }

        $data = [
            'id' => 'subject_'.$this->id,
            'is_published' => ($this->tagged_count > 0) | ($this->text_count > 0) | ($this->total_usage_count > 0),
            'resource_type' => $resourceType,
            'type' => $this->category->pluck('name')->toArray(),
            'url' => route('subjects.show', ['subject' => $this->slug]),
            'thumbnail' => $thumbnail,
            'name' => $this->name,
            'description' => strip_tags($this->bio ?? ''),
            '_geo' => $geo,
            'usages' => $this->getCount(),
        ];

        if (
            ! Storage::exists('embeddings/'.static::class.'/'.$this->id.'.json')
        ) {
            $vectors = [];
            $response = OpenAI::embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => strip_tags($this->bio ?? ''),
            ]);

            foreach ($response->embeddings as $embedding) {
                $vectors = $embedding->embedding;
            }
            Storage::put('embeddings/'.static::class.'/'.$this->id.'.json', json_encode($vectors));
            $data['_vectors'] = [
                'semanticSearch' => $vectors,
            ];
        } else {
            $data['_vectors'] = [
                'semanticSearch' => json_decode(Storage::get('embeddings/'.static::class.'/'.$this->id.'.json')),
            ];
        }

        return $data;
    }

    public function getCount()
    {
        $count = 0;

        if ($this->total_usage_count > 0) {
            $count = $this->total_usage_count;
        } else {
            $count = $this->tagged_count + $count += $this->text_count;
        }

        return $count;
    }

    public function getScoutKey(): mixed
    {
        return 'subject_'.$this->id;
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with([
            'category',
        ]);
    }

    public function searchableAs(): string
    {
        return app()->environment('production') ? 'resources' : 'dev-resources';
    }

    public function shouldBeSearchable(): bool
    {
        return ($this->tagged_count > 0) | ($this->text_count > 0) | ($this->total_usage_count > 0);
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

    public static function countryName($state, $country)
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

    public function firstLetter()
    {
        return Item::query()
            ->whereIn(
                'id',
                $this->pages->pluck('parent_item_id')->toArray())
            ->whereRelation('type', 'name', 'Letters')
            ->whereNotNull('first_date')
            ->orderBy('first_date', 'asc')
            ->first();
    }

    public function registerMediaConversions(?Media $media = null): void
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

    public static function extractFromText($text)
    {
        $matches = str($text)->matchAll('/(?:\[\[)(.*?)(?:\]\])/s');
        $names = [];
        foreach ($matches as $match) {
            $names[] = str($match)
                ->explode('|')
                ->first();
        }

        return Subject::query()
            ->with([
                'category',
            ])
            ->whereIn('name', $names)
            ->get()
            ->groupBy(function ($subject, int $key) {
                return $subject
                    ->category
                    ->filter(function ($category) {
                        return in_array($category->name, ['People', 'Places', 'Index']);
                    })
                    ->first()
                    ?->name;
            });
    }

    public function formatAuditFieldsForPresentation($field, Audit $record)
    {
        $fields = Arr::wrap($record->{$field});

        $formattedResult = '<ul class="max-w-3xl whitespace-normal divide-y divide-gray-300">';

        foreach ($fields as $key => $value) {
            $formattedResult .= '<li class="py-2">';
            $formattedResult .= '<span class="font-semibold inline-block text-gray-700 whitespace-normal rounded-md dark:text-gray-200 bg-gray-500/10">'.str($key)->replace('_', ' ')->title().':</span>';
            $formattedResult .= '<div class="">'.$value.'</div>';
            $formattedResult .= '</li>';
        }

        $formattedResult .= '</ul>';

        return new HtmlString($formattedResult);
    }
}
