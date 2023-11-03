<x-guest-layout>
    <div x-data="{}"
         class="py-12 px-12 mx-auto max-w-7xl">
        <div class="flex flex-col gap-y-12">

            <div class="flex gap-x-12 justify-center items-center">
                <div>
                    @if(! empty($previousDay))
                        <a href="{{ route('day-in-the-life', ['date' => $previousDay]) }}"
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
                           class="p-2 text-white rounded-full shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 font-semibold text-secondary">
                                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <div class="relative bg-white">
                <div class="flex items-center">
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
                </div>
            </div>

            <div class="grid grid-cols-3 gap-x-8">
                <div class="col-span-3 text-3xl font-semibold">
                    {{ $date->format('F d, Y ~ l') }}
                </div>
                <div class="col-span-2 text-2xl leading-relaxed">
                    {!! $content !!}
                </div>
                <div>
                    <img src="{{ $day->first()->getfirstMediaUrl(conversionName: 'thumb') }}"
                         alt=""
                         class="w-full h-auto"
                         x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $day->first()->id }}})"
                    />
                </div>
            </div>

            @if($pages->count() > 0)
                <div>
                    <div id="places">
                        <h2 class="my-8 text-2xl font-semibold">
                            Documents
                        </h2>
                    </div>

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
                                                        str($page->transcript)
                                                            ->extractContentOnDate($date)
                                                            ->addSubjectLinks()
                                                            ->addScriptureLinks()
                                                            ->removeQZCodes(false)
                                                            ->replace('&amp;', '&')
                                                            ->replace('<s>', '')
                                                            ->replace('</s>', '')
                                                    !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>



                    {{--<div class="grid grid-cols-1 gap-16">
                        @foreach($pages as $page)
                            <div>
                                <div class="grid grid-cols-2 gap-x-4">
                                    <div class="col-span-1 px-8 @if($loop->odd) order-0 @else order-1 @endif">
                                        <img src="{{ $page->getfirstMediaUrl(conversionName: 'thumb') }}"
                                             alt=""
                                             class="w-full h-auto" />
                                    </div>
                                    <div class="col-span-1 @if($loop->odd) order-1 text-right @else order-0 text-left @endif">
                                        <div class="flex flex-col gap-y-4 justify-between">
                                            <div>
                                                <div class="text-xl cursor-pointer text-secondary"
                                                     x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $page->id }}})">
                                                    {{ $page->parent?->name }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-lg line-clamp-3">
                                                    {!!
                                                        str($page->transcript)
                                                            ->extractContentOnDate($date)
                                                            ->addSubjectLinks()
                                                            ->addScriptureLinks()
                                                            ->removeQZCodes(false)
                                                            ->replace('&amp;', '&')
                                                    !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>--}}
                </div>
            @endif

            @if(! empty($people))
                <div>
                    <div id="people">
                        <h2 class="my-8 text-2xl font-semibold">
                            People
                        </h2>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($people as $person)
                            <div class="p-4 border border-gray-300 shadow-lg">
                                <a href="{{ route('subjects.show', ['subject' => $person->slug]) }}"
                                   class="text-xl text-secondary popup"
                                   target="_blank"
                                >
                                    {{ $person->name }}
                                </a>
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
                    <div class="grid grid-cols-3">
                        @foreach($places as $place)
                            <div class="">
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
                                                       class="text-base !text-secondary popup"
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
                <div>
                    <div id="places">
                        <h2 class="my-8 text-2xl font-semibold">
                            Events
                        </h2>
                    </div>
                    <div class="grid grid-cols-2 gap-8">
                        @foreach($events as $event)
                            <div>
                                <div class="text-xl">
                                    {!! str($event->text)->addScriptureLinks()->addSubjectLinks() !!}
                                </div>
                            </div>
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

        </div>
    </div>




</x-guest-layout>
