<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      prefix="og: https://ogp.me/ns#"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="facebook-domain-verification" content="jz329nocbeufu5m4s8g7dxdtz8j2qq" />

        <meta property="og:site_name" content="Wilford Woodruff Papers">


        @if (empty($openGraph))
            <x-open-graph-image::metatags title="{{ str($title ?? null)->before('|')->replaceMatches('/\[.*?\]/', '')->replace(' ', '_')->trim() }}" />
            <meta name="description" property="og:description" content="Explore Wilford Woodruff's powerful eyewitness account of the Restoration"/>
        @else
            {!! $openGraph !!}
        @endif


        <meta property="og:description" content="Explore Wilford Woodruff's powerful eyewitness account of the Restoration">
        <meta property="og:type" content="website" />
        {{--<meta property="og:image" content="https://wilfordwoodruffpapers.org/img/wilford-woodruff.png">--}}
        <meta name="url" property="og:url" content="{{ request()->url() }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="keywords" content="Wilford Woodruff, Restoration, Prophet, The Church of Jesus Christ of Latter-day Saints"/>

        <title>{{ $title ?? config('app.name') }}</title>

        {!! $canonical ?? '' !!}

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro&display=swap" rel="stylesheet">

        <x-favicon />

        <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
        @filamentStyles
        @filamentScripts
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
        @stack('styles')
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        <!-- Scripts -->
        @include('layouts.partials.google-tag-manager-head')
    </head>
    <body>
        <x-relative-finder-popup />
        @include('layouts.partials.google-tag-manager-no-script')
        <x-admin-bar />
        <x-header />
        <div class="font-sans antialiased text-gray-900">
            {{ $slot }}
        </div>

        <x-subject-modal />
        <x-footer />

        @if(app()->environment(['production']))
            <x-google />
            <x-facebook-pixel />
        @endif


        @livewireScriptConfig


        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js" charset="utf-8"></script>

        @stack('scripts')

        <script>
            function copyShortUrlToClipboard(event) {
                let shortUrl = event.dataset.url;
                navigator.clipboard.writeText(shortUrl).then(() => {
                    // Alert the user that the action took place.
                    // Nobody likes hidden stuff being done under the hood!
                    console.log(shortUrl + " copied to clipboard");
                });
            }
        </script>

        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('scroll', function() {
                    scrollTo({top: 0, behavior: 'smooth'});
                });
            });
        </script>
        @livewire('wire-elements-modal')
        <x-constant-contact />

    </body>
</html>
