<x-guest-layout>

    <div class="mx-auto max-w-7xl">
        <div class="page-title">
            Understand the unfolding Restoration through Wilford’s unique eyewitness account
        </div>
        <div class="grid grid-cols-12">
            <div class="col-span-12 md:col-span-3">
                <ul class="divide-y divide-gray-200 submenu">
                    <li class="flex">
                        <a class="py-4 block w-full text-gray-900 hover:bg-gray-100 @if(empty(request()->get('type'))) active @else @endif"
                           href="{{ route('documents') }}">
                            <div class="ml-3">
                                <p class="text-lg font-medium">All</p>
                            </div>
                        </a>
                    </li>
                    @foreach($types as $type)
                        <li class="flex">
                            <a class="py-4 block w-full text-gray-900 hover:bg-gray-100 @if($type->id == request()->get('type')) active @else @endif"
                               href="{{ route('documents', ['type' => $type]) }}">
                                <div class="ml-3">
                                    <p class="text-lg font-medium">{{ $type->name }} ({{ $type->items_count }})</p>
                                </div>
                            </a>
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
                            @if(request()->has('type'))
                                <input type="hidden" name="type" value="{{ request('type') }}">
                            @endif
                            <div class="inline-block">
                                <select class="block py-2 pr-10 pl-3 mt-1 w-full text-base border border-gray-300 sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
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

                            <div class="inline-block">
                                <button type="submit" class="inline-flex items-center py-2 px-4 text-sm font-medium text-white border border-gray-300 shadow-sm focus:outline-none bg-secondary hover:text-highlight">Sort</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-3 grid-flow-col gap-6 lg:grid-cols-4">
                    @if(request()->has('type') && (request()->get('type') == \App\Models\Type::firstWhere('name', 'Letters')->id))
                        <div class="col-span-1 px-4 pt-6">
                            <!-- This example requires Tailwind CSS v2.0+ -->
                            <nav class="space-y-1" aria-label="Decade filter">
                                @foreach($decades->sortBy('decade') as $decade)
                                    <a class="@if(request()->get('decade') == $decade->decade) bg-gray-200 text-gray-900 @else text-gray-600 hover:bg-gray-50 hover:text-gray-900 @endif flex items-center pl-3 py-2 text-base font-medium"
                                       href="{{ route('documents', ['type' => $type, 'decade' => $decade->decade]) }}">
                                        <span class="truncate">
                                          {{ $decade->decade }}<span class="lowercase">s</span> ({{ $decade->total }})
                                        </span>
                                        <span class="inline-block py-0.5 px-3 ml-auto text-xs">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                    </a>
                                    @if(request()->has('decade') && request()->get('decade') == $decade->decade)
                                        <div class="pl-4">
                                            @foreach($years->sortBy('year') as $year)
                                                <a class="@if(request()->get('year') == $year->year) bg-gray-200 text-gray-900 @else text-gray-600 hover:bg-gray-50 hover:text-gray-900 @endif flex items-center pl-3 py-2 text-base font-medium"
                                                   href="{{ route('documents', ['type' => $type, 'decade' => $decade->decade, 'year' => $year->year]) }}">
                                                    <span class="truncate">
                                                      {{ $year->year }} ({{ $year->total }})
                                                    </span>
                                                            <span class="inline-block py-0.5 px-3 ml-auto text-xs">
                                                      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </span>
                                                </a>
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


                <div class="px-8 my-4">
                    {!! $items->withQueryString()->links('vendor.pagination.tailwind') !!}
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


    {{--@each('components.item-summary', $items, 'item')--}}

</x-guest-layout>


