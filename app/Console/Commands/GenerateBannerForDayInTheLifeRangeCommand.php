<?php

namespace App\Console\Commands;

use App\Models\DayInTheLife;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateBannerForDayInTheLifeRangeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'banner:generate-count {count=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a banner for the day in the life for homepage slider.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = $this->argument('count');

        $start = DayInTheLife::query()
            ->select('date', DB::raw('MONTH(date) month'), DB::raw('DAY(date) day'))
            ->orderBy('month', 'DESC')
            ->orderBy('day', 'DESC')
            ->first()
            ?->date
            ?? now('America/Denver');

        foreach (range(1, $count) as $i) {
            $this->call('banner:generate', [
                'month' => $start->clone()->addDays($i)->month,
                'day' => $start->clone()->addDays($i)->day,
            ]);
        }
    }
}
