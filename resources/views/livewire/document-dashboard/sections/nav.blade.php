<div>
    <div class="top-0 z-10 bg-white md:sticky"
         :class="{'': !scrolledFromTop, 'md:shadow-2xl': scrolledFromTop}">
        <div x-ref="nav"
             class="px-12 mx-auto max-w-7xl">
            <ul role="list"
                class="flex flex-col transition-all duration-200 md:flex-row md:items-center"
                :class="{'gap-6': !scrolledFromTop, 'md:divide-x md:divide-gray-200': scrolledFromTop}"
            >
                @foreach($sections as $key => $stat)
                    @if(! empty($stat['items']) && $stat['items']->count() > 0)
                        <li class="flex-1 bg-white divide-y divide-gray-200 hover:bg-gray-100"
                            :class="{'shadow border border-gray-200': !scrolledFromTop, '': scrolledFromTop}">
                            <a href="#{{ str($stat['name'])->slug() }}">
                                <div class="flex justify-between items-center py-2 px-6 space-x-6 w-full">
                                    <div class="flex flex-row flex-1 gap-y-1 gap-x-4 justify-start items-center md:flex-col lg:items-start truncate">
                                        <div class="flex items-center space-x-3">
                                            <h3 class="text-2xl font-semibold text-gray-900 truncate">
                                                {{ $stat['items']->count() }}
                                            </h3>
                                        </div>
                                        <p class="mt-1 text-lg font-semibold uppercase text-secondary truncate">
                                            {{ str($key)->plural($stat['items']->count()) }}
                                        </p>
                                    </div>
                                    <div class="hidden flex-shrink-0 justify-center items-center w-10 h-10 lg:flex bg-secondary">
                                        <x-dynamic-component :component="$stat['icon']" class="w-6 h-6 text-white"/>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
