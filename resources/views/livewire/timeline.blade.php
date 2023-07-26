<div>
    <x-slot name="title">
        Timeline | {{ config('app.name') }}
    </x-slot>

    <div x-data="{
            event: @entangle('event'),
            activeEvent: null,
            isOverlap: $overlap('#event-selector')
        }"
         x-init="$watch('activeEvent', (value, oldValue) => $wire.set('event', value))"
         class="grid grid-cols-5">
        <div class="relative col-span-1 bg-gray-200">
            <div class="sticky top-10">
                Left Sidebar
            </div>
        </div>
        <div class="col-span-3 bg-gray-400">
            Main
            <div x-ref="container" class="relative pt-32">

                <div class="sticky top-32 z-10 bg-white">
                    <div class="grid grid-cols-5 items-center text-center">
                        @foreach($groups as $group)
                            <div>
                                {{ $group }}
                            </div>
                        @endforeach
                    </div>
                    <div id="event-selector"
                         class="top-10 w-full h-20 bg-gray-800 opacity-25">

                    </div>
                </div>
                <div class="">
                    @foreach ($hits as $key => $events)
                        <div class="grid grid-cols-5 gap-x-4 px-4">
                            @foreach($groups as $group)
                                <div class="{{ str($group)->slug() }} col-span-1">
                                    @foreach($events->where('type', $group)->all() as $hit)
                                        <div x-on:click="activeEvent = '{{ str($hit['id'])->after('_') }}'"
                                             class="z-10 w-full h-auto cursor-pointer"
                                        >
                                            <div @scroll.window.throttle.100ms="$overlap('#event-selector') ? activeEvent = '{{ str($hit['id'])->after('_') }}' : null"
                                                 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600"
                                                 id="{{ $hit['id'] }}"
                                            >
                                                <img src="{{ data_get($hit, '_formatted.thumbnail') }}"
                                                     alt=""
                                                     title="{{ data_get($hit, 'name') }}"
                                                     class="object-cover w-full bg-gray-100 aspect-[16/9] sm:aspect-[2/1] lg:aspect-[3/2]">
                                                <div class="absolute inset-0 ring-1 ring-inset ring-gray-900/10"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="relative col-span-1 bg-gray-200">

            <div class="sticky top-10">
                Right Sidebar
                @if($event)
                    @php
                        $currentEvent = \App\Models\Event::find($event);
                    @endphp
                    <div>
                        {!! str($currentEvent->text)->addScriptureLinks() !!}
                    </div>
                    <div>

                    </div>
                    <div>

                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
