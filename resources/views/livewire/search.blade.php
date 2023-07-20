<x-slot name="title">
    Search | {{ config('app.name') }}
</x-slot>

<div x-data="{
        q: @entangle('q'),
        'filtersOpen': false,
        currentIndex: @entangle('currentIndex'),
        layout: $persist('list'),
        exact: @entangle('exact'),
        toggleExactMatch(value) {
            this.q = value ? window.addQuotes(this.q) : window.removeQuotes(this.q);
        }
    }"
     x-init="$watch('exact', value => toggleExactMatch(value))"
    class="px-4 mx-auto max-w-7xl"
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
                           class="block py-1.5 pl-10 w-full border-0 ring-1 ring-inset ring-gray-300 sm:text-lg sm:leading-10 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary"
                           placeholder="Search" />
                </div>
            </div>
        </div>
        <div class="mt-2 ml-4">
            <div class="flex relative flex-col gap-4 items-center sm:flex-row">
                <div class="flex items-start">
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
                <div class="flex flex-col gap-4 items-center sm:flex-row">
                    @if(! empty($q))
                        <button wire:click="$set('q', '')"
                                type="button" class="inline-flex gap-x-1.5 items-center py-1.5 px-2.5 text-sm font-semibold text-white rounded-md shadow-sm bg-secondary-600 hover:bg-secondary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary-600">
                            Search term: {{ $q }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mr-0.5 w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                    @foreach($filters as $key => $filter)
                        @if(! empty($filters[$key]))
                            <button wire:click="$set('filters.{{$key}}', [])"
                                    type="button" class="inline-flex gap-x-1.5 items-center py-1.5 px-2.5 text-sm font-semibold text-white rounded-md shadow-sm bg-secondary-600 hover:bg-secondary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary-600">
                                {{ str($key)->title()->replace('_', ' ') }}: {{ collect($filters[$key])->join(', ') }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mr-0.5 w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        @endif
                    @endforeach
                    @if(! empty($year_range))
                        <button wire:click="$set('year_range', [])"
                                type="button" class="inline-flex gap-x-1.5 items-center py-1.5 px-2.5 text-sm font-semibold text-white rounded-md shadow-sm bg-secondary-600 hover:bg-secondary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary-600">
                            Year Range: {{ $year_range[0] }} - {{ $year_range[1] }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mr-0.5 w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                    @if(! empty($use_date_range))
                        <button wire:click="$set('use_date_range', false)"
                                type="button" class="inline-flex gap-x-1.5 items-center py-1.5 px-2.5 text-sm font-semibold text-white rounded-md shadow-sm bg-secondary-600 hover:bg-secondary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary-600">
                            Full Date Range: {{ \Carbon\Carbon::create($full_date_range['min'])->toFormattedDateString() }} - {{ \Carbon\Carbon::create($full_date_range['max'])->toFormattedDateString() }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mr-0.5 w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <div class="sm:hidden">
            <div class="flex gap-x-4 items-center">
                <div class="flex-1">
                    <label for="tabs" class="sr-only">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select wire:model="currentIndex"
                            id="tabs"
                            name="tabs"
                            class="block py-2 pr-10 pl-3 w-full text-base border-gray-300 sm:text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                    >
                        @foreach($indexes as $key => $index)
                            <option @selected($currentIndex === $key)>{{ $key }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-0">
                    <button x-on:click="filtersOpen = true"
                            type="button"
                            class="inline-flex gap-x-1.5 items-center py-3 px-3 text-sm font-semibold text-gray-900 border-gray-300 ring-1 ring-inset ring-gray-300 shadow-sm hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <span class="sr-only">Show filtering options</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-0.5 w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
        <div class="hidden sm:block">
            <div class="flex justify-between items-center border-b border-gray-200">
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
                <div class="flex gap-x-8 items-center">
                    <div class="flex gap-x-4">
                        <div>
                            <button wire:click="sortBy('name')"
                                    class="inline-flex gap-x-1.5 items-center text-sm text-gray-500">
                                Name
                                @if(array_key_exists('name', $sort))
                                    @if($sort['name'] == 'asc')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                                        </svg>
                                    @endif
                                @endif
                            </button>
                        </div>
                        <div>
                            <button wire:click="sortBy('date')"
                                    class="inline-flex gap-x-1.5 items-center text-sm text-gray-500">
                                Date
                                @if(array_key_exists('date', $sort))
                                    @if($sort['date'] == 'asc')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                                        </svg>
                                    @endif
                                @endif
                            </button>
                        </div>
                    </div>
                    <div class="inline-flex rounded-md shadow-sm isolate">
                        <button x-on:click="layout = 'list'"
                                type="button"
                                class="inline-flex relative gap-x-1.5 items-center py-2 px-3 text-sm font-semibold ring-1 ring-inset ring-gray-300 focus:z-10"
                                :class="layout ==='list' ? 'bg-secondary text-white' : 'bg-white text-gray-900 hover:bg-gray-50'"
                        >
                            <span class="sr-only">Display results as list</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 w-5 h-5" :class="layout ==='list' ? 'text-white' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                      </button>
                        <button x-on:click="layout = 'grid'"
                                type="button"
                                class="inline-flex relative gap-x-1.5 items-center py-2 px-3 text-sm font-semibold ring-1 ring-inset ring-gray-300 focus:z-10"
                                :class="layout ==='grid' ? 'bg-secondary text-white' : 'bg-white text-gray-900 hover:bg-gray-50'"
                        >
                            <span class="sr-only">Display results as grid</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 w-5 h-5" :class="layout ==='grid' ? 'text-white' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                      </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-5 gap-x-4 gap-y-4 items-center my-4">
        <div class="col-span-5 text-center sm:col-span-1 sm:text-left">
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
             class="col-span-5 px-4 sm:col-span-4"
        >
            @include('meilisearch.pagination.simple-tailwind', ['location' => 'top'])
        </div>
    </div>

    <div x-show="filtersOpen"
         x-cloak
         class="relative z-10"
         aria-labelledby="slide-over-title"
         role="dialog"
         aria-modal="true"
    >
        <!--
          Background backdrop, show/hide based on slide-over state.

          Entering: "ease-in-out duration-500"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in-out duration-500"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="overflow-hidden fixed inset-0">
            <div class="overflow-hidden absolute inset-0">
                <div class="flex fixed inset-y-0 right-0 pl-10 max-w-full pointer-events-none">
                    <!--
                      Slide-over panel, show/hide based on slide-over state.

                      Entering: "transform transition ease-in-out duration-500 sm:duration-700"
                        From: "translate-x-full"
                        To: "translate-x-0"
                      Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
                        From: "translate-x-0"
                        To: "translate-x-full"
                    -->
                    <div x-on:click.away="filtersOpen = false"
                         class="w-screen max-w-md pointer-events-auto">
                        <div class="flex overflow-y-scroll flex-col py-6 h-full bg-white shadow-xl">
                            <div class="px-4 sm:px-6">
                                <div class="flex justify-between items-start">
                                    <h2 class="text-base font-semibold leading-6 text-gray-900" id="slide-over-title">Search Filters</h2>
                                    <div class="flex items-center ml-3 h-7">
                                        <button x-on:click="filtersOpen = false"
                                                type="button" class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
                                            <span class="sr-only">Close panel</span>
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="relative flex-1 px-4 mt-6 sm:px-6">
                                @include('search.filters', ['location' => 'mobile'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-5">
        <div class="hidden @if(! empty($indexes[$currentIndex])) sm:block @endif col-span-1">
            <div class="flex flex-col gap-y-5 bg-white border-r border-gray-200 grow">
                @include('search.filters', ['location' => 'left'])
            </div>
        </div>
        <div wire:loading.class.delay="opacity-50" class="@if(empty($indexes[$currentIndex])) col-span-5 @else col-span-5 sm:col-span-4 @endif">
            <div id="chart">
                @if($currentIndex == 'Documents')
                    <div class="h-[250px]">
                        <livewire:livewire-line-chart
                            key="{{ $documentModel->reactiveKey() }}"
                            :line-chart-model="$documentModel"
                        />
                    </div>
                @endif
            </div>

            <div class="min-h-screen">
                <div :class="layout ==='grid' ? '' : 'hidden'"
                     x-cloak
                >
                    <div class="grid grid-cols-1 gap-x-8 gap-y-20 mx-auto mt-16 max-w-2xl lg:grid-cols-3 lg:mx-2 lg:max-w-none">
                        @foreach ($hits as $hit)
                            <article class="flex flex-col justify-between items-start">
                                <a href="{{ data_get($hit, '_formatted.url') }}"
                                   class="w-full"
                                >

                                    <div class="relative w-full">
                                        @if(! empty(data_get($hit, '_formatted.thumbnail')))
                                            <img src="{{ data_get($hit, '_formatted.thumbnail') }}"
                                                 alt=""
                                                 class="object-cover w-full bg-gray-100 aspect-[16/9] sm:aspect-[2/1] lg:aspect-[3/2]">
                                            <div class="absolute inset-0 ring-1 ring-inset ring-gray-900/10"></div>
                                        @else
                                            <div class="flex justify-center items-center w-full text-white bg-gray-400 aspect-[16/9]">
                                                @if(in_array(data_get($hit, 'resource_type'), ['Media']))
                                                    @includeFirst(['search.'.str(data_get($hit, 'type'))->snake(), 'search.generic'])
                                                @else
                                                    @includeFirst(['search.'.str(data_get($hit, 'resource_type'))->snake(), 'search.generic'])
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="max-w-xl">
                                        <div class="relative group">
                                            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                                <span class="absolute inset-0"></span>
                                                {!! data_get($hit, '_formatted.name') !!}
                                            </h3>
                                            <div class="mt-5 text-sm leading-6 text-gray-600 line-clamp-3">
                                                {!! str(data_get($hit, '_formatted.description'))->remove('[[')->remove(']]') !!}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </div>

                <ul :class="layout ==='list' ? '' : 'hidden'"
                    class="divide-y divide-gray-200"
                    x-cloak
                >
                    @foreach ($hits as $hit)
                        <a class="col-span-1 my-2 mx-auto w-20 h-auto group"
                           href="{{ data_get($hit, '_formatted.url') }}"
                           target="{{ (str(data_get($hit, '_formatted.url'))->contains(config('app.url')) ? '_self' : '_blank') }}"
                        >
                            <li class="grid grid-cols-7 py-4 group-focus:bg-gray-100 hover:bg-gray-100">

                                <div class="col-span-3 px-2 sm:col-span-1">
                                    <div class="col-span-1 my-2 mx-auto w-20 h-auto">
                                        @if(! empty(data_get($hit, '_formatted.thumbnail')))
                                            <img src="{{ data_get($hit, '_formatted.thumbnail') }}"
                                                 alt=""
                                                 loading="lazy"
                                            >
                                        @else
                                            <div class="flex justify-center items-center w-full text-white bg-gray-400 aspect-[16/9]">
                                                @if(in_array(data_get($hit, 'resource_type'), ['Media']))
                                                    @includeFirst(['search.'.str(data_get($hit, 'type'))->snake(), 'search.generic'])
                                                @else
                                                    @includeFirst(['search.'.str(data_get($hit, 'resource_type'))->snake(), 'search.generic'])
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-span-4 py-2 px-4 sm:col-span-6">
                                    <div class="flex gap-x-3 text-base font-medium">
                                        <div class="pb-2">
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
                                    <div class="flex gap-x-2 items-center pb-1">
                                        @if(in_array(data_get($hit, 'resource_type'), ['Media']))
                                            @includeFirst(['search.'.str(data_get($hit, 'type'))->snake(), 'search.generic'])
                                        @else
                                            @includeFirst(['search.'.str(data_get($hit, 'resource_type'))->snake(), 'search.generic'])
                                        @endif
                                        <span class="text-lg font-medium capitalize text-secondary">
                                            {!! data_get($hit, '_formatted.name') !!}
                                        </span>
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
                        </a>
                    @endforeach
                </ul>
                <div id="top-pagination"
                     class="my-4">
                    @include('meilisearch.pagination.simple-tailwind', ['location' => 'bottom'])
                </div>
            </div>
        </div>
    </div>

    @push('styles')
{{--        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />--}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <!-- https://www.chartjs.org/ -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
        @livewireChartsScripts
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
            .flatpickr-day.selected {
                background: rgb(103, 30, 13);
                border-color: rgb(93, 27, 12);
            }
            .flatpickr-day.selected:hover {
                background: rgb(140, 68, 51);
                border-color: rgb(113, 33, 14);
            }
            /*.flatpickr-day:hover {*/
            /*    background: rgb(113, 33, 14);*/
            /*    border-color: rgb(103, 30, 13);*/
            /*}*/
        </style>
    @endpush
    @push('styles')
{{--        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>--}}

{{--        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>--}}
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
            var mobile_range = document.getElementById('mobile_range');
            var mobile_slider = noUiSlider.create(mobile_range, {
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
            mobile_range.noUiSlider.on('change', function (v) {
                @this.set('year_range', v);
            });

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
