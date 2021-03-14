<x-guest-layout>

    <div class="max-w-7xl mx-auto">
        <div class="page-title">
            Understand the unfolding Restoration through Wilford’s unique eyewitness account
        </div>
        <div class="grid grid-cols-12">
            <div class="col-span-12 md:col-span-3">
                <ul class="divide-y divide-gray-200">

                    @foreach($types as $type)
                        <li class="flex">
                            <a class="py-4 block w-full text-gray-900 hover:bg-gray-100" href="{{ route('documents', ['type' => $type]) }}">
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
                    <a class="block text-sm text-center text-white font-bold bg-secondary uppercase py-4 px-8 mt-8" href="/s/wilford-woodruff-papers/item/search">
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
                            <input type="hidden" name="page" value="1">
                            <div class="inline-block">
                                <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" name="sort_by" aria-label="Sort by">
                                    <option value="dcterms:title">Title</option>
                                    <option value="created" selected="">Added to Collection</option>
                                </select>
                            </div>

                            <div class="inline-block">
                                <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" name="sort_order" aria-label="Sort order">
                                    <option value="asc">Ascending</option>
                                    <option value="desc" selected="">Descending</option>
                                </select>
                            </div>

                            <div class="inline-block">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium text-white bg-secondary hover:text-highlight focus:outline-none">Sort</button>
                            </div>
                        </form>                    </div>
                </div>
                <ul class="divide-y divide-gray-200 px-4">

                    @foreach($items as $item)
                        <li class="py-4 grid grid-cols-7">
                            <div class="col-span-1 ">
                                <a class="col-span-1" href="/s/wilford-woodruff-papers/item/2505"><img class="h-auto w-20 my-2 mx-auto" src="https://wilfordwoodruffpapers.org/files/medium/0ba67b58e7ee4e8a94a1b8bd87ff2f2f5dde54c7.jpg" alt=""></a>                                                            </div>
                            <div class="col-span-6 py-2">
                                <a href="/s/wilford-woodruff-papers/item/2505">
                                    <div class="ml-3">
                                        <p class="text-lg font-medium text-secondary pb-1">{{ $item->name }}</p>
                                        <p>{{ $item->type->name }}</p>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-900"></p>
                                    </div>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>

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

                <!--
                    <div class="blocks">
                                        </div>
                -->        </div>
        </div>
    </div>
    

    {{--@each('components.item-summary', $items, 'item')--}}

</x-guest-layout>


