<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'temp' => [
            'driver' => 'local',
            'root' => storage_path('tmp'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        'lfm' => ['driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => '',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'board_members' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'board-members',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'maps' => [
            //            'driver' => 'local',
            //            'root' => storage_path('app/maps'),
            //            'throw' => false,
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'maps',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'content_pages' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'content-pages',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'media' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'media',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'media_library' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'media-library',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'authors' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'authors',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'submissions' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'submissions',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'job_opportunities' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'job-opportunities',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'announcements' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'announcements',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'updates' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'updates',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'testimonials' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'testimonials',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'content-pages' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'content-pages',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'open-graph' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'open-graph',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'exports' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'exports',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'partners' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'partners',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'contest_submissions' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'contest_submissions',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'profile' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'profile',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'backups' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'root' => 'backups',
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

        'instagram' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'spaces' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'url' => env('DO_SPACES_URL'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

        'lasso' => [
            'driver' => 's3',
            'key' => env('LASSO_DO_SPACES_KEY'),
            'secret' => env('LASSO_DO_SPACES_SECRET'),
            'region' => env('LASSO_DO_SPACES_REGION'),
            'bucket' => env('LASSO_DO_SPACES_BUCKET'),
            'url' => env('LASSO_DO_SPACES_URL'),
            'endpoint' => env('LASSO_DO_SPACES_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
