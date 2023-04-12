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
</head>
<body>
    <div class="p-6 mx-auto max-w-7xl lg:p-12">
        <h1 class="py-4 text-2xl font-medium">{{ $item->name }}</h1>
        <h2 class="pb-6 text-xl font-semibold">Document Transcript</h2>
        @foreach($item->pages as $page)
            <div class="relative">
                <div class="flex absolute inset-0 items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="flex relative justify-center items-center">
                    <span class="px-2 text-sm text-gray-500 bg-white"> Page {{ $page->order }} </span>
                    @auth()
                        @hasanyrole('Super Admin|CFM Research')
                            <span class="px-2 bg-white">
                                <button type="button"
                                        title="Copy Short URL"
                                        data-url="{{ route('short-url.page', ['hashid' => $page->hashid()]) }}"
                                        onclick="copyShortUrlToClipboard(this)"
                                        class="inline-flex items-center p-1 border border-transparent shadow-sm text-white bg-secondary hover:bg-secondary-80% focus:outline-none focus:ring-2 focus:ring-offset-2">
                                    <!-- Heroicon name: outline/clipboard-copy -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                    </svg>
                                </button>
                            </span>
                                <span class="px-2 bg-white">
                                <a href="{{ route('short-url.page', ['hashid' => $page->hashid()]) }}"
                                   class="inline-flex items-center p-1 border border-transparent shadow-sm text-white bg-secondary hover:bg-secondary-80% focus:outline-none focus:ring-2 focus:ring-offset-2" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </span>
                        @endif
                    @endauth

                </div>
            </div>
            <div class="my-4 font-serif metadata">
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



