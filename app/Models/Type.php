<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class Type extends Model
{
    use HasFactory;
    use HasRoles;

    protected $guard_name = 'web';

    protected $guarded = ['id'];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function template(): HasOne
    {
        return $this->hasOne(Template::class);
    }

    public function subType(): HasOne
    {
        return $this->hasOne(Type::class);
    }

    public function goal(): HasOne
    {
        return $this->hasOne(Goal::class)->latestOfMany();
    }
}
