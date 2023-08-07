<div x-ref="container"
     class="relative"
>

    <div class="sticky top-10 z-10">
        <div class="grid z-50 grid-cols-6 gap-x-2 items-center py-4 text-center bg-white">
            <div class="flex justify-start">
                <div class="z-50 -ml-0.5 bg-white">
                    <div class="">
                        <div x-show="! filtersOpen"
                             x-cloak
                        >
                            <button x-on:click="filtersOpen = true"
                                    type="button"
                                    class="inline-flex gap-x-1.5 items-center py-3 px-3 text-sm font-semibold text-gray-900 border-t border-r border-b border-gray-300 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary-600">
                                <span class="sr-only">Show filtering options</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-0.5 w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                                </svg>
                            </button>
                        </div>
                        <div x-show="filtersOpen"
                             x-cloak
                        >
                            <button x-on:click="filtersOpen = false"
                                    type="button"
                                    class="inline-flex gap-x-1.5 items-center py-3 px-3 text-sm font-semibold text-gray-900 border-t border-r border-b border-gray-300 hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary-600">
                                <span class="sr-only">Hide filtering options</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-0.5 w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($groups as $group)
                <div class="inline-block">
                    <div x-on:click="{{ str($group)->snake() }} = ! {{ str($group)->snake() }}"
                         x-show="{{ str($group)->snake() }}"
                         class="font-semibold cursor-pointer"
                    >
                        {{ $group }}
                    </div>
                    <span x-on:click="{{ str($group)->snake() }} = ! {{ str($group)->snake() }}"
                          x-show="! {{ str($group)->snake() }}"
                          x-cloak
                          class="flex justify-center items-center w-auto cursor-pointer"
                          title="Show {{ $group }} Events"
                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                </div>
            @endforeach
        </div>
        <div id="event-selector"
             class="top-0 w-full h-20 bg-gray-800 opacity-25">

        </div>
    </div>
    <div class="">
        @if($v_min < 1810)
            <div class="flex sticky top-0 z-10 justify-center items-center my-0 w-full text-4xl font-bold text-white h-18 bg-primary">
                1800
            </div>
        @endif

        @foreach ($years as $year => $months)
            @php
                $count = 0;
            @endphp

            @if(($year % 10) == 0)
                <div class="grid grid-cols-6 px-4 h-8 divide-x divide-slate-300">
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                </div>

                <div class="flex sticky top-0 z-10 justify-center items-center w-full text-4xl font-bold text-white h-18 bg-primary">
                    {{ $year }}
                </div>

                <div class="grid grid-cols-6 px-4 h-8 divide-x divide-slate-300">
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                </div>
            @else
                <div class="grid grid-cols-6 px-4 h-14 divide-x divide-slate-300">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $year }}
                        </p>
                    </div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            @endif


            <div>
                @if($months->filter(function($month){
                    return count($month) > 0;
                })->count() > 0)
                    @foreach($months as $month => $monthEvents)
                        <div>
                            @if(count($monthEvents) > 0)
                                <div class="grid grid-cols-6 px-4 h-8 divide-x divide-slate-300">
                                    <div class="font-semibold">
                                        {{ $month }}
                                    </div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                @foreach($monthEvents->groupBy('date') as $events)
                                    @php
                                        $count = 0;
                                    @endphp
                                    <div class="grid grid-cols-6 px-4 divide-x divide-slate-300 min-h-[3.5rem]">
                                        <div class="border-t border-gray-400 border-1">
                                        </div>
                                        @foreach($groups as $key => $group)
                                            @php
                                                if($count == 0){
                                                  $count = $events->where('type', $group)->count();
                                                }
                                            @endphp
                                            <div @class([
                                                        str($group)->slug().' col-span-1',
                                                        'border-t !border-t-gray-400 border-1' => $count == 0,
                                                      ])
                                                 class="{{ str($group)->slug() }} col-span-1"
                                            >
                                                @foreach($events->where('type', $group)->all() as $hit)
                                                    <div x-on:click="event = {
                                                                image: '{{ data_get($hit, 'thumbnail') }}',
                                                                date: '{{ data_get($hit, 'display_date') }}',
                                                                text: '{{ addslashes(str($hit['name'])->addScriptureLinks()->toString()) }}',
                                                                links: [
                                                                    @foreach(data_get($hit, 'links', []) as $link)
                                                                        { name: '{{ $link['name'] }}',
                                                                        url: '{{ $link['url'] }}'},
                                                                    @endforeach
                                                                ]
                                                            }"
                                                         x-show="{{ str($group)->snake() }}"
                                                         id="container_{{ $hit['id'] }}"
                                                         class="z-10 w-full h-14 cursor-pointer"
                                                    >
                                                        <div @scroll.window.throttle.50ms="$overlap('#event-selector') ? event = {
                                                                    image: '{{ data_get($hit, 'thumbnail') }}',
                                                                    date: '{{ data_get($hit, 'display_date') }}',
                                                                    text: '{{ addslashes(str($hit['name'])->addScriptureLinks()->toString()) }}',
                                                                    links: [
                                                                        @foreach(data_get($hit, 'links', []) as $link)
                                                                            { name: '{{ $link['name'] }}',
                                                                            url: '{{ $link['url'] }}'},
                                                                        @endforeach
                                                                    ]
                                                                } : null"
                                                             class="relative h-10 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600"
                                                             id="event_{{ $hit['id'] }}"
                                                        >
                                                            <div @class([
                                                                    'absolute w-[22rem] text-sm font-normal bg-white hover:z-10 drop-shadow-md',
                                                                    'left-[25%]' => ($key <= 2),
                                                                    'right-[25%]' => ($key > 2),
                                                                ])>
                                                                <div class="flex">
                                                                    <div @class([
                                                                            'flex-1 py-1',
                                                                            'order-2 pl-8 pr-1' => ($key <= 2),
                                                                            'order-1 pr-8 pl-1' => ($key > 2),
                                                                        ])>
                                                                        <div class="">
                                                                            <p class="font-semibold">
                                                                                {{ data_get($hit, 'display_date') }}
                                                                            </p>
                                                                            <p class="line-clamp-1">
                                                                                {{ str($hit['name'])->limit(40, '...') }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    @if(data_get($hit, 'thumbnail'))
                                                                        <div @class([
                                                                                        'flex-0',
                                                                                        'order-1' => ($key <= 2),
                                                                                        'order-2' => ($key > 2),
                                                                                    ])>
                                                                            <img src="{{ data_get($hit, 'thumbnail') }}"
                                                                                 alt=""
                                                                                 class="object-cover object-top mx-auto w-20 bg-gray-100 scale-150 aspect-[16/9] sm:aspect-[2/1] lg:aspect-[3/2]">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @else
                                <div class="grid grid-cols-6 px-4 h-8 divide-x divide-slate-300">
                                    <div>
                                        <div class="w-1/2 border-t border-gray-400 border-1"></div>
                                    </div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
</div>
