<?php

namespace App\Jobs;

use App\Models\Relationship;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class RelationshipFinderJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;

    public \stdClass $person;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $person)
    {
        $this->user = $user;
        $this->person = $person;
    }

    /*public function middleware(): array
    {
        return [
            new RateLimited('relationships'),
        ];
    }*/

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (! empty($this->batch()) && $this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }

        $response = Http::withToken($this->user->familysearch_token)
            ->acceptJson()
            ->get(config('services.familysearch.base_uri').'/platform/tree/persons/CURRENT/relationships/'.$this->person->pid);

        if ($response->ok()) {
            $persons = collect($response->json('persons'));
            $length = $persons->count();
            $relative = $persons->pop();
            $relation = data_get($relative, 'display.relationshipDescription');
            $relationship = Relationship::updateOrCreate([
                'subject_id' => $this->person->id,
                'user_id' => $this->user->id,
            ],
                [
                    'distance' => $length,
                    'description' => str($relation)->after('My '),
                ]);
        }
    }
}
