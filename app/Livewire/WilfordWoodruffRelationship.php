<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

#[Lazy]
class WilfordWoodruffRelationship extends Component
{
    public ?string $description;

    public ?int $distance;

    public function render()
    {
        $user = auth()->user();
        if (empty($user->ww_relationship_distance)) {
            $response = Http::withToken($user->familysearch_token)
                ->withHeaders([
                    'Accept' => 'application/json',
                ])
                ->timeout(20)
                ->get(
                    config('services.familysearch.base_uri').'/platform/tree/persons/CURRENT/relationships/KWNT-8NB'
                );

            if ($response->ok()) {
                $persons = collect(data_get($response->json(), 'persons'));
                $length = $persons->count();
                $relative = $persons->pop();
                $relation = data_get($relative, 'display.relationshipDescription');
                $user->update([
                    'ww_relationship_distance' => $length,
                    'ww_relationship_description' => str($relation)->after('My '),
                ]);
                $this->distance = $user->ww_relationship_distance;
                $this->description = $user->ww_relationship_description;
            }
        } else {
            $this->distance = $user->ww_relationship_distance;
            $this->description = $user->ww_relationship_description;
        }

        return view('livewire.wilford-woodruff-relationship');
    }
}
