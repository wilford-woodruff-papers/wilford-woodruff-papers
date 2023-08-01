<div>
    <x-slot name="title">
        Timeline | {{ config('app.name') }}
    </x-slot>

    <div x-data="{
            event: {image: '', date: '', text: '', links: []},
            activeEvent: null,
            currentIndex: @entangle('currentIndex'),
            @foreach($groups as $group)
                {{ str($group)->snake() }}: true,
            @endforeach
            isOverlap: $overlap('#event-selector')
        }"
         x-init="$watch('activeEvent', (value, oldValue) => $wire.set('event', value))"
         class="grid grid-cols-5">
        <div class="relative col-span-1 bg-gray-200">
            <div class="sticky top-0">
                <div class="flex flex-col gap-y-5 py-8 px-4 bg-white border-r border-gray-200 grow">
                    <div class="flex-1 min-w-0">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input wire:model.debounce.400="q"
                                   type="search"
                                   name="search"
                                   id="search"
                                   class="block py-1.5 pl-10 w-full border-0 ring-1 ring-inset ring-gray-300 sm:text-lg sm:leading-10 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary"
                                   placeholder="Search" />
                        </div>
                    </div>
                    @include('search.filters', ['location' => 'left'])
                </div>
            </div>
        </div>
        <div class="col-span-3 pb-96 bg-gray-100">
            Main
            <div x-ref="container" class="relative pt-32">

                <div class="sticky top-10 z-10">
                    <div class="grid z-50 grid-cols-6 gap-x-2 items-center py-4 text-center bg-white">
                        <div></div>
                        @foreach($groups as $group)
                            <div {{--x-on:click="{{ str($group)->snake() }} = ! {{ str($group)->snake() }}"--}}
                                 class="cursor-pointer">
                                {{ $group }}
                            </div>
                        @endforeach
                    </div>
                    <div id="event-selector"
                         class="top-0 w-full h-20 bg-gray-800 opacity-25">

                    </div>
                </div>
                <div class="">
                    @if($v_min < 1810)
                        <div class="flex sticky top-0 z-10 justify-center items-center my-8 w-full text-4xl font-bold text-white h-18 bg-primary">
                            1800
                        </div>
                    @endif

                    @foreach ($years as $year => $months)
                        @php
                            $count = 0;
                        @endphp
                        @if(($year % 10) == 0)
                            <div class="grid grid-cols-6 px-4 h-8 divide-x divide-slate-300">
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                            </div>

                            <div class="flex sticky top-0 z-10 justify-center items-center w-full text-4xl font-bold text-white h-18 bg-primary">
                                {{ $year }}
                            </div>

                            <div class="grid grid-cols-6 px-4 h-8 divide-x divide-slate-300">
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                            </div>
                        @else
                            <div class="grid grid-cols-6 px-4 h-14 divide-x divide-slate-300">
                                <div>
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ $year }}
                                    </p>
                                </div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        @endif

                        @if($months->filter(function($month){
                                return count($month) > 0;
                            })->count() > 0)
                            @foreach($months as $month => $monthEvents)

                                @if(count($monthEvents) > 0)
                                    <div class="grid grid-cols-6 px-4 h-8 divide-x divide-slate-300">
                                        <div class="font-semibold">
                                            {{ $month }}
                                        </div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                    @foreach($monthEvents->groupBy('date') as $events)
                                        @php
                                            $count = 0;
                                        @endphp
                                        <div class="grid grid-cols-6 px-4 divide-x divide-slate-300 min-h-[3.5rem]">
                                            <div class="border-t border-gray-400 border-1">
                                            </div>
                                            @foreach($groups as $key => $group)
                                                @php
                                                    if($count == 0){
                                                      $count = $events->where('type', $group)->count();
                                                    }
                                                @endphp
                                                <div x-show="{{ str($group)->snake() }}"
                                                     @class([
                                                        str($group)->slug().' col-span-1',
                                                        'border-t !border-t-gray-400 border-1' => $count == 0,
                                                      ])
                                                     class="{{ str($group)->slug() }} col-span-1"
                                                >
                                                    @foreach($events->where('type', $group)->all() as $hit)
                                                        <div x-on:click="event = {
                                                                image: '{{ data_get($hit, 'thumbnail') }}',
                                                                date: '{{ data_get($hit, 'display_date') }}',
                                                                text: '{{ addslashes(str($hit['name'])->addScriptureLinks()->toString()) }}',
                                                                links: [
                                                                    @foreach(data_get($hit, 'links', []) as $link)
                                                                        { name: '{{ $link['name'] }}',
                                                                        url: '{{ $link['url'] }}'},
                                                                    @endforeach
                                                                ]
                                                            }"
                                                             id="{{ $hit['id'] }}"
                                                             class="z-10 w-full h-14 cursor-pointer"
                                                        >
                                                            <div @scroll.window.throttle.50ms="$overlap('#event-selector') ? event = {
                                                                    image: '{{ data_get($hit, 'thumbnail') }}',
                                                                    date: '{{ data_get($hit, 'display_date') }}',
                                                                    text: '{{ addslashes(str($hit['name'])->addScriptureLinks()->toString()) }}',
                                                                    links: [
                                                                        @foreach(data_get($hit, 'links', []) as $link)
                                                                            { name: '{{ $link['name'] }}',
                                                                            url: '{{ $link['url'] }}'},
                                                                        @endforeach
                                                                    ]
                                                                } : null"
                                                                 class="relative h-10 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600"
                                                                 id="{{ $hit['id'] }}"
                                                            >
                                                                <div @class([
                                                                    'absolute w-[22rem] text-sm font-normal bg-white hover:z-10 drop-shadow-md',
                                                                    'left-[25%]' => ($key <= 2),
                                                                    'right-[25%]' => ($key > 2),
                                                                ])>
                                                                    <div class="flex">
                                                                        <div @class([
                                                                            'flex-1 py-1',
                                                                            'order-2 pl-8 pr-1' => ($key <= 2),
                                                                            'order-1 pr-8 pl-1' => ($key > 2),
                                                                        ])>
                                                                            <div class="">
                                                                                <p class="font-semibold">
                                                                                    {{ data_get($hit, 'display_date') }}
                                                                                </p>
                                                                                <p class="line-clamp-1">
                                                                                    {{ str($hit['name'])->limit(40, '...') }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        @if(data_get($hit, 'thumbnail'))
                                                                            <div @class([
                                                                                'flex-0',
                                                                                'order-1' => ($key <= 2),
                                                                                'order-2' => ($key > 2),
                                                                            ])>
                                                                                <img src="{{ data_get($hit, 'thumbnail') }}"
                                                                                     alt=""
                                                                                     class="object-cover object-top mx-auto w-20 bg-gray-100 scale-150 aspect-[16/9] sm:aspect-[2/1] lg:aspect-[3/2]">
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @else
                                    <div class="grid grid-cols-6 px-4 h-8 divide-x divide-slate-300">
                                        <div>
                                            <div class="w-1/2 border-t border-gray-400 border-1"></div>
                                        </div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                @endif

                          @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="relative col-span-1 bg-gray-200">

            <div class="sticky top-0 py-8 px-4 h-screen bg-primary">
                Right Sidebar
                <div>
                    <img x-bind:src="event.image"
                         alt=""
                         class="w-full h-auto">
                </div>
                <div x-text="event.date"
                     class="py-4 text-2xl text-white">
                </div>
                <div x-html="event.text"
                     class="text-lg text-white">
                </div>
                <div x-show="event.links.length > 0"
                     class="my-4">
                    <div class="py-4 text-lg text-white">
                        Read More
                    </div>
                    <ul class="flex flex-col gap-6">
                        <template x-for="link in event.links">
                            <li>
                                <a x-bind:title="link.name"
                                   x-bind:href="link.url"
                                   class="py-2 px-4 my-4 text-white text-md bg-secondary">
                                    View Source
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css" integrity="sha512-qveKnGrvOChbSzAdtSs8p69eoLegyh+1hwOMbmpCViIwj7rn4oJjdmMvWOuyQlTOZgTlZA0N2PXA7iA8/2TUYA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .noUi-connect {
                background: rgb(103, 30, 13);
            }
            .noUi-tooltip {
                display: none;
            }
            .noUi-active .noUi-tooltip {
                display: block;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js" integrity="sha512-UOJe4paV6hYWBnS0c9GnIRH8PLm2nFK22uhfAvsTIqd3uwnWsVri1OPn5fJYdLtGY3wB11LGHJ4yPU1WFJeBYQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wnumb/1.2.0/wNumb.min.js" integrity="sha512-igVQ7hyQVijOUlfg3OmcTZLwYJIBXU63xL9RC12xBHNpmGJAktDnzl9Iw0J4yrSaQtDxTTVlwhY730vphoVqJQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            {{--var mobile_range = document.getElementById('mobile_range');--}}
            {{--var mobile_slider = noUiSlider.create(mobile_range, {--}}
            {{--    range: {--}}
            {{--        'min': {{ $v_min }},--}}
            {{--        'max': {{ $v_max }}--}}
            {{--    },--}}
            {{--    step: 1,--}}
            {{--    // Handles start at ...--}}
            {{--    start: [{{ $v_min }}, {{ $v_max }}],--}}

            {{--    // Display colored bars between handles--}}
            {{--    connect: true,--}}

            {{--    // Move handle on tap, bars are draggable--}}
            {{--    behaviour: 'tap-drag',--}}
            {{--    tooltips: true,--}}
            {{--    format: wNumb({--}}
            {{--        decimals: 0--}}
            {{--    }),--}}

            {{--    // Show a scale with the slider--}}
            {{--    pips: {--}}
            {{--        mode: 'range',--}}
            {{--        stepped: true,--}}
            {{--        density: 3--}}
            {{--    }--}}
            {{--});--}}
            {{--mobile_range.noUiSlider.on('change', function (v) {--}}
            {{--    @this.set('year_range', v);--}}
            {{--});--}}

            var left_range = document.getElementById('left_range');
            var left_slider = noUiSlider.create(left_range, {
                range: {
                    'min': {{ $v_min }},
                    'max': {{ $v_max }}
                },
                step: 1,
                // Handles start at ...
                start: [{{ $v_min }}, {{ $v_max }}],

                // Display colored bars between handles
                connect: true,

                // Move handle on tap, bars are draggable
                behaviour: 'tap-drag',
                tooltips: true,
                format: wNumb({
                    decimals: 0
                }),

                // Show a scale with the slider
                pips: {
                    mode: 'range',
                    stepped: true,
                    density: 3
                }
            });
            left_range.noUiSlider.on('change', function (v) {
                @this.set('year_range', v);
            });
        </script>
    @endpush
</div>
