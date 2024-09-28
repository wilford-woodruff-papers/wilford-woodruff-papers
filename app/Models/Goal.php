<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wildside\Userstamps\Userstamps;

class Goal extends Model
{
    use HasFactory;
    use Userstamps;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'finish_at' => 'datetime:Y-m-d',
        ];
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function action_type(): BelongsTo
    {
        return $this->belongsTo(ActionType::class);
    }
}
