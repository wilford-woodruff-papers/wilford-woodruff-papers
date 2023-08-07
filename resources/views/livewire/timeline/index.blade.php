<div>
    <x-slot name="title">
        Timeline | {{ config('app.name') }}
    </x-slot>

    <div x-data="{
            event: {image: '', date: '', text: '', links: []},
            filtersOpen: true,
            view: 'timeline',
            activeEvent: null,
            currentIndex: @entangle('currentIndex'),
            @foreach($groups as $group)
                {{ str($group)->snake() }}: true,
            @endforeach
            isOverlap: $overlap('#event-selector')
        }"
         x-init="$watch('activeEvent', (value, oldValue) => $wire.set('event', value))"
         class="grid grid-cols-5">
        <div x-show="filtersOpen"
             x-transition
             class="relative col-span-1 bg-gray-200">
            <div class="sticky top-0">
                <div class="grid grid-flow-row auto-rows-max gap-y-5 py-8 px-4 min-h-screen bg-white border-r border-gray-200 grow">
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
                    <div class="my-4">
                        <div class="flex w-full isolate">
                            <button x-on:click="view = 'timeline'"
                                    type="button"
                                    class="relative flex-1 items-center py-2 px-3 text-sm font-semibold ring-1 ring-inset focus:z-10"
                                    :class="view =='timeline' ? 'bg-secondary text-white hover:bg-secondary-600 ring-secondary' : 'text-gray-900 bg-white hover:bg-gray-50 ring-gray-300'"
                            >
                                Timeline
                            </button>
                            <button x-on:click="view = 'list'"
                                    type="button"
                                    class="relative flex-1 items-center py-2 px-3 text-sm font-semibold ring-1 ring-inset focus:z-10"
                                    :class="view =='list' ? 'bg-secondary text-white hover:bg-secondary-600 ring-secondary' : 'text-gray-900 bg-white hover:bg-gray-50 ring-gray-300'"
                            >
                                List
                            </button>
                            <button x-on:click="view = 'map'"
                                    type="button"
                                    class="relative flex-1 items-center py-2 px-3 text-sm font-semibold ring-1 ring-inset focus:z-10"
                                    :class="view =='map' ? 'bg-secondary text-white hover:bg-secondary-600 ring-secondary' : 'text-gray-900 bg-white hover:bg-gray-50 ring-gray-300'"
                            >
                                Map
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-3 pb-96 bg-gray-100"
             :class="filtersOpen ?'col-span-3' : 'col-span-4'"
        >
            <div x-show="view == 'timeline'"
                 x-cloak
            >
                @include('livewire.timeline.timeline')
            </div>
            <div x-show="view == 'list'"
                 x-cloak
            >
                @include('livewire.timeline.list')
            </div>
            <div x-show="view == 'map'"
                 x-cloak
            >
                @include('livewire.timeline.map')
            </div>
        </div>
        <div class="relative col-span-1 bg-gray-200">

            <div class="sticky top-0 py-8 px-4 h-screen bg-primary">
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
