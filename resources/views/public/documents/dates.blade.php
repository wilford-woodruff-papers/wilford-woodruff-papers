<x-guest-layout>

    <div class="max-w-7xl mx-auto">
        <div class="page-title">
            Understand the unfolding Restoration through Wilford’s unique eyewitness account
        </div>
        <div class="grid grid-cols-12">
            <div class="col-span-12 md:col-span-3">
                <ul class="divide-y divide-gray-200">

                    @foreach($years as $year)
                        <li class="flex">
                            <a class="py-4 block w-full text-gray-900 hover:bg-gray-100" href="{{ route('documents.dates', ['year' => $year->year]) }}">
                                <div class="ml-3">
                                    <p class="text-lg font-medium">{{ $year->year }}</p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if(! empty($months) && $months->count() > 0)
                <div class="col-span-12 md:col-span-3">
                    <ul class="divide-y divide-gray-200">

                        @foreach($months as $month)
                            <li class="flex">
                                <a class="py-4 block w-full text-gray-900 hover:bg-gray-100" href="{{ route('documents.dates', ['year' => request('year'), 'month' => $month->month]) }}">
                                    <div class="ml-3">
                                        <p class="text-lg font-medium">{{ monthName($month->month) }}</p>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(! empty($pages) && $pages->count() > 0)
                <div class="col-span-12 md:col-span-6">
                    <ul class="divide-y divide-gray-200 px-4">
                        @foreach($pages as $page)
                            <x-page-summary :page="$page"/>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="col-span-12 md:col-span-9">
                <div class="browse-controls flex flex-wrap grid grid-cols-1 lg:grid-cols-5">
                    <div class="items-center col-span-3">

                    </div>
                    <div class="col-span-2 flex items-center grid justify-items-center lg:justify-items-end">

                    </div>
                </div>
                <ul class="divide-y divide-gray-200 px-4">

                   {{-- @foreach($items as $item)
                        <x-item-summary :item="$item"/>
                    @endforeach--}}
                </ul>

                <div class="my-4 px-8">
                    {{--{!! $items->withQueryString()->links('vendor.pagination.tailwind') !!}--}}
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


