<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ContestSubmission extends Model implements HasMedia
{
    use GeneratesUuid;
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = ['id'];

    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];

    public static array $statuses = [
        'Complete' => 'Complete',
        'Pending Collaborators' => 'Pending Collaborators',
    ];

    public static array $divisions = [
        'High School Student' => 'High School Student',
        'Undergraduate Student' => 'Undergraduate Student',
        'Graduate Student' => 'Graduate Student',
    ];

    public static array $categories = [
        'Art' => 'Art',
        'Performance' => 'Performance',
        'Literary Composition' => 'Literary Composition',
    ];

    public static array $medium = [
        '' => [],
        'Art' => [
            '2-D Art' => '2-D Art',
            '3-D Art' => '3-D Art',
            'Digital Art' => 'Digital Art',
        ],
        'Performance' => [
            'Theater' => 'Theater',
            'Dance' => 'Dance',
            'Cinema' => 'Cinema',
            'Musical Composition' => 'Musical Composition',
        ],
        'Literary Composition' => [
            'Literary Composition' => 'Literary Composition',
        ],
    ];

    public function contestants()
    {
        return $this->hasMany(Contestant::class);
    }

    public function primary_contact()
    {
        return $this->hasOne(Contestant::class)->ofMany([
            'is_primary_contact' => 'max'
        ]);
    }

    public function scopePending($query)
    {
        $query->where('is_original', 0)
              ->orWhere('is_appropriate', 0);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }
}
