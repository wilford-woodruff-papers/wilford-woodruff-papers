<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class HistoricalEvents extends Component
{
    public $date = null;

    public $readyToLoad = false;

    public function loadEvents()
    {
        $this->readyToLoad = true;
    }

    public function mount($date)
    {
        $this->date = $date;
    }

    public function render()
    {
        $events = [];
        if ($this->readyToLoad) {
            $url = "https://api.api-ninjas.com/v1/historicalevents?year={$this->date->year}&month={$this->date->month}";
            $response = Http::withHeaders([
                'X-Api-Key' => config('services.api-ninja.key'),
            ])
                ->get($url);
            if ($response->ok()) {
                $events = collect($response
                    ->json())
                    ->map(function ($event) {
                        return [
                            'title' => $event['event'],
                        ];
                    })
                    ->toArray();
            }
        }

        return view('livewire.historical-events', [
            'events' => $events,
        ]);
    }
}
