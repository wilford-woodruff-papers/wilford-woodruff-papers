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
    <x-clarity::script />
</head>
<body>
{{--<x-relative-finder-popup />--}}
@include('layouts.partials.google-tag-manager-no-script')
{{--<x-admin-bar />--}}

<header class="relative z-10">
    <div class="absolute w-full h-32 bg-gradient-to-t from-transparent to-white z-1"></div>
    <nav class="flex relative z-10 justify-between items-center p-3 mx-auto max-w-7xl lg:px-8" aria-label="Global">
        <a href="{{ route('home') }}" class="p-1.5 -m-1.5">
            <span class="sr-only">Wilford Woodruff Papers</span>
            <img class="-mt-4 w-auto h-16" src="{{ asset('img/image-logo.png') }}" alt="">
        </a>
        {{--<div class="flex lg:hidden">
            <button type="button" class="inline-flex justify-center items-center p-2.5 -m-2.5 text-gray-700 rounded-md">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>--}}
        <div class="hidden pt-3 font-sans lg:flex lg:gap-x-12">
            <a href="{{ route('documents') }}" class="text-base font-medium leading-6 text-primary">
                Documents
            </a>
            <a href="#" class="text-base font-medium leading-6 text-primary">
                Study
            </a>
            <a href="#" class="text-base font-medium leading-6 text-primary">
                Explore
            </a>
            <a href="#" class="text-base font-medium leading-6 text-primary">
                Get Involved
            </a>
            <a href="#" class="text-base font-medium leading-6 text-primary">
                About
            </a>
            <a href="#" class="text-base font-medium leading-6 text-primary">
                Donate
            </a>

            <a href="#" class="text-base font-semibold leading-6 text-primary">
                <x-heroicon-o-magnifying-glass class="w-6 h-6" />
            </a>
        </div>
    </nav>
    {{--<!-- Mobile menu, show/hide based on menu open state. -->
    <div class="lg:hidden" role="dialog" aria-modal="true">
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class="fixed inset-0 z-10"></div>
        <div class="overflow-y-auto fixed inset-y-0 right-0 z-10 py-6 px-6 w-full bg-white sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex justify-between items-center">
                <a href="#" class="p-1.5 -m-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="w-auto h-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
                </a>
                <button type="button" class="p-2.5 -m-2.5 text-gray-700 rounded-md">
                    <span class="sr-only">Close menu</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flow-root mt-6">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="py-6 space-y-2">
                        <a href="#" class="block py-2 px-3 -mx-3 text-base font-semibold leading-7 text-gray-900 rounded-lg hover:bg-gray-50">Product</a>
                        <a href="#" class="block py-2 px-3 -mx-3 text-base font-semibold leading-7 text-gray-900 rounded-lg hover:bg-gray-50">Features</a>
                        <a href="#" class="block py-2 px-3 -mx-3 text-base font-semibold leading-7 text-gray-900 rounded-lg hover:bg-gray-50">Marketplace</a>
                        <a href="#" class="block py-2 px-3 -mx-3 text-base font-semibold leading-7 text-gray-900 rounded-lg hover:bg-gray-50">Company</a>
                    </div>
                    <div class="py-6">
                        <a href="#" class="block py-2.5 px-3 -mx-3 text-base font-semibold leading-7 text-gray-900 rounded-lg hover:bg-gray-50">Log in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
</header>


<div class="min-h-screen font-sans antialiased text-gray-900">
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
<!-- Tippy.js -->
<!-- https://atomiks.github.io/tippyjs/v6 -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script>
    document.addEventListener('alpine:init', () => {
        // Magic: $tooltip
        Alpine.magic('tooltip', el => message => {
            let instance = tippy(el, { content: message, trigger: 'manual' })

            instance.show()

            setTimeout(() => {
                instance.hide()

                setTimeout(() => instance.destroy(), 150)
            }, 2000)
        })

        // Directive: x-tooltip
        Alpine.directive('tooltip', (el, { expression }) => {
            tippy(el, { content: expression, allowHTML: true })
        })
    })
</script>
@livewire('wire-elements-modal')
<x-constant-contact />

</body>
</html>
