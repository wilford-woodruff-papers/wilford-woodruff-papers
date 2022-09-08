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

    ],

];
