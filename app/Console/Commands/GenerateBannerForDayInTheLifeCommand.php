<?php

namespace App\Console\Commands;

use App\Models\DayInTheLife;
use App\Models\Page;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Spatie\Browsershot\Browsershot;

class GenerateBannerForDayInTheLifeCommand extends Command
{
    protected $signature = 'banner:generate {month?} {day?}';

    protected $description = 'Generate a banner for the day in the life for homepage slider.';

    public function handle(): int
    {
        $month = $this->argument('month') ?? now()->month;
        $day = $this->argument('day') ?? now()->day;

        $date = Date::createFromFormat('Y-m-d',
            \App\Models\Date::query()
                ->select('date')
                ->whereMonth('date', $month)
                ->whereDay('date', $day)
                ->where('dateable_type', Page::class)
                ->whereHasMorph('dateable', Page::class, function ($query) {
                    $query->whereRelation('parent', 'type_id', 5);
                })
                ->inRandomOrder()
                ->toBase()
                ->first()
                ?->date
        );

        $base64Data = Browsershot::url(route('day-in-the-life-banner', [
            'year' => $date->year,
            'month' => $date->month,
            'day' => $date->day,
        ]))
            ->newHeadless()
            //->setChromePath('/usr/bin/google-chrome')
            ->setChromePath('/opt/homebrew/bin/chromium')
            //->setOption('addStyleTag', json_encode([
            //    'content' => '#tips, #controls, #deck-progress { display: none; }',
            //]))
            ->windowSize(1232, 371)
            //->fit(Manipulations::FIT_CONTAIN, 400, 400)
            ->setScreenshotType('jpeg', 100)
            ->base64Screenshot();

        //dd($base64Data);
        //Storage::disk('day_in_the_life')
        //        Storage::disk('local')
        //            ->put($month.'/'.$day.'.jpg', base64_decode($base64Data));

        $dayInTheLife = DayInTheLife::firstOrCreate([
            'date' => $date,
        ]);

        $dayInTheLife->addMediaFromBase64($base64Data)
            ->usingFileName($date->year.'/'.$date->month.'/'.$date->day.'.jpg')
            ->toMediaCollection('banner');

        return Command::SUCCESS;
    }
}
