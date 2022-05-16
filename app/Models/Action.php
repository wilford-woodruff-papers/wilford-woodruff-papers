<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = [
        'assigned_at',
        'completed_at',
    ];

    public function actionable()
    {
        return $this->morphTo();
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function finisher()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

}
