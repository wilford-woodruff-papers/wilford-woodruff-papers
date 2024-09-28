<?php

return [

    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),

    'channels' => [
        'imports' => [
            'driver' => 'single',
            'path' => storage_path('logs/imports.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
    ],

];
