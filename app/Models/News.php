<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Parental\HasParent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;

class News extends Press implements HasMedia, \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;
    use HasFactory;
    use HasParent;
    use HasSlug;
    use InteractsWithMedia;
}
