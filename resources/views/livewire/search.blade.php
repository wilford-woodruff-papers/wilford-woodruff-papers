<div x-data="{
        q: @entangle('q'),
        exact: @entangle('exact'),
        toggleExactMatch(value) {
            this.q = value ? window.addQuotes(this.q) : window.removeQuotes(this.q);
        }
    }"
     x-init="$watch('exact', value => toggleExactMatch(value))"
    class="mx-auto max-w-7xl"
>

    <div class="pb-4 mt-12">
        <div class="flex gap-x-4">
            <div class="flex-1 min-w-0">
                <label for="search" class="sr-only">Search</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input wire:model.debounce.250="q"
                           type="search"
                           name="search"
                           id="search"
                           class="block py-1.5 pl-10 w-full rounded-md border-0 ring-1 ring-inset ring-gray-300 sm:text-lg sm:leading-10 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary"
                           placeholder="Search" />
                </div>
            </div>
        </div>
        <div class="mt-1">
            <div class="flex relative items-start">
                <div class="flex items-center h-6">
                    <input x-model="exact"
                           id="exact"
                           name="exact"
                           type="checkbox"
                           class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="exact" class="font-medium text-gray-900">Search for exact word or phrase</label>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select a tab</label>
            <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
            <select wire:model="currentIndex"
                    id="tabs"
                    name="tabs"
                    class="block py-2 pr-10 pl-3 w-full text-base rounded-md border-gray-300 sm:text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
            >
                @foreach($indexes as $key => $index)
                    <option @selected($currentIndex === $key)>{{ $key }}</option>
                @endforeach
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px space-x-8" aria-label="Tabs">
                    @foreach($indexes as $key => $index)
                        <button wire:click="$set('currentIndex', '{{ $key }}')"
                            @class([
                              'py-4 px-1 text-sm font-medium whitespace-nowrap border-b-2',
                              'border-secondary text-secondary' => $currentIndex === $key,
                              'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' => $currentIndex !== $key,
                            ])
                        >
                            {{ $key }}
                        </button>
                    @endforeach
                </nav>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-5 gap-x-4 my-4">
        <div>
            <p class="text-sm leading-5 text-gray-700">
                Showing
                <span class="font-medium">{{ number_format($first_hit, 0, ',') }}</span>
                to
                <span class="font-medium">{{ number_format($last_hit, 0, ',') }}</span>
                of
                <span class="font-medium">{{ number_format($total, 0, ',') }}</span>
                results
            </p>
        </div>
        <div id="top-pagination"
             class="col-span-4 px-4"
        >
            @include('meilisearch.pagination.simple-tailwind', ['location' => 'top'])
        </div>
    </div>

    <div class="grid grid-cols-5">
        <div class="@if(empty($indexes[$currentIndex])) hidden @endif col-span-1">
            <div class="flex flex-col gap-y-5 bg-white border-r border-gray-200 grow">
                <nav class="flex flex-col flex-1">
                    <ul role="list" class="flex flex-col flex-1 gap-y-7">
                        @foreach($facets as $facetKey => $facet)
                            <li x-data="{ expanded: $persist(true).as('{{ $facetKey }}_expanded') }">
                                <ul role="list" class="space-y-1">
                                    <li>

                                        <div>
                                            <button x-on:click="expanded = ! expanded"
                                                    type="button"
                                                    class="flex gap-x-3 items-center py-2 w-full text-base font-semibold leading-6 text-left text-gray-700 rounded-md hover:bg-gray-50"
                                                    aria-controls="sub-menu-{{ $facetKey }}"
                                                    aria-expanded="false"
                                                    x-bind:aria-expanded="expanded.toString()">
                                                <!-- Expanded: "rotate-90 text-gray-500", Collapsed: "text-gray-400" -->
                                                <svg class="w-5 h-5 text-gray-400 shrink-0"
                                                     viewBox="0 0 20 20"
                                                     fill="currentColor"
                                                     aria-hidden="true"
                                                     :class="{ 'rotate-90 text-gray-500': expanded, 'text-gray-400': !(expanded) }"
                                                >
                                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                                </svg>
                                                {{ str($facetKey)->before('_facet')->title()->replace('_', ' ') }}
                                            </button>
                                            <!-- Expandable link section, show/hide based on state. -->
                                            <ul  x-show="expanded"
                                                 x-collapse.duration.300ms
                                                 x-cloak
                                                 class="overflow-x-hidden overflow-y-scroll px-2 mt-1 max-h-80"
                                                 id="sub-menu-{{ $facetKey }}">
                                                @foreach($facet as $key => $value)
                                                    <li
                                                        class="pl-4 cursor-pointer"
                                                        id="list_item_{{ str($facetKey) }}_{{ str($key)->snake() }}"
                                                    >
                                                        <div class="flex relative gap-x-1 items-center">
                                                            <div class="flex items-center h-6 flex-0">
                                                                <input wire:model="filters.{{ str($facetKey)->before('_facet') }}"
                                                                       id="{{ str($facetKey) }}_{{ str($key)->snake() }}"
                                                                       name="{{ str($facetKey) }}"
                                                                       type="checkbox"
                                                                       value="{{ $key }}"
                                                                       class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" />
                                                            </div>
                                                            <div class="overflow-hidden flex-1 text-sm leading-6">
                                                                <label for="{{ str($facetKey) }}_{{ str($key)->snake() }}"
                                                                       class="flex-1 font-medium text-gray-900 cursor-pointer">
                                                                    <div class="flex gap-x-2 justify-between py-1 pr-2 pl-2 text-sm leading-6 text-gray-700 rounded-md hover:bg-gray-50"
                                                                    >
                                                                        <span class="truncate">{{ $key }}</span>
                                                                        <span>({{ number_format($value, 0, ',') }})</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>

                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
        <div wire:loading.class.delay="opacity-50" class="@if(empty($indexes[$currentIndex])) col-span-5 @else col-span-4 @endif">
            <div id="chart">
                @if($currentIndex == 'Documents')
                    {{-- TODO: Values update but chart does not --}}
                    {{--<div
                        x-data="{
                            decades: @entangle('decades'),
                            labels: [
                                {{ $decades->join(', ') }}
                            ],
                            values: [
                                {{ $decadeCounts->join(', ') }}
                            ],
                            init() {
                                let chart = new Chart(this.$refs.canvas.getContext('2d'), {
                                    type: 'line',
                                    data: {
                                        labels: this.labels,
                                        datasets: [{
                                            data: this.values,
                                            backgroundColor: 'rgb(103, 30, 13)',
                                            borderColor: 'rgb(103, 30, 13)',
                                        }],
                                    },
                                    options: {
                                        interaction: { intersect: false },
                                        scales: { y: { beginAtZero: true }},
                                        plugins: {
                                            legend: { display: false },
                                            tooltip: {
                                                displayColors: false,
                                                callbacks: {
                                                    label(point) {
                                                        return 'Pages: '+point.raw
                                                    }
                                                }
                                            }
                                        }
                                    }
                                })

                                this.$watch('decades', () => {
                                    chart.data.labels = this.labels
                                    chart.data.datasets[0].data = this.values
                                    chart.update()
                                })

                                this.$watch('values', () => {
                                    chart.data.labels = this.labels
                                    chart.data.datasets[0].data = this.values
                                    chart.update()
                                })
                            }
                        }"
                        class="w-full"
                    >
                        <canvas x-ref="canvas" class="p-8 max-h-96 bg-white"></canvas>
                    </div>--}}

                    <div class="h-[250px]">
                        <livewire:livewire-line-chart
                            key="{{ $documentModel->reactiveKey() }}"
                            :line-chart-model="$documentModel"
                        />
                    </div>
                @endif
            </div>

            <ul class="divide-y divide-gray-200">
                @foreach ($hits as $hit)
                    <li class="grid grid-cols-7 py-4">

                        <div class="col-span-1 px-2">
                            <a class="col-span-1 my-2 mx-auto w-20 h-auto"
                               href="{{ data_get($hit, '_formatted.url') }}"
                               target="{{ (str(data_get($hit, '_formatted.url'))->contains(config('app.url')) ? '_self' : '_blank') }}"
                            >
                                <img src="{{ data_get($hit, '_formatted.thumbnail') }}"
                                     alt=""
                                     loading="lazy"
                                >
                            </a>
                        </div>
                        <div class="col-span-6 py-2 px-4">
                            <div class="flex gap-x-2 items-center pb-1">
                                @includeFirst(['search.'.str(data_get($hit, 'resource_type'))->snake(), 'search.generic'])
                                <a href="{{ data_get($hit, '_formatted.url') }}"
                                   class="text-lg font-medium capitalize text-secondary"
                                   target="{{ (str(data_get($hit, '_formatted.url'))->contains(config('app.url')) ? '_self' : '_blank') }}"
                                >
                                    {!! data_get($hit, '_formatted.name') !!}
                                </a>
                            </div>
                            <div class="flex gap-x-3 ml-2 text-base font-medium">
                                {{--<div>
                                    <span class="text-gray-600">Part of </span>
                                    <span class="text-secondary">
                                        <a href="{{ route('documents.show', ['item' => $page->item]) }}">{{ \Illuminate\Support\Str::of($page->item?->name)->replaceMatches('/\[.*?\]/', '')->trim() }}</a>
                                    </span>
                                </div>--}}
                                <div>
                                    @auth()
                                        @hasanyrole('CFM Researcher')
                                        <div>
                                            @if(data_get($hit, '_formatted.is_published'))
                                                <span class="inline-flex items-center py-0.5 px-2.5 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                                {{ __('Published') }}
                                            </span>
                                            @else
                                                <span class="inline-flex items-center py-0.5 px-2.5 text-xs font-medium text-red-800 bg-red-100 rounded-full">
                                                {{ __('Not Published') }}
                                            </span>
                                            @endif
                                        </div>
                                        @endhasanyrole
                                    @endauth
                                </div>
                            </div>
                            {{--@if($page->item->type)
                                <p class="ml-2 text-base text-primary">{{ $page->item->type->name }}</p>
                            @endif--}}
                            <div class="py-2 px-4 font-serif text-sm text-gray-500">
                                {{--@php
                                    $description = '';
                                    if(! empty( request('q')) && request('q') != '*'){
                                        preg_match_all('~(?:[\p{L}\p{N}\']+[^\p{L}\p{N}\']+){0,10}'.request('q').'(?:[^\p{L}\p{N}\']+[\p{L}\p{N}\']+){0,10}~ui', str_replace(['[[', ']]'], '', strip_tags( $page->transcript ) ),$matches);
                                        foreach ($matches[0] as $match) {
                                            $description .= '<div>...' . str_highlight($match, request('q'), STR_HIGHLIGHT_SIMPLE, '<span class="bg-yellow-100">\1</span>') . '...</div>';
                                        }

                                    }else {
                                        $description = (strlen($page->text()) > 0) ? get_snippet($page->text(), 100) . ((get_word_count($page->text()) > 100)?' ...':'') : '';
                                        $description = str_replace(['[[', ']]'], '', strip_tags( $description ) );
                                    }
                                @endphp

                                @if(! empty($description))
                                    <div class="mb-1 font-bold">
                                        Excerpt:
                                    </div>
                                    {!! $description !!}
                                @endif--}}

                                <div class="line-clamp-3">
                                    {!! str(data_get($hit, '_formatted.description'))->remove('[[')->remove(']]') !!}
                                </div>

                                {{--{!! Str::of( strip_tags( $page->text() ) )->words(50) !!}--}}
                                {{--@if($page->dates->count() > 0)
                                    <div class="grid grid-cols-12 mt-3">
                                        <div class="col-span-1 font-bold">
                                            Dates:
                                        </div>
                                        <div class="col-span-11">
                                            <div class="grid grid-cols-4 gap-1">
                                                {!! $page->dates->sortBy('date')->map(function($date){
                                                    return '<span class="inline-flex items-center py-0.5 px-2 text-xs font-medium text-gray-800 bg-gray-100 rounded">'
                                                                . $date->date->format('F j, Y')
                                                            . '</span>';
                                                })->join(" ") !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif--}}
                            </div>
                        </div>

                    </li>
                @endforeach
            </ul>
            <div id="top-pagination"
                 class="my-4">
                @include('meilisearch.pagination.simple-tailwind', ['location' => 'bottom'])
            </div>
        </div>
    </div>

    @push('styles')
        <!-- https://www.chartjs.org/ -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
        @livewireChartsScripts
        <style>
            #chart [fill]{
                color
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            window.addQuotes = function (value) {
                return '"' + value + '"';
            }
            window.removeQuotes = function (value) {
                return value.replace(/^\"+|\"+$/g, '');
            }
        </script>
    @endpush
    @push('styles')
        <style>
            em {
                background-color: #fff59d;
            }
        </style>
    @endpush
</div>
