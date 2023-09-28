<?php

namespace App\Console\Commands;

use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Console\Command;
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
        //$index = $client->index((app()->environment('production') ? 'places' : 'dev-places'));
        $places = Subject::query()
            ->select([
                'id',
                'name',
                'latitude',
                'longitude',
                'total_usage_count',
                'tagged_count',
                'text_count',
            ])
            ->with([
                'pages' => function ($query) {
                    $query
                        ->select([
                            'id',
                            'parent_item_id',
                            'first_date',
                        ])
                        ->whereRelation('parent', 'enabled', true);
                },
            ])
            ->places()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $bar = $this->output->createProgressBar(count($places));

        $client->index($indexName)
            ->addDocuments(
                $places->map(function ($place) use ($bar) {
                    $bar->advance();

                    return [
                        'id' => $place->id,
                        'name' => $place->name,
                        'years' => $place
                            ->pages
                            ->map(function ($page) {
                                return ! empty($page->first_date) ? Carbon::make($page->first_date)?->year : null;
                            })
                            ->unique()
                            ->filter()
                            ->values()
                            ->all(),
                        'types' => $place
                            ->pages
                            ->map(function ($page) {
                                return $page->parent?->type?->name;
                            })
                            ->unique()
                            ->filter()
                            ->values()
                            ->all(),
                        '_geo' => [
                            'lat' => $place->latitude,
                            'lng' => $place->longitude,
                        ],
                        'usages' => $place->getCount(),
                    ];
                })
                    ->toArray()
            );
        $bar->finish();
        $this->info("\n");
        $this->info("Done indexing places to: $indexName");
    }
}
