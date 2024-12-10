<?php

namespace App\Console\Commands;

use App\Models\Subject;
use Illuminate\Console\Command;

class CacheGender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cache-gender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache gender from familysearch json';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $people = Subject::query()
            ->select(['id', 'name', 'familysearch_person', 'gender'])
            ->people()
            ->whereNull('gender')
            ->whereNotNull('familysearch_person')
            ->limit(50)
            ->get();

        foreach ($people as $person) {
            $gender = data_get(
                json_decode($person->familysearch_person),
                'persons.0.gender.type'
            );
            // print_r($gender . "\n");
            if (empty($gender)) {
                logger()->info("No Gender Available\n");

                // print_r($person->familysearch_person . "\n");
                continue;
            }
            $calculatedGender = null;
            if (str($gender)->endsWith('/Female')) {
                $calculatedGender = 'F';
            } elseif (str($gender)->endsWith('/Male')) {
                $calculatedGender = 'M';
            }

            logger()->info($calculatedGender."\n");

            if (! empty($calculatedGender)) {
                $person->update([
                    'gender' => $calculatedGender,
                ]);
            }
        }
    }
}
