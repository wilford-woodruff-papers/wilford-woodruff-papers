<?php

return [
    'image' => [
        'extension' => 'jpg',
        'quality' => 100,
        'width' => 1200,
        'height' => 630,
    ],

    // The cache location to use.
    'storage' => [
        'disk' => 'open-graph',
        'path' => 'social',
    ],

    // Whether to use the browse URL instead of the HTML input.
    // This is slower, but makes fonts available.
    // Alternative: http
    'method' => 'html',

    'metatags' => [
        'og:title' => 'title',
        'og:description' => 'description',
        'og:type' => 'type',
        'og:url' => 'url',
    ],
];
