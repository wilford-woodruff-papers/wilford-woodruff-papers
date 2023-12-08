<?php

namespace App\Console\Commands;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class RelationshipFinderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'relationships {pid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pid = $this->argument('pid');

        $user = User::query()
            ->where('pid', $pid)
            ->firstOrFail();

        $people = Subject::query()
            ->select('id', 'name', 'pid')
            ->whereNotNull('pid')
            ->whereHas('category', function ($query) {
                $query->whereIn('name', ['People'])
                    ->whereNotIn('name', ['Scriptural Figures', 'Historical Figures', 'Eminent Men and Women']);
            })
            ->where('pid', '!=', 'n/a')
            ->inRandomOrder()
            ->limit(500)
            ->toBase()
            ->get();

        $jobs = [];

        foreach ($people as $person) {
            $jobs[] = new \App\Jobs\RelationshipFinderJob($user, $person);
        }

        $batch = Bus::batch($jobs)
            ->onQueue('relationships')
            ->name('Relation Ship Finder')
            ->allowFailures()
            ->finally(function (Batch $batch) {
                // TODO:
            })
            ->dispatch();

        return Command::SUCCESS;
    }
}
