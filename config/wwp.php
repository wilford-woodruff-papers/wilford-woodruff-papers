<?php

return [

    'admin_email' => env('ADMIN_EMAIL'),

    'form_emails' => [

        'media_request' => env('MEDIA_REQUEST_FORMS'),

        'contact' => env('CONTACT_FORM'),

        'testify' => env('TESTIFY_FORM'),

        'contest_submission' => env('CONTEST_SUBMISSION_FORM'),

    ],

    'list_memberships' => [

        'conference' => env('CONFERENCE_LIST_ID'),

        'newsletter' => env('NEWSLETTER_LIST_ID'),

        'immersive_ai_experience' => env('IMMERSIVE_AI_LIST_ID'),

    ],

    'ai_download_path' => env('AI_DOWNLOAD_PATH'),

    'api_token' => env('WWP_API_TOKEN'),

    'ftp' => [
        'username' => env('FTP_USERNAME'),
        'password' => env('FTP_PASSWORD'),
    ],

];
