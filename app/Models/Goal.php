<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Goal extends Model
{
    use HasFactory;
    use Userstamps;

    protected $guarded = ['id'];

    protected $casts = [
        'finish_at' => 'datetime:Y-m-d',
    ];

    protected $dates = [
        'finish_at',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function action_type()
    {
        return $this->belongsTo(ActionType::class);
    }
}
