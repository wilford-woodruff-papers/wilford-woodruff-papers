<x-guest-layout>

    <div class="max-w-7xl mx-auto">

        <div class="my-12 mx-4 bg-gray-200 py-2 px-12">
            <form action="{{ route('search') }}" method="GET">
                <div class="space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-4">
                        <label for="q"
                               class="block text-xl font-medium text-gray-700 sm:mt-px sm:pt-2 pl-8">
                            Search
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-3">
                            <input type="search"
                                   name="q"
                                   id="q"
                                   value="{{ request('q') }}"
                                   class="block max-w-5xl w-full shadow-sm focus:ring-gray-500 focus:border-gray-500 sm:text-sm border-gray-300">
                        </div>
                    </div>
                </div>
                <div class="space-y-6 sm:space-y-5">
                    <div class="grid grid-cols-2 mt-0 sm:pb-5">
                        <div class="px-8">
                            <div class="block text-lg font-medium text-primary sm:mt-px sm:pt-2">
                                <div class="mt-4 sm:mt-0 sm:col-span-2">
                                    <div class="max-w-lg space-y-4">
                                        <div class="relative flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="use_min_date" name="use_min_date" type="checkbox" value="true" class="focus:secondary h-4 w-4 text-secondary border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 mb-3 text-lg">
                                                <label for="use_min_date" class="font-medium text-primary">Date comes after</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label for="min_date" class="block text-sm font-medium text-gray-700 sr-only">Date comes after</label>
                                <input type="date"
                                       name="min_date"
                                       id="min_date"
                                       value="{{ $dates['min']->date->toDateString() }}"
                                       class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300">
                            </div>
                        </div>
                        <div class="px-8">
                            <div class="block text-lg font-medium text-primary sm:mt-px sm:pt-2">
                                <div class="mt-4 sm:mt-0 sm:col-span-2">
                                    <div class="max-w-lg space-y-4">
                                        <div class="relative flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="use_max_date" name="use_max_date" type="checkbox" value="true" class="focus:secondary h-4 w-4 text-secondary border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 mb-3 text-lg">
                                                <label for="use_max_date" class="font-medium text-primary">Date comes after</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label for="max_date" class="block text-sm font-medium text-gray-700 sr-only">Date comes before</label>
                                <input type="date"
                                       name="max_date"
                                       id="max_date"
                                       value="{{ $dates['max']->date->toDateString() }}"
                                       class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300">
                            </div>
                        </div>
                        <div class="mt-4 mx-8" id="page-actions">
                            <input class="inline-flex items-center relative inline-flex items-center px-12 py-2 border border-secondary text-sm font-medium text-white bg-secondary hover:text-highlight cursor-pointer" type="submit" name="submit" value="Search">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="browse-controls flex flex-wrap grid grid-cols-1 lg:grid-cols-4 mt-8">
            <div class="items-center col-span-2 px-8">
                {!! $pages->links('vendor.pagination.tailwind') !!}
            </div>
            <div class="flex items-center grid justify-items-center lg:justify-items-end md:col-span-2">

            </div>
        </div>

        <div class="">
            <ul class="divide-y divide-gray-200">

                @foreach($pages as $page)

                    <x-page-summary :page="$page" />

                @endforeach

            </ul>
        </div>

        <div class="my-4 px-8">
            {!! $pages->links('vendor.pagination.tailwind') !!}
        </div>

    </div>

</x-guest-layout>
