<?php

namespace App\Console\Commands;

use App\Models\Subject;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Meilisearch\Client;

class IndexPlacesForMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'places:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index places for map searching and filtering';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $indexName = (app()->environment('production') ? 'places' : 'dev-places');
        $this->info("Using index: $indexName");

        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $client
            ->index($indexName)
            ->deleteAllDocuments();
        $this->info("All documents deleted from index: $indexName \n");

        $placesQuery = Subject::query()
            ->select([
                'subjects.id as place_id',
                'subjects.name',
                'subjects.latitude',
                'subjects.longitude',
                'subjects.total_usage_count',
                DB::raw('YEAR(pages.first_date) as year'),
                'items.id as doc_id',
                'pages.id as page_id',
                'types.name as type',
            ])
            ->join('page_subject', 'page_subject.subject_id', '=', 'subjects.id')
            ->join('pages', 'page_subject.page_id', '=', 'pages.id')
            ->join('items', 'pages.parent_item_id', '=', 'items.id')
            ->join('types', 'items.type_id', '=', 'types.id')
            ->where('items.enabled', true)
            ->whereNotNull('pages.first_date')
            ->places()
            ->whereNotNull('subjects.latitude')
            ->whereNotNull('subjects.longitude');

        $rows = (clone $placesQuery)->count();
        $bar = $this->output->createProgressBar(intval($rows / 500));

        $placesQuery->chunk(500, function (Collection $places) use ($client, $indexName, $bar) {
            $client->index($indexName)
                ->addDocuments(
                    $places->map(function ($place) {

                        return [
                            'id' => $place->place_id.'_'.$place->page_id,
                            'place' => $place->place_id,
                            'document' => $place->doc_id,
                            'page' => $place->page_id,
                            'name' => $place->name,
                            'type' => $place->type,
                            'year' => $place->year,
                            '_geo' => [
                                'lat' => $place->latitude,
                                'lng' => $place->longitude,
                            ],
                        ];
                    })
                        ->toArray()
                );
            $bar->advance();
        }, $column = 'subjects.id');

        $bar->finish();
        $this->info("\n");
        $this->info("Done Indexing $rows Places to $indexName");

        activity('background-logs')
            ->event('places:index')
            ->withProperties([
                "Indexed $rows Places to $indexName",
            ])
            ->log('Index Places for Map Searching and Filtering');
    }
}
