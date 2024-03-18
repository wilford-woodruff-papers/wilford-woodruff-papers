<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Search Engine
    |--------------------------------------------------------------------------
    |
    | This option controls the default search connection that gets used while
    | using Laravel Scout. This connection is used when syncing all models
    | to the search service. You should adjust this based on your needs.
    |
    | Supported: "algolia", "meilisearch", "database", "collection", "null"
    |
    */

    'driver' => env('SCOUT_DRIVER', 'algolia'),

    /*
    |--------------------------------------------------------------------------
    | Index Prefix
    |--------------------------------------------------------------------------
    |
    | Here you may specify a prefix that will be applied to all search index
    | names used by Scout. This prefix may be useful if you have multiple
    | "tenants" or applications sharing the same search infrastructure.
    |
    */

    'prefix' => env('SCOUT_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Queue Data Syncing
    |--------------------------------------------------------------------------
    |
    | This option allows you to control if the operations that sync your data
    | with your search engines are queued. When this is set to "true" then
    | all automatic data syncing will get queued for better performance.
    |
    */

    'queue' => env('SCOUT_QUEUE', false),

    /*
    |--------------------------------------------------------------------------
    | Database Transactions
    |--------------------------------------------------------------------------
    |
    | This configuration option determines if your data will only be synced
    | with your search indexes after every open database transaction has
    | been committed, thus preventing any discarded data from syncing.
    |
    */

    'after_commit' => false,

    /*
    |--------------------------------------------------------------------------
    | Chunk Sizes
    |--------------------------------------------------------------------------
    |
    | These options allow you to control the maximum chunk size when you are
    | mass importing data into the search engine. This allows you to fine
    | tune each of these chunk sizes based on the power of the servers.
    |
    */

    'chunk' => [
        'searchable' => 500,
        'unsearchable' => 500,
    ],

    /*
    |--------------------------------------------------------------------------
    | Soft Deletes
    |--------------------------------------------------------------------------
    |
    | This option allows to control whether to keep soft deleted records in
    | the search indexes. Maintaining soft deleted records can be useful
    | if your application still needs to search for the records later.
    |
    */

    'soft_delete' => false,

    /*
    |--------------------------------------------------------------------------
    | Identify User
    |--------------------------------------------------------------------------
    |
    | This option allows you to control whether to notify the search engine
    | of the user performing the search. This is sometimes useful if the
    | engine supports any analytics based on this application's users.
    |
    | Supported engines: "algolia"
    |
    */

    'identify' => env('SCOUT_IDENTIFY', false),

    /*
    |--------------------------------------------------------------------------
    | Algolia Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Algolia settings. Algolia is a cloud hosted
    | search engine which works great with Scout out of the box. Just plug
    | in your application ID and admin API key to get started searching.
    |
    */

    'algolia' => [
        'id' => env('ALGOLIA_APP_ID', ''),
        'secret' => env('ALGOLIA_SECRET', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Meilisearch Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Meilisearch settings. Meilisearch is an open
    | source search engine with minimal configuration. Below, you can state
    | the host and key information for your own Meilisearch installation.
    |
    | See: https://docs.meilisearch.com/guides/advanced_guides/configuration.html
    |
    */

    'meilisearch' => [
        'host' => env('MEILISEARCH_HOST', 'http://localhost:7700'),
        'key' => env('MEILISEARCH_KEY'),
        'search_key' => env('MEILISEARCH_SEARCH_KEY'),
        'index-settings' => [
            'resources' => [
                'filterableAttributes' => [
                    'resource_type',
                    'type',
                    'is_published',
                    'date',
                    'dates',
                    'decade',
                    'year',
                    'topics',
                    'people',
                    'places',
                    '_geo',
                    'parent_id',
                ],
                'faceting' => [
                    'maxValuesPerFacet' => 1500,
                ],
                'sortableAttributes' => [
                    'name',
                    'date',
                    'order',
                ],
                'typoTolerance' => [
                    'minWordSizeForTypos' => [
                        'oneTypo' => 5,
                        'twoTypos' => 10,
                    ],
                ],
                'stopWords' => [
                    'A',
                    'ABOUT',
                    'ACTUALLY',
                    'ALMOST',
                    'ALSO',
                    'ALTHOUGH',
                    'ALWAYS',
                    'AM',
                    'AN',
                    'AND',
                    'ANY',
                    'ARE',
                    'AS',
                    'AT',
                    'BE',
                    'BECAME',
                    'BECOME',
                    'BUT',
                    'BY',
                    'CAN',
                    'COULD',
                    'DID',
                    'DO',
                    'DOES',
                    'EACH',
                    'EITHER',
                    'ELSE',
                    'FOR',
                    'FROM',
                    'HAD',
                    'HAS',
                    'HAVE',
                    'HENCE',
                    'HOW',
                    'I',
                    'IF',
                    'IN',
                    'IS',
                    'IT',
                    'ITS',
                    'JUST',
                    'MAY',
                    'MAYBE',
                    'ME',
                    'MIGHT',
                    'MINE',
                    'MUST',
                    'MY',
                    'MINE',
                    'MUST',
                    'MY',
                    'NEITHER',
                    'NOR',
                    'NOT',
                    'OF',
                    'OH',
                    'OK',
                    'WHEN',
                    'WHERE',
                    'WHEREAS',
                    'WHEREVER',
                    'WHENEVER',
                    'WHETHER',
                    'WHICH',
                    'WHILE',
                    'WHO',
                    'WHOM',
                    'WHOEVER',
                    'WHOSE',
                    'WHY',
                    'WILL',
                    'WITH',
                    'WITHIN',
                    'WITHOUT',
                    'WOULD',
                    'YES',
                    'YET',
                    'YOU',
                    'YOUR',
                ],
                'pagination' => [
                    'maxTotalHits' => 100000,
                ],
            ],
            'dev-resources' => [
                'filterableAttributes' => [
                    'resource_type',
                    'type',
                    'is_published',
                    'date',
                    'dates',
                    'decade',
                    'year',
                    'topics',
                    'people',
                    'places',
                    '_geo',
                    'parent_id',
                ],
                'faceting' => [
                    'maxValuesPerFacet' => 1500,
                ],
                'sortableAttributes' => [
                    'name',
                    'date',
                    'order',
                ],
                'typoTolerance' => [
                    'minWordSizeForTypos' => [
                        'oneTypo' => 5,
                        'twoTypos' => 10,
                    ],
                ],
                'stopWords' => [
                    'A',
                    'ABOUT',
                    'ACTUALLY',
                    'ALMOST',
                    'ALSO',
                    'ALTHOUGH',
                    'ALWAYS',
                    'AM',
                    'AN',
                    'AND',
                    'ANY',
                    'ARE',
                    'AS',
                    'AT',
                    'BE',
                    'BECAME',
                    'BECOME',
                    'BUT',
                    'BY',
                    'CAN',
                    'COULD',
                    'DID',
                    'DO',
                    'DOES',
                    'EACH',
                    'EITHER',
                    'ELSE',
                    'FOR',
                    'FROM',
                    'HAD',
                    'HAS',
                    'HAVE',
                    'HENCE',
                    'HOW',
                    'I',
                    'IF',
                    'IN',
                    'IS',
                    'IT',
                    'ITS',
                    'JUST',
                    'MAY',
                    'MAYBE',
                    'ME',
                    'MIGHT',
                    'MINE',
                    'MUST',
                    'MY',
                    'MINE',
                    'MUST',
                    'MY',
                    'NEITHER',
                    'NOR',
                    'NOT',
                    'OF',
                    'OH',
                    'OK',
                    'WHEN',
                    'WHERE',
                    'WHEREAS',
                    'WHEREVER',
                    'WHENEVER',
                    'WHETHER',
                    'WHICH',
                    'WHILE',
                    'WHO',
                    'WHOM',
                    'WHOEVER',
                    'WHOSE',
                    'WHY',
                    'WILL',
                    'WITH',
                    'WITHIN',
                    'WITHOUT',
                    'WOULD',
                    'YES',
                    'YET',
                    'YOU',
                    'YOUR',
                ],
                'pagination' => [
                    'maxTotalHits' => 100000,
                ],
            ],
            'places' => [
                'filterableAttributes' => [
                    'types',
                    'years',
                    '_geo',
                ],
                'sortableAttributes' => [
                    'name',
                ],
                'faceting' => [
                    'maxValuesPerFacet' => 100,
                ],
                'pagination' => [
                    'maxTotalHits' => 100000,
                ],
            ],
            'dev-places' => [
                'filterableAttributes' => [
                    'type',
                    'year',
                    '_geo',
                ],
                'sortableAttributes' => [
                    'name',
                ],
                'faceting' => [
                    'maxValuesPerFacet' => 100,
                ],
                'pagination' => [
                    'maxTotalHits' => 100000,
                ],
            ],
        ],
    ],

];
