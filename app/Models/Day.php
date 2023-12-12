<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Stringable;

class Day extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function getNextAttribute(): Model
    {
        return Day::query()
            ->where('date', '>', $this->date)
            ->orderBy('date', 'asc')
            ->first();
    }

    public function getPreviousAttribute(): Model
    {
        return Day::query()
            ->where('date', '<', $this->date)
            ->orderBy('date', 'desc')
            ->first();
    }

    public function getTextAttribute(): Stringable
    {
        return str($this->content)
            ->addSubjectLinks()
            ->replaceInlineLanguageTags()
            ->addScriptureLinks()
            ->removeQZCodes(false)
            ->replace('&amp;', '&');
    }
}
