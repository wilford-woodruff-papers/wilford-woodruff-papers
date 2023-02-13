<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Type extends Model
{
    use HasFactory;
    use HasRoles;

    protected $guard_name = 'web';

    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function type()
    {
        return $this->belongsTo(self::class);
    }

    public function template()
    {
        return $this->hasOne(Template::class);
    }

    public function subType()
    {
        return $this->hasOne(self::class);
    }

    public function goal()
    {
        return $this->hasOne(Goal::class)->latestOfMany();
    }
}
