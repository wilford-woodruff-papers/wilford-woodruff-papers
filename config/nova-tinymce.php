<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    |
    | Here you can define the options that are passed to all NovaTinyMCE
    | fields by default.
    |
    */

    'default_options' => [
        'content_css' => '/vendor/tinymce/skins/ui/oxide/content.min.css',
        'skin_url' => '/vendor/tinymce/skins/ui/oxide',
        'path_absolute' => '/',
        'plugins' => [
            'lists', 'preview', 'anchor', 'pagebreak', 'image', 'wordcount', 'fullscreen', 'directionality',
        ],
        'toolbar' => 'undo redo | styles | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | image | bullist numlist outdent indent | link',

        /*'plugins' => [
            'lists preview hr anchor pagebreak image wordcount fullscreen directionality paste textpattern link code',
        ],
        'toolbar' => 'undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | link image | bullist numlist outdent indent | code',*/
        'relative_urls' => false,
        'link_context_toolbar' => true,
        'use_lfm' => true,
        'lfm_url' => 'filemanager',
    ],
];
