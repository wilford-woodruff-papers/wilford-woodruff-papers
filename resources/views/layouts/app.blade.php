<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <x-favicon />

        <x-open-graph-image::metatags
            title="{{ str($title ?? null)->before('|')->replaceMatches('/\[.*?\]/', '')->replace(' ', '_')->trim() }}"
        />

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
        @livewireStyles

        @include('layouts.partials.google-tag-manager-head')
        <x-clarity::script />
    </head>
    <body class="font-sans antialiased">
        @include('layouts.partials.google-tag-manager-no-script')
        <x-admin-bar />
        <x-header />
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="py-6 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <x-footer />
        @stack('modals')

        @livewireScriptConfig

        <x-constant-contact />
        @stack('scripts')
    </body>
</html>
