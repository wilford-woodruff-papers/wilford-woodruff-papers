<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="facebook-domain-verification" content="jz329nocbeufu5m4s8g7dxdtz8j2qq" />

    <meta property="og:site_name" content="Wilford Woodruff Papers">
    <meta property="og:title" content="Wilford Woodruff Papers Foundation">
    <meta property="og:description" content="Explore Wilford Woodruff's powerful eyewitness account of the Restoration">
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://wilfordwoodruffpapers.org/img/wilford-woodruff.png">
    <meta property="og:url" content="https://wilfordwoodruffpapers.org/">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="description" content="Explore Wilford Woodruff's powerful eyewitness account of the Restoration"/>
    <meta name="keywords" content="Wilford Woodruff, Restoration, Prophet, The Church of Jesus Christ of Latter-day Saints"/>

    <title>{{ $item->name }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro&display=swap" rel="stylesheet">

    <x-favicon />

    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">

    <!-- Styles -->
    <!--
        <table>
            <tr>
                <th></th>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
     -->
    <link rel="stylesheet" href="{{ mix('css/transcript.css') }}">

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body>
    <div class="max-w-7xl mx-auto p-6 lg:p-12">
        <h1 class="text-2xl font-medium py-4">{{ $item->name }}</h1>
        <h2 class="text-xl font-semibold pb-6">Document Transcript</h2>
        @foreach($item->pages as $page)
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-2 bg-white text-sm text-gray-500"> Page {{ $page->order }} </span>
                </div>
            </div>
            <div class="font-serif metadata my-4">
                {!! $page->text() !!}
            </div>
        @endforeach
    </div>

    @if(app()->environment(['production']))
        <x-google />
        <x-facebook-pixel />
    @endif

</body>
</html>



