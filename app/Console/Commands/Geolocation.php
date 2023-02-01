<?php

namespace App\Console\Commands;

use App\Models\Subject;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class Geolocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:geo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search for addresses';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $places = Subject::whereEnabled(1)->whereHas('category', function (Builder $query) {
            $query->where('name', 'Places');
        })->get();

        foreach ($places as $place) {
            $response = \GoogleMaps::load('geocoding')
                            ->setParam(['address' => $place->name])
                            ->get();
            $place->geolocation = json_decode($response, true)['results'][0];
            $place->save();
        }

        return 0;
    }
}
