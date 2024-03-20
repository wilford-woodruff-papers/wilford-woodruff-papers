<?php

namespace App\Jobs;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class GenerateDocumentBannerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $itemUuid)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $base64Data = Browsershot::url(route('document-banner', [
            'item' => $this->itemUuid,
        ]))
            ->newHeadless()
            //->setChromePath('/usr/bin/google-chrome')
            ->setChromePath((app()->environment('local') ? '/opt/homebrew/bin/chromium' : '/usr/bin/google-chrome'))
            //->setOption('addStyleTag', json_encode([
            //    'content' => '#tips, #controls, #deck-progress { display: none; }',
            //]))
            ->windowSize(1232, 371)
            //->fit(Manipulations::FIT_CONTAIN, 400, 400)
            ->setScreenshotType('jpeg', 100)
            ->waitUntilNetworkIdle()
            ->base64Screenshot();

        //dd($base64Data);
        //Storage::disk('day_in_the_life')
        //        Storage::disk('local')
        //            ->put($month.'/'.$day.'.jpg', base64_decode($base64Data));
        // dd($date);
        $item = Item::whereUuid($this->itemUuid)->first();

        $item->clearMediaCollection('default');

        $item->addMediaFromBase64($base64Data)
            ->usingFileName(str($item->name)->slug()->toString().'.jpg')
            ->toMediaCollection('default');
    }
}
