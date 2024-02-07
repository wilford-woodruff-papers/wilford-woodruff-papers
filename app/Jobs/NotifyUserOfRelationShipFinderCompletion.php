<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\RelationshipFinderCompletedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfRelationShipFinderCompletion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $topRelationships = $this
            ->user
            ->relationships()
            ->orderBy('distance')
            ->limit(10)
            ->get();

        $topRelationships
            ->loadMissing([
                'person',
            ]);

        $this
            ->user
            ->notify(
                new RelationshipFinderCompletedNotification(
                    relationships: $topRelationships,
                )
            );
    }
}
