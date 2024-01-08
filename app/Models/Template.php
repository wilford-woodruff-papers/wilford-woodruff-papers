<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function template_properties()
    {
        return $this->belongsToMany(Property::class)
            ->withPivot([
                'order_column',
                'is_required',
            ])
            ->orderBy('property_template.order_column', 'ASC');
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_template')
            ->withPivot([
                'order_column',
                'is_required',
            ])
            ->orderBy('property_template.order_column', 'ASC');
    }
}
