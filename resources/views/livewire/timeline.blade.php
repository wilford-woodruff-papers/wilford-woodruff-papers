<div>
    <x-slot name="title">
        Timeline | {{ config('app.name') }}
    </x-slot>

    <div x-data="{
            {{--event: @entangle('event'),--}}
            event: {image: '', date: '', text: ''},
            activeEvent: null,
            @foreach($groups as $group)
                {{ str($group)->snake() }}: true,
            @endforeach
            isOverlap: $overlap('#event-selector')
        }"
         x-init="$watch('activeEvent', (value, oldValue) => $wire.set('event', value))"
         class="grid grid-cols-5">
        <div class="relative col-span-1 bg-gray-200">
            <div class="sticky top-0">
                Left Sidebar
            </div>
        </div>
        <div class="col-span-3 pb-96 bg-gray-100">
            Main
            <div x-ref="container" class="relative pt-32">

                <div class="sticky top-24 z-10">
                    <div class="grid z-50 grid-cols-6 items-center text-center bg-white">
                        <div></div>
                        @foreach($groups as $group)
                            <div x-on:click="{{ str($group)->snake() }} = ! {{ str($group)->snake() }}"
                                 class="cursor-pointer">
                                {{ $group }}
                            </div>
                        @endforeach
                    </div>
                    <div id="event-selector"
                         class="top-0 w-full h-20 bg-gray-800 opacity-25">

                    </div>
                </div>
                <div class="">
                    <div class="flex sticky top-0 z-10 justify-center items-center my-8 w-full h-24 text-4xl font-bold text-white bg-primary">
                        1800
                    </div>
                    @php
                        $previousYear = null;
                        //$currentYear = 1800;
                    @endphp
                    @foreach ($hits as $key => $events)
                        @php
                            $count = 0;
                            $currentYear = \Carbon\Carbon::createFromTimestamp($key)->year;
                        @endphp
                        @if(($previousYear < $currentYear))
                            @if(($currentYear % 10) == 0)
                                <div class="grid grid-cols-6 px-4 h-8 divide-x divide-slate-200">
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                </div>

                                <div class="flex sticky top-0 z-10 justify-center items-center w-full h-24 text-4xl font-bold text-white bg-primary">
                                    {{ $currentYear }}
                                </div>

                                <div class="grid grid-cols-6 px-4 h-8 divide-x divide-slate-200">
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                </div>
                            @else
                                <div class="grid grid-cols-6 px-4 h-14 divide-x divide-slate-200">
                                    <div>
                                        <p class="text-2xl font-bold text-gray-900">
                                            {{ $currentYear }}
                                        </p>
                                    </div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            @endif
                        @endif
                        <div class="grid grid-cols-6 px-4 h-14 divide-x divide-slate-200">
                            <div>
                                {{ \Carbon\Carbon::createFromTimestamp($key)->toFormattedDateString() }}
                            </div>
                            @foreach($groups as $key => $group)
                                @ray($key)
                                @php
                                    if($count == 0){
                                      $count = $events->where('type', $group)->count();
                                    }
                                @endphp
                                <div x-show="{{ str($group)->snake() }}"
                                     @class([
                                        str($group)->slug().' col-span-1',
                                        'border-t-0' => $count == 0,
                                      ])
                                     class="{{ str($group)->slug() }} col-span-1"
                                >
                                    @foreach($events->where('type', $group)->all() as $hit)
                                        <div x-on:click="event = {image: '{{ data_get($hit, 'thumbnail') }}', date: '{{ data_get($hit, 'display_date') }}', text: '{{ addslashes(str($hit['name'])->addScriptureLinks()->toString()) }}'}"
                                             id="{{ $hit['id'] }}"
                                             class="z-10 w-full h-auto cursor-pointer"
                                        >
                                            <div @scroll.window.throttle.50ms="$overlap('#event-selector') ? event = {image: '{{ data_get($hit, 'thumbnail') }}', date: '{{ data_get($hit, 'display_date') }}', text: '{{ addslashes(str($hit['name'])->addScriptureLinks()->toString()) }}'} : null"
                                                 class="relative h-10 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600"
                                                 id="{{ $hit['id'] }}"
                                            >
                                                <div @class([
                                                        'absolute w-80 text-sm font-normal bg-white hover:z-10',
                                                        'left-2' => ($key <= 2),
                                                        'right-2' => ($key > 2),
                                                    ])>
                                                    <div class="flex">
                                                        <div @class([
                                                                'p-1',
                                                                'order-2' => ($key <= 2),
                                                                'order-1' => ($key > 2),
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
                                                        <div @class([
                                                                'flex-0 w-20',
                                                                'order-1' => ($key <= 2),
                                                                'order-2' => ($key > 2),
                                                            ])>
                                                            <img src="{{ data_get($hit, 'thumbnail') }}"
                                                                 alt=""
                                                                 class="object-cover object-top mx-auto w-full bg-gray-100 aspect-[16/9] sm:aspect-[2/1] lg:aspect-[3/2]">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--<div class="absolute inset-0 ring-1 ring-inset ring-gray-900/10"></div>--}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        @php
                            if($currentYear > $previousYear){
                                $previousYear = $currentYear;
                            }
                        @endphp
                    @endforeach
                </div>
            </div>
        </div>
        <div class="relative col-span-1 bg-gray-200">

            <div class="sticky top-0 py-8 px-4 h-screen bg-primary">
                Right Sidebar
                {{--@if($event)
                    @php
                        $currentEvent = \App\Models\Event::find($event);
                    @endphp
                    <div>
                        <img src="{{ $currentEvent->thumbnail_url }}"
                             alt=""
                             class="w-full h-auto">
                    </div>
                    <div class="py-4 text-2xl text-white">
                        {{ $currentEvent->display_date }}
                    </div>
                    <div class="text-lg text-white">
                        {!! str($currentEvent->text)->addScriptureLinks() !!}
                    </div>


                @endif--}}
                <div>
                    <img x-bind:src="event.image"
                         alt=""
                         class="w-full h-auto">
                </div>
                <div x-text="event.date"
                     class="py-4 text-2xl text-white">
                </div>
                <div x-html="event.text"
                     class="text-lg text-white">
                </div>
            </div>
        </div>
    </div>
</div>
