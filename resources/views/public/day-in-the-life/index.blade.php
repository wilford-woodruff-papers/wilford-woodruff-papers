<x-guest-layout>
    <x-slot name="title">
        Day in the Life | {{ config('app.name') }}
    </x-slot>
    <x-banner-image :image="asset('img/banners/places.png')"
                    :text="'Day in the Life'"
    />
    <div x-data="{}"
         class="py-12 px-12 mx-auto max-w-7xl">
        <div class="flex flex-col gap-y-12">

            <div class="flex gap-x-12 justify-center items-center">
                <div>
                    @if(! empty($previousDay))
                        <a href="{{ route('day-in-the-life', ['date' => $previousDay]) }}"
                           title="{{ $previousDay }}"
                           class="p-2 text-white rounded-full shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 font-semibold text-secondary">
                                <path fill-rule="evenodd" d="M7.72 12.53a.75.75 0 010-1.06l7.5-7.5a.75.75 0 111.06 1.06L9.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                </div>
                <h1 class="text-4xl font-semibold text-center">
                    {{ $date->toFormattedDateString() }}
                </h1>
                <div>
                    @if(! empty($nextDay))
                        <a href="{{ route('day-in-the-life', ['date' => $nextDay]) }}"
                           title="{{ $nextDay }}"
                           class="p-2 text-white rounded-full shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 font-semibold text-secondary">
                                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <div class="relative bg-white">
                <ul role="list" class="flex flex-col gap-6 md:flex-row md:items-center">
                    @if($pages->count() > 0)
                        <li class="flex-1 bg-white divide-y divide-gray-200 shadow">
                            <a href="#documents">
                                <div class="flex justify-between items-center py-2 px-6 space-x-6 w-full">
                                    <div class="flex-1 truncate">
                                        <div class="flex items-center space-x-3">
                                            <h3 class="text-2xl font-semibold text-gray-900 truncate">
                                                {{ $pages->count() }}
                                            </h3>
                                        </div>
                                        <p class="mt-1 text-lg font-semibold text-secondary truncate">
                                            {{ str('Document')->plural($pages->count()) }}
                                        </p>
                                    </div>
                                    <div class="flex flex-shrink-0 justify-center items-center w-10 h-10 bg-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif

                    @if(! empty($people))
                        <li class="flex-1 bg-white divide-y divide-gray-200 shadow">
                            <a href="#people">
                                <div class="flex justify-between items-center py-2 px-6 space-x-6 w-full">
                                    <div class="flex-1 truncate">
                                        <div class="flex items-center space-x-3">
                                            <h3 class="text-2xl font-semibold text-gray-900 truncate">
                                                {{ $people->count() }}
                                            </h3>
                                        </div>
                                        <p class="mt-1 text-lg font-semibold text-secondary truncate">
                                            {{ str('Person')->plural($people->count()) }}
                                        </p>
                                    </div>
                                    <div class="flex flex-shrink-0 justify-center items-center w-10 h-10 bg-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if(! empty($places))
                        <li class="flex-1 bg-white divide-y divide-gray-200 shadow">
                            <a href="#places">
                                <div class="flex justify-between items-center py-2 px-6 space-x-6 w-full">
                                    <div class="flex-1 truncate">
                                        <div class="flex items-center space-x-3">
                                            <h3 class="text-2xl font-semibold text-gray-900 truncate">
                                                {{ $places->count() }}
                                            </h3>
                                        </div>
                                        <p class="mt-1 text-lg font-semibold text-secondary truncate">
                                            {{ str('Place')->plural($places->count()) }}
                                        </p>
                                    </div>
                                    <div class="flex flex-shrink-0 justify-center items-center w-10 h-10 bg-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if($events->count() > 0)
                        <li class="flex-1 bg-white divide-y divide-gray-200 shadow">
                            <a href="#events">
                                <div class="flex justify-between items-center py-2 px-6 space-x-6 w-full">
                                    <div class="flex-1 truncate">
                                        <div class="flex items-center space-x-3">
                                            <h3 class="text-2xl font-semibold text-gray-900 truncate">
                                                {{ $events->count() }}
                                            </h3>
                                        </div>
                                        <p class="mt-1 text-lg font-semibold text-secondary truncate">
                                            {{ str('Event')->plural($events->count()) }}
                                        </p>
                                    </div>
                                    <div class="flex flex-shrink-0 justify-center items-center w-10 h-10 bg-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if($quotes->count() > 0)
                        <li class="flex-1 bg-white divide-y divide-gray-200 shadow">
                            <a href="#quotes">
                                <div class="flex justify-between items-center py-2 px-6 space-x-6 w-full">
                                    <div class="flex-1 truncate">
                                        <div class="flex items-center space-x-3">
                                            <h3 class="text-2xl font-semibold text-gray-900 truncate">
                                                {{ $quotes->count() }}
                                            </h3>
                                        </div>
                                        <p class="mt-1 text-lg font-semibold text-secondary truncate">
                                            {{ str('Quote')->plural($quotes->count()) }}
                                        </p>
                                    </div>
                                    <div class="flex flex-shrink-0 justify-center items-center w-10 h-10 bg-secondary">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif
                </ul>





                {{--<div class="flex items-center">
                    @if($pages->count() > 0)
                        <div class="flex justify-center py-4 px-12 text-lg text-center text-secondary">
                            <a href="#documents">Documents</a>
                        </div>
                    @endif
                    @if(! empty($people))
                        <div class="flex justify-center py-4 px-12 text-lg text-center text-secondary">
                            <a href="#people">People</a>
                        </div>
                    @endif
                    @if(! empty($places))
                        <div class="flex justify-center py-4 px-12 text-lg text-center text-secondary">
                            <a href="#places">Places</a>
                        </div>
                    @endif
                    @if($events->count() > 0)
                        <div class="flex justify-center py-4 px-12 text-lg text-center text-secondary">
                            <a href="#events">Events</a>
                        </div>
                    @endif
                    @if($quotes->count() > 0)
                        <div class="flex justify-center py-4 px-12 text-lg text-center text-secondary">
                            <a href="#quotes">Quotes</a>
                        </div>
                    @endif
                </div>--}}
            </div>

            <div class="grid grid-cols-3 gap-x-12">
                <div class="col-span-2">
                    <div class="pb-6 text-3xl font-semibold">
                        {{ $date->format('F d, Y ~ l') }}
                    </div>
                    <div class="text-2xl leading-relaxed">
                        {!! $content !!}
                    </div>
                </div>
                <div>
                    <img src="{{ $day->first()->getfirstMediaUrl(conversionName: 'thumb') }}"
                         alt=""
                         class="w-full h-auto cursor-pointer"
                         x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $day->first()->id }}})"
                    />
                </div>
                @if(! empty($topics))
                    <div class="col-span-3 mt-6">
                        <ul class="grid grid-flow-col auto-cols-max gap-3">
                            @foreach($topics as $topic)
                                <li class="">
                                    <a href="{{ route('subjects.show', ['subject' => $topic->slug]) }}"
                                       class="inline-flex items-center py-1 px-3 text-base text-white bg-secondary"
                                       target="_blank"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-0.5 w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        {{ $topic->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                @endif
            </div>

            @if($pages->count() > 0)
                <div>
                    <div id="documents">
                        <h2 class="my-8 text-2xl font-semibold">
                            Documents
                        </h2>
                    </div>
                    @if($pages->count() > 3)
                        <div class="grid grid-cols-1 gap-x-8 gap-y-20 mx-auto mt-16 max-w-2xl lg:grid-cols-3 lg:mx-2 lg:max-w-none">
                            @foreach ($pages as $page)
                                <article class="flex flex-col justify-between items-start cursor-pointer"
                                         x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $page->id }}})">
                                    <div
                                       class="w-full"
                                    >

                                        <div class="relative w-full">
                                            <img src="{{ $page->getfirstMediaUrl(conversionName: 'thumb') }}"
                                                 alt=""
                                                 class="object-cover w-full bg-gray-100 aspect-[16/9] sm:aspect-[2/1] lg:aspect-[3/2]">
                                            <div class="absolute inset-0 ring-1 ring-inset ring-gray-900/10"></div>
                                        </div>
                                        <div class="max-w-xl">
                                            <div class="relative group">
                                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                                    <span class="absolute inset-0"></span>
                                                    {!! str($page->parent?->name)->remove('[[')->remove(']]') !!}
                                                </h3>
                                                <div class="mt-5 text-sm leading-6 text-gray-600 line-clamp-3">
                                                    {!!
                                                            strip_tags(
                                                                str($page->transcript)
                                                                    ->extractContentOnDate($date)
                                                                    ->addSubjectLinks()
                                                                    ->addScriptureLinks()
                                                                    ->removeQZCodes(false)
                                                                    ->replace('&amp;', '&')
                                                                    ->replace('<s>', '')
                                                                    ->replace('</s>', '')
                                                                )
                                                        !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-16">
                            @foreach($pages as $page)
                                <article x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $page->id }}})">
                                    <div class="grid grid-cols-2 gap-x-4">
                                        <div class="col-span-1 px-8 @if($loop->odd) order-0 @else order-1 @endif">
                                            <img src="{{ $page->getfirstMediaUrl(conversionName: 'thumb') }}"
                                                 alt=""
                                                 class="w-full h-auto" />
                                        </div>
                                        <div class="col-span-1 @if($loop->odd) order-1 text-right @else order-0 text-left @endif">
                                            <div class="flex flex-col gap-y-4 justify-between py-12 h-full">
                                                <div>
                                                    <div class="text-xl cursor-pointer text-secondary"
                                                         x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $page->id }}})">
                                                        {{ $page->parent?->name }}
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="text-lg line-clamp-6">
                                                        {!!
                                                            str($page->transcript)
                                                                ->extractContentOnDate($date)
                                                                ->addSubjectLinks()
                                                                ->addScriptureLinks()
                                                                ->removeQZCodes(false)
                                                                ->replace('&amp;', '&')->replace('<s>', '')
                                                                ->replace('</s>', '')
                                                        !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            @if(! empty($people))
                <div>
                    <div id="people">
                        <h2 class="my-8 text-2xl font-semibold">
                            People
                        </h2>
                    </div>
                    <div class="grid grid-cols-1 gap-2 lg:grid-cols-3">
                        @foreach($people as $person)
                            <div class="p-4 border border-gray-300 shadow-lg">
                                <div>
                                    <a href="{{ route('subjects.show', ['subject' => $person->slug]) }}"
                                       class="text-xl text-secondary popup"
                                       target="_blank"
                                    >
                                        {{ $person->name }}
                                    </a>
                                </div>
                                <div class="flex justify-between items-center pt-2">
                                    {{ $person->tagged_count }} {{ str('mention')->plural($person->tagged_count) }}
                                </div>
                                <div class="flex justify-between items-center pt-2">
                                    <div class="font-medium text-black">
                                        <div>
                                            @if(! empty($person->life_years))
                                                {{ $person->life_years }}
                                            @endif
                                        </div>
                                        <div>
                                            {{
                                                $person
                                                    ->category
                                                    ->filter(fn($category) => $category->name !== 'People')
                                                    ->pluck('name')
                                                    ->map(fn($name) => str($name)->singular())
                                                    ->join(', ')
                                            }}
                                        </div>
                                    </div>
                                    <div>
                                        @if(! empty($person->pid))
                                            <a href="https://www.familysearch.org/tree/person/details/{{ $person->pid }}"
                                               class="block px-2 pt-1 pb-2 text-sm bg-white rounded-md border border-gray-200"
                                               target="_blank"
                                            >
                                                <img src="{{ asset('img/familytree-logo.png') }}"
                                                    alt="FamilySearch"
                                                        class="w-auto h-6"
                                                />
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(! empty($places))
                <div>
                    <div id="places">
                        <h2 class="my-8 text-2xl font-semibold">
                            Places
                        </h2>
                    </div>
                    <div class="grid grid-cols-1 gap-y-4 lg:grid-cols-3">
                        @foreach($places as $place)
                            <div class="flex gap-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-700">
                                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                                <a href="{{ route('subjects.show', ['subject' => $place->slug]) }}"
                                   class="text-xl text-secondary popup"
                                   target="_blank"
                                >
                                    {{ $place->name }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <div x-data="map"
                         id="map"
                         class="z-10 w-full aspect-[16/9]"
                    ></div>
                    @push('styles')
                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
                    @endpush
                    @push('scripts')
                        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                        <script>
                            document.addEventListener('alpine:init', () => {
                                Alpine.data('map', () => ({
                                    map: null,
                                    init(){
                                        this.map = L.map('map', {
                                            scrollWheelZoom: false,
                                        })
                                            .setView([37.71859, -54.140625], 3);

                                        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}.png', {
                                                attribution: '&copy; <a href="https://carto.com/">carto.com</a> contributors'
                                            })
                                            .addTo(this.map);

                                        @foreach($places as $place)
                                            L.marker([{{ $place->latitude }}, {{ $place->longitude }}])
                                                .addTo(this.map)
                                                .bindPopup(`
                                                    <a href="{{ route('subjects.show', ['subject' => $place->slug]) }}"
                                                       class="text-base !text-secondary"
                                                       target="_blank"
                                                    >
                                                        {{ $place->name }}
                                                    </a>
                                                `)
                                                @if($places->count() === 1)
                                                    .openPopup()
                                                @endif
                                                ;
                                        @endforeach
                                    }
                                }));
                            });
                        </script>
                    @endpush
                </div>
            @endif

            @if($events->count() > 0)
                <div class="">
                    <div id="events">
                        <h2 class="my-8 text-2xl font-semibold">
                            Events
                        </h2>
                    </div>
                    <div class="">
                        @foreach($events as $event)
                            <article class="grid grid-cols-2 py-4 gap-8 @if($loop->first)  @else -mt-32 @endif">
                                <div class="col-span-1 @if($loop->odd) order-0 @else order-1 @endif">
                                    <div class="relative flex flex-col @if($loop->odd) text-left @else text-right @endif">
                                        <div class="flex @if($loop->odd) justify-start @else justify-end @endif">
                                            <img src="{{ $event->thumbnail_url }}"
                                                 alt=""
                                                 class="w-1/3 h-auto  @if($loop->odd) order-0 @else order-1 @endif" />
                                            {{--<div class="text-lg font-semibold flex-1 @if($loop->odd) order-1 text-right @else order-0 text-left @endif">
                                                {{ $event->start_at->toFormattedDateString() }}
                                            </div>--}}
                                        </div>
                                        <div class="absolute z-10 bottom-8 text-xl bg-white shadow-xl px-3 py-1 @if($loop->odd) left-8 @else right-8 @endif">
                                            <div class="text-lg font-semibold">
                                                <a href="{{ route('day-in-the-life', ['date' => $event->start_at?->toDateString()]) }}"
                                                    class="text-secondary"
                                                >
                                                    {{ $event->display_date }}
                                                </a>
                                            </div>
                                            <div class="pt-2">
                                                {!! str($event->text)->addScriptureLinks()->addSubjectLinks() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div></div>
                            </article>
                            {{--<article class=" @if($loop->odd) justify-start @else justify-end -mt-48 @endif">
                                <div class="relative h-64">
                                    <div class="absolute w-64 @if($loop->odd) top-0 left-0 @else right-0 bottom-0 @endif">
                                        <img src="{{ $event->thumbnail_url }}"
                                             alt=""
                                             class="w-full h-auto" />
                                        <div>
                                            {{ $date->toFormattedDateString() }}
                                        </div>
                                    </div>
                                    <div class="absolute z-10 bg-white w-128 @if($loop->odd) right-0 top-4 @else bottom-4 left-0 @endif">
                                        <div class="p-4 shadow-lg @if($loop->odd) text-left @else text-right @endif">
                                            {!! str($event->text)->addScriptureLinks()->addSubjectLinks() !!}
                                        </div>
                                    </div>
                                </div>
                            </article>--}}
                        @endforeach
                    </div>
                </div>
            @endif


            @if($quotes->count() > 0)
                <div>
                    <div id="quotes">
                        <h2 class="my-8 text-2xl font-semibold">
                            Quotes
                        </h2>
                    </div>
                    <div class="grid">
                        @foreach($quotes as $quote)
                            <div class="">
                                <div class="py-2 px-4 font-serif text-sm text-gray-500">
                                    <div class="flex gap-x-4 mt-4 text-base text-gray-800 lg:text-lg">
                                        <div class="flex-initial">
                                            <svg class="w-8 h-8 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                                            </svg>
                                        </div>
                                        <blockquote class="text-justify">
                                            {!! $quote->text !!}
                                        </blockquote>
                                        <div class="flex-initial">
                                            <svg class="w-8 h-8 transform rotate-180 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex gap-x-12 justify-center items-center mt-20">
                <div>
                    @if(! empty($previousDay))
                        <a href="{{ route('day-in-the-life', ['date' => $previousDay]) }}"
                           title="{{ $previousDay }}"
                           class="p-2 text-white rounded-full shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 font-semibold text-secondary">
                                <path fill-rule="evenodd" d="M7.72 12.53a.75.75 0 010-1.06l7.5-7.5a.75.75 0 111.06 1.06L9.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                </div>
                <h1 class="text-4xl font-semibold text-center">
                    {{ $date->toFormattedDateString() }}
                </h1>
                <div>
                    @if(! empty($nextDay))
                        <a href="{{ route('day-in-the-life', ['date' => $nextDay]) }}"
                           title="{{ $nextDay }}"
                           class="p-2 text-white rounded-full shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 font-semibold text-secondary">
                                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>




</x-guest-layout>
