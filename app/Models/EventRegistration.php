<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtmlInput;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class EventRegistration extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $casts = [
        'first_name' => CleanHtmlInput::class,
        'last_name' => CleanHtmlInput::class,
        'email' => CleanHtmlInput::class,
        'extra_attributes' => SchemalessAttributes::class,
    ];

    public function scopeWithExtraAttributes(): Builder
    {
        return $this->extra_attributes->modelScope();
    }
}
