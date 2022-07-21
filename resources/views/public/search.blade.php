<x-guest-layout>
    <x-slot name="title">
        Search Documents | {{ config('app.name') }}
    </x-slot>
    <div class="max-w-7xl mx-auto">

        <div class="my-12 mx-4 bg-gray-200 py-2 px-12">
            <form action="{{ route('advanced-search') }}" method="GET">
                <div class="space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-4">
                        <label for="q"
                               class="block text-xl font-medium text-gray-700 sm:mt-px sm:pt-2 pl-8">
                            Search
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-3 md:mr-8">
                            <input type="search"
                                   name="q"
                                   id="q"
                                   value="{{ request('q') }}"
                                   class="block max-w-5xl w-full shadow-sm focus:ring-gray-500 focus:border-gray-500 sm:text-sm border-gray-300">
                        </div>
                    </div>
                </div>
                <div class="space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-4 px-8">
                        @foreach($types as $type)
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="type-{{ $type->id }}"
                                           name="types[]"
                                           type="checkbox"
                                           value="{{ $type->id }}"
                                           @if((empty(request('types')) && request('people') != 1) || (request('types') && in_array($type->id, request('types')))) checked="checked" @endif
                                           class="focus:ring-secondary h-4 w-4 text-secondary border-gray-300">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="type-{{ $type->id }}" class="font-medium text-gray-700">{{ $type->name }}</label>
                                </div>
                            </div>
                        @endforeach
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="type-people"
                                       name="people"
                                       type="checkbox"
                                       value="1"
                                       @if(empty(request('types')) || request('people') == 1) checked="checked" @endif
                                       class="focus:ring-secondary h-4 w-4 text-secondary border-gray-300">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="people" class="font-medium text-gray-700">People</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-6 sm:space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 mt-0 sm:pb-5">
                        <div class="px-8 grid grid-cols-1 sm:grid-cols-2">
                            <div class="text-lg font-medium text-primary sm:mt-px sm:pt-2">
                                <div class="mt-4 sm:mt-0">
                                    <div class="max-w-lg space-y-4">
                                        <div class="relative flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="use_min_date"
                                                       name="use_min_date"
                                                       type="checkbox"
                                                       value="true"
                                                       class="focus:secondary h-4 w-4 text-secondary border-gray-300 rounded"
                                                       @checked(request('use_min_date'))
                                                >
                                            </div>
                                            <div class="ml-3 mb-3 text-lg">
                                                <label for="use_min_date" class="font-medium text-primary">Date comes after</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <label for="min_date" class="block text-sm font-medium text-gray-700 sr-only">Date comes after</label>
                                <input type="date"
                                       name="min_date"
                                       id="min_date"
                                       value="{{ request('min_date', $dates['min']->date->toDateString()) }}"
                                       class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300">
                            </div>
                        </div>
                        <div class="px-8 grid grid-cols-1 sm:grid-cols-2">
                            <div class="text-lg font-medium text-primary sm:mt-px sm:pt-2">
                                <div class="mt-4 sm:mt-0">
                                    <div class="max-w-lg space-y-4">
                                        <div class="relative flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="use_max_date"
                                                       name="use_max_date"
                                                       type="checkbox"
                                                       value="true"
                                                       class="focus:secondary h-4 w-4 text-secondary border-gray-300 rounded"
                                                        @checked(request('use_max_date'))
                                                >
                                            </div>
                                            <div class="ml-3 mb-3 text-lg">
                                                <label for="use_max_date" class="font-medium text-primary">Date comes before</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <label for="max_date" class="block text-sm font-medium text-gray-700 sr-only">Date comes before</label>
                                <input type="date"
                                       name="max_date"
                                       id="max_date"
                                       value="{{ request('max_date', $dates['max']->date->toDateString()) }}"
                                       class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mx-8 col-span-2" id="page-actions">
                        <div class="grid grid-cols-2">
                            <div>
                                <input class="inline-flex items-center relative inline-flex items-center px-2 sm:px-12 py-3 border border-secondary text-sm font-medium text-white bg-secondary hover:text-highlight cursor-pointer" type="submit" name="submit" value="Search">
                            </div>
                            <div class="grid justify-items-end">
                                <select class="max-w-xs block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:ring-secondary focus:border-secondary sm:text-sm"
                                        name="sort"
                                        aria-label="Sort by">
                                    <option value="added:desc" @if(request()->get('sort') == 'added:desc') selected="" @endif>Added to Collection (Newest to Oldest)</option>
                                    <option value="added:asc" @if(request()->get('sort') == 'added:asc') selected="" @endif>Added to Collection (Oldest to Newest)</option>
                                    <option value="created:desc" @if(request()->get('sort') == 'created:desc') selected="" @endif>Created (Newest to Oldest)</option>
                                    <option value="created:asc" @if(request()->get('sort') == 'created:asc') selected="" @endif>Created (Oldest to Newest)</option>
                                    <option value="title:asc" @if(request()->get('sort') == 'title:asc') selected="" @endif>Title (A-Z)</option>
                                    <option value="title:desc" @if(request()->get('sort') == 'title:desc') selected="" @endif>Title (Z-A)</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <div class="browse-controls flex flex-wrap grid grid-cols-1 lg:grid-cols-2 mt-8">
            <div class="items-center col-span-2 px-8">
                {!! $pages->withQueryString()->links('vendor.pagination.tailwind') !!}
            </div>
        </div>

        @if($people->count() > 0)
            <div class="px-4">
                <h2 class="text-primary text-2xl font-serif mt-4 mb-4 border-b border-gray-300">
                    People
                </h2>
                <ul class="divide-y divide-gray-200">

                    @foreach($people as $person)

                        <x-person-summary :person="$person" />

                    @endforeach

                </ul>
            </div>
        @endif

        <div id="results" class="px-4">
            <h2 class="text-primary text-2xl font-serif mt-4 mb-4 border-b border-gray-300">
                Documents
            </h2>
            @if($pages->total() > 0)
                <ul class="divide-y divide-gray-200">

                    @foreach($pages as $page)

                        <x-page-summary :page="$page" />

                    @endforeach

                </ul>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-24 max-w-6xl mx-auto">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Heroicon name: solid/exclamation -->
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Sorry, we could not find any results for your search. Please try expanding your search.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="my-4 px-8">
            {!! $pages->withQueryString()->links('vendor.pagination.tailwind') !!}
        </div>

    </div>

</x-guest-layout>
