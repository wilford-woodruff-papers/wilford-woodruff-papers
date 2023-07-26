<div>
    <x-slot name="title">
        Timeline | {{ config('app.name') }}
    </x-slot>

    <div x-data="{
            event: @entangle('event'),
            activeEvent: null,
            @foreach($groups as $group)
                {{ str($group)->snake() }}: true,
            @endforeach
            isOverlap: $overlap('#event-selector')
        }"
         x-init="$watch('activeEvent', (value, oldValue) => $wire.set('event', value))"
         class="grid grid-cols-5">
        <div class="relative col-span-1 bg-gray-200">
            <div class="sticky top-10">
                Left Sidebar
            </div>
        </div>
        <div class="col-span-3 pb-96 bg-gray-400">
            Main
            <div x-ref="container" class="relative pt-32">

                <div class="sticky top-32 z-10 bg-white">
                    <div class="grid grid-cols-5 items-center text-center">
                        @foreach($groups as $group)
                            <div x-on:click="{{ str($group)->snake() }} = ! {{ str($group)->snake() }}"
                                 class="cursor-pointer">
                                {{ $group }}
                            </div>
                        @endforeach
                    </div>
                    <div id="event-selector"
                         class="top-10 w-full h-20 bg-gray-800 opacity-25">

                    </div>
                </div>
                <div class="">
                    @php
                        $previousYear = null;
                    @endphp
                    @foreach ($hits as $key => $events)
                        @php
                            $count = 0;
                            $currentYear = \Carbon\Carbon::createFromTimestamp($key)->year;
                        @endphp
                        @if(($previousYear < $currentYear) && ($currentYear % 10) == 0)
                            <div class="flex sticky top-10 justify-center items-center my-8 w-full h-24 text-4xl font-bold text-white bg-primary">
                                {{ $currentYear }}
                            </div>
                        @endif
                        <div class="grid grid-cols-6 px-4 mt-4">
                            <div>
                                {{ \Carbon\Carbon::createFromTimestamp($key)->toFormattedDateString() }}
                            </div>
                            @foreach($groups as $group)
                                @php
                                    if($count == 0){
                                      $count = $events->where('type', $group)->count();
                                    }                                    
                                @endphp
                                <div x-show="{{ str($group)->snake() }}"
                                     @class([
                                        str($group)->slug().' col-span-1',
                                        'border-t-2' => $count == 0,
                                      ])
                                     class="{{ str($group)->slug() }} col-span-1"
                                >
                                    @foreach($events->where('type', $group)->all() as $hit)
                                        <div x-on:click="activeEvent = '{{ str($hit['id'])->after('_') }}'"
                                             id="{{ $hit['id'] }}"
                                             class="z-10 w-full h-auto cursor-pointer"
                                        >
                                            <div @scroll.window.throttle.50ms="$overlap('#event-selector') ? activeEvent = '{{ str($hit['id'])->after('_') }}' : null"
                                                 class="text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600"
                                                 id="{{ $hit['id'] }}"
                                            >
                                                <img src="{{ data_get($hit, 'thumbnail') }}"
                                                     alt=""
                                                     class="object-cover w-full bg-gray-100 aspect-[16/9] sm:aspect-[2/1] lg:aspect-[3/2]">
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

            <div class="sticky top-10 py-8 px-4 h-screen bg-primary">
                Right Sidebar
                @if($event)
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
                @endif
            </div>
        </div>
    </div>
</div>
