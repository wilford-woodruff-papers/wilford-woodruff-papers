<div>
    <x-slot name="title">
        Browse Documents | {{ config('app.name') }}
    </x-slot>

    <x-documents-banner-image :image="asset('img/banners/document.jpg')"
                    :text="'Documents'"
    />

    <div class="mx-auto max-w-7xl">
        <div class="page-title">
            Understand the unfolding Restoration through Wilford’s unique eyewitness account
        </div>
        <div class="col-span-12 px-8 pb-12 -mt-2">
            <p class="text-black">
                The Wilford Woodruff Papers consist of all extant documents written by Wilford Woodruff and correspondence written to Wilford Woodruff that have been located and digitized. Images of the documents are displayed side by side with transcriptions of the text. In addition, every date, person, place, scriptural reference, and topic within the documents is tagged and hyperlinked to allow for more in-depth study.
            </p>
        </div>
        <div class="grid grid-cols-12">
            <div
                 class="col-span-12 md:col-span-3">
                <ul class="divide-y divide-gray-200 submenu">
                    <li wire:click="$set('filters.type', '')"
                        class="flex">
                        <span class="cursor-pointer py-4 block w-full text-gray-900 hover:bg-gray-100 @if(empty($filters['type'])) active @else @endif">
                            <div class="ml-3">
                                <p class="text-lg font-medium">All</p>
                            </div>
                        </span>
                    </li>
                    @foreach($types as $t)
                        <li wire:click="$set('filters.type', {{ $t->id }})"
                            class="flex">
                            <span class="cursor-pointer py-4 block w-full text-gray-900 hover:bg-gray-100 @if($t->id == data_get($filters, 'type')) active @else @endif">
                                <div class="ml-3">
                                    <p class="text-lg font-medium">{{ $t->name }} ({{ $t->items_count }})</p>
                                </div>
                            </span>
                        </li>
                    @endforeach
                </ul>
                <div class="hidden py-8 px-4 mt-24 mb-12 text-white md:block bg-highlight">
                    <div class="text-lg font-semibold">
                        Advanced Search
                    </div>
                    <div>

                    </div>
                    <a class="block py-4 px-8 mt-8 text-sm font-bold text-center text-white uppercase bg-secondary" href="{{ route('advanced-search') }}">
                        Begin Advanced Search
                    </a>
                </div>
            </div>
            <div class="col-span-12 md:col-span-9">
                <div>
                    <form wire:submit.prevent="submit">
                        <div class="pl-3">
                            <label for="search" class="sr-only">Search term</label>
                            <div class="relative mt-0 rounded-md shadow-sm">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none" aria-hidden="true">
                                    <svg class="mr-3 w-4 h-4 text-gray-400" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <input wire:model.defer="filters.search"
                                           type="search"
                                           id="search"
                                           class="block pl-9 w-full border-gray-300 sm:text-sm focus:ring-secondary focus:border-secondary"
                                           placeholder="Search by Title" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="flex grid flex-wrap grid-cols-1 lg:grid-cols-5 browse-controls">
                    <div class="col-span-3 items-center">
                        <nav class="flex justify-between items-center py-3 px-4 bg-white sm:px-6" role="navigation" aria-label="Pagination">
                            <div class="hidden sm:block">
                                <p class="text-base text-primary">
                                    Showing
                                    <span class="font-medium">{{ $items->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $items->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $items->total() }}</span>
                                    results
                                </p>
                            </div>
                            <div class="flex flex-1 justify-between sm:justify-end">
                                <span class="previous o-icon-prev button inactive"></span>
                                <span class="next o-icon-next button inactive"></span>
                            </div>
                        </nav>
                    </div>
                    <div class="flex grid col-span-2 justify-items-center items-center lg:justify-items-end">
                        <form class="sorting" action="">
                            @if(! empty(data_get($filters, 'type')))
                                <input type="hidden" name="type" value="{{ $filters['type'] }}">
                            @endif
                            <div class="inline-block">
                                <select wire:model="filters.sort"
                                        class="block py-2 pr-10 pl-3 mt-1 w-full text-base border border-gray-300 sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        name="sort"
                                        aria-label="Sort by">
                                   {{-- <option value="added:desc" @if(request()->get('sort') == 'added:desc') selected="" @endif>Added to Collection (Newest to Oldest)</option>
                                    <option value="added:asc" @if(request()->get('sort') == 'added:asc') selected="" @endif>Added to Collection (Oldest to Newest)</option>--}}
                                    <option value="created:desc"
                                            @selected(request()->get('sort') == 'created:desc')>
                                        Created (Newest to Oldest)
                                    </option>
                                    <option value="created:asc"
                                            @selected(request()->get('sort') == 'created:asc')>
                                        Created (Oldest to Newest)
                                    </option>
                                    <option value="title:asc"
                                            @selected(request()->get('sort') == 'title:asc')>
                                        Title (A-Z)
                                    </option>
                                    <option value="title:desc"
                                            @selected(request()->get('sort') == 'title:desc')>
                                        Title (Z-A)
                                    </option>
                                </select>
                            </div>

                            {{--<div class="inline-block">
                                <button type="submit" class="inline-flex items-center py-2 px-4 text-sm font-medium text-white border border-gray-300 shadow-sm focus:outline-none bg-secondary hover:text-highlight">Sort</button>
                            </div>--}}
                        </form>
                    </div>
                </div>
                <div wire:loading.remove
                     class="grid grid-cols-3 grid-flow-col gap-6 lg:grid-cols-4">
                    @if(data_get($filters, 'type') == $types->where('name', 'Letters')->first()->id)
                        <div class="col-span-1 px-4 pt-6">
                            <!-- This example requires Tailwind CSS v2.0+ -->
                            <nav class="space-y-1" aria-label="Decade filter">
                                @foreach($decades->sortBy('decade') as $d)
                                    <span wire:click="$set('filters.decade', {{ $d->decade }})"
                                        class="@if(data_get($this->filters, 'decade') == $d->decade) bg-gray-200 text-gray-900 @else text-gray-600 hover:bg-gray-50 hover:text-gray-900 @endif flex items-center pl-3 py-2 text-base font-medium cursor-pointer"
                                    >
                                        <span class="truncate">
                                          {{ $d->decade }}<span class="lowercase">s</span> ({{ $d->total }})
                                        </span>
                                        <span class="inline-block py-0.5 px-3 ml-auto text-xs">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                    </span>
                                    @if(data_get($this->filters, 'decade') == $d->decade)
                                        <div class="pl-4">
                                            @foreach($years->sortBy('year') as $y)
                                                <span wire:click="$set('filters.year', {{ $y->year }})"
                                                   class="@if(data_get($this->filters, 'year') == $y->year) bg-gray-200 text-gray-900 @else text-gray-600 hover:bg-gray-50 hover:text-gray-900 @endif flex items-center pl-3 py-2 text-base font-medium cursor-pointer"
                                                >
                                                    <span class="truncate">
                                                      {{ $y->year }} ({{ $y->total }})
                                                    </span>
                                                    <span class="inline-block py-0.5 px-3 ml-auto text-xs">
                                                      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </span>
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </nav>
                        </div>
                    @endif
                    <div class="col-span-2 lg:col-span-3">
                        <ul class="px-4 divide-y divide-gray-200">
                            @if($items->count() > 0)
                                @foreach($items as $item)
                                    <x-item-summary :item="$item"/>
                                @endforeach
                            @else
                                <div class="p-4 mx-auto mb-24 max-w-6xl bg-yellow-50 border-l-4 border-yellow-400">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <!-- Heroicon name: solid/exclamation -->
                                            <svg class="w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                Sorry, we are still working on transcribing these documents. Subscribe to our newsletter to get updates.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </ul>
                    </div>
                </div>
                <div wire:loading.grid
                     class="grid grid-cols-3 grid-flow-col gap-6 lg:grid-cols-4">
                    @if(data_get($filters, 'type') == $types->where('name', 'Letters')->first()->id)
                        <div class="col-span-1 px-4 pt-6">
                            <!-- This example requires Tailwind CSS v2.0+ -->
                            <nav class="space-y-1" aria-label="Decade filter">
                                @foreach($decades as $d)
                                    <span wire:click="$set('filters.decade', {{ $d->decade }})"
                                          class="@if(data_get($this->filters, 'decade') == $d->decade) bg-gray-200 text-gray-900 @else text-gray-600 hover:bg-gray-50 hover:text-gray-900 @endif flex items-center pl-3 py-2 text-base font-medium cursor-pointer"
                                    >
                                        <span class="truncate">
                                            <div data-placeholder class="overflow-hidden relative mb-2 h-6 bg-gray-200">

                                            </div>
                                        </span>
                                        <span class="inline-block py-0.5 px-3 ml-auto text-xs">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                    </span>
                                @endforeach
                            </nav>
                        </div>
                    @endif
                    <div class="col-span-2 lg:col-span-3">
                        <ul class="px-4 divide-y divide-gray-200">
                            @foreach([1, 2, 3, 4, 5] as $placeholder)
                                <li class="grid grid-cols-7 py-4">
                                    <div class="col-span-1 pl-4">
                                        <div data-placeholder class="overflow-hidden relative my-2 mr-2 w-20 h-20 bg-gray-200">

                                        </div>
                                    </div>
                                    <div class="col-span-6 py-2 pl-4">
                                        <div class="flex flex-col justify-between">
                                            <div data-placeholder class="overflow-hidden relative mb-2 w-40 h-8 bg-gray-200">

                                            </div>
                                            <div data-placeholder class="overflow-hidden relative w-40 h-6 bg-gray-200">

                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div wire:loading.remove
                     class="px-8 my-4">
                    {!! $items->links() !!}
                </div>

            {{--<nav class="flex justify-between items-center py-3 px-4 bg-white sm:px-6" role="navigation" aria-label="Pagination">
                <div class="hidden sm:block">
                    <p class="text-base text-primary">
                        Showing
                        <span class="font-medium">{{ $items->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $items->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $items->total() }}</span>
                        results
                    </p>
                </div>
                <div class="flex flex-1 justify-between sm:justify-end">
                    <span class="previous o-icon-prev button inactive"></span>
                    <span class="next o-icon-next button inactive"></span>
                </div>
            </nav>--}}

            <!--
                    <div class="blocks">
                                        </div>
                -->
            </div>

        </div>
    </div>
    @push('styles')
        <style>
            [data-placeholder]::after {
                content: " ";
                box-shadow: 0 0 50px 9px rgba(254,254,254);
                position: absolute;
                top: 0;
                left: -100%;
                height: 100%;
                animation: load 1s infinite;
            }
            @keyframes load {
                0%{ left: -100%}
                100%{ left: 150%}
            }
        </style>
    @endpush
</div>
