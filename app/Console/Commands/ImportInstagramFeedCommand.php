<?php

namespace App\Console\Commands;

use App\Models\SocialMedia;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportInstagramFeedCommand extends Command
{
    protected $signature = 'import:instagram';

    protected $description = 'Add new instagram posts to ponder feed';

    public function handle()
    {
        $profile = \Dymantic\InstagramFeed\Profile::for('wilford_woodruff_papers');
        $feed = $profile?->refreshFeed(2);

        foreach ($feed as $post) {
            if ($post->type == 'video') {
                continue;
            }

            $socialMedia = SocialMedia::updateOrCreate([
                'social_id' => $post->id,
            ], [
                'title' => 'Instagram: '.$post->id,
                'social_type' => $post->type,
                'cover_image' => ($post->type == 'video' ? $this->storeMediaToLocalDisk($post->thumbnail_url) : $this->storeMediaToLocalDisk($post->url)),
                'embed' => ($post->type == 'video' ? $this->storeMediaToLocalDisk($post->url) : null),
                'description' => $post->caption,
                'excerpt' => str($post->caption)->before('#'),
                'link' => $post->permalink,
                'date' => Carbon::createFromFormat(\DateTime::ISO8601, $post->timestamp),
            ]);
            if ($post->isCarousel()) {
                /*dd($post->children);*/
                $socialMedia->extra_attributes = $this->storeMedias($post->children);
                $socialMedia->save();
            }
        }
    }

    private function storeMedias($images)
    {
        foreach ($images as &$image) {
            $image['url'] = $this->storeMediaToLocalDisk($image['url'], $image['id']);
        }

        return $images;
    }

    private function storeMediaToLocalDisk($image, $name = null)
    {
        $extension = str($image)->before('?')->afterLast('.');

        if (empty($name)) {
            $name = str($image)->before('?')->afterLast('/')->before('.');
        }

        $path = 'instagram/'.$name.'.'.$extension;

        if (Storage::disk('instagram')->exists($path)) {
            return Storage::disk('instagram')->url($path);
        }

        $contents = file_get_contents($image);

        if (Storage::disk('instagram')->put($path, $contents)) {
            return Storage::disk('instagram')->url($path);
        }
    }
}
