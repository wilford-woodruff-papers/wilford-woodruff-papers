<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function template_properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot([
                'order_column',
                'is_required',
            ])
            ->where('enabled', true);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_template')
            ->withPivot([
                'order_column',
                'is_required',
            ])
            ->where('enabled', true)
            ->orderBy('property_template.order_column', 'ASC');
    }
}
