<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro&display=swap" rel="stylesheet">

        <x-favicon />

        <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @stack('styles')
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.1/dist/alpine.min.js" defer></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script async data-uid="a6d02620a7" src="https://wilford-woodruff-papers.ck.page/a6d02620a7/index.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js" charset="utf-8"></script>
    </head>
    <body>
        <x-header />
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>

    <x-subject-modal />
    <x-footer />
    <x-facebook-pixel />
    <script async data-uid="7ce7f1665b" src="https://wilford-woodruff-papers.ck.page/7ce7f1665b/index.js"></script>
    @stack('scripts')
</html>
