<?php

namespace App\Models;

use Dyrynda\Database\Support\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Contestant extends Model
{
    use GeneratesUuid;
    use HasFactory;
    use Notifiable;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'uuid' => EfficientUuid::class,
        ];
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(ContestSubmission::class, 'contest_submission_id');
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'].' '.$this->attributes['last_name'];
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
