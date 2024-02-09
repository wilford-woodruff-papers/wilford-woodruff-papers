<?php

namespace App\Console\Commands;

use App\Jobs\NotifyUserOfRelationShipFinderCompletion;
use App\Models\Relationship;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;

class RelationshipFinderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'relationships:check {id} {isBatch?}';

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
        $isBatch = $this->argument('isBatch', false);

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
            ->limit(50)
            ->toBase()
            ->get();

        $jobs = [];

        if ($people->count() > 0) {
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
                    Artisan::call('relationships:check', [
                        'id' => $user->id,
                        'isBatch' => true,
                    ]);
                })
                ->dispatch();
        } else {
            if ($isBatch) {
                NotifyUserOfRelationShipFinderCompletion::dispatch($user);
            }
        }

        return Command::SUCCESS;
    }
}
