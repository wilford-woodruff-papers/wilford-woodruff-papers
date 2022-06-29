<x-guest-layout>

    <div class="max-w-7xl mx-auto">
        <div class="page-title">
            Understand the unfolding Restoration through Wilford’s unique eyewitness account
        </div>
        <div class="grid grid-cols-12">
            <div class="col-span-12 md:col-span-3">
                <ul class="submenu divide-y divide-gray-200">
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
                <div class="hidden md:block mt-24 bg-highlight text-white py-8 px-4 mb-12">
                    <div class="text-lg font-semibold">
                        Advanced Search
                    </div>
                    <div>

                    </div>
                    <a class="block text-sm text-center text-white font-bold bg-secondary uppercase py-4 px-8 mt-8" href="{{ route('advanced-search') }}">
                        Begin Advanced Search
                    </a>
                </div>
            </div>
            <div class="col-span-12 md:col-span-9">
                <div class="browse-controls flex flex-wrap grid grid-cols-1 lg:grid-cols-5">
                    <div class="items-center col-span-3">
                        <nav class="bg-white px-4 py-3 flex items-center justify-between sm:px-6" role="navigation" aria-label="Pagination">
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
                            <div class="flex-1 flex justify-between sm:justify-end">
                                <span class="previous o-icon-prev button inactive"></span>
                                <span class="next o-icon-next button inactive"></span>
                            </div>
                        </nav>
                    </div>
                    <div class="col-span-2 flex items-center grid justify-items-center lg:justify-items-end">
                        <form class="sorting" action="">
                            @if(request()->has('type'))
                                <input type="hidden" name="type" value="{{ request('type') }}">
                            @endif
                            <div class="inline-block">
                                <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
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
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium text-white bg-secondary hover:text-highlight focus:outline-none">Sort</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="grid grid-flow-col grid-cols-3 lg:grid-cols-4 gap-6">
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
                                        <span class="ml-auto inline-block py-0.5 px-3 text-xs">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                                            <span class="ml-auto inline-block py-0.5 px-3 text-xs">
                                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                        <ul class="divide-y divide-gray-200 px-4">
                            @if($items->count() > 0)
                                @foreach($items as $item)
                                    <x-item-summary :item="$item"/>
                                @endforeach
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
                                                Sorry, we are still working on transcribing these documents. Subscribe to our newsletter to get updates.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </ul>
                    </div>
                </div>


                <div class="my-4 px-8">
                    {!! $items->withQueryString()->links('vendor.pagination.tailwind') !!}
                </div>

                {{--<nav class="bg-white px-4 py-3 flex items-center justify-between sm:px-6" role="navigation" aria-label="Pagination">
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
                    <div class="flex-1 flex justify-between sm:justify-end">
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


