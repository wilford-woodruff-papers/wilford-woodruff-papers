<?php

namespace App\Console\Commands;

use App\Jobs\NotifyUserOfRelationShipFinderCompletion;
use App\Models\Relationship;
use App\Models\RelationshipFinderQueue;
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
    protected $signature = 'relationships:check {id} {entry?}';

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
        $entry = RelationshipFinderQueue::find($this->argument('entry'));

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
            ->name('Relationship Finder')
            ->allowFailures()
            ->finally(function (Batch $batch) use ($user) {
                RelationshipFinderQueue::query()
                    ->where('user_id', $user->id)
                    ->update([
                        'in_progress' => false,
                        'finished_at' => now(),
                    ]);
                NotifyUserOfRelationShipFinderCompletion::dispatch($user);
            })
            ->dispatch();

        if ($entry) {
            $entry->update([
                'batch_id' => $batch->id,
            ]);
        }

        return Command::SUCCESS;
    }
}
