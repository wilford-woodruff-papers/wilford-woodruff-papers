<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class GenerateBannerForDayInTheLifeCommand extends Command
{
    protected $signature = 'banner:generate {month?} {day?}';

    protected $description = 'Generate a banner for the day in the life for homepage slider.';

    public function handle(): int
    {
        $month = $this->argument('month') ?? now()->month;
        $day = $this->argument('day') ?? now()->day;

        $base64Data = Browsershot::url(route('day-in-the-life-banner', [
            'month' => $month,
            'day' => $day,
        ]))
            ->newHeadless()
            ->setChromePath('/usr/bin/google-chrome')
            //->setOption('addStyleTag', json_encode([
            //    'content' => '#tips, #controls, #deck-progress { display: none; }',
            //]))
            ->windowSize(1232, 371)
            //->fit(Manipulations::FIT_CONTAIN, 400, 400)
            ->setScreenshotType('jpeg', 100)
            ->base64Screenshot();

        Storage::disk('day_in_the_life')
            ->put($month.'/'.$day.'.jpg', $base64Data);

        return Command::SUCCESS;
    }
}
