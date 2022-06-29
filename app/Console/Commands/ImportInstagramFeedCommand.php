<?php

namespace App\Console\Commands;

use App\Models\SocialMedia;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportInstagramFeedCommand extends Command
{
    protected $signature = 'import:instagram';

    protected $description = 'Add new instagram posts to ponder feed';

    public function handle()
    {
        $profile = \Dymantic\InstagramFeed\Profile::for('wilford_woodruff_papers');
        $feed = $profile?->refreshFeed(10);

        foreach($feed as $post){
            if($post->type == 'video'){
                continue;
            }

            $socialMedia = SocialMedia::updateOrCreate([
                'social_id' => $post->id
            ], [
                'title' => 'Instagram: ' . $post->id,
                'social_type' => $post->type,
                'cover_image' => ($post->type == 'video' ? $post->thumbnail_url : $post->url),
                'embed' => ($post->type == 'video' ? $post->url : null),
                'description' => $post->caption,
                'excerpt' => str($post->caption)->before('#'),
                'link' => $post->permalink,
                'date' => Carbon::createFromFormat(\DateTime::ISO8601, $post->timestamp),
            ]);
            if($post->isCarousel()){
                /*dd($post->children);*/
                $socialMedia->extra_attributes = $post->children;
                $socialMedia->save();
            }
        }

    }
}
