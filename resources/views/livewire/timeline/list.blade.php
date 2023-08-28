<div x-ref="container"
     class="relative"
>

    <div class="sticky top-10 z-10">
        <div class="grid z-50 grid-cols-6 gap-x-2 items-center py-0 text-center bg-white">
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
        </div>
        <div id="event-selector"
             class="hidden top-0 w-full h-20 bg-gray-800 opacity-25">

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

            @if((((int) $year) % 10) == 0)
                {{--<div class="grid grid-cols-6 px-4 h-8 divide-x divide-slate-300">
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                </div>--}}

                <div class="flex sticky top-0 z-10 justify-center items-center w-full text-4xl font-bold text-white h-18 bg-primary">
                    {{ $year }}
                </div>

                {{--<div class="grid grid-cols-6 px-4 h-8 divide-x divide-slate-300">
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                </div>--}}
            @else
                {{--<div class="grid grid-cols-6 px-4 h-14 divide-x divide-slate-300">
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
                </div>--}}
            @endif


            <div>
                @if($months->filter(function($month){
                    return count($month) > 0;
                })->count() > 0)
                    @foreach($months as $month => $monthEvents)
                        <div>
                            @if(count($monthEvents) > 0)
                                <div>
                                    @foreach($monthEvents as $event)
                                        <div class="group">
                                            <div class="grid grid-cols-5 gap-x-8 py-4 h-24 group-hover:hidden">
                                                <div class="">
                                                    @if(data_get($event, 'thumbnail'))
                                                        <img x-on:click="Livewire.emit('openModal', 'photo-viewer', { url: '{{ data_get($event, 'thumbnail') }}' })"
                                                             src="{{ data_get($event, 'thumbnail') }}"
                                                             alt=""
                                                             class="object-cover object-top mx-auto w-20 bg-gray-100 scale-150 cursor-pointer aspect-[16/9] sm:aspect-[2/1] lg:aspect-[3/2]">
                                                    @endif
                                                </div>
                                                <div class="col-span-4">
                                                    <div class="grid grid-cols-7 gap-x-2">
                                                        <div class="col-span-5 gap-y-2">
                                                            <div class="line-clamp-2">
                                                                {!! str($event['name'])->addSubjectLinks()->addScriptureLinks()->toString() !!}
                                                            </div>
                                                            <div>
                                                                <span class="px-1.5 text-sm text-white py-0.25 bg-secondary">
                                                                    {{ data_get($event, 'type') }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-span-2">
                                                            <div class="pr-8 text-sm font-semibold text-right md:text-lg">
                                                                {{ data_get($event, 'display_date') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="hidden grid-cols-6 gap-x-12 p-4 text-white group-hover:grid bg-primary">
                                                <div class="">
                                                    @if(data_get($event, 'thumbnail'))
                                                        <img x-on:click="Livewire.emit('openModal', 'photo-viewer', { url: '{{ data_get($event, 'thumbnail') }}' })"
                                                             src="{{ data_get($event, 'thumbnail') }}"
                                                             alt=""
                                                             class="object-cover object-top mx-auto w-full bg-gray-100 cursor-pointer">
                                                    @endif
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-3xl">
                                                        {{ data_get($event, 'display_date') }}
                                                    </div>
                                                </div>
                                                <div class="flex flex-col col-span-3 gap-y-4">
                                                    <div>
                                                        <span class="px-1.5 text-sm text-white py-0.25 bg-secondary">
                                                            {{ data_get($event, 'type') }}
                                                        </span>
                                                    </div>
                                                    <div class="text-3xl">
                                                        {!! str($event['name'])->addSubjectLinks()->addScriptureLinks()->toString() !!}
                                                    </div>
                                                </div>
                                                @if(count($links = data_get($event, 'links')) > 0)
                                                    <div class="flex flex-col justify-end my-4">
                                                        <div class="py-4 text-lg text-white">
                                                            Read More
                                                        </div>
                                                        <ul class="flex flex-col gap-6">
                                                            @foreach($links as $link)
                                                                <li>
                                                                    <a title="{{ $link['name'] }}"
                                                                       href="{{ $link['url'] }}"
                                                                       class="block py-2 px-4 my-4 text-white text-md bg-secondary">
                                                                        View Source
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
</div>
