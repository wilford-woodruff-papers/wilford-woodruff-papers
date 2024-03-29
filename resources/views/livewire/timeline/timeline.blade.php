<div x-ref="container"
     class="relative"
>

    <div id="context-header" class="sticky top-10 z-50">
        <div class="grid z-50 grid-cols-11 gap-x-2 items-center py-4 text-center bg-white">
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
                <div class="inline-block col-span-2 px-2">
                    <div x-on:click="{{ str($group)->snake() }} = ! {{ str($group)->snake() }}"
                         {{--x-show="{{ str($group)->snake() }}"--}}
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>


                    </span>
                    <span x-on:click="{{ str($group)->snake() }} = ! {{ str($group)->snake() }}"
                          x-show="{{ str($group)->snake() }}"
                          x-cloak
                          class="flex justify-center items-center w-auto cursor-pointer"
                          title="Show {{ $group }} Events"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                    </span>
                </div>
            @endforeach
        </div>
    </div>
    <div class="relative pt-[9rem]">
        <div class="sticky top-48 z-10 mb-[-14rem]">
            <div id="event-selector"
                 class="flex top-0 w-full h-20">
                <div class="absolute z-50 w-full h-20 bg-gray-800 opacity-10"></div>
                <div class="w-12">

                </div>
                <div class="flex flex-col flex-1 h-full">
                    <div class="h-1/2"></div>
                    <div class="h-1/2"></div>
                </div>
                <div class="w-12">

                </div>
            </div>
        </div>

        @if(! empty($v_min) && $v_min < 1810)
            <div class="flex sticky top-0 z-10 justify-center items-center my-0 w-full text-4xl font-normal text-white h-18 bg-primary">
                1800
            </div>
        @endif

        @php
            $totalYears = 0;
        @endphp

        @foreach ($years as $year => $months)
            @if($year == 0)
                @continue
            @endif
            @php
                $count = 0;
                $totalYears += 1;
            @endphp

            @if((((int) $year) % 10) == 0)
                <div class="grid grid-cols-11 px-4 h-8 divide-x divide-slate-300">
                    <div>&nbsp;</div>
                    <div class="col-span-2">&nbsp;</div>
                    <div class="col-span-2">&nbsp;</div>
                    <div class="col-span-2">&nbsp;</div>
                    <div class="col-span-2">&nbsp;</div>
                    <div class="col-span-2">&nbsp;</div>
                </div>

                <div class="flex sticky top-0 z-10 justify-center items-center w-full text-4xl font-normal text-white h-18 bg-primary">
                    {{ $year }}
                </div>

                <div class="grid grid-cols-11 px-4 h-8 divide-x divide-slate-300">
                    <div>&nbsp;</div>
                    <div class="col-span-2">&nbsp;</div>
                    <div class="col-span-2">&nbsp;</div>
                    <div class="col-span-2">&nbsp;</div>
                    <div class="col-span-2">&nbsp;</div>
                    <div class="col-span-2">&nbsp;</div>
                </div>
            @else
                <div class="grid grid-cols-11 px-4 h-14 divide-x divide-slate-300">
                    <div>
                        <p class="text-2xl font-normal text-gray-900">
                            {{ $year }}
                        </p>
                    </div>
                    <div class="col-span-2"></div>
                    <div class="col-span-2"></div>
                    <div class="col-span-2"></div>
                    <div class="col-span-2"></div>
                    <div class="col-span-2"></div>
                </div>
            @endif


            <div>
                @if($months->filter(function($month){
                    return count($month) > 0;
                })->count() > 0)
                    @foreach($months as $month => $monthEvents)
                        <div>
                            @if(count($monthEvents) > 0)
                                <div class="grid grid-cols-11 px-4 h-8 divide-x divide-slate-300">
                                    <div class="font-semibold">
                                        {{ $month }}
                                    </div>
                                    <div class="col-span-2"></div>
                                    <div class="col-span-2"></div>
                                    <div class="col-span-2"></div>
                                    <div class="col-span-2"></div>
                                    <div class="col-span-2"></div>
                                </div>
                                @foreach($monthEvents->groupBy('date') as $events)
                                    @php
                                        $count = 0;
                                    @endphp
                                    <div class="grid grid-cols-11 px-4 divide-x divide-slate-300 min-h-[3.5rem]">
                                        <div class="border-t border-gray-400 border-1">
                                        </div>
                                        @foreach($groups as $key => $group)
                                            @php
                                                if($count == 0){
                                                  $count = $events->where('type', $group)->count();
                                                }
                                            @endphp
                                            <div @class([
                                                        str($group)->slug().' col-span-2',
                                                        'border-t !border-t-gray-400 border-1' => $count == 0,
                                                      ])
                                                 class="{{ str($group)->slug() }} col-span-2"
                                            >
                                                @foreach($events->where('type', $group)->all() as $hit)
                                                    <div x-on:click="event = {
                                                                id: '{{ data_get($hit, 'id') }}',
                                                                image: '{{ data_get($hit, 'thumbnail') }}',
                                                                date: '{{ data_get($hit, 'display_date') }}',
                                                                text: '{{ addslashes(str($hit['name'])->addSubjectLinks()->addScriptureLinks()->toString()) }}',
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
                                                                    id: '{{ data_get($hit, 'id') }}',
                                                                    image: '{{ data_get($hit, 'thumbnail') }}',
                                                                    date: '{{ data_get($hit, 'display_date') }}',
                                                                    text: '{{ addslashes(str($hit['name'])->addSubjectLinks()->addScriptureLinks()->toString()) }}',
                                                                    links: [
                                                                        @foreach(data_get($hit, 'links', []) as $link)
                                                                            { name: '{{ $link['name'] }}',
                                                                            url: '{{ $link['url'] }}'},
                                                                        @endforeach
                                                                    ]
                                                                } : null"
                                                             class="relative h-10 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600"
                                                             id="{{ str($hit['id'])->replace('_', '-') }}"
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
                                                                                {{ str($hit['name'])->removeSubjectTags()->limit(40, '...') }}
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
                                <div class="grid grid-cols-11 px-4 h-8 divide-x divide-slate-300">
                                    <div class="text-sm text-gray-600">
                                        {{ $month }}
                                    </div>
                                    <div class="col-span-2"></div>
                                    <div class="col-span-2"></div>
                                    <div class="col-span-2"></div>
                                    <div class="col-span-2"></div>
                                    <div class="col-span-2"></div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
        <div>
            @if($totalYears == 0)
                <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400">
                    <div class="flex justify-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-base text-yellow-700">
                                <span class="font-semibold">Sorry. </span>
                                <span href="#" class="text-yellow-600">We could find any events in Wilford's life that match your search. Please try expanding your search or changing you search query.</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="h-80">

    </div>
</div>
