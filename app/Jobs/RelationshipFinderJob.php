<?php

namespace App\Jobs;

use App\Http\Integrations\FamilySearch\RelationshipFinder;
use App\Http\Integrations\FamilySearch\Requests\Relationship as RelationshipRequest;
use App\Models\Relationship;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Saloon\RateLimitPlugin\Helpers\ApiRateLimited;

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

    public function middleware(): array
    {
        return [
            new ApiRateLimited(),
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (! empty($this->batch()) && $this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }

        $familysearch = new RelationshipFinder();
        $request = new RelationshipRequest($this->user->familysearch_token, $this->person->pid);

        $response = $familysearch->send($request);

        // TODO: Check for 401 which means we need to reauthenticate with refresh token
        //        $response = Http::withToken($this->user->familysearch_token)
        //            ->acceptJson()
        //            ->get(config('services.familysearch.base_uri').'/platform/tree/persons/CURRENT/relationships/'.$this->person->pid);

        if ($response->ok()) {
            $persons = collect(data_get($response->json(), 'persons'));
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
        } elseif ($response->status() === 204) {
            $relationship = Relationship::updateOrCreate([
                'subject_id' => $this->person->id,
                'user_id' => $this->user->id,
            ],
                [
                    'distance' => 0,
                ]);
        } else {
            info('HTTP Status: '.$response->status().' for '.$this->person->pid);
        }
    }
}
