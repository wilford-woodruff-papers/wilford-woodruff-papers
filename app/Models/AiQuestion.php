<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiQuestion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function session()
    {
        return $this->belongsTo(AiSession::class, 'ai_session_id');
    }

    public function topics()
    {
        return $this->belongsToMany(Subject::class)
            ->whereHas('category', function (Builder $query) {
                $query->where('name', 'Index');
            })
            ->orderBy('name');
    }
}
