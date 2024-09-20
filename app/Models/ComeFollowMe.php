<?php

namespace App\Models;

use App\Models\Scriptures\Chapter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ComeFollowMe extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function events(): HasMany
    {
        return $this->hasMany(ComeFollowMeEvent::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function chapters(): BelongsToMany
    {
        return $this->belongsToMany(Chapter::class);
    }

    public function getVideoEmbedUrlAttribute(): string
    {
        return 'https://www.youtube.com/embed/'.str($this->video_link)->afterLast('v=').'?rel=0';
    }

    public function getArticle()
    {
        if (empty($this->article_link)) {
            return null;
        }

        if (str($this->article_link)->contains('wilfordwoodruffpapers.org')) {
            return Article::query()
                ->where('slug', str($this->article_link)->afterLast('/'))
                ->first();
        } else {
            return Article::query()
                ->where('link', $this->article_link)
                ->first();
        }
    }
}
