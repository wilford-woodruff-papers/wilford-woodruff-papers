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
                         class=""
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
                    <div class="grid grid-cols-2 gap-8">
                        @foreach($pages as $page)
                            <div>
                                <div class="text-xl cursor-pointer text-secondary"
                                     x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $page->id }}})">
                                    {{ $page->parent?->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(! empty($people))
                <div>
                    <div id="people">
                        <h2 class="my-8 text-2xl font-semibold">
                            People
                        </h2>
                    </div>
                    <div class="grid grid-cols-3">
                        @foreach($people as $person)
                            <div class="">
                                <a href="{{ route('subjects.show', ['subject' => $person->slug]) }}"
                                   class="text-xl text-secondary popup"
                                   target="_blank"
                                >
                                    {{ $person->name }}
                                </a>
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
                                {!! $quote->text !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>




</x-guest-layout>
