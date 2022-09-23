<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="facebook-domain-verification" content="jz329nocbeufu5m4s8g7dxdtz8j2qq" />

        <meta property="og:site_name" content="Wilford Woodruff Papers">

        <x-open-graph-image::metatags title="Wilford Woodruff Papers Foundation" />

        <meta property="og:description" content="Explore Wilford Woodruff's powerful eyewitness account of the Restoration">
        <meta property="og:type" content="website" />
        <meta property="og:image" content="https://wilfordwoodruffpapers.org/img/wilford-woodruff.png">
        <meta property="og:url" content="https://wilfordwoodruffpapers.org/">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="description" content="Explore Wilford Woodruff's powerful eyewitness account of the Restoration"/>
        <meta name="keywords" content="Wilford Woodruff, Restoration, Prophet, The Church of Jesus Christ of Latter-day Saints"/>

        <title>{{ $title ?? config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro&display=swap" rel="stylesheet">

        <x-favicon />

        <script src="{{ asset('js/slickscroll.min.js') }}" type="text/javascript"></script>

        <script type="text/javascript">
            /*let slick = new slickScroll.default({
                root: "body",
                duration: 400,
                easing: "easeOutQuart",
                offsets: [
                    {element: ".slow-parallax", speedY: 0.8}
                ],
                onScroll: function(){
                    console.log('Scrolling');
                }
            });*/

            /*document.querySelector("#cover").style.overflowX = "hidden";*/

        </script>

        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', () => {
                new slickScroll.default({
                    root: '.body',
                    duration: 400,
                    easing: "easeOutQuart",
                    offsets: [
                        {element: ".slow-parallax", speedY: 0.8}
                    ]
                });
            }, false);
        </script>


        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @livewireStyles

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

    </head>
    <body>
        <div class="body">

            <div class="font-sans text-gray-900 antialiased">
                {{ $slot }}
            </div>

            @if(app()->environment(['production']))
                <x-google />
                <x-facebook-pixel />
            @endif
            {{--<x-constant-contact />--}}
        </div>
    </body>
</html>
