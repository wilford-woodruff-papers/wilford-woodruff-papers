<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $guarded = [
        'id',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function text($isQuoteTagger = false)
    {
        return str($this->transcript)
            ->addSubjectLinks()
            ->addScriptureLinks()
            ->replace('&amp;', '&');
    }
}
