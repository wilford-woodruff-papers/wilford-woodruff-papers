<?php

namespace App\Console\Commands;

use App\Models\Subject;
use Illuminate\Console\Command;

class CalculateTaggedSubjectPageCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tags:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the number of pages tagged with each subject';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Subject::chunkById(100, function ($subjects) {
            $subjects->loadCount('pages');
            foreach ($subjects as $subject) {
                logger()->info($subject->name.' : '.$subject->pages_count);
                $subject->tagged_count = $subject->pages_count;
                $subject->save();
            }
        });

        return 0;
    }
}
