<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;
use Spatie\Browsershot\Browsershot;

class GenerateBannerForDocumentCommand extends Command
{
    protected $signature = 'item-banner:generate {item?}';

    protected $description = 'Generate a banner for documents.';

    public function handle(): int
    {
        $base64Data = Browsershot::url(route('document-banner', [
            'item' => $this->argument('item'),
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
        $item = Item::whereUuid($this->argument('item'))->first();

        $item->clearMediaCollection('default');

        $item->addMediaFromBase64($base64Data)
            ->usingFileName(str($item->name)->slug()->toString().'.jpg')
            ->toMediaCollection('default');

        return Command::SUCCESS;
    }
}
