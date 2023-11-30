<x-guest-layout>
    <x-slot name="title">
        Day in the Life | {{ config('app.name') }}
    </x-slot>
    <x-banner-image :image="asset('img/banners/places.png')"
                    :text="'Day in the Life'"
    />
    <div x-data="dayInTheLife"
         @scroll.window="$refs.nav.getBoundingClientRect().top <= 10 ? scrolledFromTop = true : scrolledFromTop = false">
        <div class="py-12">
            <div class="">
                <div class="">
                    <div class="flex flex-col gap-y-12">

                        <div class="px-12 mx-auto max-w-7xl">
                            @include('public.day-in-the-life.sections.date-navigation', ['location' => 'top'])
                        </div>


                        <div class="top-0 z-50 bg-white md:sticky"
                             :class="{'': !scrolledFromTop, 'md:shadow-2xl': scrolledFromTop}">
                            <div x-ref="nav"
                                 class="px-12 mx-auto max-w-7xl">
                                <ul role="list"
                                    class="flex flex-col transition-all duration-200 md:flex-row md:items-center"
                                    :class="{'gap-6': !scrolledFromTop, 'md:divide-x md:divide-gray-200': scrolledFromTop}"
                                >
                                    <li class="px-6 pt-1 mx-auto h-full bg-white flex-0"
                                        :class="{'hidden': !scrolledFromTop, '': scrolledFromTop}"
                                        x-cloak
                                    >
                                        <div class="h-0">
                                            <input class="w-0 h-0 border-0" x-ref="nav_picker" type="text"/>
                                        </div>
                                        <button class="mx-auto text-gray-900" x-on:click="pickers['nav'].toggle()">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                            </svg>

                                        </button>
                                    </li>

                                    @foreach($sections as $key => $stat)
                                        @if(! empty($stat['items']) && $stat['items']->count() > 0)
                                            <li class="flex-1 bg-white divide-y divide-gray-200 hover:bg-gray-100"
                                                :class="{'shadow border border-gray-200': !scrolledFromTop, '': scrolledFromTop}">
                                                <a href="#{{ str($stat['name'])->slug() }}">
                                                    <div class="flex justify-between items-center py-2 px-6 space-x-6 w-full">
                                                        <div class="flex flex-row flex-1 gap-y-1 gap-x-4 justify-start items-center md:flex-col lg:items-start truncate">
                                                            <div class="flex items-center space-x-3">
                                                                <h3 class="text-2xl font-semibold text-gray-900 truncate">
                                                                    {{ $stat['items']->count() }}
                                                                </h3>
                                                            </div>
                                                            <p class="mt-1 text-lg font-semibold uppercase text-secondary truncate">
                                                                {{ str($key)->plural($stat['items']->count()) }}
                                                            </p>
                                                        </div>
                                                        <div class="hidden flex-shrink-0 justify-center items-center w-10 h-10 lg:flex bg-secondary">
                                                            <x-dynamic-component :component="$stat['icon']" class="w-6 h-6 text-white"/>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="flex-1">
                            <div class="px-12 mx-auto -mb-12 max-w-7xl">
                                <h2 class="flex justify-between my-8 border-b-4 border-highlight">
                                    <div class="text-2xl font-thin uppercase md:text-3xl lg:text-4xl">
                                        Journal Entry
                                    </div>
                                    <div class="flex gap-x-1 items-center pb-2">
                                        <button x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $day->first()->id }}})"
                                                class="flex gap-x-4 items-center py-1.5 px-2 sm:py-1 bg-secondary"
                                        >
                                            <x-heroicon-m-arrows-pointing-out class="w-6 h-6 text-white"/>
                                            <div class="hidden text-lg text-white whitespace-nowrap sm:block">
                                                View Fullscreen
                                            </div>
                                        </button>
                                        <div class="flex justify-center">
                                            <div
                                                x-data="{
                                                    open: false,
                                                    copied: false,
                                                    citation: '&quot;{{ str($day->first()->parent->name)->stripBracketedID() }},&quot; {{ $date->toFormattedDateString() }}, The Wilford Woodruff Papers, accessed {{ now()->format('F j, Y') }}, {{ url()->current() }}',
                                                    copy() {
                                                        navigator.clipboard.writeText(this.citation).then(() => {
                                                            this.copied = true;
                                                            setTimeout(() => {
                                                                this.copied = false;
                                                            }, 3000);
                                                        });
                                                    },
                                                    toggle() {
                                                        if (this.open) {
                                                            return this.close()
                                                        }

                                                        this.$refs.button.focus()

                                                        this.open = true
                                                    },
                                                    close(focusAfter) {
                                                        if (! this.open) return

                                                        this.open = false

                                                        focusAfter && focusAfter.focus()
                                                    }
                                                }"
                                                x-on:keydown.escape.prevent.stop="close($refs.button)"
                                                x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                                                x-id="['dropdown-button']"
                                                class="relative"
                                            >
                                                <!-- Button -->
                                                <button
                                                    x-ref="button"
                                                    x-on:click="toggle()"
                                                    :aria-expanded="open"
                                                    :aria-controls="$id('dropdown-button')"
                                                    type="button"
                                                    class="flex gap-2 items-center py-1.5 px-2 bg-secondary"
                                                >
                                                    <x-ri-double-quotes-l class="w-6 h-6 text-white" />
                                                </button>

                                                <!-- Panel -->
                                                <div
                                                    x-ref="panel"
                                                    x-show="open"
                                                    x-transition.origin.top.left
                                                    x-on:click.outside="close($refs.button)"
                                                    :id="$id('dropdown-button')"
                                                    style="display: none;"
                                                    class="absolute right-0 mt-2 max-w-4xl bg-white shadow-md w-[400px] md:w-[600px]"
                                                >
                                                    <div class="flex gap-x-2 items-center p-8 text-base">
                                                        <div class="flex-1">
                                                            <div x-html="citation"
                                                                 x-show="! copied"
                                                            >

                                                            </div>
                                                            <div x-show="copied"
                                                                 x-cloak
                                                            >
                                                                <div class="p-4 bg-emerald-800 rounded-md">
                                                                    <div class="flex">
                                                                        <div class="flex-shrink-0">
                                                                            <svg class="w-5 h-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                                                            </svg>
                                                                        </div>
                                                                        <div class="ml-3">
                                                                            <p class="text-base font-medium text-white">Citation Copied to Clipboard</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div x-show="! copied"
                                                            class="flex-0">
                                                            <button x-on:click="copy()"
                                                                    class="pointer"
                                                            >
                                                                <x-heroicon-o-clipboard class="w-6 h-6" />
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </h2>
                            </div>
                        </div>
                        <div class="overflow-hidden w-full">
                            <div class="bg-center bg-cover lg:-mx-80 bg-[grey] bg-blend-multiply"
                                 style="background-image: url('{{ app()->environment('production') ? $day->first()->getfirstMediaUrl(conversionName: 'web') : 'https://wilford-woodruff-papers.nyc3.digitaloceanspaces.com/media-library/233014/conversions/default-web.jpg' }}')">
                                @include('public.day-in-the-life.sections.journal')
                            </div>
                        </div>

                        <div class="flex-1">
                            <div class="flex flex-col gap-y-12 px-12 mx-auto max-w-7xl">
                                @include($sections['Person']['view'], ['section' => $sections['Person']])

                                @include($sections['Place']['view'], ['section' => $sections['Place']])

                                @include($sections['Quote']['view'], ['section' => $sections['Quote']])

                                @include($sections['Document']['view'], ['section' => $sections['Document']])

                                @include($sections['Event']['view'], ['section' => $sections['Event']])

                                @include('public.day-in-the-life.sections.date-navigation', ['location' => 'bottom'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <style>
            .flatpickr-input {
                height: 0px;
                font-size: 0px;
                padding: 0px;
                border: none;
            }
            html {
                scroll-behavior: smooth;
            }
            .flatpickr-day.selected, .flatpickr-day.prevMonthDay.selected {
                background: rgb(103, 30, 13);
                border-color: rgb(93, 27, 12);
            }
            .flatpickr-day.selected:hover, .flatpickr-day.prevMonthDay.selected:hover {
                background: rgb(140, 68, 51);
                border-color: rgb(113, 33, 14);
            }
        </style>
        <script>
            window.allPlaces = @json($allDates->pluck('date')->toArray());
        </script>
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('dayInTheLife', () => ({
                    value: ['{{ $date->toDateString() }}'],
                    pickers: {'top': null, 'bottom': null, 'nav': null},
                    top_picker: null,
                    bottom_picker: null,
                    nav_picker: null,
                    scrolledFromTop: false,
                    init() {
                        for (const [key, value] of Object.entries(this.pickers)) {
                            this.pickers[key] = flatpickr(this.$refs[key+'_picker'], {
                                mode: 'single',
                                dateFormat: 'Y-m-d',
                                defaultDate: this.value,
                                onChange: (date, dateString) => {
                                    this.value = dateString.split(' to ')
                                },
                                enable: window.allPlaces,
                            });
                        }

                        this.$refs.nav.getBoundingClientRect().top <= 10  ? scrolledFromTop = true : scrolledFromTop = false;

                        this.$watch('value', () => {
                            for (const [key, value] of Object.entries(this.pickers)) {
                                this.pickers[key].setDate(this.value);
                            }
                            window.location.href = '{{ route('day-in-the-life') }}/' + this.value[0];
                        });
                    },
                }));
            });
        </script>
    @endpush


</x-guest-layout>
