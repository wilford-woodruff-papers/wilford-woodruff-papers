<?php

namespace App\Console\Commands;

use App\Models\RelationshipFinderQueue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ProcessRelationshipFinderQueueCommand extends Command
{
    protected $signature = 'relationships:process';

    protected $description = 'Check for pending jobs in the relationship finder queue and process them.';

    public function handle(): void
    {
        $isProgress = RelationshipFinderQueue::query()
            ->where('in_progress', true)
            ->count();

        if ($isProgress < 1) {
            $entry = RelationshipFinderQueue::query()
                ->with([
                    'user',
                ])
                ->whereNull('started_at')
                ->whereNull('finished_at')
                ->first();

            if ($entry) {
                DB::transaction(function () use ($entry) {
                    $exitCode = Artisan::call('relationships:check', [
                        'id' => $entry->user_id,
                        'entry' => $entry->id,
                    ]);

                    if ($exitCode === Command::SUCCESS) {
                        $entry->update([
                            'in_progress' => true,
                            'started_at' => now(),
                        ]);
                        $this->info('Relationship finder queue started for user '.$entry->user->name.'.');
                    }
                });
            }
        }
    }
}
