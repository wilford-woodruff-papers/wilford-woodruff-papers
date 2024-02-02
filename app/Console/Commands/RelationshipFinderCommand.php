<?php

namespace App\Console\Commands;

use App\Models\Relationship;
use App\Models\RelationshipFinderQueue;
use App\Models\Subject;
use App\Models\User;
use App\Notifications\RelationshipFinderCompletedNotification;
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
    protected $signature = 'relationships:check {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check relationships for a given user id.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');

        $user = User::query()
            ->where('id', $id)
            ->firstOrFail();

        $people = Subject::query()
            ->select('id', 'name', 'pid')
            ->whereNotNull('pid')
            ->where('pid', '!=', 'n/a')
            ->whereHas('category', function ($query) {
                $query->whereIn('name', ['People'])
                    ->whereNotIn('name', ['Scriptural Figures', 'Historical Figures', 'Eminent Men and Women']);
            })
            ->where('pid', '!=', 'n/a')
            ->whereNotIn('id',
                Relationship::query()
                    ->where('user_id', $user->id)
                    ->pluck('subject_id')
                    ->all()
            )
            //->inRandomOrder()
            //->limit(500)
            ->toBase()
            ->get();

        $jobs = [];

        foreach ($people as $person) {
            if (! empty($person->pid)) {
                $jobs[] = new \App\Jobs\RelationshipFinderJob($user, $person);
            }
        }

        $batch = Bus::batch($jobs)
            ->onQueue('relationships')
            ->name('Relation Ship Finder')
            ->allowFailures()
            ->finally(function (Batch $batch) use ($user) {
                RelationshipFinderQueue::query()
                    ->where('user_id', $user->id)
                    ->update([
                        'in_progress' => false,
                        'finished_at' => now(),
                    ]);
                $user->notify(new RelationshipFinderCompletedNotification());
            })
            ->dispatch();

        return Command::SUCCESS;
    }
}
