<x-guest-layout>
    <x-slot name="title">
        Search Documents | {{ config('app.name') }}
    </x-slot>
    <div class="mx-auto max-w-7xl">

        <div class="py-2 px-12 my-12 mx-4 bg-gray-200">
            <form action="{{ route('advanced-search') }}" method="GET">
                <div class="space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:py-4 sm:border-t sm:border-gray-200">
                        <label for="q"
                               class="block pl-8 text-xl font-medium text-gray-700 sm:pt-2 sm:mt-px">
                            Search
                        </label>
                        <div class="mt-1 sm:col-span-3 sm:mt-0 md:mr-8">
                            <input type="search"
                                   name="q"
                                   id="q"
                                   value="{{ request('q') }}"
                                   class="block w-full max-w-5xl border-gray-300 shadow-sm sm:text-sm focus:border-gray-500 focus:ring-gray-500">
                        </div>
                    </div>
                </div>
                <div class="space-y-6 sm:space-y-5">
                    <div class="px-8 sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start sm:py-4 sm:border-t sm:border-gray-200">
                        @foreach($types as $type)
                            <div class="flex relative items-start">
                                <div class="flex items-center h-5">
                                    <input id="type-{{ $type->id }}"
                                           name="types[]"
                                           type="checkbox"
                                           value="{{ $type->id }}"
                                           @if((empty(request('types')) && request('people') != 1) || (request('types') && in_array($type->id, request('types')))) checked="checked" @endif
                                           class="w-4 h-4 border-gray-300 text-secondary focus:ring-secondary">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="type-{{ $type->id }}" class="font-medium text-gray-700">{{ $type->name }}</label>
                                </div>
                            </div>
                        @endforeach
                        <div class="flex relative items-start">
                            <div class="flex items-center h-5">
                                <input id="type-people"
                                       name="people"
                                       type="checkbox"
                                       value="1"
                                       @if(empty(request('types')) || request('people') == 1) checked="checked" @endif
                                       class="w-4 h-4 border-gray-300 text-secondary focus:ring-secondary">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="people" class="font-medium text-gray-700">People</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-6 sm:space-y-5">
                    <div class="grid grid-cols-1 mt-0 sm:grid-cols-2 sm:pb-5">
                        <div class="grid grid-cols-1 px-8 sm:grid-cols-2">
                            <div class="text-lg font-medium sm:pt-2 sm:mt-px text-primary">
                                <div class="mt-4 sm:mt-0">
                                    <div class="space-y-4 max-w-lg">
                                        <div class="flex relative items-start">
                                            <div class="flex items-center h-5">
                                                <input id="use_min_date"
                                                       name="use_min_date"
                                                       type="checkbox"
                                                       value="true"
                                                       class="w-4 h-4 rounded border-gray-300 text-secondary focus:secondary"
                                                       @checked(request('use_min_date'))
                                                >
                                            </div>
                                            <div class="mb-3 ml-3 text-lg">
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
                                       class="block mt-1 w-full border-gray-300 shadow-sm sm:text-sm focus:border-gray-500 focus:ring-gray-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 px-8 sm:grid-cols-2">
                            <div class="text-lg font-medium sm:pt-2 sm:mt-px text-primary">
                                <div class="mt-4 sm:mt-0">
                                    <div class="space-y-4 max-w-lg">
                                        <div class="flex relative items-start">
                                            <div class="flex items-center h-5">
                                                <input id="use_max_date"
                                                       name="use_max_date"
                                                       type="checkbox"
                                                       value="true"
                                                       class="w-4 h-4 rounded border-gray-300 text-secondary focus:secondary"
                                                        @checked(request('use_max_date'))
                                                >
                                            </div>
                                            <div class="mb-3 ml-3 text-lg">
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
                                       class="block mt-1 w-full border-gray-300 shadow-sm sm:text-sm focus:border-gray-500 focus:ring-gray-500">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 mx-8 mt-4" id="page-actions">
                        <div class="grid grid-cols-2">
                            <div>
                                <input class="inline-flex relative items-center py-3 px-2 text-sm font-medium text-white border cursor-pointer sm:px-12 border-secondary bg-secondary hover:text-highlight" type="submit" name="submit" value="Search">
                            </div>
                            <div class="grid justify-items-end">
                                <select class="block py-2 pr-10 pl-3 w-full max-w-xs text-base border border-gray-300 sm:text-sm focus:ring-secondary focus:border-secondary"
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

        <div class="flex grid flex-wrap grid-cols-1 mt-8 lg:grid-cols-2 browse-controls">
            <div class="col-span-2 items-center px-8">
                {!! $pages->withQueryString()->links('vendor.pagination.tailwind') !!}
            </div>
        </div>

        @if($people->count() > 0)
            <div class="px-4">
                <h2 class="mt-4 mb-4 font-serif text-2xl border-b border-gray-300 text-primary">
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
            <h2 class="mt-4 mb-4 font-serif text-2xl border-b border-gray-300 text-primary">
                Documents
            </h2>
            @if($pages->total() > 0)
                <ul class="divide-y divide-gray-200">

                    @foreach($pages as $page)

                        <x-page-summary :page="$page" />

                    @endforeach

                </ul>
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
                                Sorry, we could not find any results for your search. Please try expanding your search.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="px-8 my-4">
            {!! $pages->withQueryString()->links('vendor.pagination.tailwind') !!}
        </div>

    </div>

</x-guest-layout>
