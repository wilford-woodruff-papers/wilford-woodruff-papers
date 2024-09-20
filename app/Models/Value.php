<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Value extends Model
{
    use HasFactory;
    use Userstamps;

    protected $guarded = ['id'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'value');
    }

    public function repository()
    {
        return $this->belongsTo(Repository::class, 'value');
    }

    public function copyrightstatus()
    {
        return $this->belongsTo(CopyrightStatus::class, 'value');
    }

    public function displayValue($values = null)
    {
        switch ($this->property->type) {
            case 'relationship':
                return match ($this->property->relationship) {
                    'Source' => $this->source->name,
                    'Repository' => $this->repository->name,
                    'CopyrightStatus' => $this->copyrightstatus->name,
                };
                break;
            case 'link':
                return match ($values->where('property.name', '*Source')->first()->displayValue()) {
                    'FamilySearch' => "<a href='{$this->value}' class='text-secondary underline' target='_blank'>{$values->where('property.name', '*Repository')->first()->displayValue()}</a>",
                    default => "<a href='{$this->value}' class='text-secondary underline' target='_blank'>{$values->where('property.name', str($this->property->name)->before(' Link'))->first()->displayValue()}</a>",
                };
                break;
            default:
                return $this->value;
        }
    }
}
