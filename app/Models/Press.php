<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Press extends Model implements HasMedia, \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable, HasFactory, InteractsWithMedia;
}
