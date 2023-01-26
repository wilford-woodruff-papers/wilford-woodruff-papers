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

        <!-- Slickscroll -->
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', () => {
                new slickScroll.default({
                    root: document.body,
                    duration: 400,
                    easing: "easeOutQuart",
                    offsets: [
                        {element: ".slow-parallax", speedY: 0.8},
                        {element: ".faster-parallax", speedY: 0.7}
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
            #landing.section {
                width: 100vw;
                height: 100vh;
                position: relative;
            }
            #landing.section .back-image {
                position: absolute;
                left: 0;
                right: 0;
                margin-left: auto;
                margin-right: auto;
                text-align: center;
                z-index: -1;
            }
            #landing.section .back-image img {

            }
            #landing.section .align-wrapper {
                width: 100%;
                text-align: center;
            }
            #landing.section .align-wrapper .content {
                width: 60%;
                margin: 0 auto;
                text-align: center;
            }
            #landing.section .align-wrapper .content * {
                margin-bottom: 5vh;
            }
            #content.section {
                position: relative;
                width: 100vw;
                padding: 0 10vw;
                margin-top: 15vh;
                box-sizing: border-box;
            }
            #content.section .back-image-slide {
                position: absolute;
                text-align: center;
                left: -20vw;
                right: -20vw;
                top: -10vh;
                z-index: -1;
            }
            #content.section .back-image-slide .stack {
                display: inline-block;
            }
            #content.section .back-image-slide .stack.offset {
                position: relative;
                top: 10vh;
                opacity: 0.4;
            }
            #content.section .back-image-slide .stack:not(:last-child) {
                margin-right: 5vh;
            }
            #content.section .back-image-slide img {
                display: block;
                height: 40vh;
                width: 35vw;
                object-fit: cover;
                opacity: 0.3;
                border-radius: 30px;
                margin-bottom: 8vh;
            }
            #content.section .aligner {
                width: 100%;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            #content.section .aligner .right, #content.section .aligner .left {
                display: block;
                margin-bottom: 15vh;
            }
            #content.section .aligner .right .button, #content.section .aligner .left .button {
                margin-top: 5vh;
            }
            #content.section .aligner .right .heart, #content.section .aligner .left .heart {
                position: relative;
                top: 50%;
                left: 0.2em;
                fill: #FF5722;
                transform: translateY(30%);
                width: 1.7em;
            }
            #content.section .aligner .right {
                align-self: flex-end;
                text-align: right;
            }
        </style>
        @include('layouts.partials.google-tag-manager-head')
    </head>
    <body>
        @include('layouts.partials.google-tag-manager-no-script')
        {{ $slot }}


            <div class="font-sans text-gray-900 antialiased">

            </div>

            @if(app()->environment(['production']))
                <x-google />
                <x-facebook-pixel />
            @endif
            <x-constant-contact />

    </body>
</html>
